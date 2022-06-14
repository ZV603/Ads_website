<?php

declare(strict_types=1);

namespace AdsWebsite\Controller;

use AdsWebsite\Repository\AdRepository;
use AdsWebsite\Service\UserRegistry;

class AdController
{
    public function listAds(): void
    {
        $repository = new AdRepository();
        $ads = $repository->getAll();

        $innerTemplate = './view/list_ads.php';

        require './view/page.php';
    }

    public function showCreateAdForm(): void
    {
        $pageTitle = 'New Ad';
        $actionRoute = '/ad/create';
        $innerTemplate = './view/create_edit_ad.php';

        require './view/page.php';
    }

    public function handleCreateAdSubmission(): void
    {
        $repository = new AdRepository();
        $newAd = [
            'customer_id' => $_SESSION['authenticated_user_id'],
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'contact_phone' => $_POST['contact_phone'],
        ];
        $repository->create($newAd);

        header('Location: /ad/list');
    }

    public function showEditAdForm(string $id): void
    {
        // is kazkur gauti redaguojamo iraso ID
        // pagal ta ID is failo uzkrauti reikalinga irasa
        $repository = new AdRepository();
        $ad = $repository->getOneById($id);
        $pageTitle = 'Edit Ad';
        $actionRoute = '/ad/' . $id . '/edit';
        // to iraso duomenis paduoti i template'a
        // grazinti template i vartotojo narsykle

        $innerTemplate = './view/create_edit_ad.php';

        require './view/page.php';
    }

    public function handleEditAdSubmission(string $id): void
    {
        $repository = new AdRepository();
        // uzloadiname sena irasa
        $ad = $repository->getOneById($id);
        
        $ad['title'] = $_POST['title'];
        $ad['description'] = $_POST['description'];
        $ad['price'] = $_POST['price'];
        $ad['contact_phone'] = $_POST['contact_phone'];
        
        $repository->update($ad);

        header('Location: /ad/list');
    }

    public function handleDeleteAd(string $id): void
    {
        $repository = new AdRepository();
        $repository->delete($id);

        header('Location: /ad/list');
    }

    public function listLoggedInUserAds(): void
    {
        // gauti prisijungusi vartotoja
        $userRegistry = new UserRegistry();
        $loggedInCustomer = $userRegistry->getCurrentlyLoggedInUser();
        // issitraukti vartotojo skelbimus is db
        $repository = new AdRepository();
        $ads = $repository->findAllByCustomerId($loggedInCustomer['id']);
        $innerTemplate = './view/list_ads.php';

        require './view/page.php';
    }
}
