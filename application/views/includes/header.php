<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title><?php echo $pageTitle; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= site_url('assets/images/favicon.ico')  ?>">
    <meta name="robots" content="noindex, nofollow, nosnippet">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport' />
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/kami.css" />
    <style>
        .error{
            color:red;
            font-weight: normal;
        }

    </style>
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-<?= ($role == ROLE_ADMIN)? "blue" : "yellow" ?> sidebar sidebar-collapse">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
            <span class="logo-mini"><b>D</b>C</span>
            <span class="logo-lg"><b>DIGABLO</b>CASH</span>
        </a>
        <span id="ajax-notif" style="display: none; position: absolute; left: 50%; z-index: 9999999;" class="alert alert-success">
        </span>
        <?php if(isset($_SESSION['message'])):  ?>
            <?php foreach($_SESSION['message'] as $type=>$message):  ?>
                <span role="alert" data-dismiss="alert" style="position: absolute; left: 50%; z-index: 9999999;" class="notif alert alert-<?= $type ?>">
                    <?= $message  ?>
                </span>
            <?php endforeach  ?>
            <?php
            unset($_SESSION['message']);
        endif ;
        ?>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                            <span class="hidden-xs"><?php echo $name; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                                <p>
                                    <?php echo $name; ?>
                                    <small><?php echo $role_text; ?></small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo base_url(); ?>loadChangePass" class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <li class="treeview">
                    <i class="fa fa-search"></i>
                    <span>
                        <form method="post" class="navbar-form" action="<?= ($role == ROLE_ADMIN ) ? site_url('search') : site_url('check') ?>">
                            <div class="input-group">
                                <span class="input-group-field">
                                    <input <?php if($role == ROLE_LIVREUR) echo "disabled"  ?> autocomplete="off" class="form-control" type="search" name="__ref" placeholder="Taper le numero de référence ici">
                                </span>
                                <div class="input-group-btn">
                                    <button <?php if($role == ROLE_LIVREUR) echo "disabled"  ?> type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </form>
                    </span>
                </li>
                <li class="treeview">
                    <a href="<?php echo base_url(); ?>dashboard">
                        <i class="fa fa-dashboard"></i> <span>Tableau de bord</span>
                    </a>
                </li>
                <?php if($role == ROLE_ADMIN OR $role == ROLE_VENDOR): ?>
                    <li class="treeview">
                        <a href="<?= site_url('user/config') ?>" >
                            <i class="fa fa-phone"></i>
                            <span>Paiment mobile</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="<?= site_url('editOld/'.get_instance()->session->userdata('userId')) ?>" >
                            <i class="fa fa-wrench"></i>
                            <span>Parametre</span>
                        </a>
                    </li>
                <?php endif ?>

                <?php
                if($role == ROLE_ADMIN || $role == ROLE_MANAGER)
                {
                    ?>
                    <!--                    <li class="treeview">-->
                    <!--                        <a href="#" >-->
                    <!--                            <i class="fa fa-thumb-tack"></i>-->
                    <!--                            <span>Hummeur</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                    <!--                    <li class="treeview">-->
                    <!--                        <a href="#" >-->
                    <!--                            <i class="fa fa-upload"></i>-->
                    <!--                            <span>Téléchargement</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                    <?php
                }
                if($role == ROLE_ADMIN)
                {
                    ?>
                    <li class="treeview">
                        <a href="<?php echo base_url(); ?>userListing">
                            <i class="fa fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#" >
                            <i class="fa fa-files-o"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <?php
                }
                ?>
                <li class="treeview">
                    <a href="#" >
                        <i class="fa fa-sign-out"></i>
                        <span>Deconnexion</span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>