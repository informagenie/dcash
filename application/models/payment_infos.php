<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 22/03/2017
 * Time: 14:11
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_infos extends CI_Model
{
    /**
     * Tables tbl_paiement_infos
     * @var string
     */
    protected $table = 'tbl_paiement_infos';

    /**
     * @param $data
     * @return mixed
     */
    function add_options($data)
    {
        $this->db   ->set('id', null)
                    ->set('id_paiement', $data['id_paiement'])
                    ->set('vendor_id', $data['vendor_id'])
                    ->set('vendor_data', $data['vendor_data'])
                    ->set('reference', $data['reference']);

        return $this->db->insert($this->table);
    }

    function payment_already($data)
    {
        return $this->db->select()->from($this->table)
                    ->where('id_paiement', $data['id_paiement'])
                    ->where('vendor_id', $data['vendor_id'])
                    ->get()->num_rows();
    }

    /**
     * Récupère tous les paiements du digablo pour etablissement comportant le numéro
     * de référenced $référence
     *
     * @param $id
     * @return mixed
     */
    function paymentFor($reference = null)
    {
        if($reference === null)
        {
            return $this->db->select()->from($this->table)->get()->result();
        }
        return $this->db->select()->from($this->table)->where('client', $reference)->get()->result();
    }

    /**
     * Récupère le paiment qui a le numéro de référence $reference
     *
     * @param $reference
     * @return mixed
     */
    function payment_options_by_reference($reference)
    {
        return $this->db->select()->from($this->table)->where('reference', $reference)->get()->row();
    }

    /**
     * Récupère tous les paiments qui ont l'id de paiemet $id_payment
     *
     * @param $id_payment
     * @return mixed
     */
    function get_by_payment($id_payment)
    {
        return $this->db->select()->from($this->table)->where('id_paiement', $id_payment)->get()->result();
    }

    /**
     * Récupère tous les paiments du id_paiement $vendor
     *
     * @param $id_vendor
     * @return mixed
     */
    function get_payment_by_vendor($id_vendor)
    {
        return $this->db->select()->from($this->table)->where('vendor_id', $id_vendor)->get()->result();
    }

    /**
     * Rétourne le total de paiement $id_payment déjà effectué
     *
     * @param $id_payment
     * @return int
     */
    function get_total_by_payment($id_payment)
    {
        $data = $this->get_by_payment($id_payment);
        $amount = 0;
        for($i = 0; $i < sizeof($data) ; $i++) {
            $amount += total_item(unserialize($data[$i]->vendor_data));
        }

        return $amount;
    }

    function updateOption($datas, $contraine)
    {
        foreach($datas as $i=>$v)
        {
            $this->db->set($i, $v);
        }
        return $this->db->where($contraine)->update($this->table);
    }

    function payment_for_ready($ready)
    {
        return $this->db->select()->from($this->table)->where('ready', $ready)->get()->result();
    }

}