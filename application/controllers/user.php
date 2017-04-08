<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/** Class : User (UserController) User Class to control all user related operations. @author : Kishor Mali @version : 1.1 @since : 15 November 2016 */
class User extends Basecontroller
{
    /** This is default constructor of the class */
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('user_model', 'payment', 'user_infos', 'payment_infos'));
        $this->isLoggedIn();
    }

    /** This function used to load the first screen of the user */
    public function index()
    {
        $this->global['pageTitle'] = site_title('Dashboard');
        $sort = !empty($_GET['sort']) ? $_GET['sort'] : 'all';
        $price = [];
        $status = [];
        //Est-il un administrateur ? Parce que un admin doit tout voir
        if ($this->global['role'] == ROLE_ADMIN) {
            $status['all'] = $payments['admin'] = $this->payment->paymentFor(null);
            $status['end'] = $this->payment->paymentTo(null, STATUS_END);
            $status['success'] = $this->payment->paymentTo(null, STATUS_SUCCESS);
            $status['wait'] = $this->payment->paymentTo(null, STATUS_WAIT);
            $status['missing'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_MISSING);
            $status['process'] = $this->payment->paymentTo(null, STATUS_PROCESS);
            $status['unknow'] = $this->payment->paymentTo(null, STATUS_UNKNOW);
            //Parcourt pour le prix
            foreach ($status as $k => $v) {
                foreach ($v as $value) {
                    @$price[$k] = (int)($price[$k] + $value->montant);
                    if ($k == 'success') {
                        $price[$k] = ($price[$k] + $price['end']);
                    }
                }
            }
        }
        //    else { TODO: c'était pour le vendeur quand ils partagaient le même tableau de bord avec les ADMINS
//            $status['all'] = $payments['vendeur'] = $this->payment->paymentFor($this->session->userdata('userId'));
//            $status['success'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_SUCCESS);
//            $status['wait'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_WAIT);
//            $status['missing'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_MISSING);
//            $status['process'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_PROCESS);
//            $status['unknow'] = $this->payment->paymentTo($this->session->userdata('userId'), STATUS_UNKNOW);
//        }

        if ($this->global['role'] == ROLE_VENDOR) {
            $status = array_reverse($this->payment_infos->get_payment_by_vendor($this->session->userdata('userId')));
        }

        if ($this->global['role'] == ROLE_LIVREUR) {
            $status = array_reverse($this->payment_infos->payment_for_ready(STATUS_READY));
        }

//        debug($payments);

        $this->loadViews("dashboard", $this->global, array('price' => $price,
            'payments' => $status,
            'status' => array_map('count', $status), 'sort' => $sort), NULL);
    }

    function search()
    {
        $this->global['pageTitle'] = site_title('Recherche par référence');
        $data['options'] = [];
        if (isset($_POST['__ref'])) {
            $data['options'] = $this->payment->paymentBy(html_escape($_POST['__ref']));
        }

        $this->loadViews("search", $this->global, $data, null);
    }

    function check()
    {

        $this->global['pageTitle'] = site_title('Recherche par référence');
        $data['options'] = [];
        if (isset($_REQUEST['__ref'])) {
            $data['options'] = $this->payment_infos->payment_options_by_reference(html_escape($_REQUEST['__ref']));
        }

        if ($data['options'] != null) {
            if (!($data['options']->vendor_id == $this->session->userdata['userId'] or $this->global['role'] == ROLE_ADMIN)) {
                $this->loadThis();
                return;
            }
        }
        $this->loadViews("check", $this->global, $data, null);
    }

    function commande($reference)
    {
        if ($this->woocommerce->change_order_status('2713', dc_to_wc_status(STATUS_END))) {
            echo "<h1>SUCCESS</h1>";
        }
        if (!$data['options'] = $this->payment->paymentBy(html_escape($reference))) {
            $this->pageNotFound();
            return;
        }

        if (!($this->global['role'] == ROLE_ADMIN)) {
            $this->loadThis();
            return;
        }
        $data['items'] = get_grouped_item(get_items(unserialize($data['options']->options)));
        $data['items_delivred'] = $this->payment_infos->get_by_payment($data['options']->id);
        $this->global['pageTitle'] = site_title('Commande ' . $data['options']->reference);

        $this->loadViews('drccash/commande', $this->global, $data);
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = site_title('404 - Page non trouvée');

        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * Change le status de paiement
     */
    function updateInfo()
    {
        if (!empty($_POST['status']) and !empty($_POST['__p'])) {
            if ($_POST['status'] >= 0 && $_POST['status'] <= 5) {
                if ($this->payment->updateOption(array('status' => $_POST['status']), ["id" => $_POST['__p'],
                    'client' => $this->session->userdata('userId')])
                ) {
                    redirect(site_url('dashboard'));
                }
            } else {
                if ($this->payment_infos->updateOption(array('ready' => $_POST['status']), ["reference" => $_POST['__p'],
                    'vendor_id' => $this->session->userdata('userId')])
                ) {
                    $this->__alert_order('Merci ! Nous avons notifié l\'équipe chargée de la livraison qui viendront dans moins d\'une heure', 'success');
                }
            }
        }


        if (!empty($_POST['mpesa']) || !empty($_POST['airtel_money']) || !empty($_POST['orange_money'])) {
            $success = false;
            foreach ($_POST as $name => $value) {
                if (is_valid_number($value)) {
                    $this->user_infos->update($this->session->userdata('userId'), $name, $value);
                }
            }
            redirect(site_url('user/config?save'));
            exit();
        }

    }

    /**
     * Le menu parametre de l'utilisateur
     */
    function config()
    {
        $data['userInfo'] = $this->user_model->getUserInfo($this->session->userdata['userId']);
        $data['userInfo']['providers'] = $this->user_infos->get_providers_by($this->session->userdata['userId']);
        $data['userInfo']['infos'] = $this->user_infos->get_profil_infos($this->session->userdata['userId']);
        $this->global['pageTitle'] = 'Paramètre';

        $this->loadViews('drccash/user_config', $this->global, $data, null);
    }

    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->model('user_model');

            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;

            $this->load->library('pagination');

            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress("userListing/", $count, 5);

            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = site_title('Liste d\'utilisateurs');

            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if (empty($userId)) {
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if (empty($result)) {
            echo("true");
        } else {
            echo("false");
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->addNew();
            } else {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array('email' => $email, 'password' => getHashedPassword($password), 'roleId' => $roleId, 'name' => $name,
                    'mobile' => $mobile, 'createdBy' => $this->vendorId, 'createdDtm' => date('Y-m-d H:i:s'));

                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'L\'utilisateur a été créé avec succès');
                } else {
                    $this->session->set_flashdata('error', 'La création de cet utilisateur a echoué');
                }

                redirect('addNew');
            }
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = site_title('Ajouter un nouveau utilisateur');

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if ($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');

            $userId = $this->input->post('userId');

            $this->form_validation->set_rules('fname', 'Full Name', 'trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password', 'Password', 'matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]|max_length[20]');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->editOld($userId);
            } else {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->input->post('mobile');

                $userInfo = array();

                if (empty($password)) {
                    $userInfo = array('email' => $email, 'roleId' => $roleId, 'name' => $name,
                        'mobile' => $mobile, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:sa'));
                } else {
                    $userInfo = array('email' => $email, 'password' => getHashedPassword($password), 'roleId' => $roleId,
                        'name' => ucwords($name), 'mobile' => $mobile, 'updatedBy' => $this->vendorId,
                        'updatedDtm' => date('Y-m-d H:i:s'));
                }

                $result = $this->user_model->editUser($userInfo, $userId);

                if ($result == true) {
                    $this->session->set_flashdata('success', 'User updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'User updation failed');
                }

                redirect('userListing');
            }
        }
    }

    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if ($this->isAdmin() == TRUE || $userId == 1) {
            $this->loadThis();
        } else {
            if ($userId == null) {
                redirect('userListing');
            }

            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = site_title('Editer l\'utilsateur');

            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if ($this->isAdmin() == TRUE) {
            echo(json_encode(array('status' => 'access')));
        } else {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted' => 1, 'updatedBy' => $this->vendorId, 'updatedDtm' => date('Y-m-d H:i:sa'));

            $result = $this->user_model->deleteUser($userId, $userInfo);

            if ($result > 0) {
                echo(json_encode(array('status' => TRUE)));
            } else {
                echo(json_encode(array('status' => FALSE)));
            }
        }
    }

    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldPassword', 'Old password', 'required|max_length[20]');
        $this->form_validation->set_rules('newPassword', 'New password', 'required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword', 'Confirm new password', 'required|matches[newPassword]|max_length[20]');

        if ($this->form_validation->run() == FALSE) {
            $this->loadChangePass();
        } else {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');

            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);

            if (empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'L\'ancien mot de passe que vous avez entré est incorrect');
                redirect('loadChangePass');
            } else {
                $usersData = array('password' => getHashedPassword($newPassword), 'updatedBy' => $this->vendorId,
                    'updatedDtm' => date('Y-m-d H:i:sa'));

                $result = $this->user_model->changePassword($this->vendorId, $usersData);

                if ($result > 0) {
                    $this->session->set_flashdata('success', 'Mot de passe changé avec succès');
                } else {
                    $this->session->set_flashdata('error', 'Le changement de mot de passe a echoué');
                }

                redirect('loadChangePass');
            }
        }
    }

    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = site_title('Changer le mot de passe');

        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }

    function getUserInfo($id)
    {
        return $this->user_model->getUserInfo($id, true);
    }

    function name_by_email($email)
    {
        return $this->user_model->get_user_by_email($email)->name;
    }
}