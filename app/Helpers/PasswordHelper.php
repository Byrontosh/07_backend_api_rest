<?php

namespace App\Helpers;

class PasswordHelper
{

    // Función para generar la encriptación del password 
    private static string $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
    private static int $length = 16;

    public static function generatePassword()
    {
        $count = mb_strlen(self::$characters);
        for ($i = 0, $result = ''; $i < self::$length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr(self::$characters, $index, 1);
        }
        return $result;
    }
}
