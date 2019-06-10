<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;
use \App\Poem;

class PoemViews
{
    private $session;
    
    public function __construct(Store $session)
    {
        $this->session = $session;
    }
    
    public function handle($request, Closure $next)
    {
        //Poem::increment('views');
        //$poem->views += 1;

        return $next($request);
    }
}
