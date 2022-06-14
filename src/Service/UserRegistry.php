<?php

declare(strict_types=1);

namespace AdsWebsite\Service;

// naudokime cia ne failu repozitorija, bet db repozitorija
// use AdsWebsite\Repository\Repository;
use AdsWebsite\Repository\CustomerRepository;

class UserRegistry
{
    public function getCurrentlyLoggedInUser()
    {
        if (isset($_SESSION['authenticated_user_id'])) {
            // naudokime cia ne failu repozitorija, bet db repozitorija
            // $repository = new Repository('./data/users.json');
            $repository = new CustomerRepository();
    
            return $repository->getOneById($_SESSION['authenticated_user_id']);
        }

        return null;
    }
}