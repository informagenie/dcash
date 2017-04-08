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
    <section class="content">
        <!--        <div class="col-md-12">-->
        <?php if(!empty($options)): ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <a class="accordion-toggle" href="#item1" dataparent="#monaccordeon" data-toggle="collapse">
                            <span class="fa fa-check"><strong><?= $_POST['__ref']?></strong> est un numéro de référence valide</span>
                        </a>
                    </h3>
                </div>
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
        <?php elseif(empty($_POST['__ref'])): ?>
            <div class="alert alert-warning">Vous devriez taper quelque chose</div>
        <?php else: ?>
            <div class="alert alert-danger"><?= $_POST['__ref'] ?> n'est pas reconnu comme étant un numéro de référence</div>
        <?php endif ?>
        <!--        </div>-->
    </section>
</div>
</div>
