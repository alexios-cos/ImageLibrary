<?php

use app\Models\Utils\DatabaseUtility;

require_once 'app/Models/Utils/DatabaseUtility.php';

$connection = DatabaseUtility::getConnection("localhost", "root", "1234", "imagelibrary");

$table = 'image';
$query = "
    CREATE TABLE IF NOT EXISTS $table(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(127) NOT NULL,
    CONSTRAINT primary_key PRIMARY KEY (id));
";
createTable($connection, $table, $query);

$table = 'attribute';
$query = "
    CREATE TABLE IF NOT EXISTS $table(
    image_id INT UNSIGNED NOT NULL,
    attr VARCHAR(63),
    val VARCHAR (255),
    CONSTRAINT image_foreign_key FOREIGN KEY (image_id) REFERENCES image(id) ON DELETE CASCADE);
";
createTable($connection, $table, $query);

/**
 * @param PDO $connection
 * @param string $table
 * @param string $query
 */
function createTable(PDO $connection, string $table, string $query): void
{
    try {
        $connection->exec($query);
        echo "Table \"$table\" was successfully created." . PHP_EOL;
    } catch (\PDOException $exception) {
        echo "An error occurred while creating table $table: {$exception->getMessage()}";
    }
}
