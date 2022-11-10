<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Debug
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
        // set $onlyInDebugMode to false if this method is also allowed to work on the production server
        $onlyInDebugMode = true;
        $response = $next($request);

        // go to the view if $onlyInDebugMode = true and if APP_DEBUG = false in .env file
        if ($onlyInDebugMode && !config('app.debug')) {
            return $response;
        }

        if ($request->hasAny(['json', 'dd', 'ddd', 'dump']) && $request->getMethod() === 'GET') {
            // get the data
            $data = $response->getOriginalContent()->getData();
            // ?json: output the data as a JSON
            if ($request->exists('json') && $request->isNotFilled('json')) return response()->json($data);
            // ?dd: dump and die
            if ($request->exists('dd') && $request->isNotFilled('dd')) dd($data);
            // ?ddd dump, die and debug
            if ($request->exists('ddd') && $request->isNotFilled('ddd')) ddd($data);
            // ?dump: dump the data and proceed
            if ($request->exists('dump') && $request->isNotFilled('dump')) dump($data);
        }
        return $response;
    }
}
