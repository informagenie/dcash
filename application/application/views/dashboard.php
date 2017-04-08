
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tableau de board
            <small>Control panel</small>
        </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>500$</h3>
                        <p>En processus</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>3000<sup style="font-size: 20px">$</sup></h3>
                        <p>Vérifiés</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>820$</h3>
                        <p>En attente</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">Plus d'informations<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>320$</h3>
                        <p>Manquants</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Plus d'informations<i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        </div>
        <div class="row">
            <ul class="list list-unstyled list-inline">
                <?php foreach($status as $statu=>$v): ?>
                    <li class="">
                        <?php if($sort == $statu or $v == 0): ?>
                            <strong> <?= ucfirst($statu) ?> (<?= $v ?>)</strong>
                        <?php else: ?>
                            <a href="dashboard?sort=<?= $statu ?>"><?= ucfirst($statu) ?></a> <small>(<?= $v ?>)</small>
                        <?php endif ?>
                    </li>
                <?php endforeach ?>
            </ul>
            <?php if($role == ROLE_VENDOR || $role == ROLE_ADMIN): ?>
                <?php if(!empty($payments)): ?>
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
                            <?php $status = 0; foreach($payments as $payment): ?>
                                <tr>
                                    <td>#<a href="<?= site_url('commande/'.$payment->id) ?>"><?= $payment->reference ?></a></td>
                                    <td><?= $payment->date_paiement ?></td>
                                    <td><?= $payment->montant ?></td>
                                    <td><span style="color: <?= status_name($payment->status)['color'] ?>"> <?= strtoupper(status_name($payment->status)['name']) ?></span></td>
                                    <td>
                                        <?php foreach(status_list() as $s=>$v):?>
                                            <div class="col-md-1">
                                                <form method="post" action="<?= site_url('update') ?>">
                                                    <input type="hidden" name="status" value="<?= $s ?>">
                                                    <input type="hidden" name="__p" value="<?= $payment->id ?>">
                                                    <button <?php if($status == $s) echo 'disabled' ?> type="submit" title="<?= $v['name'] ?>" class="btn btn-<?= $v['btn_type'] ?>"><span class="glyphicon <?= $v['icon'] ?>"></span></button>
                                                </form>
                                            </div>
                                        <?php endforeach ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>
    </section>
</div>