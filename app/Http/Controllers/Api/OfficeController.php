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
     * @return OfficeCollection|MessageResource
     */

    public function index(Request $request): OfficeCollection|MessageResource
    {
        $checked = $request->input('checked') === 'true' ? true: false;
        $skip = intval($request->input('skip'));
        $data = ['checked' => $checked,'skip' => $skip];
        $officeContract = $this->officeContract->index($data,['locations']);
        if ($officeContract ['success'] === 1) {
            return new OfficeCollection(['offices' => $officeContract ['offices'], 'success' => 1]);
        }
        return new MessageResource(['success' => 0]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * @param OfficeStoreRequest $request
     * @return MessageResource|OfficeResource
     */
    public function store(OfficeStoreRequest $request): MessageResource|OfficeResource
    {

        $officeContract = $this->officeContract->store(['name' => $request->input('name'), 'user_id' => Auth::id()]);
        if ($officeContract['success'] === 1) {
            $officeContract['office']->locations()->sync($request->input('locations'));
            return new OfficeResource(['success' => $officeContract['success'], 'office' => $officeContract['office']]);
        }
        return new MessageResource(['success' => 0]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param OfficeUpdateRequest $request
     * @param Office $office
     * @return MessageResource
     */
    public function update(OfficeUpdateRequest $request, Office $office): MessageResource
    {
        $officeContract = $this->officeContract->update(['name' => $request->input('name')],$office->id);
        if ($officeContract['success'] === 1){
            $office->locations()->sync($request->input('locations'));
            return new MessageResource(['success' => $officeContract['success']]);
        }
        return new MessageResource(['success' => $officeContract['success']]);
    }


    /**
     * @param Office $office
     * @return Response|MessageResource
     */
    public function destroy(Office $office): Response|MessageResource
    {
        $office->locations()->sync([]);
        $destroy = $this->officeContract->destroy($office['id']);
        return new MessageResource(['success' => $destroy['success']]);
    }
}
