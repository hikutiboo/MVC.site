<?php

namespace Controller\Contacts;

class Contacts extends \Controller\Controller
{
    static public function run()
    {
        $viewData = new \Model\ViewData();

        \Model\RenderHTMLPage::renderHTML(['view/contacts/v_contacts.php'], $viewData);
    }
}