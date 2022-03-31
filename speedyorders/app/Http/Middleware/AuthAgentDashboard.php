<?php

namespace App\Http\Middleware;

use App\Models\Agent;
use App\Utils\Option;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthAgentDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function handle($request, Closure $next)
    {
        if (!auth('admin')) {
            return redirect()->route('admin.login');
        }

        if (!$request->agent_id) {
            return redirect()->back();
        }

        $tokenTTL = Option::get('token_ttl_sdk');
        $agent = Agent::find($request->agent_id);

        if (!$token = auth('auth-agent-sdk')->setTTL($tokenTTL)->login($agent)) {

            //if(!Auth::guard('auth-agent-dashboard')->loginUsingId($request->agent_id)){
            return response()->json([
                'success' => false,
                'data' => [
                    'error' => 'Invalid credentials.',
                ],
            ], 200);
        }

        /*        Session::put('auth_agent_dashboard_id',$agent->id);
                Session::save();*/

        return $next($request);
    }
}
