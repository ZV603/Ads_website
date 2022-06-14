<?php

declare(strict_types=1);

namespace AdsWebsite\Repository;

use PDO;

class AdRepository extends AbstractDbRepository
{
    protected $tableName = 'ad';

    public function findAllByCustomerId(int $customerId): array
    {
        $query = 'SELECT * FROM ' . $this->tableName . ' WHERE customer_id = :customer_id;';
        $statement = $this->connection->prepare($query);
        $statement->bindParam('customer_id', $customerId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllSavedByCustomer(int $customerId): array
    {
        $query = 'SELECT * FROM ' . $this->tableName .
        ' JOIN saved_ad ON ad.id = saved_ad.ad_id WHERE saved_ad.customer_id = :customer_id;';
        $statement = $this->connection->prepare($query);
        $statement->bindParam('customer_id', $customerId);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}