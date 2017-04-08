<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commander</title>
</head>
<body>
<div class="container" >
    <form action="http://localhost/connexion/order" method="post">
        <input type="hidden" name="commande" value="67">
        <input type="hidden" name="email_client" value="mercingoma@gmail.com" />
        <input type="hidden" name="nom_commande" value="Samsung Galaxy note 3" />
        <input type="hidden" name="__montant" value="50" />
        <input type="hidden" name="__devise" value="USD" />
        <input type="hidden" name="__email" value="mercingoma@gmail.com" />
        <input type="hidden" name="__return" value="http://localhost" />
        <input type="hidden" name="__phone_number" value="0897641497">
        <button type="submit" class="">Commander</button>
    </form>
</div>
</body>
</html>

<?php
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

function arrange($data)
{
    $items = [];
    foreach($data as $item=>$value)
    {
        $items[substr($item, -1)][$item] = $value;
    }
    return $items;
}

function named_item($item_name)
{
    $name = $item_name;
    if(preg_match("#sold by#i", $name))
    {
        preg_match("#Sold by:?(.+) \)?$#i", $name, $matches);
        $name = trim($matches[1]);
    }

    return $name;
}
function encoded_url($string)
{
    return str_replace('.', '%2E', urlencode($string));
}
echo urldecode(encoded_url('jesus.com'));
?>