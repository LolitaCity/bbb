<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Getall_model extends CI_Model{

    const TBL_NAV = 'getbond';
    

	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_NAV,$data);
	}// 修改	
	public function del($id){
	    $this->db->where('sid',$id);
	    return $this->db->delete(self::TBL_NAV);
	
	} //删除
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
	}
	public function getMySend($userid){
        $this->db->where('userid',$userid);
        $this->db->where('status','0');
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
	
	
}