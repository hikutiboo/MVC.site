<?php
declare(strict_types=1);
/**
 * @function will translate from file mask en_{ln}.csv
 * @param string $string
 * @return string
 */

class Bootstrap
{
    static function __(string $string) : string {
        $ln = $_GET['ln'] ?? false;
        $file = "en_$ln.csv";

        if($ln && isset($_SESSION['ln']) && $_SESSION['ln'] != $ln || !isset($_SESSION['translate'])) {
            $_SESSION['ln'] = $ln;
            if(file_exists($file)) {
                $_SESSION['translate'] = file($file);
            } else {
                unset($_SESSION['translate']);
            }
        }

        if(isset($_SESSION['translate']) && is_array($_SESSION['translate'])) {
            foreach ($_SESSION['translate'] as $line) {
                if(strpos($line, $string."/&/") === 0) {
                    return explode("/&/", $line)[1] ?? $string;
                }
            }
//            file_put_contents('translate.log', $string.PHP_EOL , FILE_APPEND | LOCK_EX);
        }

        return $string;
    }
}