<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserWorkOrdersTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_work_orders_relationship()
    {
        $user = User::factory()->create();

        $workOrders = WorkOrder::factory(5)->create([
            'user_id' => $user->id
        ]);

        $this->assertCount(5, $user->workOrders);
        $this->assertEquals($workOrders->pluck('id'), $user->workOrders->pluck('id'));
    }
}
