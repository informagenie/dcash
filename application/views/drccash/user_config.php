<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 14/03/2017
 * Time: 06:39
 */
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Paramettre
            <small>Configuration de parametre utilisateur</small>
        </h1>
    </section>
<section class="content">
 <div class="row">
     <div>
         <?php if(isset($_GET['save'])): ?>
             <div class="alert alert-success">Enregistrement effectué avec succèss</div>
         <?php endif ?>
     </div>
    <form action="<?= site_url('user/updateinfo') ?>" method="post" class="col-md-6">
        <fieldset>
            <legend>Configuration de paiement</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="mpesa">N° Vodacom MPESA</label>
                    </div>
                    <div class="col-md-9">
                        <input value="<?= __($userInfo['providers']['mpesa']->info_value) ?>" placeholder="Ex: 0822251907" class="form-control" type="text" name="mpesa" id="mpesa">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="orange_money">N° Orange Money</label>
                    </div>
                    <div class="col-md-9">
                        <input value="<?= __($userInfo['providers']['orange_money']->info_value) ?>" placeholder="Ex: 0898988542" class="form-control" type="text" name="orange_money" id="orange_money">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3">
                        <label for="airtel_money">N° Airtel Money</label>
                    </div>
                    <div class="col-md-9">
                        <input value="<?= __($userInfo['providers']['airtel_money']->info_value) ?>" placeholder="Ex: 0999333344" class="form-control" type="text" name="airtel_money" id="airtel_money">
                    </div>
                </div>
            </div>
        </fieldset>
        <button class="pull-right btn btn-primary">Enregistrer</button>
    </form>
 </div>
</section>
</div>
</div>