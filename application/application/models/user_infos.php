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

    function get_info($userId, $key)
    {
        if(empty($return = $this->db->select()->from($this->table)->where('info_name', $key)->where('user_id', $userId)->get()->row()))
        {
            return false;
        }

        return $return;
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

}