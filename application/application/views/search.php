<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 13/03/2017
 * Time: 02:48
 */
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Recherche
            <small>Par référence</small>
        </h1>
    </section>
    <selection class="content">
        <div class="col-md-6">
            <?php if(!empty($options)): ?>
            <div id="monaccordeon" class="panel-group col-lg-6">
                <h3>Voir</h3>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <a class="accordion-toggle" href="#item1" dataparent="#monaccordeon" data-toggle="collapse">
                                <span class="fa fa-check"></span><strong><?= $_POST['__ref']?></strong> est un numéro de référence valide</div>
                            </a>
                        </h3>
                    </div>
                    <div id="item1" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <ul class="list list-unstyled">
                                <?php foreach(unserialize($options->options) as $item=>$value): ?>
                                    <li><strong><?= $item ?></strong> : <?= $value ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif(empty($_POST['__ref'])): ?>
            <div class="alert alert-warning">Vous devriez taper quelque chose</div>
        <?php else: ?>
            <div class="alert alert-danger"><?= $_POST['__ref'] ?> n'est pas reconnu comme numéro de référence</div>
        <?php endif ?>
        </div>
    </selection>
</div>
</div>
