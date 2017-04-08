<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 11/03/2017
 * Time: 15:28
 */
?>
<ul>
<?php foreach($errors as $type=>$message): ?>
    <li><span class="alert alert-<?= $type ?>"><?= $message ?></span></li>
<?php endforeach ?>
</ul>


