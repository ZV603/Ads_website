<?php

declare(strict_types=1);

namespace AdsWebsite\Repository;

class FileRepository
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    // grazina viena skelbima pagal paduota ID
    public function getOneById(string $id): ?array
    {
        $records = $this->getAll();

        return $records[$id];
    }
    
    // uzkrauna visus skelbimus is ads.json failo
    public function getAll(): array
    {
        return json_decode(file_get_contents($this->filePath), true);
    }

    // issaugo paduota skelbima faile ads.json
    public function create(array $record): void
    {
        $records = $this->getAll();

        if (count($records) === 0) {
            $record['id'] = '1';
            $records[1] = $record;
        } else {
            $lastId = (int) end(array_keys($records));
            $record['id'] = (string) $lastId + 1;
            $records[] = $record;
        }
        
        $this->save($records);
    }

    // issaugo atnaujinta irasa, kurio ID yra $id
    public function update(string $id, array $updatedRecord): void
    {
        $records = $this->getAll();
        // dedame atnaujinta irasa atgal prie visu duomenu
        $records[$id] = $updatedRecord;
        $this->save($records);
    }

    // istrina viena irasa pagal paduota ID
    public function delete(string $id): void
    {
        // uzsiloadiname duomenis is failo
        $record = $this->getAll();
        // istriname irasa pagal paduota ID. Unset funkcija veikia ir tuo atveju,
        // jeigu iraso su pasirinktu ID nera
        unset($record[$id]);
        
        // issaugome duomenis atgal i faila
        $this->save($record);
    }

    private function save(array $data): void
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT|JSON_FORCE_OBJECT));
    }
}
