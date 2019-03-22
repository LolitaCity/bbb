<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Article_model extends CI_Model{

    const TBL_NAV = 'articlecatlog';
	const TBL_INFO = 'article';
    
	public function getinfo($key){
	    $this->db->where('cat_id',$key);
	    $this->db->order_by('goods_id','desc');
	    $query = $this->db->get(self::TBL_INFO);
	    return $query->first_row();
	}
	public function getList($pid,$limit,$offset){
	    $this->db->where('cat_id',$pid);
	    $this->db->order_by('add_time','desc');
	    $this->db->where('is_delete',0);
	    $this->db->limit($limit,$offset);
	    $query=$this->db->get(self::TBL_INFO);
	    return $query->result();
	}
	public function getCount($pid){
	    $this->db->where('cat_id',$pid);
	    $query=$this->db->get(self::TBL_INFO);
	    return $query->num_rows();
	}
	public function getInfos($key){
	    $this->db->where('goods_id',$key);
	    $this->db->order_by('goods_id','desc');
	    $query = $this->db->get(self::TBL_INFO);
	    return $query->first_row();
	}
	public function getInfosOne($pid){
	    $this->db->where('cat_id',$pid);
	    $this->db->order_by('add_time','desc');
	    $query = $this->db->get(self::TBL_INFO);
	    return $query->first_row();	    
	}
}