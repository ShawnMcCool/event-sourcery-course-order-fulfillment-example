<?php namespace App\Http\Middleware;

use Ramsey\Uuid\Uuid;
use Session;

class FakeCustomerSession {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next) {
        if ( ! Session::has('customer_name') || ! Session::has('customer_id')) {
            $faker = \Faker\Factory::create();

            Session::put('customer_name', $faker->name);
            Session::put('customer_id', Uuid::uuid4()->toString());
        }

        return $next($request);
    }
}