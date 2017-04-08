<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 11/03/2017
 * Time: 08:42
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Order extends BaseController
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('user_infos', 'userinfo');
        $this->load->model('user_model', 'user');
        $this->load->model(array('provider', 'payment'));

//        $this->load->model('paiement');
//        $paiement = array(
//            'id'=>null,
//            'client'=>3,
//            'montant'=>500,
//            'devise'=>'FC',
//            'options'=>serialize(array(
//                'order'=>'4',
//                'email'=>'mercingoma@gmail.com',
//                'nom_produit'=>'Samsung Galaxy note 3'
//            )),
//            'reference'=>'5222547',
//            'status'=>'3'
//        );
//
//        $this->paiement->addPayment($paiement);
    }

    function index()
    {
        $token = uniqid('drccash', true);
        if(empty($_SERVER['HTTP_REFERER'])) //TODO : Enlever la négation pour que ça soit mieux
        {
            die('<h1>VOUS N\'AVEZ PAS ACCESS A CETTE PAGE</h1>');
            return ;
        }

        $errors = [];


        if(!isset($_POST['__email']) && !isset($_POST['__return']) && !isset($_POST['__phone_number']))
        {
            die('<h1>COMMANDE INVALIDE</h1>');
        }
        //Le vendeur existe t-il ?
        if(!($vendor = $this->user->get_user_by_email($_POST['__email'])))
        {
            die('<h1>CE VENDEUR N\'EXISTE PAS');
        }
        //Peut il accepter le paiement pour ce réseau
        $canpay = $this->userinfo->get_info($vendor->userId, $this->provider->get(what_service($_POST['__phone_number']))->nom);
        if(!$this->userinfo->get_info($vendor->userId, $this->provider->get(what_service($_POST['__phone_number']))->nom))
        {
            die('<h1>CE VENDEUR NE PEUX PAS RECEVOIR DE L\'ARGENT POUR CE SERVICE');
        }

        $this->load->view('drccash/order', array('token'=>$token, 'number'=>$_POST['__phone_number'], 'clientId'=>$vendor->userId,'montant'=>$_POST['__montant'], 'devise'=>$_POST['__devise'] ));
    }

    function process()
    {
        $base_params = [];
        $options = [];
        if(!empty(['HTTP_REFERER'])) //TODO : Ajouter la négation pour que ça soit mieux
        {
            if(!stripos($_SERVER['HTTP_REFERER'],'/order' ))
            {
                //Le lien ammenant dans /order/process devrait provenir de /order
                die('Impossible de traiter votre commande ! veuiilez réssayer plus tard');
            }
            $errors = [];
            if(empty($_GET[decrypter('__ref')]))
            {
                $errors['danger'] = 'Renseigner le numéro de référence s\'il vous plaît';
            }

            foreach($_GET  as $k=>$v)
            {
                if(stripos(decrypter($k), '__') === 0)
                {
                    $base_params[decrypter($k)] = (decrypter($k) == '__ref') ? $v : decrypter($v);
                }else
                {
                    $options[decrypter($k)] = decrypter($v);
                }
            }

            $data = array(
                'id'=>null,
                'client'=> (isset($base_params['__clientId'])) ? $base_params['__clientId'] : null,
                'montant'=> (isset($base_params['__montant'])) ? $base_params['__montant'] : null,
                'devise'=> (isset($base_params['__devise'])) ? $base_params['__devise'] : null,
                'reference'=> (isset($base_params['__ref'])) ? $base_params['__ref'] : null,
                'options'=>serialize($options),
                'status'=>STATUS_WAIT,
                'provider'=>what_service($base_params['__phone_number']),
                'date_paiement'=>"now()"
            );
            //TODO : Arranger le problème de l'enregistrement dans la base de données
            if($this->payment->addPayment($data))
            {
                $this->load->view('drccash/order_success', array('redirect'=>$base_params['__return']));
            }else
            {
                echo '<h1>Ce numéro de référence est déjà utilisé</h1><a href="'.$_SERVER['HTTP_REFERER'].'">Retour</a>';
            }


        }
    }

}