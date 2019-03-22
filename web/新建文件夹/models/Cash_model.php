<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Cash_model extends CI_Model{

	const TBL_ADMIN = 'cashlog';
    

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
	}// 按照ID查询
     public function getUserid($id){
	    $this->db->where('userid',$id);
         $query = $this->db->get(self::TBL_ADMIN);
         return $query->first_row();
     }
     public function getInfoList($pid,$limit,$offset){
         $this->db->where('userid',$pid);
         $this->db->limit($limit,$offset);
         $this->db->order_by('addtime','desc');
         $query = $this->db->get(self::TBL_ADMIN);
         return $query->result();
     }
     public function getCount($pid){
         $this->db->where('userid',$pid);
         $query = $this->db->get(self::TBL_ADMIN);
         
         return $query->num_rows();
     }
     public function OutExcel($id,$start){
         $this->db->where('userid',$id);
         $this->db->where('addtime >',$start);
         $query = $this->db->get(self::TBL_ADMIN);
         return $query->result();
     }
    public function getListSearch($id,$begintime,$endtime){
        $this->db->where('userid',$id);
        if($begintime>0){
            $this->db->where('addtime >',$begintime);
        }
        if($endtime>0){
            $this->db->where('addtime <',$endtime);
        }
        $this->db->order_by('addtime','desc');
        $query = $this->db->get(self::TBL_ADMIN);
        return $query->result();
    }
}