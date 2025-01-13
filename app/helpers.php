<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($number)
    {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 2) . 'B';  // Format miliar
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 2) . 'M';  // Format juta
        } else {
            return number_format($number);
        }
    }
}

?>