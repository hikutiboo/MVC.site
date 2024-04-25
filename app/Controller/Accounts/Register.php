<?php

namespace Controller\Accounts;

class Register extends \Controller\Controller
{
    static public function run()
    {
        $formData = $_POST;
        $viewData = new \Model\ViewData();
        $error = \Model\Accounts::registerValidate($formData);

        if ($error === false) {
            \Model\Accounts::registerUser(\DBAdapter::getConnection(), $formData);
        }

        $viewData->addData([
            'title' => \Bootstrap::__('Register'),
            'error' => $error
        ]);
        \Model\RenderHTMLPage::renderHTML(['view/accounts/v_register.php'], $viewData);
    }
}