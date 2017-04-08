<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 11/03/2017
 * Time: 15:28
 */
?>
<h1>ERREURS LORS DE LA VALIDATION DU FORMULAIRE</h1>
<ul>
    <?php foreach($errors as $key=>$error):?>
        <li><?= $error ?></li>
    <?php endforeach  ?>
</ul>
<p><a href="<?= $_SERVER['HTTP_REFERER'] ?>">Retourner dans le formualaire</a></p>


