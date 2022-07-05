<?php

namespace App\Repositories;

use App\Contracts\OfficeContract;
use App\Models\Office;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OfficeRepository implements OfficeContract
{
    protected Office $office;

    /**
     * @param Office $office
     */
    public function __construct(Office $office)
    {
        $this->office = $office;
    }


    /**
     * @param $data
     * @param $relations
     * @return Collection
     */
    public function index($data, $relations): Collection
    {
        if (!$data['checked']) {
            $offices = $this->office::with($relations)->skip($data['skip'])->take(10)->get();
        } else {
            $offices = $this->office::with($relations)->where('user_id', $data['id'])->skip($data['skip'])->take(10)->get();
        }
        return $offices;
    }


    /**
     * @param $data
     * @return Model
     */
    public function store($data): Model
    {
        return $this->office::create($data);
    }

    /**
     * @param $updateData
     * @param $updateId
     * @return array
     */
    public function update($updateData, $updateId): int
    {
        return $this->office::where('id', $updateId)->update($updateData);
    }


    /**
     * @param $deleteId
     * @return int
     */
    public function destroy($deleteId): int
    {
        return $this->office::destroy($deleteId);
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getByUserId($id): Collection
    {
        return $this->office::where($id)->get();
    }

}
