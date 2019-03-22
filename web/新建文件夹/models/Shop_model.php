<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Shop_model extends CI_Model{

    const TBL_NAV = 'shop';
    
	public function getcount($key){
	    $this->db->where('userid',$key);
	    $this->db->order_by('sid','desc');
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('sid',$id);
	    return $this->db->update(self::TBL_NAV,$data);
	}// 修改
	public function getlist($userid,$auditing,$limitkey,$limit,$offset){
	    $this->db->where('userid',$userid);
	    if($auditing!='all'){
	        $this->db->where('auditing',$auditing);
	    }
	    if($limitkey == 1){
	        $this->db->limit($limit,$offset);
	    }
	    $this->db->order_by('addtime','desc');
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getcountlist($userid,$auditing){
	    $this->db->where('userid',$userid);
	    if($auditing!='all'){
	        $this->db->where('auditing',$auditing);
	    }
	    $this->db->order_by('addtime','desc');
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
	public function getInfo($key){
	    $this->db->where('sid',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
	}
	public function del($id){
	    $this->db->where('sid',$id);
	    return $this->db->delete(self::TBL_NAV);
	
	}
	public function getArr($arr){
        $this->db->where_in('sid',$arr);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
}