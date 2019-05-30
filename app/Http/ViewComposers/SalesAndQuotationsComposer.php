<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Variable;

class SalesAndQuotationsComposer
{
    function compose(View $view)
    {
        $view->exchange = Variable::find(1)->value;
    }
}