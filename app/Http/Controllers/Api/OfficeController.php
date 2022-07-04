<?php

namespace App\Http\Controllers\Api;

use App\Contracts\OfficeContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficeStoreRequest;
use App\Http\Requests\OfficeUpdateRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\OfficeCollection;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OfficeController extends Controller
{
    protected OfficeContract $officeContract;

    /**
     * @param OfficeContract $officeContract
     */

    public function __construct(OfficeContract $officeContract)
    {
        $this->officeContract = $officeContract;
    }


    /**
     * @param Request $request
     * @return OfficeCollection
     */

    public function index(Request $request): OfficeCollection
    {
        $checked = $request->input('checked') === 'true' ? true : false;
        $skip = intval($request->input('skip'));
        $data = ['checked' => $checked, 'skip' => $skip,'id' => Auth::id()];
        $offices = $this->officeContract->index($data, ['locations']);
        return new OfficeCollection(['offices' => $offices, ['offices'], 'success' => 1]);

    }


    /**
     * @param OfficeStoreRequest $request
     * @return OfficeResource
     */
    public function store(OfficeStoreRequest $request): OfficeResource
    {
        $office = $this->officeContract->store(['name' => $request->input('name'), 'user_id' => Auth::id()]);
        $office->locations()->sync($request->input('locations'));
        return new OfficeResource(['success' => 1, 'office' => $office]);
    }

    /**
     * @param OfficeUpdateRequest $request
     * @param Office $office
     * @return MessageResource
     */
    public function update(OfficeUpdateRequest $request, Office $office): MessageResource
    {
        $updatedOffice = $this->officeContract->update(['name' => $request->input('name')], $office['id']);
        $office->locations()->sync($request->input('locations'));
        return new MessageResource(['success' => $updatedOffice]);
    }


    /**
     * @param Office $office
     * @return Response|MessageResource
     */
    public function destroy(Office $office): Response|MessageResource
    {
        $office->locations()->sync([]);
        $destroy = $this->officeContract->destroy($office['id']);
        return new MessageResource(['success' => $destroy]);
    }
}
