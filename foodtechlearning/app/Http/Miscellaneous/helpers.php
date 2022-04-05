<?php

if (!function_exists('uiavatar')) {
    function uiavatar($name = 'John Doe')
    {
        return "https://ui-avatars.com/api/?name=$name";
    }
}
