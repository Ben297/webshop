<?php


namespace App\Controllers;


use App\Models\User;
use Core\View;

class Authentication
{
    public function showRegistrationForm()
    {
        View::renderTemplate('registration.html');
    }

    /**
     * Function to Register the User and validate the input of the User
     * TODO Validate the user input
     */
    public function creatUser()
    {
        $newUser =  new User();
        $userData = $_POST;
        $userData['password'] = password_hash($userData['password'],PASSWORD_DEFAULT);
        $userID = $newUser->insertUser($userData);
        $newUser->insertAddress($userData,$userID);
    }
}