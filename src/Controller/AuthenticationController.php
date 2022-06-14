<?php

declare(strict_types=1);

namespace AdsWebsite\Controller;

use AdsWebsite\Repository\CustomerRepository;
use PDOException;

class AuthenticationController
{
    public function showLoginForm(): void
    {
        $innerTemplate = './view/login.php';

        require './view/page.php';
    }

    public function handleLogin(): void
    {
        $customer = $this->getCustomer();
        if ($customer === null) {
            // TODO: sutvarkyti redirecta po logino
            echo 'User not found or password is not correct';
        } else {
            $_SESSION['authenticated_user_id'] = $customer['id'];
            header('Location: /');
        }
    }

    private function getCustomer(): ?array
    {
        // issitraukti is failo visus userius
        // eiti per userius ir tikrinti, ar yra vienas useris, kurio email yra lygus $_POST['email']
        // ir kurio password yra $_POST['password']
        $emailFromForm = $_POST['email'];
        $passwordFromForm = $_POST['password'];
        $repository = new CustomerRepository();
        $users = $repository->getAll();

        foreach($users as $user) {
            if (
                $user['email'] === $emailFromForm
                && password_verify($passwordFromForm, $user['password_hash'])
            ) {
                return $user;
            }
        }

        return null;
    }

    public function showRegistrationForm(): void
    {
        $innerTemplate = './view/register.php';

        require './view/page.php';
    }

    public function handleRegistration(): void
    {
        $emailFromForm = $_POST['email'];
        $passwordFromForm = $_POST['password'];
        $repeatedPasswordFromForm = $_POST['repeat_password'];
        $phoneNumberFromForm = $_POST['phone_number'];

        // tikrinti ar passwordai matchina
        if ($passwordFromForm === $repeatedPasswordFromForm) {
            $customer = [
                'email'=> $emailFromForm,
                'password_hash' => password_hash($passwordFromForm, PASSWORD_BCRYPT),
                'phone_number' => $phoneNumberFromForm,
            ];
            // sukurti nauja useri
            $repository = new CustomerRepository();
            try {

                $repository->create($customer);
            } catch (PDOException $exception) {
                if ($exception->getCode() === '23000') {
                    echo 'This email is already taken.';
                    return;
                }
            }
            // TODO: sutvarkyti redirecta po registracijos
            echo 'Registration successful';
            return;
        }
        echo 'passwords do not match';
    }

    public function handleLogout(): void
    {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', 0, '/');
        header('Location: /');
    }
}