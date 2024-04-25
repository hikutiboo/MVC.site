<?php

namespace Controller\Accounts;

class Login extends \Controller\Controller
{
    static public function run()
    {
        $formData = $_POST;
        $connect = \DBAdapter::getConnection();
        $viewData = new \Model\ViewData();
        $error = !empty($formData) ? \Model\Accounts::loginValidate($formData) : false;

        $viewData->addData([
            'title' => \Bootstrap::__('Log in'),
            'error' => $error
        ]);
        \Model\RenderHTMLPage::renderHTML(['view/accounts/v_login.php'], $viewData);
    }
}