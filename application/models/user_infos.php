<?php
/**
 * Created by PhpStorm.
 * User: ESGRA
 * Date: 11/03/2017
 * Time: 16:43
 */

if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_infos extends CI_Model
{
    private $table = 'tbl_users_infos';
    private $providers = [];

    function __construct()
    {
        parent::__construct();
        $this->providers = $this->get_providers();
    }

    function get_info($userId, $key)
    {
        if(empty($return = $this->db->select()->from($this->table)->where('info_name', $key)->where('user_id', $userId)->get()->rows()))
        {
            return false;
        }

        return $return;
    }

    function update($id, $name, $value)
    {
        if($this->db->select()->from($this->table)->where('user_id', $id)->where('info_name', $name)->get()->num_rows() > 0)
        {
            return $this->db->set('info_value', $value)->where('user_id', $id)->where('info_name', $name)->update($this->table);
        }else{
            return $this->db->set('info_name', $name)->set('info_value', $value)->set('user_id', $id)->insert($this->table);
        }
    }

    /**
     * Renvoie toutes les informations de la table tbl_user_infos relative l'utilisateur $user
     *
     * @param $userId
     * @return mixed
     */
    function get_user_info($userId)
    {
        return $this->db->select()->from($this->table)->where("user_id", $userId)->get()->result();
    }

    /**
     * Renvoie tous les providers disponibles dans la tables providers
     *
     * @return array
     */
    private function get_providers()
    {
        foreach($this->db->select('nom')->from('providers')->get()->result() as $v)
        {
            $providers[] = $v->nom;
        }
        return $providers;
    }

    /**
     * Vérifie si l'utilisateur $id dispose d'au moins un numéro de téléphone
     *
     * @param $userId
     * @return boolean
     */

    function can_received_payment($userId)
    {

        foreach ($this->providers as $provider) {
            if($this->db->select()->from($this->table)->where("user_id ='$userId' && info_name = '$provider' ")->get()->num_rows() > 0)
            {
                return true;
            }
        }
        return false;

    }

    /**
     * Retourne tous les numeros providers de $userId
     *
     * @param $userId
     * @return array
     */
    function get_providers_by($userId)
    {
        $providers = [];
        foreach($this->providers as $provider)
        {
            if(!empty($p = $this->db->select()->from($this->table)->where('info_name',$provider)->where('user_id', $userId)->get()->row())){
                $providers[$provider] = $p;
            }
        }
        if(empty($providers)) return false;
        return $providers;
    }

}