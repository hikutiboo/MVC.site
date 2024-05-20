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
            echo !trim($value);
            if (!trim($value)) {
                return ucfirst($key) . \Bootstrap::__(" field should not be empty!") . __LINE__;
            }

            if ((mb_strlen($value) < 3 || mb_strlen($value) > 24) && $key !== 'email' && $key !== 'role') {
                return ucfirst($key) . \Bootstrap::__(" field value has wrong length!");
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

        $emailRepetitions = \Model\Accounts::emailRepetition(\DBAdapter::getConnection(), $userData['email']);
        if (sizeof($emailRepetitions)) {
            return \Bootstrap::__("This email is already in use!");
        }

        return false;
    }

    static public function loginValidate(array $userData): bool|string
    {
        $email = $userData['email'];

        if (trim($email) == '') {
            return \Bootstrap::__("Email field should not be empty!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return \Bootstrap::__("Email is not valid!");
        }

        $emailRepetitions = \Model\Accounts::emailRepetition(\DBAdapter::getConnection(), $email);
        if (sizeof($emailRepetitions) < 1) {
            return \Bootstrap::__("User not found!");
        }

        if (sizeof($emailRepetitions) > 1) {
            # TODO: log about double email
            return
                \Bootstrap::__(
                    "Something went wrong with your account!<br>Please wait, moderation will fix that as fast, as possible!"
                );
        }

        return false;
    }

    static public function loginError(array $userData, string $password): bool|string
    {
        return password_verify($password, $userData['password']) ? false : \Bootstrap::__("Wrong password!");
    }

    static public function emailRepetition(\mysqli $connect, string $email): array
    {
        $usernameStmt = mysqli_prepare($connect, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($usernameStmt, "s", $email);
        mysqli_stmt_execute($usernameStmt);
        $result = mysqli_stmt_get_result($usernameStmt);
        $requestResult = [];

        while ($item = mysqli_fetch_assoc($result)) {
            $requestResult[] = $item;
        }

        return $requestResult;
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