<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfPlacementNotCompleted
{
    /**
     * After login, students who haven't taken the placement test
     * are redirected to begin it. Once completed, they proceed
     * to the dashboard.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $studentProfile = $user->studentProfile;

        if ($studentProfile && !$studentProfile->placement_completed) {
            return redirect()->route('placement-test');
        }

        return $next($request);
    }
}
