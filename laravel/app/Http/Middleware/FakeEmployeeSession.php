<?php namespace App\Http\Middleware;

use Session;
use Ramsey\Uuid\Uuid;

class FakeEmployeeSession {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ( ! Session::has('employee_name') || ! Session::has('employee_id')) {
            $faker = \Faker\Factory::create();

            Session::put('employee_name', $faker->name);
            Session::put('employee_id', Uuid::uuid4()->toString());
        }

        return $next($request);
    }
}