<?php

namespace Core;

class Validator
{
    // checks if the value is not null or empty
    public static function required($value): bool
    {
        return isset($value);
    }
    public static function nullable($value, callable $validationFunction): bool
    {
        // if the value is null or an empty string, it's valid
        if (is_null($value) || $value === '') {
            return true;
        }

        // if the value is not null run the provided validation function (for example number , string ...)
        return $validationFunction($value);
    }
    // checks if the value is string
    public static function string($value, $min = 1, $max = INF)
    {

        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    // checks if the value is email 
    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
    // checks if the value is number
    public static function number(string $value): bool
    {
        // dd($value);
        return is_numeric($value);
    }

    // checks if the value is date
    public static function date(string $value): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        return $date && $date->format('Y-m-d') === $value;
    }

    // checks if the value of date1 is after the value of date2
    public static function isDateGreater($date1, $date2): bool
    {
        if (!$date1 || !$date2) {
            return true;
        }
        try{
            $d1 = \DateTime::createFromFormat('Y-m-d', $date1); 
            $d2 = \DateTime::createFromFormat('Y-m-d', $date2); 
    
        }catch(\Exception $e){
            return false;
        }

        // Invalid dates provided
        if (!$d1 || !$d2) {
            return false; 
        }

        return $d1 > $d2;
    }
}
