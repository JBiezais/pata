<?php

namespace App\Http\Controllers;

use App\Actions\CreateWorkOrderAction;
use App\Actions\DestroyWorkOrderAction;
use App\Actions\UpdateWorkOrderAction;
use App\Models\WorkOrder;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\WorkOrderRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;


class WorkOrderController extends Controller
{

    private const WORKORDER_IMAGE_PATH = 'workorder';
    public function store(WorkOrderRequest $request, CreateWorkOrderAction $createWorkOrderAction):RedirectResponse
    {
        $createWorkOrderAction->create($request->all());

        return Redirect::to('/');
    }

    public function update(WorkOrderRequest $request, WorkOrder $workorder, UpdateWorkOrderAction $updateWorkOrderAction):RedirectResponse
    {
        $updateWorkOrderAction->update($request->all(), $workorder);

        return Redirect::to('/');
    }

    public function destroy(WorkOrder $workorder, DestroyWorkOrderAction $destroyWorkOrderAction):RedirectResponse
    {
        $destroyWorkOrderAction->destroy($workorder);

        return Redirect::to('/');
    }
}
