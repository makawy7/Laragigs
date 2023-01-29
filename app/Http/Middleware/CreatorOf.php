<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CreatorOf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $listing = $request->route()->parameter('listing');
        if ($listing->user_id !== auth()->user()->id) {
            return back()->with('message', 'Not Allowed!');
        }
        return $next($request);
    }
}
