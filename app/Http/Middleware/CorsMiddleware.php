<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class CorsMiddleware
 *
 * @package App\Http\Middleware
 */
class CorsMiddleware
{
    /** @var string */
    protected $path;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->path    = $request->getPathInfo();
    }

    /**
     * @param          $request
     * @param Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers'     => '*',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
