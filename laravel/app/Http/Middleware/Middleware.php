<?php namespace App\Http\Middleware;

interface Middleware {
    public function handle($request, Closure $next, ...$guards) : Request;
}