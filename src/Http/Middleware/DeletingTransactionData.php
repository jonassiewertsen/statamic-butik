<?php

namespace Jonassiewertsen\StatamicButik\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class DeletingTransactionData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // TODO: Please enable me again when the time comes or remove me completly
//        if ($this->sessionExists() && $this->sessionExpired()) {
//            session()->forget('butik.transaction');
//        }

        return $next($request);
    }

    private function sessionExists()
    {
        return Session::has('butik.transaction');
    }

    private function sessionExpired()
    {
        $expiresAfter = config('statamic-butik.transaction_data_cache');

        return Session::get('butik.transaction.created_at') < now()->subMinutes($expiresAfter);

    }
}