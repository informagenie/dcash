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
    <title>Paiement sécurisé</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= site_url('assets/images/favicon.ico')  ?>">
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!--    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">-->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <style>
        form{
            background: #131E1A;
            padding: 3em 0 2em 0;
        }
        legend{
            color: #ffa200 !important;
        }
        label{
            color: white;
        }
        form .btn
        {
            background: #ffa200;
        }
    </style>
</head>
<body>
<?php //debug($options)  ?>
<!--<div class="jumbotron">-->
    <div class="container-fluid">
        <header>
            <div class="navbar navbar-inverse">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        <div class="navbar-title">
                            <a href="<?= E_COMMERCE_HOST ?>"><img width="100" src="<?= site_url('assets/images/logo.png') ?>" alt="Logo" /></a></div>
                    </div>
                    <button data-target="#nav-collapse" class="navbar-toggle" data-toggle="collapse">
                           <span  class="icon-bar"></span>
                           <span  class="icon-bar"></span>
                    </button>
                </div>
                <div id="nav-collapse" class="nav-collapse navbar-collapse collapse">
                    <div class="navbar-right">
                        <ul class="navbar-nav nav">
                            <li><a href="#">Comment ça marche</a></li>
                            <li><a href="#">A propos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">

            <?php if(isset($_SESSION['errors'])): ?>
                <?php foreach($_SESSION['errors'] as $type=>$message): ?>
                    <div class="alert alert-<?= $type ?>"><?= $message ?></div>
                <?php endforeach ?>
            <?php endif ?>
            <form class="col-xs-12 col-md-6 col-md-offset-3" action="./order/process" method="post">
                <legend class="right">
                    Mode de paiement <img src="<?= site_url('assets/images/payment.png') ?>" alt="">
                </legend>
                <legend>Envoyez <?= $__montant ?>$ au numero : <strong><span id="__n"><?= radicalise_number($numbers['mpesa']['info_value']) ?></span></strong></legend>
                <div class="form-group">
                    <label for="">Selectionner le réseau <span class="glyphicon glyphicon-signal"></span></label>
                    <select class="form-control" name="<?= crypter('__phone_number') ?>" id="phone_number">
                        <option selected="selected" value="0">Selectionner le numéro d'envoie possible</option>
                        <?php foreach($numbers as $number): ?>
                            <option <?= (what_service($number['info_value']) == VODACOM)? 'selected': ''  ?> value="<?= $number['info_value'] ?>"><?= radicalise_number($number['info_value']) ?> (<?= $number['info_name'] ?>)</option>
                        <?php endforeach  ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="montant">Combien avez-vous envoyé ?</label>
                    <div class="input-group">
                        <input class="form-control" value="<?= $__montant ?>" type="text" name="<?= crypter('__montant') ?>" id="">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-usd"></span>
                        </span>
                    </div>
                </div>
                <legend>En suite, entrer le numéro de référence reçu lors de la confirmation de votre transaction</legend>
                <div class="form-group">
                    <label for="ref">Numéro de référence:</label>
                    <input required pattern="[a-zA-Z0-9]{10}" class="form-control" type="text" name="<?= crypter('__ref')?>">
                </div>
                <input type="hidden" name="<?= crypter('__clientId') ?>" value="<?= crypter($clientId) ?>" />
                <input type="hidden" name="<?= crypter('__token') ?>" value="<?= crypter($token) ?>" />
                <?php foreach($options as $i=>$v): ?>
                    <input type="hidden" name="<?= crypter($i) ?>" value="<?= crypter($v) ?>" />
                <?php endforeach ?>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <button class="btn btn-primary form-control" type="submit"><span class="glyphicon glyphicon-check"></span>Valider</button>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <a class="btn btn-danger" href="<?= $options['cancel_return'] ?>">Annuler</a>
                    </div>
                </div>
            </form>
    </div>
        </div>
<!--</div>-->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/app.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/validation.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
</body>
</html>
