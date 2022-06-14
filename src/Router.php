<?php

declare(strict_types=1);

namespace AdsWebsite;

use AdsWebsite\DTO\Route;
use AdsWebsite\Controller\AdController;
use AdsWebsite\Controller\HomepageController;
use AdsWebsite\Controller\AuthenticationController;
use AdsWebsite\Controller\SavedAdController;

class Router
{
    public function doRouting(): void
    {
        $route = $this->parseRoute();

        if ($route->getResource() === 'ad') {
            $this->routeAds($route);
        }

        if ($route->getResource() === 'my-ads') {
            $controller = new AdController();
            $controller->listLoggedInUserAds();
            die();
        }

        if ($route->getResource() === '') {
            $controller = new HomepageController();
            $controller->show();
            die();
        }

        if ($route->getResource() === 'login') {
            // reikia naujo kontrolerio
            $controller = new AuthenticationController();
            if ($route->getMethod() === 'GET') {
                $controller->showLoginForm();
            } elseif ($route->getMethod() === 'POST') {
                $controller->handleLogin();
            }
            
            die();
        }

        if ($route->getResource() === 'registration') {
            $controller = new AuthenticationController();
            if ($route->getMethod() === 'GET') {
                $controller->showRegistrationForm();
            } elseif ($route->getMethod() === 'POST') {
                $controller->handleRegistration();
            }
            
            die();
        }

        if ($route->getResource() === 'logout') {
            $controller = new AuthenticationController();
            $controller->handleLogout();
            die();
        }

        if ($route->getResource() === 'saved-ads') {
            $controller = new SavedAdController();
            $controller->listCustomerSavedAds();
            die();
        }

        http_response_code(404);
    }

    private function routeAds(Route $route): void
    {
        $controller = new AdController();
        switch ($route->getAction()) {
            case 'list': 
                $controller->listAds();
                break;
            case 'create':
                if ($route->getMethod() === 'GET') {
                    $controller->showCreateAdForm();
                } elseif ($route->getMethod() === 'POST') {
                    $controller->handleCreateAdSubmission();
                } else {
                    http_response_code(404);
                }
                
                break;
            case 'edit':
                if ($route->getMethod() === 'GET') {
                    // rodome forma
                    if ($route->getId() === null) {
                        http_response_code(404);
                        break;
                    }
                    $controller->showEditAdForm($route->getId());
                } elseif ($route->getMethod() === 'POST') {
                    // submittiname forma
                    $controller->handleEditAdSubmission($route->getId());
                } else {
                    http_response_code(404);
                }
                
                break;
            case 'delete':
                if ($route->getId() === null) {
                    http_response_code(404);
                    break;
                }
                $controller->handleDeleteAd($route->getId());
                break;
            case 'saved-ad':
                if ($route->getId() === null) {
                    http_response_code(404);
                    break;
                }
                $controller = new SavedAdController();
                $controller->createSavedAd($route->getId());
                break;
            default:
                http_response_code(404);
                break;
        }
        die();
    }

    /*
        pvz. 'ad/15/create' po 'explode' skaidosi i 
        [
            0 => 'ad', // resursas (resource)
            1 => '15', // id
            2 => 'create', // veiksmas (action)
        ]

        pvz. 'ad/list' po 'explode' skaidosi i 
        [
            0 => 'ad', // resursas (resource)
            1 => 'list', // veiksmas (action)
        ]

        pvz. '' po 'explode' skaidosi i 
        [
            0 => '', // resursas (resource)
        ]
    */
    private function parseRoute(): Route
    {
        $route = new Route();
        $route->setMethod($_SERVER['REQUEST_METHOD']);

        $uri = $_SERVER['REQUEST_URI'];
        $uri = trim($uri, '/');

        $parts = explode('/', $uri);
        $route->setResource($parts[0]);

        // issitraukti actiona arba id
        if (!isset($parts[1])) {
            return $route;
        }

        if (is_numeric($parts[1])) {
            $route->setId($parts[1]);
            $route->setAction($parts[2]);
        } else {
            $route->setId(null);
            $route->setAction($parts[1]);
        }

        return $route;
    }
}
