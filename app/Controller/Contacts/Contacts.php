<?php

namespace Controller\Contacts;

use Controller\Controller;

class Contacts extends Controller
{
    static public function run()
    {
        $viewData = new \Model\ViewData();

        \Model\RenderHTMLPage::renderHTML(['view/contacts/v_contacts.php'], $viewData);
    }
}