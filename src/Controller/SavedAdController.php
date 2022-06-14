<?php

declare(strict_types=1);

namespace AdsWebsite\Controller;

use AdsWebsite\Repository\SavedAdRepository;
use AdsWebsite\Repository\AdRepository;
use AdsWebsite\Service\UserRegistry;

class SavedAdController
{
    public function createSavedAd(string $id): void
    {
        $userRegistry = new UserRegistry();
        $loggedInCustomer = $userRegistry->getCurrentlyLoggedInUser();

        $savedAd = [
            'customer_id' => $loggedInCustomer['id'],
            'ad_id' => $id,
        ];

        $repository = new SavedAdRepository();
        $repository->create($savedAd);

        header('Location: /ad/list');
    }

    public function listCustomerSavedAds(): void
    {
        $userRegistry = new UserRegistry();
        $loggedInCustomer = $userRegistry->getCurrentlyLoggedInUser();

        $repository = new AdRepository();
        $ads = $repository->findAllSavedByCustomer($loggedInCustomer['id']);

        $innerTemplate = './view/saved_ads.php';

        require './view/page.php';
    }

}