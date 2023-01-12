<?php


namespace App\Actions;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RemoveWorkOrderImageAction{

    public function remove(string $file): void
    {
        Storage::delete($file);
    }
}
