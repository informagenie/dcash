<?php
/**
 * Created by PhpStorm.
 * User: GOMS
 * Date: 11/03/2017
 * Time: 17:39
 */
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Provider extends CI_Model
{
    private $table = 'providers';

    function get($id)
    {
        return $this->db->select()->from($this->table)->where('id', $id)->get()->row();
    }

    function get_by_name($name)
    {
        return $this->db->select()->from($this->table)->where('nom', $name)->get()->row();
    }
}