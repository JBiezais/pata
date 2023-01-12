<?php


namespace App\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DestroyWorkOrderAction{

    public function __construct(
        private RemoveWorkOrderImageAction $removeWorkOrderImageAction
    ){}

    public function destroy($workorder): void
    {
        if($workorder->image_path){
            $this->removeWorkOrderImageAction->remove($workorder->image_path);
        }

        WorkOrder::destroy($workorder->id);
    }
}
