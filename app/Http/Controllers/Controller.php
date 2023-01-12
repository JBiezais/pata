<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkOrder;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request): \Inertia\Response
    {
        $workOrdersOffset = 0;
        $usersOffset = 0;

        $data = $request->validate([
           'workOrder' => 'nullable|numeric|min:0',
           'user' => 'nullable|numeric|min:0'
        ]);

        if(isset($data['workOrder'])){
            $workOrdersOffset = $data['workOrder'] ;
        }
        if(isset($data['user'])){
            $workOrdersOffset = $data['user'] ;
        }

        $workOrders = User::with(['workOrders'=>function($query) use ($workOrdersOffset) {
                return $query ->take(10)->offset($workOrdersOffset);
            }])
            ->where('id', auth()->user()->id)
            ->get();

        $users = User::query()
            ->whereNot('id', auth()->user()->id)
            ->take(10)
            ->offset($usersOffset)
            ->get();

        return Inertia::render('Dashboard', [
            'workOrders' =>  $workOrders[0],
            'users' => $users,
            'workOrdersOffset' => $workOrdersOffset,
            'usersOffset' => $usersOffset
        ]);
    }
}
