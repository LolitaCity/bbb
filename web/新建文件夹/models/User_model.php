<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  User_model extends CI_Model{

	const TBL_ADMIN = 'user';
    
	public function userlogin($username,$password){
	    $this->db->where('Username',$username);
        $this->db->where('PassWord',$password);
        $this->db->where('Opend',1);
	    $query = $this->db->get(self::TBL_ADMIN);
	    return $query->first_row();
	}
	public function add($data){
	    return $this->db->insert(self::TBL_ADMIN,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_ADMIN,$data);
	}// 修改
	public function updataArr($arr,$data){
	    $this->db->where_in('id',$arr);
	    return $this->db->update(self::TBL_ADMIN,$data);
	}// 修改
	public function delete($id){
	    $this->db->where('id',$id);
	    return $this->db->delete(self::TBL_ADMIN);
	}// 删除
	public function deleteArr($arr){
	    $this->db->where_in('id',$arr);
	    return $this->db->delete(self::TBL_ADMIN);
	}// 批量删除
	public function getInfo($id)
	{
	    $this->db->where('id', $id);
	    $query = $this->db->get(self::TBL_ADMIN);
	    return $query->first_row();
	}//按照ID查询
    public function userthis($username,$email){
        $this->db->where('UserName',$username);
        $this->db->where('Email',$email);
        $query =$this->db->get(self::TBL_ADMIN);
        return $query->first_row();
    }
	public function UseID($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_ADMIN);
        return $query->first_row();
    }
    public function getAll(){
        $query =$this->db->get(self::TBL_ADMIN);
        return $query->result();
    }
    public function UserPid($pid,$limit,$offset){
        $this->db->where('parentid',$pid);
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query = $this->db->get(self::TBL_ADMIN);
        return $query->result();
    }
    public function CountUserPid($pid){
        $this->db->where('parentid',$pid);
        $query = $this->db->get(self::TBL_ADMIN);
        return $query->num_rows();
    }
}