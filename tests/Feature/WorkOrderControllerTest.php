<?php

namespace Tests\Feature;

use App\Http\Controllers\WorkOrderController;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorkOrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private const WORKORDER_IMAGE_PATH = 'workorder';

    public function test_work_order_store()
    {
        $user = User::factory()->create();

        Storage::fake(self::WORKORDER_IMAGE_PATH);

        $file = UploadedFile::fake()->image('test.jpg');

        $workOrderData = [
            'user_id' => $user->id,
            'title' => 'Test WorkOrder',
            'description' => 'Test WorkOrder Description',
            'image_path' => $file
        ];

        $response = $this->actingAs($user)
            ->post('/workorder', $workOrderData);

        $filePath = WorkOrder::query()->select('image_path')->latest('created_at')->first()->image_path;
        $workOrderData['image_path'] = $filePath;

        $this->assertDatabaseHas('work_orders',$workOrderData);

        $response->assertRedirect(route('dashboard'));

    }

    public function test_work_order_update()
    {
        $user = User::factory()->create();

        Storage::fake(self::WORKORDER_IMAGE_PATH);

        $workOrder = WorkOrder::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');

        $workOrderData = [
            'id' => $workOrder->id,
            'title' => 'Test WorkOrder',
            'description' => 'Test WorkOrder Description',
            'image_path' => $file
        ];

        $response = $this->actingAs($user)
            ->put(route('workorder.update', $workOrderData['id']), $workOrderData);

        $this->assertDatabaseHas('work_orders', [
            'id' => $workOrder->id,
            'title' => $workOrderData['title'],
            'description' => $workOrderData['description'],
        ]);

        $response->assertStatus(302);
    }

    public function test_work_order_destroy()
    {
        $user = User::factory()->create();

        Storage::fake(self::WORKORDER_IMAGE_PATH);

        $workOrder = WorkOrder::factory()->create();

        $file = UploadedFile::fake()->image('test.jpg');

        Storage::disk(self::WORKORDER_IMAGE_PATH)
            ->put($workOrder->image_path, file_get_contents($file));

        $response = $this->actingAs($user)
            ->delete(route('workorder.destroy', $workOrder->id));

        $this->assertDatabaseMissing('work_orders', [ 'id' => $workOrder->id ]);

        $response->assertStatus(302);
    }
}
