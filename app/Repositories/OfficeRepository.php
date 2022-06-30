<?php

namespace App\Repositories;

use App\Contracts\OfficeContract;
use App\Models\Office;
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
     * @return array|int[]
     */
    public function index($data, $relations): array
    {
        if (!$data['checked']) {
            $offices = $this->office::with($relations)->skip($data['skip'])->take(10)->get();
        } else {
            $offices = $this->office::with($relations)->where('user_id', Auth::id())->skip($data['skip'])->take(10)->get();
        }
        if (!$offices->isEmpty() ) {
            return ['success' => 1, 'offices' => $offices];
        }
        return ['success' => 0];

    }

    /**
     * @param $data
     * @return array|int[]
     */
    public function store($data): array
    {
        $office = $this->office::create($data);
        if ($office) {
            return ['success' => 1, 'office' => $office];

        }
        return ['success' => 0];
    }

    /**
     * @param $updateData
     * @param $updateId
     * @return array
     */
    public function update($updateData, $updateId): array
    {
        $office = $this->office::where('id',$updateId)->update($updateData);
        return ['success' => $office];

    }

    /**
     * @param $deleteId
     * @return array
     */

    public function destroy($deleteId): array
    {
        $destroy = $this->office::destroy($deleteId);
        return ['success' => $destroy];
    }
}
