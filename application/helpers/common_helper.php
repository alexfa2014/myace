<?php

if ( ! function_exists('p'))
{
    function p($obj)
    {
        print "<pre> ";
        print_r($obj);
        print "</pre> ";
        exit;
    }
}
