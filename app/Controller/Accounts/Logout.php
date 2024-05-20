<?php

namespace Controller\Accounts;

class Logout extends \Controller\Controller
{
    static public function run()
    {
        self::checkTheAnswer();

        $formData = $_POST;
        $connect = \DBAdapter::getConnection();
        $viewData = new \Model\ViewData();

        $viewData->addData([
            'title' => \Bootstrap::__('Are you sure want to log out?'),
        ]);
        \Model\RenderHTMLPage::renderHTML(['view/accounts/v_logout.php'], $viewData);
    }

    static public function checkTheAnswer(): void
    {
        switch (mb_strtolower($_POST['answer'] ?? '')) {
            case 'confirm':
                $_SESSION['user'] = [];

            case 'cancel':
                header("Location: " . HOST . BASE_URL);
                break;
        }
    }
}