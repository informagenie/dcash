<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 11/03/2017
 * Time: 11:39
 */

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<div class="container">
    <?php if(isset($_SESSION['errors'])): ?>
        <?php foreach($_SESSION['errors'] as $type=>$message): ?>
            <div class="alert alert-<?= $type ?>"><?= $message ?></div>
        <?php endforeach ?>
    <?php endif ?>
    <form action="./order/process">
        <p>Envoyez <?= $montant ?> <?= $devise ?> au numero : <strong>+243<?= radicalise_number($number) ?></strong></p>
        <p>En suite, entrer le numéro de référence reçu lors de la confirmation de votre paiement</p>
        <label for="ref">
            Numéro de référence:
        </label>
        <input type="text" name="<?= crypter('__ref')?>">
        <input type="hidden" name="<?= crypter('__clientId') ?>" value="<?= crypter($clientId) ?>" />
        <input type="hidden" name="<?= crypter('__token') ?>" value="<?= crypter($token) ?>" />
        <?php foreach($_POST as $i=>$v): ?>
            <input type="hidden" name="<?= crypter($i) ?>" value="<?= crypter($v) ?>" />
        <?php endforeach ?>
        <button type="submit">Valider</button>
    </form>
</div>
</body>
</html>
