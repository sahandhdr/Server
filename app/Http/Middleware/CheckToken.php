<?php

namespace App\Http\Middleware;

use App\Models\Agent\Agent;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agentId = $request->header('Agent-ID') ?? $request->input('agent_id');
        $token = $request->header('Token') ?? $request->input('token');

        if (!$agentId || !$token)
            return response()->json(['message' => 'Unauthorized: Missing agent credentials'], 401);

        $agent = Agent::find($agentId);
        if (!$agent || $agent->token !== $token)
            return response()->json(['message' => 'Unauthorized: Invalid agent credentials'], 401);

        // احراز هویت موفق، Agent رو به request تزریق کن
        $request->merge(['agent' => $agent]);

        return $next($request);
    }
}
