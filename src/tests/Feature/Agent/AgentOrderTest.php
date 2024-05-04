<?php

namespace Tests\Feature\Agent;

use App\Models\Agent;
use App\Models\DelayReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgentOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_delay_report_throw_exception_because_dont_pass_data()
    {
        $response = $this->putJson(route('agent.orders.assign'));

        $response->assertStatus(422);
    }

    public function test_delay_report_throw_exception_because_already_assigned_delay_report_not_checked()
    {
        $delayReport = DelayReport::factory()
            ->state(['checked_at' => null])
            ->for(Agent::factory())
            ->create();

        $response = $this->putJson(route('agent.orders.assign'), ['agent_name' => $delayReport->agent->name]);

        $response->assertStatus(400);
    }

    public function test_delay_report_throw_exception_because_dont_exist_any_delay_report_to_assign()
    {
        $agent = Agent::factory()->create();
        DelayReport::factory()
            ->state(['checked_at' => now()])
            ->for(Agent::factory())
            ->count(5)
            ->create();

        $response = $this->putJson(route('agent.orders.assign'), ['agent_name' => $agent->name]);

        $response->assertStatus(400);
    }

    public function test_delay_report_assign_to_agent()
    {
        $agent = Agent::factory()->create();
        $delayReport = DelayReport::factory()
            ->state(['agent_id' => null, 'checked_at' => null])
            ->create();

        $response = $this->putJson(route('agent.orders.assign'), ['agent_name' => $agent->name]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('delay_reports', ['id' => $delayReport->id, 'agent_id' => $agent->id]);
    }
}