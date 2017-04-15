<?php
if(!empty($_POST))
{
    echo json_encode($_POST);
    return;
}
?>
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

function init_email($email)
{
    $part_email = explode("@", $email);
    $part_email[0] = str_replace('.', '', $part_email[0]);
    return implode('@', $part_email);
}

$email = "merci.ngoma@gmail.com";

$part_email = explode("@", $email);
print_r(init_email($email));

?>

<form action="./test.php" id="formulaire">
    <input type="text" name="nom">
    <input type="text" name="postnom" id="">
    <input type="submit" value="enregistrer">
</form>
<script src="assets/js/jQuery-2.1.4.min.js"></script>
<script>
$(function(){
    $('#formulaire').find("input[type='submit']").on('click', function(e){
        e.preventDefault();
        $.ajax({
            url: 'test.php',
            data: $(this).parent().serialize(),
            type: 'post',
            dataType: 'json',
            success: function($data){
                alert($data);
            }
        })
    });
})
</script>
