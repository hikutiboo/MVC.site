<?php
declare(strict_types=1);

class Arr
{
    static public function extractFields(array $target, array $fields): array {
        $arrayResult = [];

        foreach ($fields as $field) {
            $arrayResult[$field] = isset($target[$field])?trim($target[$field]):'';
        }
        return $arrayResult;
    }
}
