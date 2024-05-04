<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Services\Agent\DelayReport\DelayReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function assign(Request $request): JsonResponse
    {
        $agent = Agent::query()->firstOrCreate([
            'name' => $request->agent_name,
        ], [
            'user_id' => User::factory()->create()->id,
        ]);

        $delayReport = resolve(DelayReportService::class)->handle($agent->id);

        return response()->json($delayReport->toArray() ?? []);
    }
}
