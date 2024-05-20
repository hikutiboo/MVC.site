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
        $emailRepetition = !empty($formData) ? \Model\Accounts::emailRepetition($connect, $formData['email']) : false;
        $loginError = null;

        if (!empty($formData) && !$error) {
            $loginError = \Model\Accounts::loginError($emailRepetition[0], $formData['password']);
            unset($emailRepetition[0]['password']);
        }

        if ($loginError === false) {
            $_SESSION["user"] = $emailRepetition[0];
            header("Location: " . HOST . BASE_URL);
        }

        $viewData->addData([
            'title' => \Bootstrap::__('Log in'),
            'error' => $error ?: $loginError
        ]);
        \Model\RenderHTMLPage::renderHTML(['view/accounts/v_login.php'], $viewData);
    }
}