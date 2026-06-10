<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfPlacementCompleted
{
    private const REQUIRED_SECTIONS = ['grammar', 'vocabulary', 'reading', 'writing'];

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        $studentProfile = $user->studentProfile;

        if (! $studentProfile) {
            return $next($request);
        }

        $sectionsDone = $studentProfile->placement_sections_completed ?? [];

        if (count(array_intersect(array_keys($sectionsDone), self::REQUIRED_SECTIONS)) === count(self::REQUIRED_SECTIONS)) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
