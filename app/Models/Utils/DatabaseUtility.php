<?php

declare(strict_types=1);

namespace app\Models\Utils;

use Exception;
use PDO;

class DatabaseUtility
{
    /** @var PDO */
    private static $connection;

    /** @var array */
    private static $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return void
     */
    public static function connect(string $host, string $user, string $password, string $database): void
    {
        if (self::$connection) {
            return;
        }

        try {
            self::$connection = new PDO (
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings
            );
        } catch (\PDOException $exception) {
            //log $exception->getMessage()
        }
    }

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     * @return PDO
     */
    public static function getConnection(string $host, string $user, string $password, string $database): PDO
    {
        if (!self::$connection) {
            self::connect($host, $user, $password, $database);
        }

        return self::$connection;
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function queryOneAssoc(string $query, array $params = []): array
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function queryAllAssoc(string $query, array $params = []): array
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @param array $params
     * @return void
     * @throws Exception
     */
    public static function insert(string $query, array $params = []): void
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);

        if ($result->rowCount() < 1) {
            throw new \Exception("Inserting failed");
        }
    }

    /**
     * @return int
     */
    public static function getLastInsertedId(): int
    {
        return (int)self::$connection->lastInsertId();
    }

    /**
     * @return void
     */
    public static function beginTransaction(): void
    {
        self::$connection->beginTransaction();
    }

    /**
     * @return void
     */
    public static function commitTransaction(): void
    {
        self::$connection->commit();
    }

    /**
     * @return void
     */
    public static function rollBackTransaction(): void
    {
        self::$connection->rollBack();
    }
}
