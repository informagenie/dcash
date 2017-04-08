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
        return urlencode(base64_encode(BEGIN_KEY. $string .END_KEY));
    }
}
if(!function_exists('decrypter'))
{
    function decrypter($string)
    {
        return str_replace(BEGIN_KEY, '',str_replace(END_KEY, '', base64_decode(urldecode($string))));
    }
}

if(!function_exists('uriliser'))
{
    function uriliser()
    {

    }
}


if(!function_exists('encrypte_data'))
{
    /**
     * Transforme un tableau à une chaine de parametre d'url et l'encrypte avec crypter
     *
     * @param $data
     * @return string
     */
    function encrypte_data($data)
    {
        $data = http_build_query($data,'', '&');
        return crypter($data);
    }
}

if(!function_exists('decrypte_data'))
{
    /**
     * Transforme les données cryptée par @encrypte_data et le remet en claire
     *
     * @param $data
     * @return mixed
     */
    function decrypte_data($data)
    {
        parse_str(decrypter($data), $output);
        return $output;
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

if(!function_exists('name_provider'))
{
    function name_provider($id)
    {
        switch($id)
        {
            case 1:
                return 'Vodacom (MPESA)';
            break;
            case 2:
                return 'Orange (orange money)';
            break;
            case 3:
                return 'Airtel (airtel money)';
            break;
            default:
                return 'Inconnu';
            break;
        }
    }
}

if(!function_exists('devise_name'))
{
    function devise_name($id)
    {
        switch($id)
        {
            case DEVISE_USD:
                return '$';
                break;
            case DEVISE_CDF:
                return 'FC';
                break;
            default:
                return '$';
                break;
        }
    }
}

if(!function_exists('role_name'))
{
    function role_name($id)
    {
        switch($id)
        {
            case 1:
                return 'admin';
                break;
            case 2:
                return 'manager';
                break;
            case 3:
                return 'employer';
            break;
            case 4:
                return 'vendeur';
            break;
            default:
                return 'false';
                break;
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

if(!function_exists('__'))
{
    function __(&$var)
    {
        if(empty($var) or $var == null)
        {
         return (is_numeric($var)) ? 0 : '-';
        }
        return $var;
    }
}

if(!function_exists('get_items'))
{
    /**
     * Rétourne les items dans les données reçus
     *
     * @param $data
     * @return array
     */
    function get_items($data)
    {
        $items = [];
        foreach($data as $item=>$value)
        {
            if(preg_match('#^item_#i', $item))
            {
                $items[$item] = $value;
            }
        }
        return $items;
    }
}

if(!function_exists('get_fact'))
{
    function get_fact($data)
    {
        $facts = [];

        foreach($data as $fact=>$value)
        {
            if(preg_match('#^fact_#i', $fact))
            {
                $facts[$fact] = $value;
            }
        }
        return $facts;
    }
}

if(!function_exists('get_grouped_item'))
{
    /**
     * Régroupe les produits (items) par rapport à leurs vendeurs
     *
     * @param $data
     * @param bool|false $sub_dimension
     * @return array
     */
    function get_grouped_item($data, $sub_dimension= false)
    {

        $items = [];
        foreach($data as $item=>$value)
        {
            $items[strtolower($data['item_vendor_email_'.substr($item, -1)])][substr($item, -1)][substr_replace($item, '', -2)] = $value;
        }
//        return array_arrange($items);
        return $items;
    }
}

if(!function_exists('total_item'))
{
    function total_item($data)
    {
        $price = 0;
       foreach($data as $k)
       {
           $qte = ($k['item_quantity'] == 0) ? 1 : $k['item_quantity'];
           $price += $k['item_amount'] * $qte;
       }
        return $price;
    }
}

if(!function_exists('total_items'))
{
    function total_items($data)
    {
        $total = 0;
        foreach($data as $k)
        {
            $total += total_item($k);
        }
        return $total;
    }
}

if(!function_exists('total_product'))
{
    function total_product(array $item)
    {
       return $item['item_amount'] * $item['item_quantity'];
    }
}


if(!function_exists('named_item'))
{
    function named_item($item_name)
    {
        $name = $item_name;
        if(preg_match("#sold by#i", $name))
        {
            preg_match("#Sold by:?(.+) \)?$#i", $name, $matches);
            $name = trim($matches[1]);
        }

        return trim($name);
    }
}

if(!function_exists('object_to_array'))
{
    function object_to_array($object)
    {
        $array = [];
        foreach($object as $k=>$v)
        {
            $array[$k] = $v;
        }
        return $array;
    }
}
if(!function_exists('array_with'))
{
    /**
     * @param $array
     * @param $key
     * @param bool|true $inverse
     * @return array
     */
    function array_with($array, $key, $inverse=true)
    {
        $arrays = [];
        foreach($array as $k=>$v)
        {
            if(($k == $key) == $inverse)
            {
                $arrays[$k]=$v;
            }
        }
        return $arrays;
    }

}

if(!function_exists('site_title'))
{
    /**
     * Retourne le titre du site
     *
     * @param $title
     * @param $separator
     * @param bool|true $after
     * @return string
     */
    function site_title($title, $after = false, $separator = SEPARATOR)
    {
        return ($after) ? SITE_NAME.$separator.$title : $title.$separator.SITE_NAME;
    }
}

if(!function_exists('keyer_array'))
{
    /**
     * Remplace le dernier _ (tiret) de la chaine $key par un . (point)
     *
     * @param $key
     * @return mixed
     */
    function keyer_array($key)
    {
        return preg_replace('#(\_){1}(.{2,5})$#i', ".$2", $key);
    }
}

if(!function_exists('phrase_items_quantity'))
{
    function phrase_items_quantity($items)
    {
        $phrase = '';
        if(sizeof($items) == 1)
        {
            $phrase = phrase_item_quantity(current($items));
        }else{
            foreach($items as $item)
            {
                $phrase .= ' ' . phrase_item_quantity($item) . ',';
            }
        }
        return $phrase;
    }
}
if(!function_exists('phrase_item_quantity'))
{
    function phrase_item_quantity($item)
    {
            return '<strong>'.$item['item_quantity']
            .'</strong> '. '<a target="_bank" href="'.E_COMMERCE_HOST.'?p='.$item['item_product_id'].'">'.$item['item_name'] .'</a>';
    }
}

if(!function_exists('livraison_adresse_exist'))
{
    function livraison_adresse_exist($data)
    {
        $bool = false;
        foreach($data as $k=>$v)
        {
            if(preg_match("#^livr_#i", $k))
            {
                $bool = true;
                break;
            }
        }
        return $bool;
    }
}

if(!function_exists('phrase_livraison'))
{
    function phrase_livraison($data)
    {
        $phrase = '';
        $prefix = (livraison_adresse_exist($data)) ? 'livr': 'fact';

        $phrase .= 'à livrer chez <strong>' . $data[$prefix.'_first_name']. ' '. $data[$prefix.'_last_name'].
            '</strong> qui habite à <address>'. $data[$prefix.'_address1'].'</address>';
        $phrase .= (!empty($data[$prefix.'_address2'])) ? ' sa seconde adresse est '. $data[$prefix.'_address2']
            : '';
        $phrase .= ' et son numéro de téléphone est <em>'.$data['day_phone_b'].'</em>';

        return $phrase;
    }
}

if(!function_exists('format_date'))
{
    function format_date($date)
    {
        $date = date('d/m/Y à H:i:s', strtotime($date));
        return $date;
    }
}

if(!function_exists('encoded_url'))
{
    function encoded_url($string)
    {
        return str_replace('.', '%2E', urlencode($string));
    }
}

if(!function_exists('init_email'))
{
    function init_email($email)
    {
        $part_email = explode("@", $email);
        $part_email[0] = str_replace('.', '', $part_email[0]);
        return implode('@', $part_email);
    }
}