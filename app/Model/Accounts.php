<?php

namespace Model;

class Accounts
{
    static public function validateUser(array $userData): string|bool
    {
        if (empty($userData)) {
            return '';
        }

        foreach ($userData as $key => $value) {
            if (!trim($value)) {
                return \Bootstrap::__(ucfirst($key) . " field should not be empty!");
            }

            if ((mb_strlen($value) < 3 || mb_strlen($value) > 24) && $key !== 'email' && $key !== 'role') {
                return \Bootstrap::__(ucfirst($key) . " field value has wrong length!");
            }
        }

        if (str_contains($userData['username'], ' ')) {
            return \Bootstrap::__("Username field should not contain spaces!");
        }

        if (mb_strlen($userData['password']) < 8) {
            return \Bootstrap::__("Password is too short!");
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return \Bootstrap::__("Email is not valid!");
        }

        return false;
    }
    
    static public function emailRepetition()
    {
        // TODO: email repetition from previous projects
    }

    static public function registerUser(array $userData)
    {
        // TODO: registration from previous projects
    }

}