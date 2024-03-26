<?php

namespace Controller\Accounts;

class Register extends \Controller\Controller
{
    static public function run()
    {
        $formData = $_POST;
        $viewData = new \Model\ViewData();
        $title = \Bootstrap::__('Register');
        $error = \Model\Accounts::validateUser($formData);

        if ($error === false) {
            \Model\Accounts::registerUser($formData);
        }

        $viewData->addData(['title'=>$title, 'error'=>$error]);
        \Model\RenderHTMLPage::renderHTML(['view/accounts/v_register.php'], $viewData);
    }
}