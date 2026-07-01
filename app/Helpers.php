<?php

if (!function_exists('getUserInitialsFromName')) {
    function getUserInitialsFromName($fName, $mName, $lName) {
        return strtoupper(
            ($fName ? substr($fName, 0, 1) : '') .
            ($mName ? substr($mName, 0, 1) : '') .
            ($lName ? substr($lName, 0, 1) : '')
        );
    }
}