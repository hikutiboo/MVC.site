<?php

namespace Controller\Errors;

class e404 extends \Controller\Controller
{
    static public function run()
    {
        $title = 'Error 404';
        include('view/errors/v_404.php');
    }
}