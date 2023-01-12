<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testIndex()
    {
        $this->actingAs(User::factory()->create());

        WorkOrder::factory(20)->create();
        User::factory(20)->create();

        $response = $this->get(route('dashboard'))
            ->assertInertia(function (Assert $page) {
                $pageVars = $page->toArray();

                $this->assertEquals('Dashboard', $pageVars['component']);
                $this->assertArrayHasKey('users', $pageVars['props']);
                $this->assertArrayHasKey('workOrders', $pageVars['props']);
                $this->assertCount(10, $pageVars['props']['users']);
                $this->assertLessThanOrEqual(10, count($pageVars['props']['workOrders']['work_orders']));
            });

        $response->assertStatus(200);
    }
}
