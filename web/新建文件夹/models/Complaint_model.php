<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Complaint_model extends CI_Model{

    const TBL_TOT = 'schedual';// 提交过来的总表
    const TBL_TALK = 'scheduallog'; // 对话表
    const TBL_CLA = 'schedualtype'; // 错误分类信息
    
    /*类型表操作*/
    public function getAll(){
        $query = $this->db->get(self::TBL_CLA);
        return $query->result();
    }

    /*总表操作*/
	public function add($data){
	    return $this->db->insert(self::TBL_TOT,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_TOT,$data);
	}// 修改	
	public function del($id){
	    $this->db->where('sid',$id);
	    return $this->db->delete(self::TBL_TOT);
	
	} //删除
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_TOT);
	    return $query->first_row();
	}
	public function getInfoByMark($key){
	    $this->db->where('mark',$key);
	    $query = $this->db->get(self::TBL_TOT);
	    return $query->first_row();
	}
	public function  getList($userid,$limit,$offset){
	    $this->db->where('merchantid',$userid);
	    $this->db->order_by('addtime','desc');
	    $this->db->limit($limit,$offset);
	    $query = $this->db->get(self::TBL_TOT);
	    return $query->result();
	}
	public function getCountList($userid){
	    $this->db->where('merchantid',$userid);
	    $query = $this->db->get(self::TBL_TOT);
	    return $query->num_rows();    
	}
	
	/* 商家与平台对话*/
	public function addTalk($data){
	    return $this->db->insert(self::TBL_TALK,$data);
	}// 添加
	public function updataTalk($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_TALK,$data);
	}// 修改
	public function delTalk($id){
	    $this->db->where('sid',$id);
	    return $this->db->delete(self::TBL_TALK);	
	}
	public function getTalkList($comid){
	    $this->db->where('schedualid',$comid);
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_TALK);
	    return $query->result();
	}
	
	
}