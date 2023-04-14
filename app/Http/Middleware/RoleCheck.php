<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class RoleCheck
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
        $userRole =User::where('id','=',auth()->user())->where('role','=','admin')->first();
        if ($userRole) {
        // Set scope as admin/moderator based on user role
            $request->request->add([
                'scope' => 'admin'
            ]);
        }

        return $next($request);
    }
}
