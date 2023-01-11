<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\WorkOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class WorkOrderController extends Controller
{

    private const WORKORDER_IMAGE_PATH = 'workorder';
    public function store(WorkOrderRequest $request):RedirectResponse
    {
        $requestData = $request->validated();
        $requestData['user_id'] = $request->user()->id;

        if($request->hasFile('image_path')){
            $requestData['image_path'] = $this->storeImage($request);
        }

        WorkOrder::create($requestData);

        return Redirect::to('/');
    }

    public function update(WorkOrderRequest $request):RedirectResponse
    {
        dd($request);
//        $requestData = $request->validated();
//        dd($request->hasFile('image_path'));
        $requestData['user_id'] = $request->user()->id;

        $workOrder = WorkOrder::find($requestData['id']);

        if($request->hasFile('image_path')){
            $requestData['image_path'] = $request->file('image_path')->store(self::WORKORDER_IMAGE_PATH);

            if($workOrder->image_path){
                $this->destroyImage($workOrder->image_path);
            }
        }

        $workOrder->update($requestData);

        return Redirect::to('/');
    }

    public function destroy(WorkOrder $workorder):RedirectResponse
    {
        if($workorder->image_path){
            $this->destroyImage($workorder->image_path);
        }

        WorkOrder::destroy($workorder->id);

        return Redirect::to('/');
    }

    private function storeImage($request){
        return $request->file('image_path')->store(self::WORKORDER_IMAGE_PATH);
    }

    private function destroyImage($path){
        Storage::delete($path);
    }
}
