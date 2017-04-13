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

    function send($email, $etat)
    {
        $this->email->from('admin@digbalo.com', 'Digablo');
        $this->email->to($email);
        $this->subject($etat);
        $this->message()
    }

}