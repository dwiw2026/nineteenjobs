<?php

namespace App\Http\Middleware;

use App\Models\AgentToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentTokenMiddleware
{
    /**
     * Handle an incoming request from Hermes agent.
     * Verifies the Bearer token and attaches the AgentToken model to the request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $raw = $request->bearerToken();

        if (!$raw) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Agent token required.',
            ], 401);
        }

        $token = AgentToken::findByRaw($raw);

        if (!$token || $token->isExpired()) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => 'Invalid or expired agent token.',
            ], 401);
        }

        // Update last_used_at
        $token->update(['last_used_at' => now()]);

        // Attach token to request for controllers to inspect abilities
        $request->attributes->set('agent_token', $token);

        return $next($request);
    }
}
