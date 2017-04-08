<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 11/03/2017
 * Time: 08:42
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Order extends BaseController
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('user_infos', 'userinfo');
        $this->load->model('user_model', 'user');
        $this->load->model(array('provider', 'payment', 'payment_infos'));

    }

    function index()
    {
        $important = array('__email', '__montant', '__commande', '__devise', '__return');

        $return['token'] = uniqid('drccash', true);

//        if (empty($_SERVER['HTTP_REFERER'])) //TODO : Enlever la négation pour que ça soit mieux
//        {
//            die('<h1>VOUS N\'AVEZ PAS ACCESS A CETTE PAGE</h1>');
//            return;
//        }

        $errors = [];

        if (!isset($_GET['__email']) && !isset($_GET['__return']) && !isset($_GET['__commande'])) {
            die('<h1>COMMANDE INVALIDE</h1>');
        }
        //Le vendeur existe t-il ?
        if (!($vendor = $this->user->get_user_by_email('admin@digablo.com'))) {
            die('<h1>CE VENDEUR N\'EXISTE PAS</h1>');
        }

        $return['clientId'] = $vendor->userId;
        //Le vendeur peut-il recevoir les paiements ?
        if (!$this->userinfo->can_received_payment($vendor->userId)) {
            die('<h1>CET UTILISATEUR NE PEUT PAS RECEVOIR LE PAIMENT POUR L\'INSTANT</h1>');
        }

        $return['numbers'] = $this->userinfo->get_providers_by($vendor->userId);
        foreach ($_GET as $item => $v) {
            if (!in_array($item, $important)) {
                $return['options'][$item] = $v;
            } else {
                $return[$item] = $v;
            }
        }

        //redirection dans la page de paiement
        redirect(site_url('payment?process=' . encrypte_data($return)));

    }

    function payment()
    {
        $data = decrypte_data($_GET['process']);
        $this->load->view('drccash/order', decrypte_data($_GET['process']));
    }

    function process()
    {
        $base_params = [];
        $options = [];
        $add_manually_in_form = array('__ref', '__devise', '__montant', '__phone_number');
        if (!empty(['HTTP_REFERER'])) //TODO : Ajouter la négation pour que ça soit mieux
        {
            if (!stripos($_SERVER['HTTP_REFERER'], '/payment')) {
                //Le lien ammenant dans /order/process devrait provenir de /order
                die('Impossible de traiter votre commande ! veuiilez réssayer plus tard');
            }
            $errors = [];
            if (empty($_POST[crypter('__ref')]) || strlen($_POST[crypter('__ref')]) != 10) {
                $errors['danger'] = 'Renseigner le numéro de référence valide s\'il vous plaît';
            }
            if (empty($_POST[crypter('__phone_number')])) {
                $errors['danger'] = 'Selectionner un numéro de téléphone valide';
            }
            foreach ($_POST as $k => $v) {
                if (stripos(decrypter($k), '__') === 0) {
                    $base_params[decrypter($k)] = (in_array(decrypter($k), $add_manually_in_form)) ? $v : decrypter($v);
                } else {
                    $options[decrypter($k)] = decrypter($v);
                }
            }

            if (empty($errors)) {

                $status = STATUS_WAIT;
                if ($base_params['__montant'] < total_items(get_grouped_item(get_items($options)))) {
                    $status = STATUS_MISSING;
                }

                $data = array(
                    'id' => null,
                    'client' => (!empty($base_params['__clientId'])) ? $base_params['__clientId'] : null,
                    'montant' => (!empty($base_params['__montant'])) ? $base_params['__montant'] : null,
                    'devise' => (!empty($base_params['__devise'])) ? $base_params['__devise'] : DEVISE_USD,
                    'reference' => (!empty($base_params['__ref'])) ? $base_params['__ref'] : null,
                    'options' => serialize($options),
                    'status' => $status,
                    'provider' => what_service($base_params['__phone_number']),
                    'date_paiement' => date(SERVER_DATEFORMAT)
                );
                //TODO : Arranger le problème de l'enregistrement dans la base de données
                if ($this->payment->addPayment($data)) {
                    $this->woocommerce->change_order_state($options['cmd_id'], dc_to_wc_status(STATUS_WAIT));
                    redirect($options['return']);
                } else {
                    echo '<h1>Ce numéro de référence est déjà utilisé</h1><a href="' . $_SERVER['HTTP_REFERER'] . '">Retour</a>';
                }
            } else {
                $this->load->view('drccash/errors', ['errors' => $errors]);
            }

        }
    }

    /**
     * Traite les informations venant de l'action @user/commande
     */
    function processes()
    {

        $errors = [];
        $datas = [];
        //Normalisation des données
        foreach ($_POST as $item => $value) {
            //si item contient arobase (@)
            if (preg_match("#%40#i", $item)) {
                $datas[keyer_array(urldecode($item))] = $value;
            } else {
                $datas[urldecode($item)] = $value;
            }
        }

        if (!empty($_POST['items'])) {
            $email = urldecode(keyer_array($datas['items']));
            if (empty($_POST['__ref'])) $errors['warning'] = "Le numéro de référence invalide";
            $data['id_paiement'] = $datas['__paiement'];
            $data['vendor_id'] = $this->user->get_user_by_email($email)->userId;
            $data['vendor_data'] = (filter_var($email, FILTER_VALIDATE_EMAIL)) ? $datas[$email] : $errors['warning'] = 'Un problème technique a été soulevé et nous sommes informé de celui-ci';
            $data['reference'] = $_POST['__ref'];
            if (empty($this->user->getUserInfo($data['vendor_id'], true))) $errors['warning'] = "Ce vendeur n'existe pas encore dans digablo cash";
            //Le numéro de référence n'est-il pas encore utilisé ?
            if (!empty($this->payment_infos->payment_options_by_reference($data['reference']))) $errors['warning'] = "Ce numéro de référence est déjà utilisé pour le paiement";
            if (empty($errors)) {

                if ($this->payment_infos->payment_already($data)) {
                    $this->__alert_order('Vous avez déjà effectué le paiement de cet etablissement', 'warning');
                }
                if ($this->payment_infos->add_options($data)) {
                    $state = ($this->payment_infos->get_total_by_payment($data['id_paiement']) >= $this->payment->get($data['id_paiement'])->montant) ? STATUS_END : STATUS_PROCESS;

                    $this->payment->updateOption(['status' => $state], ['id' => $data['id_paiement']]);
                    try {
                        $this->woocommerce->change_order_state($this->payment->get_option($data['id_paiement'], 'cmd_id'), dc_to_wc_status($state));
                    } catch (Exception $e) {
                        $this->__alert_order("Nous n'avons pas pu mettre à jour cette commande depuis wordpress ! Veuillez le faire manuellement", 'primary');
                    }
                    $this->__alert_order('Paiement effectué avec succèss', 'success');
                } else {
                    $this->__alert_order('Paiement echoué', 'danger');
                }

            } else {
                $this->__alert_order('Paiement echoué ! Vérifier que vous avez bien rempli les champs qu\'il faut', 'danger');
            }
        } else {
            $this->__alert_order('Paiement echoué ! Vérifier que vous avez bien rempli les champs qu\'il faut', 'danger');
        }

    }

    /**
     * Envoie via une requête ajax, les numéros de téléphones correspondant à l'email $email
     *
     * @param $email
     * @return null
     */
    function checkusernumbers($email)
    {
        $user = $this->user->get_user_by_email(keyer_array(urldecode($email)));


        if (empty($user)) {
            echo 'false';
            return;
        }

        $numbers = $this->userinfo->get_providers_by($user->userId);

        $returns = [];
        foreach ($numbers as $key => $value) {
            $provider = $this->provider->get_by_name($value->info_name);
            $returns[$key]['nom'] = $provider->provider;
            $returns[$key]['desc'] = $provider->libelle;
            $returns[$key]['number'] = $value->info_value;
        }
        header('Content-Type', 'text/json');
        echo json_encode($returns);
    }

}