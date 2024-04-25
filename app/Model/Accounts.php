<?php

namespace Model;

class Accounts
{
    static public function registerValidate(array $userData): string|bool
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

        if (str_contains($userData['login'], ' ')) {
            return \Bootstrap::__("Login field should not contain spaces!");
        }

        if (mb_strlen($userData['password']) < 8) {
            return \Bootstrap::__("Password is too short!");
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return \Bootstrap::__("Email is not valid!");
        }

        if (\Model\Accounts::emailRepetition(\DBAdapter::getConnection(), $userData['email'])) {
            return \Bootstrap::__("Email already exists!");
        }

        return false;
    }

    static public function loginValidate(array $formData): bool|string
    {
        if (trim($formData['email']) == '') {
            return \Bootstrap::__("No empty fields allowed!");
        }

        if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
            return \Bootstrap::__("Email is not valid!");
        }

        return false;
    }

    static public function emailRepetition(\mysqli $connect, string $email): bool
    {
        $usernameStmt = mysqli_prepare($connect, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($usernameStmt, "s", $email);
        mysqli_stmt_execute($usernameStmt);
        $result = mysqli_stmt_get_result($usernameStmt);
        $requestResult = [];

        while ($item = mysqli_fetch_assoc($result)) {
            $requestResult[] = $item;
        }

        return (bool)sizeof($requestResult);
    }

    static public function registerUser(\mysqli $connect, array $userData): void
    {
        $registerStmt = mysqli_prepare($connect, 'INSERT INTO users VALUES (null, ?, ?, ?, ?)');
        $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);

        mysqli_stmt_bind_param(
            $registerStmt,
            "ssss",
            $userData['email'], $userData['login'], $hashedPassword, $userData['role']
        );
        mysqli_stmt_execute($registerStmt);
    }

}