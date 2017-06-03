<?php namespace App\Http\Middleware;

class RequireAuthentication implements Middleware {

    public function handle($request, Closure $next, ...$guards) : Request {

    }
}