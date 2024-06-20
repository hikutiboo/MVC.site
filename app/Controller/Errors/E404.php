<?php

namespace Controller\Errors;

class e404 extends \Controller\Controller
{
    static public function run()
    {
        $viewData = new \Model\ViewData();

        $viewData->addData([
            'title' => \Bootstrap::__('Error 404'),
        ]);
        \Model\RenderHTMLPage::renderHTML(['view/errors/v_404.php'], $viewData);
    }
}