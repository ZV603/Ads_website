<?php

declare(strict_types=1);

namespace AdsWebsite\Repository;

use PDO;

abstract class AbstractDbRepository
{
    protected $connection;
    protected $tableName = '';

    public function __construct()
    {
        $config = require './config.php';
        // sukuriame connectiona prie duomenu bazes
        $this->connection = new PDO(
            sprintf('mysql:host=%s:%s;dbname=%s', $config['host'], $config['port'], $config['database']),
            $config['username'],
            $config['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        );
    }

    // grazina viena skelbima pagal paduota ID
    public function getOneById($id): ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM ' . $this->tableName . ' WHERE id = :id;');
        $statement->bindParam('id', $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) === 1) {
            return $result[0];
        }

        return null;
    }
    
    // uzkrauna visus skelbimus is ads.json failo
    public function getAll(): array
    {
        $statement = $this->connection->prepare('SELECT * FROM ' . $this->tableName . ';');

        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    // issaugo paduota skelbima mariadb lenteleje
    public function create(array $record): void
    {
        // "INSERT INTO ad (customer_id, title, description, price, contact_phone)
        // VALUES (:customer_id, :title, :description, :price, :contact_phone);"
        $columns = array_keys($record);
        $query = 'INSERT INTO ' . $this->tableName . ' (' . implode(', ', $columns) . ') VALUES ';
        // INSERT INTO ad (customer_id, title, description, price, contact_phone) VALUES
        
        $params = [];
        foreach ($columns as $param) {
            $params[] = ':' . $param;
        }
        
        $query = $query . '(' . implode(', ', $params) . ');';
        
        $statement = $this->connection->prepare($query);
        $statement->execute($record);
    }

    public function update(array $updatedRecord): void
    {
        // formuojame uzklausos pradzia 'UPDATE ad SET '
        $query = 'UPDATE ' . $this->tableName . ' SET ';

        // formuojame uzklausos segmenta 'customer_id = :customer_id, ...'
        $updates = [];
        foreach (array_keys($updatedRecord) as $columnName) {
            if ($columnName === 'id' || $columnName === 'created_at') {
                continue;
            }
            $columnUpdate = $columnName . ' = :' . $columnName;
            $updates[] = $columnUpdate;
        }
        // pridedame where salyga
        $query = $query . implode(', ', $updates) . ' WHERE id = :id;';

        // kadangi created_at yra valdomas pacios db, tai mums nereikia jo atnaujinti
        unset($updatedRecord['created_at']);

        // paruosiame uzklausa
        $statement = $this->connection->prepare($query);
        // paduodame parametru reiksmes ir vykdome uzklausa
        $statement->execute($updatedRecord);
    }

    // istrina viena irasa pagal paduota ID
    public function delete(string $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM ' . $this->tableName . ' WHERE id = :id;');
        $statement->execute(['id' => $id]);
    }
}
