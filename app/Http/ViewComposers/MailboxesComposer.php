<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Variable;

class MailboxesComposer
{
    function compose(View $view)
    {
        $view->isShifted = Variable::find(3)->value;
    }
}
