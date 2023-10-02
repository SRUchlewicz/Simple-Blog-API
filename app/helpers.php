<?php

if (! function_exists('getDefaultPerPage')) {
    function getDefaultPerPage()
    {
        return (int) config('custom.entities_per_page');
    }
}
