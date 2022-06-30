<?php

namespace App\Contracts;

interface OfficeContract
{
    /**
     * @param $checked
     * @param $relations
     * @return mixed
     */
    public function index($checked, $relations): array;

    /**
     * @param $data
     * @return mixed
     */
    public function store($data): array;

    /**
     * @param $updateData
     * @param $updateId
     * @return array
     */
    public function update($updateData, $updateId): array;

    /**
     * @param $deleteId
     * @return mixed
     */
    public function destroy($deleteId): array;
}
