<?php

function debug($str)
{
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}

if(!function_exists('crypter'))
{
    function crypter($string)
    {
        return str_replace('=', '',base64_encode(BEGIN_KEY. $string .END_KEY));
    }
}
if(!function_exists('decrypter'))
{
    function decrypter($string)
    {
        $string = base64_decode($string);
        $string = str_replace(BEGIN_KEY, '', $string);
        $string = str_replace('=', '',str_replace(END_KEY, '', $string));
        return $string;
    }
}

if(!function_exists('what_service'))
{
    function what_service($number)
    {
        if(!is_valid_number($number))
        {
           return false;
        }

        $number = radicalise_number($number);


        if(stripos($number, '81') === 1 || stripos($number, '82') === 1)
        {
            return VODACOM;
        }
        elseif(stripos($number, '97') === 1 || stripos($number, '99') === 1)
        {
            return AIRTEL;
        }
        elseif(stripos($number, '85') === 1 || stripos($number, '89') === 1 || stripos($number, '87') === 1)
        {
            return ORANGE;
        }else
        {
            return false;
        }
    }
}
if(!function_exists('radicalise_number'))
{
    function radicalise_number($number)
    {
        $number = $number;
        if(stripos($number, '+') === 0)
        {
            $number = substr_replace($number, '', 0, 4 );
        }

        if(stripos($number, '243') === 0)
        {
            $number = substr_replace($number, '', 0, 3 );
        }
        if(stripos($number, '0') !== 0)
        {
            $number = '0'.$number;
        }

        return $number;
    }
}
if(!function_exists('get_prefix'))
{
    function get_prefix($number)
    {
        $number = radicalise_number($number);

        return substr($number, 1, 2);
    }
}
if(!function_exists('is_valid_number'))
{
    function is_valid_number($numero)
    {
        $return = false;
        $prefix = array(81,82,85,86,87,89,90,91,97,99);
        $numero = radicalise_number($numero);
        foreach($prefix as $p)
        {
            if(in_array(get_prefix($numero), $prefix))
            {
                if(strlen($numero) == 10 AND is_numeric($numero))
                {
                    $return = true;
                }
                break;
            }
        }
        return $return;
    }
}
