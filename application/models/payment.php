<?php
/**
 * Created by PhpStorm.
 * User: Goms
 * Date: 11/03/2017
 * Time: 08:21
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Model
{

    private $table = 'tbl_paiement';


    function payment_by_id($id)
    {
        return $this->db->select()->from($this->table)->where('id', $id)->get()->row();
    }

    /**
     * Ajout le paiement $payment dans la base de données
     *
     * @param $payment array
     * @return bool
     */
    function addPayment($payment)
    {
        $data = [];

        foreach ($payment as $item=>$value) {
            if($item != 'id' and $value == null)
            {
                return false;
            }

        }

        if(!empty($this->db->select()->from($this->table)->where('reference', $payment['reference'])->get()->row()))
        {
            return false;
        }

        foreach($payment as $value=>$item)
        {
            $this->db->set($value, $item);
        }
        return $this->db->insert($this->table);
    }
    function updateOption($datas, $contraine)
    {
        foreach($datas as $i=>$v)
        {
            $this->db->set($i, $v);
        }
        return $this->db->where($contraine)->update($this->table);
    }

    function get($id)
    {
        return $this->db->select()->from($this->table)->where('id', $id)->get()->row();
    }

    /**
     * Récupère tous les paiements du client $id
     *
     * @param $id
     * @return mixed
     */
    function paymentFor($id = null, $order=true)
    {
        if($id === null)
        {
            $return = $this->db->select()->from($this->table)->get()->result();
        }else{
            $return = $this->db->select()->from($this->table)->where('client', $id)->get()->result();
        }

        return ($order) ?  array_reverse($return) : $return;
    }

    /**
     * Récupère tous les paiements du client $id avec un status $status
     *
     * @param $id
     * @param $status
     * @param $order
     * @return mixed
     */
    function paymentTo($id = null, $status, $order=true)
    {
        if($id === null)
        {
            $return = $this->db->select()->from($this->table)->where('status', $status)->get()->result();
        }else{
            $return = $this->db->select()->from($this->table)->where('client', $id)->where('status', $status)->get()->result();
        }
        return ($order) ?  array_reverse($return) : $return;
    }

    function paymentBy($ref)
    {
        return $this->db->select()->from($this->table)->where('reference', $ref)->get()->row();
    }

}
