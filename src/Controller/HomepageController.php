<?php

declare(strict_types=1);

namespace AdsWebsite\Controller;

class HomepageController
{
    public function show(): void
    {
        require './view/page.php';
    }
}