<?php
declare(strict_types=1);

namespace Model;

class RenderHTMLPage
{
    static public function renderHTML(array $HTMLPathsArray, ViewData $viewData): void
    {
        include('view/base/v_header.php');
        include('view/base/v_content.php');
        foreach ($HTMLPathsArray??[] as $path) {
            include($path);
        }
        include('view/base/v_footer.php');
    }
}