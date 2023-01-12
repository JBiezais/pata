<?php


namespace App\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UploadWorkOrderImageAction{

    const WORKORDER_IMAGE_PATH = 'workorder';

    public function upload(UploadedFile $file): bool|string
    {
        return $file->store(self::WORKORDER_IMAGE_PATH);
    }
}
