<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 16/03/2017
 * Time: 00:11
 */


?>
<div id="return" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Commande
            <small>Détail sur la commande <strong>#<?= $options->reference ?></strong> <span style="background: <?= status_name($options->status)['color'] ?>" class="badge"><?= status_name($options->status)['name'] ?></span></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="<?= site_url('orders') ?>">
                    <select required class="form-control" id="items-select" name="items">
                        <option selected="selected" value="0">Selectionner l'établissement</option>
                        <?php foreach($items as $item =>$value):  ?>
                            <optgroup label="<?= $item ?>">
                                <option value="<?= urlencode($item) ?>">Produit #<?= current($value)['item_product_id'] ?>(<?= total_item($items[$item]) ?>$)</option>
                            </optgroup>
                        <?php endforeach  ?>
                    </select>
                    <input  type="hidden" name="__paiement" value="<?= $options->id ?>">
                    <?php foreach($items as $k=>$v): ?>
                        <input type="hidden" name="<?= urlencode($k) ?>" value='<?= serialize($v) ?>'>
                    <?php endforeach  ?>
                    <input <?php if($options->status == STATUS_END) echo 'readonly disabled title="Les paiments pour cette commande ont été déjà effectués"';  ?> autocomplete="off" class="form-control" placeholder="Entrer le numéro de référence" required pattern="[a-zA-Z0-9]{10}" type="text" name="__ref">
                    <button <?php if($options->status == STATUS_END) echo 'readonly disabled'  ?> type="submit" class="form-control btn btn-primary">Valide</button>
                </form>

               <div id="numbers_list">

               </div>
                <legend><a href="<?= unserialize($options->options)['return'] ?>" target="_blank" >Voir la commande</a></legend>
                <div class="list-group">
                    <span class="list-group-item">
                        <h3 class="list-group-item-heading">Informations sur la commande</h3>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Montant envoyé</span>
                        <span class="badge"><?= $options->montant ?> <?= devise_name($options->devise) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Montant réel</span>
                        <span class="badge"><?= total_items(get_grouped_item(get_items(unserialize($options->options)))) ?> <?= devise_name($options->devise) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Réseau</span>
                        <span class="badge"><?= name_provider($options->provider) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Numéro de la commande</span>
                        <span class="badge"><?= __(unserialize($options->options)['cmd_id']) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Numéro de la facture</span>
                        <span class="badge"><?= __(unserialize($options->options)['invoice']) ?></span>
                    </span>
                </div>
                <div class="list-group">
                    <span class="list-group-item">
                        <h3 class="list-group-item-heading">Informations sur le client</h3>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Nom</span>
                        <span class="badge"><?= __(unserialize($options->options)['fact_last_name']) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Email</span>
                        <span class="badge"><?= __(unserialize($options->options)['fact_email'])?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Numéro de téléphone</span>
                        <span class="badge"><?= __(unserialize($options->options)['day_phone_b']) ?></span>
                    </span>
                    <span class="list-group-item">
                        <span class="list-group-item-text">Adresse</span>
                        <span class="badge"><?= __(unserialize($options->options)['fact_address1']) ?></span>
                    </span>
                </div>
                <table class="table table-bordered">
                    <?php foreach(get_items(unserialize($options->options)) as $option=>$value):  ?>
                        <tr>
                            <th><?= $option ?></th>
                            <td><?= $value ?></td>
                        </tr>
                    <?php endforeach  ?>
                </table>
            </div>
            <div class="col-md-6">
                <?php if(!empty($items_delivred)): ?>
                    <div class="list-group">
                        <span class="list-group-item">
                            <h2 class="list-group-item-heading">Etablissement déjà payé</h2>
                        </span>
                        <?php foreach($items_delivred as $item):  ?>
                            <li class="list-group-item list-group-item-success">
                                <?= get_instance()->getUserInfo($item->vendor_id)['name']?> (email: <em><?= get_instance()->getUserInfo($item->vendor_id)['email']?></em> réf: <a href="<?= site_url('check?__ref='.$item->reference) ?>">#<?= $item->reference ?></a>)
                                <span class="badge"><span class="glyphicon glyphicon-ok"></span></span>
                            </li>
                        <?php endforeach  ?>
                    </div>
                <?php else:  ?>
                    <div class="alert alert-warning">Aucun etablissement payé pour cette commande</div>
                <?php endif  ?>
                <?php
//                    $gro = [];
//                    foreach($items_delivred as $item)
//                    {
//                        @$gro = array_with($items, $item->vendor_pseudo, false);
//                    }
                ?>
<!--                --><?php //if(!empty($gro)): ?>
<!--                    <div class="list-group">-->
<!--                        <span class="list-group-item">-->
<!--                            <h2 class="list-group-item-heading">Etablissement non payé</h2>-->
<!--                        </span>-->
<!--                        --><?php //foreach($gro as $item=>$value):  ?>
<!--                            <li class="list-group-item list-group-item-warning">--><?//= $item  ?><!--<span class="badge"><span class="glyphicon glyphicon-ok"></span></span></li>-->
<!--                        --><?php //endforeach  ?>
<!--                    </div>-->
<!--                --><?php //else:  ?>
<!--                    <div class="alert alert-warning">Aucun etablissement payé pour cette commande</div>-->
<!--                --><?php //endif  ?>
            </div>
        </div>
    </section>
</div>
</div>

