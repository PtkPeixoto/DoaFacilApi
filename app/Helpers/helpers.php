<?php
if (!function_exists('generateSimpleToken')) {
    function generateSimpleToken($length = 8) {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // Sem caracteres confusos
        return substr(str_shuffle(str_repeat($characters, $length)), 0, $length);
    }
}
?>
