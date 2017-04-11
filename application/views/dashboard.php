<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tableau de bord
            <small>Vue d'ensemble</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <?php if ($role == ROLE_ADMIN): ?>
            <div data-toggle="dismiss" class="alert-dismissible alert alert-success">Vous êtes en mode Administrateur.
                Vous pouvez tout voir mais pas modifier ou agir pour l'instant
            </div>
<!--            <div class="col-lg-3 col-xs-6">-->
<!--                <!-- small box -->
<!--                <div class="small-box bg-aqua">-->
<!--                    <div class="inner">-->
<!--                        <h3>--><?//= (int)__($price['process']) ?><!--$</h3>-->
<!---->
<!--                        <p>En processus</p>-->
<!--                    </div>-->
<!--                    <div class="icon">-->
<!--                        <i class="ion ion-bag"></i>-->
<!--                    </div>-->
<!--                    <a href="#" class="small-box-footer">Plus d'informations <i-->
<!--                            class="fa fa-arrow-circle-right"></i></a>-->
<!--                </div>-->
<!--            </div><!-- ./col -->
<!--            <div class="col-lg-3 col-xs-6">-->
<!--                <!-- small box -->
<!--                <div class="small-box bg-green">-->
<!--                    <div class="inner">-->
<!--                        <h3>--><?//= (isset($price['success'])) ? (int)__($price['success']) : (int)__($price['end']) ?>
<!--                            $</h3>-->
<!---->
<!--                        <p>Vérifiés</p>-->
<!--                    </div>-->
<!--                    <div class="icon">-->
<!--                        <i class="ion ion-stats-bars"></i>-->
<!--                    </div>-->
<!--                    <a href="#" class="small-box-footer">Plus d'informations <i-->
<!--                            class="fa fa-arrow-circle-right"></i></a>-->
<!--                </div>-->
<!--            </div><!-- ./col -->
<!--            <div class="col-lg-3 col-xs-6">-->
<!--                <!-- small box -->
<!--                <div class="small-box bg-yellow">-->
<!--                    <div class="inner">-->
<!--                        <h3>--><?//= (int)__($price['wait']) ?><!--$</h3>-->
<!---->
<!--                        <p>En attente</p>-->
<!--                    </div>-->
<!--                    <div class="icon">-->
<!--                        <i class="ion ion-person-add"></i>-->
<!--                    </div>-->
<!--                    <a href="--><?php //echo base_url(); ?><!--userListing" class="small-box-footer">Plus d'informations<i-->
<!--                            class="fa fa-arrow-circle-right"></i></a>-->
<!--                </div>-->
<!--            </div><!-- ./col -->
<!--            <div class="col-lg-3 col-xs-6">-->
<!--                <!-- small box -->
<!--                <div class="small-box bg-red">-->
<!--                    <div class="inner">-->
<!--                        <h3>--><?//= (int)__($price['missing']) ?><!--$</h3>-->
<!---->
<!--                        <p>Manquants</p>-->
<!--                    </div>-->
<!--                    <div class="icon">-->
<!--                        <i class="ion ion-pie-graph"></i>-->
<!--                    </div>-->
<!--                <a href="#" class="small-box-footer">Plus d'informations<i class="fa fa-arrow-circle-right"></i></a>-->
<!--                </div><!-- ./col -->
<!--            </div>-->
        </div>
        <div class="row">
            <div class="box box-primary">
                <div class="box-header">
                    <div class="box-tools">
                        <div class="row">
                            <ul class="listlist list-inline">
                                <?php foreach ($status as $statu => $v): ?>
                                    <li class="">
                                        <?php if ($sort == $statu or $v == 0): ?>
                                            <strong> <?= ucfirst($statu) ?> (<?= $v ?>)</strong>
                                        <?php else: ?>
                                            <a href="dashboard?sort=<?= $statu ?>"><?= ucfirst($statu) ?></a>
                                            <small>(<?= $v ?>)</small>
                                        <?php endif ?>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php if (!empty($payments['all'])): ?>
                <div class="row">
                    <div class="box-body">

                        <div class="table-responsive table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                <tr>
                                    <th>N° de référence</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Status</th>
                                    <th>Opérations</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $status = 0;
                                foreach ($payments[$sort] as $payment): ?>
                                    <tr>
                                        <td>
                                            #<a href="<?= site_url('commande/' . urlencode($payment->reference)) ?>"><?= $payment->reference ?></a>
                                        </td>
                                        <td><?= format_date($payment->date_paiement) ?></td>
                                        <td><?= $payment->montant ?><?= devise_name(DEVISE_DEFAULT) ?></td>
                                        <td><span
                                                style="color: <?= status_name($payment->status)['color'] ?>"> <?= strtoupper(status_name($payment->status)['name']) ?></span>
                                        </td>
                                        <td>
                                            <?php foreach (status_list() as $s => $v): ?>
                                                <div class="col-md-1">
                                                    <form method="post" action="<?= site_url('update') ?>">
                                                        <input type="hidden" name="status" value="<?= $s ?>">
                                                        <input type="hidden" name="__p" value="<?= $payment->id ?>">
                                                        <button <?php if ($payment->status == $s) echo 'disabled' ?>
                                                            type="submit" title="<?= $v['name'] ?>"
                                                            class="btn btn-<?= $v['btn_type'] ?>"><span
                                                                class="glyphicon <?= $v['icon'] ?>"></span></button>
                                                    </form>
                                                </div>
                                            <?php endforeach ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="alert alert-warning">Pas de paiement encore pour l'instant</div>
            <?php endif ?>
            <?php endif ?>
            <?php if ($role == ROLE_VENDOR): ?>
                <?php if (empty($payments)): ?>
                    <div class="alert alert-warning">Pas de paiement encore pour l'instant</div>
                <?php else: ?>
                    <div class="box box-primary">
                    <div class="box-body">
                    <table class="table table-hover">
                    <tr>
                        <th>Date</th>
                        <th>Numéro de référence</th>
                        <th>Montant</th>
                        <th>Détail</th>
                    </tr>

                    <?php foreach ($payments as $payment => $value): ?>
                        <tr>
                            <td><?= format_date($value->date_created) ?></td>
                            <td><?= $value->reference ?></td>
                            <td><?= total_item(unserialize($value->vendor_data)) ?><?= devise_name(DEVISE_DEFAULT) ?></td>
                            <td><a href="<?= site_url('check?__ref=' . urlencode($value->reference)) ?>">Plus d'informations</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
                </table>
                </div>

                </div>

            <?php endif ?>
            <?php if ($role == ROLE_LIVREUR): ?>
                <?php if (empty($payments)): ?>
                    <div class="alert alert-warning">Aucune livraison disponible pour l'instant</div>
                <?php else: ?>
                    <div class="box box-primary">
                    <div class="box-body">
                    <table class="table table-hover">
                    <tr>
                        <th>N°</th>
                        <th>Quoi livrer ?</th>
                        <th>Où livrer ?</th>
                    </tr>

                    <?php $index = 1;
                    foreach ($payments as $item => $detail): ?>
                        <tr>
                            <td>
                                <?= $index ?>
                            </td>
                            <td>
                                <?= phrase_items_quantity(unserialize($detail->vendor_data)) ?>
                            </td>
                            <td>
                                <?= phrase_livraison(unserialize(get_instance()->payment->get($detail->id_paiement)->options)) ?>
                            </td>
                        </tr>
                        <?php $index++; endforeach ?>
                <?php endif ?>
                </table>
                </div>

                </div>

            <?php endif ?>
        </div>
    </section>
</div>