<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Blank_model extends CI_Model{

    const TBL_NAV = 'banklist';
    
    public function add($data){
        return $this->db->insert(self::TBL_NAV,$data);
    }// 添加
    public function updata($id,$data){
        $this->db->where('id',$id);
        return $this->db->update(self::TBL_NAV,$data);
    }// 修改
    public function delete($id){
        $this->db->where('id',$id);
        return $this->db->delete(self::TBL_NAV);
    }// 删除
    public function deleteArr($arr){
        $this->db->where_in('id',$arr);
        return $this->db->delete(self::TBL_NAV);
    }// 批量删除
    public function getInfo($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }//按照ID查询
    public function getOne($key){
        $this->db->where('userid',$key);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }
    public function getArrUser($arr){
        $this->db->where_in('userid',$arr);
        $this->db->where_in('isdefault',1);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    public function getArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    
}