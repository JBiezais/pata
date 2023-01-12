<?php


namespace App\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateWorkOrderAction{

    public function __construct(
        private UploadWorkOrderImageAction $uploadWorkOrderImageAction
    ){}

    public function create($input): void
    {

        $data = [
            'user_id' =>  auth()->user()->id,
            'title' => $input['title'] ?? '',
            'description' => $input['description'] ?? null
        ];

        if($input['image_path']){
            $data['image_path'] = $this->uploadWorkOrderImageAction->upload($input['image_path']);
        }

        WorkOrder::create($data);
    }
}
