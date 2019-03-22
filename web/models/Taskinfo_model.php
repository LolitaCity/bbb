<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Taskinfo_model extends CI_Model{

    const TBL_NAV = 'transfertask';
    

    public function checked($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }
	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function upDataPass($arr,$db){
	    $this->db->where('id',$arr);
	    return $this->db->update(self::TBL_NAV,$db);
	}
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_NAV,$data);
	}// 修改	
	public function del($id){
	    $this->db->where('id',$id);
	    return $this->db->delete(self::TBL_NAV);
	
	} //删除
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
	}	
	    
	public function getListWeek($time,$userid){
	    $this->db->where('userid',$userid);
	    $this->db->where('addtime >',$time);
	    $query =$this->db->get(self::TBL_NAV);
	    return $query->result();
	}
}