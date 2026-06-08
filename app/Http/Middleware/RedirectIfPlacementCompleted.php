<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfPlacementCompleted
{
    /**
     * If the student has already taken the placement test,
     * block access to the placement test page.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $studentProfile = $user->studentProfile;

        if ($studentProfile && $studentProfile->placement_completed) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
