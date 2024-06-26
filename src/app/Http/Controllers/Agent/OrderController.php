<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\OrderAssignRequest;
use App\Http\Resources\Agent\DelayReportResource;
use App\Models\Agent;
use App\Models\User;
use App\Services\Agent\DelayReport\DelayReportService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function assign(OrderAssignRequest $request): JsonResponse
    {
        $agent = Agent::query()->firstOrCreate([
            'name' => $request->agent_name,
        ], [
            'user_id' => User::factory()->create()->id,
        ]);

        $delayReport = resolve(DelayReportService::class)->handle($agent->id);

        $data = new DelayReportResource($delayReport);

        return response()->json($data);
    }
}
