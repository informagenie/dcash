<?php
/**
 * Created by PhpStorm.
 * User: Studio Animation 2D
 * Date: 13/04/2017
 * Time: 05:22
 */

class sendEmail extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('email');
    }

    function send($order, $state)
    {
        $this->email->from('admin@digbalo.com', 'Digablo');
        $this->email->to($order['fact_email']);
        $this->email->subject("Etat de la commande ". $order['cmd_id']);
        $message = $this->viewEmail('template_'. convert_status(STATUS_PROCESS),$order);
        $this->email->message($message);
        return $this->email->send();

    }

    function viewEmail($template_name, $data)
    {
        ob_start();
        $this->load->view('email_template/header');
        $this->load->view('email_template/'.$template_name, $data);
        $this->load->view('email_template/footer');
        return ob_get_clean();
    }
}