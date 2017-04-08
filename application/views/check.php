<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 13/03/2017
 * Time: 02:48
 */
$_REQUEST = array_map('htmlspecialchars', $_REQUEST);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Recherche
            <small>Par référence</small>
        </h1>
    </section>
    <section class="content">
        <div class="col-md-6">
            <?php if(!empty($options)): ?>
                <h4>MONTANT TOTAL : <kbd><?= total_item(unserialize($options->vendor_data)) ?>$</kbd></h4>
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-title">Référence : #<?= $options->reference ?> <span class="badge"><?= name_provider(get_instance()->payment->get($options->id_paiement)->provider) ?></span></div>
                            <div class="box-tools"><?= format_date($options->date_created) ?></div>
                        </div>
                        <div class="box-body table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>Nom produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                                <?php foreach(unserialize($options->vendor_data) as $item=>$value): ?>
                                    <tr>
                                        <td><?= $value['item_name'] ?></td>
                                        <td><?= $value['item_amount'].devise_name(DEVISE_DEFAULT) ?></td>
                                        <td><?= $value['item_quantity'] ?></td>
                                        <td><?= total_product($value).devise_name(DEVISE_DEFAULT) ?></td>
                                        <td>
                                            <a class="btn btn-primary" target="_blank" href="<?= E_COMMERCE_HOST ?>?p=<?= $value['item_product_id'] ?>">Voir</a>
                                        </td>
                                    </tr>
                                <?php endforeach  ?>
                            </table>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                TOTAL : <span class="badge"><?= total_item(unserialize($options->vendor_data)) ?>$</span>
                            </div>
                            <form action="<?= site_url('update') ?>" method="post">
                                <div class="box-input">
                                    <input type="hidden" name="status" value="<?= STATUS_READY ?>">
                                    <input type="hidden" name="__p" value="<?= $options->reference ?>">
                                    <?php if($options->ready == STATUS_READY):  ?>
                                        <div class="alert alert-success">Vous avez déjà signalé que cette commande est déjà prête pour la livraison</div>
                                    <?php else:  ?>
                                        <button type="submit" class="btn btn-primary">Définir comme étant prêts pour la livraison</button>
                                    <?php endif  ?>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php elseif(empty($_REQUEST['__ref'])): ?>
                <div class="alert alert-warning">Vous devriez taper quelque chose</div>
            <?php else: ?>
                <div class="alert alert-danger"><?= $_REQUEST['__ref'] ?> n'est pas reconnu comme étant un numéro de référence</div>
            <?php endif ?>
        </div>
    </section>
</div>
</div>
