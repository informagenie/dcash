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

    /**
     * Récupère tous les paiements du client $id
     *
     * @param $id
     * @return mixed
     */
    function paymentFor($id = null)
    {
        if($id === null)
        {
            return $this->db->select()->from($this->table)->get()->result();
        }
        return $this->db->select()->from($this->table)->where('client', $id)->get()->result();
    }

    /**
     * Récupère tous les paiements du client $id avec un status $status
     *
     * @param $id
     * @param $status
     * @return mixed
     */
    function paymentTo($id = null, $status)
    {
        if($id === null)
        {
            return $this->db->select()->from($this->table)->where('status', $status)->get()->result();
        }
        return $this->db->select()->from($this->table)->where('client', $id)->where('status', $status)->get()->result();
    }

    function paymentBy($ref)
    {
        return $this->db->select()->from($this->table)->where('reference', $ref)->get()->row();
    }

}
