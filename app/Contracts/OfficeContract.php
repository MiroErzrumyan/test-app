<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface OfficeContract
{
    /**
     * @param $checked
     * @param $relations
     * @return Collection
     */
    public function index($checked, $relations): Collection;

    /**
     * @param $data
     * @return Model
     */
    public function store($data): Model;

    /**
     * @param $updateData
     * @param $updateId
     * @return int
     */
    public function update($updateData, $updateId): int;

    /**
     * @param $deleteId
     * @return int
     */
    public function destroy($deleteId): int;

    /**
     * @param $id
     * @return Collection
     */
    public function getByUserId($id): Collection;
}
