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
    public static function connect($host, $user, $password, $database): void
    {
        if (self::$connection) {
            return;
        }

        self::$connection = new PDO (
            "mysql:host=$host;dbname=$database",
            $user,
            $password,
            self::$settings
        );
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     */
    public static function queryOneAssoc(string $query, $params = []): array
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $query
     * @param array $params
     * @return array
     */
    public static function queryAllAssoc(string $query, $params = []): array
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
    public static function insertDataAndVerify(string $query, $params = []): void
    {
        $result = self::$connection->prepare($query);
        $result->execute($params);

        if ($result->rowCount() < 1) {
            throw new Exception("Inserting failed", 001);
        }
    }
}
