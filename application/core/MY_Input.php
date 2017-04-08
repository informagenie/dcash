<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 15/03/2017
 * Time: 02:26
 */

class MY_Input extends CI_Input
{

    function _clean_input_keys($str)
    {
        if ( !preg_match("/^[a-z0-9:_\/\.\[\]%-]+$/i", $str))
        {
            exit('Disallowed Key buzoba.');
        }

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE)
        {
            $str = $this->uni->clean_string($str);
        }

        return $str;
    }
}