<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}
if(!function_exists('status_name'))
{
    function status_name($numero)
    {

        $status = status_list(true);

        if(isset($status[$numero]))
        {
            return $status[$numero];
        }

        return $status[0];
    }
}

if(!function_exists('convert_status'))
{
    function convert_status($n)
    {
        $in_string = array(
            '1'=>'wait',
            '2'=>'process',
            '3'=>'success',
            '4'=>'missing',
            '5'=>'end',
            '0'=>'unknow'
        );
        $in_int = array(
            'wait'=>'1',
            'process'=>'2',
            'success'=>'3',
            'missing'=>'4',
            'end'=>'5',
            'unknow'=>0
        );
        if(is_numeric($n))
        {
            if(isset($in_int[$n])) return $in_int[$n];
            return $in_string[0];
        }
        if(isset($in_string[$n])) return $in_string[$n];
        return $in_string[0];

    }
}
if(!function_exists('status_list'))
{
    function status_list($all = false)
    {

        $status = array(
            '1'=>array(
                'name'=>'En attente',
                'icon'=>'glyphicon-time',
                'color'=>'orange',
                'btn_type'=>'warning'
            ),
            '2'=>array(
                'name'=>'Traitement',
                'icon'=>'glyphicon-option-horizontal',
                'color'=>'#6DFAFF',
                'btn_type'=>'default'
            ),
            '3'=>array(
                'name'=>'Verifié',
                'color'=>'green',
                'icon'=>'glyphicon-ok',
                'btn_type'=>'success'
            ),
            '4'=>array(
                'name'=>'Manque',
                'color'=>'red',
                'icon'=>'glyphicon-remove-circle',
                'btn_type'=>'danger'
            ),
            '5'=>array(
                'name'=>'Terminé',
                'color'=>'#00c0ef',
                'icon'=>'glyphicon-check',
                'btn_type'=>'primary'
            ),
            '0'=>array(
                'name'=>'Inconnu',
                'icon'=>'glyphicon-question-sign',
                'color'=>'pink',
                'btn_type'=>'default'
            )
        );

        $unshow = array(0);

        $show = array();

        foreach($status as $s=>$v)
        {
            if(!in_array($s, $unshow))
            {
                $show[$s]=$v;
            }
        }
        return ($all) ? $status : $show;
    }
}

if(!function_exists('dc_to_wc_status'))
{
    function dc_to_wc_status($status)
    {
        $states = [0=>'pending', 1=>'on-hold', 2=>'processing', 5=>'completed'];
        return isset($states[$status]) ? $states[$status] : $states[0];
    }
}