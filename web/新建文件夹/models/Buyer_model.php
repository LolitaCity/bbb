<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Buyer_model extends CI_Model{

	const TBL_ADMIN = 'bindbuyer';
    

	public function add($data){
	    return $this->db->insert(self::TBL_ADMIN,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
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
     public function getUserid($id){
	    $this->db->where('userid',$id);
         $query = $this->db->get(self::TBL_ADMIN);
         return $query->first_row();
     }
	public function getArr($arr){
        $this->db->where_in('userid',$arr);
        $query = $this->db->get(self::TBL_ADMIN);
        return $query->result();
    }

}