<?php
declare(strict_types=1);

namespace Model;

/**
 * @by ProfStep, inc. 23.12.2020
 * @website: https://profstep.com
 **/
class Messages
{
    static function getMessages($connect): array
    {
        $queryString = "SELECT * FROM messages WHERE status = 0 or status = 3";
        $result_arr = mysqli_fetch_all(mysqli_query($connect, $queryString), MYSQLI_ASSOC);
        return $result_arr ?? [];
    }

    static function getCensoredMessages($connect): array
    {
        $queryString = "SELECT * FROM messages WHERE status = 1";
        $result_arr = mysqli_fetch_all(mysqli_query($connect, $queryString), MYSQLI_ASSOC);
        return $result_arr ?? [];
    }

    static function setMessage(\mysqli $connect, array $fields, int $status = 0): bool
    {
        $queryString = sprintf(
            "INSERT into messages VALUES (null, '%s', '%s', '%s', now(), '%s', '%s')",
            $fields['name'],
            $fields['title'],
            $fields['message'],
            $status,
            $fields['email']
        );
        $result = mysqli_query($connect, $queryString) or die(mysqli_error($connect));
        return is_bool($result) ? $result : false;
    }

    static function getMessage($connect, $id): array
    {
        $queryString = sprintf("SELECT * FROM messages WHERE id = %s", $id);
        $result_arr = mysqli_fetch_assoc(mysqli_query($connect, $queryString));
        return $result_arr ?? [];
    }

    static function messagesValidate(array &$fields, int $role): array
    {
        $errors = [];
        $nameLen = mb_strlen($fields['name'], 'UTF-8');
        $titleLen = mb_strlen($fields['title'], 'UTF-8');

        if ($role === 2) {
            $errors[] = \Bootstrap::__('Managers are not allowed to post messages!');
            return $errors;
        }

        if ($role === 0) {
            $errors[] = \Bootstrap::__('Log in to post messages!');
            return $errors;
        }

        if (mb_strlen($fields['message'], 'UTF-8') < 2) {
            $errors[] = \Bootstrap::__('Message length must be not less then 2 characters!');
        }

        if ($nameLen < 2 || $nameLen > 140) {
            $errors[] = \Bootstrap::__('Name must be from 2 to 140 chars!');
        }

        if ($titleLen < 10 || $titleLen > 140) {
            $errors[] = \Bootstrap::__('Title must be from 10 to 140 chars!');
        }

        $fields['name'] = htmlspecialchars($fields['name']);
        $fields['title'] = htmlspecialchars($fields['title']);
        $fields['message'] = htmlspecialchars($fields['message']);

        return $errors;
    }
    
    static public function editingValidate(array &$fields): array
    {
        $errors = [];
        $titleLen = mb_strlen($fields['title'], 'UTF-8');

        if (mb_strlen($fields['message'], 'UTF-8') < 2) {
            $errors[] = \Bootstrap::__('Message length must be not less then 2 characters!');
        }

        if ($titleLen < 10 || $titleLen > 140) {
            $errors[] = \Bootstrap::__('Title must be from 10 to 140 chars!');
        }

        $fields['title'] = htmlspecialchars($fields['title']);
        $fields['message'] = htmlspecialchars($fields['message']);

        return $errors;
    }

    static public function moderateMessage(\mysqli $connect, int $id, int $status = 1): void
    {
        $queryStmt = mysqli_prepare($connect, "UPDATE messages SET status = ? WHERE id = ?");
        mysqli_stmt_bind_param($queryStmt, "ii", $status, $id);
        mysqli_stmt_execute($queryStmt);
    }

    static public function getCensoredWords(\mysqli $connect): array
    {
        $queryString = "SELECT * FROM censored_words";
        $result_arr = mysqli_fetch_all(mysqli_query($connect, $queryString), MYSQLI_ASSOC);
        return $result_arr ?? [];
    }

    static public function addCensoredWord(\mysqli $connect, string $text): array
    {
        $message = "No words to add";
        if (empty(trim($text))) return ["type" => "danger", "text" => $message];
        else $message = ["type" => "success", "text" => \Bootstrap::__("Adding was successfully done, all words added!")];

        if (preg_match("/^\/.*\/[a-z]*$/i", $text)) {
            if (!preg_match("/^\/.*\/$/i", $text)) {
                return ["type" => "danger", "text" => \Bootstrap::__("Regex should not contain any options!")];
            }
            if (self::checkCensoredWordExist($connect, $text)) {
                return ["type" => "danger", "text" => \Bootstrap::__("Regex was not added, it's already in the list!")];
            }
            $queryStmt = mysqli_prepare($connect, "INSERT into censored_words VALUES (null, ?, 1)");
            mysqli_stmt_bind_param($queryStmt, "s", $text);
            mysqli_stmt_execute($queryStmt);
            return $message;
        }

        $wordsList = explode(" ", $text);
        foreach ($wordsList as $word) {
            if (empty($word) || self::checkCensoredWordExist($connect, $word)) {
                $message = ["type" => "danger", "text" => \Bootstrap::__("Some words was not added, check the list or try again try again!")];
                continue;
            }

            $queryStmt = mysqli_prepare($connect, "INSERT into censored_words VALUES (null, ?, 1)");
            mysqli_stmt_bind_param($queryStmt, "s", $word);
            mysqli_stmt_execute($queryStmt);
        }
        return $message;
    }

    static public function checkCensoredWordExist(\mysqli $connect, string $word): bool
    {
        $queryString = sprintf("SELECT word FROM censored_words WHERE word = '%s'", $word);
        $result_arr = mysqli_fetch_all(mysqli_query($connect, $queryString), MYSQLI_ASSOC);
        return !empty($result_arr);
    }

    static public function deleteCensoredWord(\mysqli $connect, int $id): array
    {
        $queryStmt = mysqli_prepare($connect, "DELETE FROM censored_words WHERE id = ?");
        mysqli_stmt_bind_param($queryStmt, "i", $id);
        mysqli_stmt_execute($queryStmt);
        if (!mysqli_error($connect)) {
            return ["type" => "success", "text" => \Bootstrap::__("Word deleted successfully!")];
        }
        return ["type" => "danger", "text" => \Bootstrap::__("Failed to delete word, please try again later")];
    }

    static public function allowMessage(\mysqli $connect, string $id): array
    {
        $queryStmt = mysqli_prepare($connect, "UPDATE messages SET status = 3 WHERE id = ?");
        mysqli_stmt_bind_param($queryStmt, "i", $id);
        mysqli_stmt_execute($queryStmt);
        if (!mysqli_error($connect)) {
            return ["type" => "success", "text" => \Bootstrap::__("Message allowed successfully!")];
        }
        return ["type" => "danger", "text" => \Bootstrap::__("Failed to restore message, please try again later")];
    }

    static public function deleteMessage(\mysqli $connect, string $id): array
    {
        $queryStmt = mysqli_prepare($connect, "UPDATE messages SET status = 2 WHERE id = ?");
        mysqli_stmt_bind_param($queryStmt, "i", $id);
        mysqli_stmt_execute($queryStmt);
        if (!mysqli_error($connect)) {
            return ["type" => "success", "text" => \Bootstrap::__("Message deleted successfully!")];
        }
        return ["type" => "danger", "text" => \Bootstrap::__("Failed to delete message, please try again later")];
    }

    static public function checkForCensorship(\mysqli $connect, string $message): array
    {
        $words = self::getCensoredWords($connect);
        $textForCheck = str_replace(' ', '', $message);
        $matches = [];
        foreach ($words as $word) {
            $search = self::string_to_regex($word['word'], CENSORSHIP_OPTIONS);
            if (preg_match_all($search, $textForCheck, $currentMatches) === false) {
                echo "error";
            }
            $matches = array_merge($matches, $currentMatches[0]);
        }
        if (empty($matches)) {
            return ["allow" => true];
        }
        return ["allow" => false, "message" => \Bootstrap::__("This message did not pass censorship and was sent to the administration for review!")];
    }

    static public function string_to_regex(string $string, string $options): string
    {
        $result = $string;
        if (preg_match("/^\/.+\/$/i", $string)) {
            $result = $string . $options;
        } else {
            $result = '/' . $string . '/' . $options;
        }
        return $result;
    }

    static public function editMessage(\mysqli $connect, int $id, array $fields, int $status = 0): array
    {
        $queryStmt = mysqli_prepare($connect, "UPDATE messages SET title = ?, message = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($queryStmt, "ssii", $fields["title"], $fields["message"], $status, $id);
        mysqli_stmt_execute($queryStmt);
        if (!mysqli_error($connect)) {
            return ["success" => true, "message" => \Bootstrap::__("Message successfully edited!")];
        }
        return ["success" => false, "message" => \Bootstrap::__("Something went wrong, message was not edited!")];
    }
}