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
        // Create some test data
        WorkOrder::factory(10)->create();
        User::factory(10)->create();

        $response = $this->get(route('dashboard'))
            ->assertInertia(function (Assert $page) {
                $pageVars = $page->toArray();

                $this->assertEquals('Dashboard', $pageVars['component']);
                $this->assertArrayHasKey('users', $pageVars['props']);
                $this->assertArrayHasKey('workOrders', $pageVars['props']);
                $this->assertCount(11, $pageVars['props']['users']);
                $this->assertCount(10, $pageVars['props']['workOrders']);
            });

        $response->assertStatus(200);
    }
}
