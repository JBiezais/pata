<?php


namespace App\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdateWorkOrderAction{

    public function __construct(
        private UploadWorkOrderImageAction $uploadWorkOrderImageAction,
        private RemoveWorkOrderImageAction $removeWorkOrderImageAction
    ){}

    public function update($input, $workorder): void
    {

        $data = [
            'user_id' =>  auth()->user()->id,
            'title' => $input['title'] ?? '',
            'description' => $input['description'] ?? null
        ];

        if($input['image_path'] === null){
            $data['image_path'] = $input['old_image_path'];
        }

        if($input['image_path']){
            if($workorder->image_path){
                $this->removeWorkOrderImageAction->remove($workorder->image_path);
            }

            $data['image_path'] = $this->uploadWorkOrderImageAction->upload($input['image_path']);
        }

        $workorder->update($data);
    }
}
