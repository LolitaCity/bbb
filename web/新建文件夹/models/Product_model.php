<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Product_model extends CI_Model{

	const TBL_ADMIN = 'product';
    

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
	public function getList($uid,$sid,$commodity_id,$commodity_name,$limitkey,$limit,$offset){
	    $sql = "SELECT * FROM `zxjy_product` WHERE `userid` = '".$uid."'" ;

	    if($sid!='all'){
	        $sql .= " AND `shopid` = '".$sid."'";
	    }
	    if($commodity_id!='all'){
	        $sql .= " AND ( `commodity_id` LIKE '%".$commodity_id."%' )";
	    }
	    if($commodity_name!='all'){
	        /* $this->db->like('commodity_abbreviation',$commodity_name);
	        $this->db->or_like('commodity_title',$commodity_name); */
	        $sql .= " AND ( `commodity_abbreviation` LIKE '%".$commodity_name."%' ESCAPE '!' OR `commodity_title` LIKE '%".$commodity_name."%' ESCAPE '!' )";
	    }
	    $sql .= " ORDER BY `addtime` DESC";
	    if($limitkey !=0 ){
	        $sql .= " LIMIT ".$offset.",".$limit."";
	    }
	    //echo $sql;
	    $query = $this->db->query($sql);
	    return $query->result();	    
	}
	public function getListCount($uid,$sid,$commodity_id,$commodity_name){
	    $sql = "SELECT * FROM `zxjy_product` WHERE `userid` = '".$uid."'" ;
	    if($sid!='all'){
	        $sql .= " AND `shopid` = '".$sid."'";
	    }
	    if($commodity_id!='all'){
	        $sql .= " AND ( `commodity_id` LIKE '%".$commodity_id."%' )";
	    }
	    if($commodity_name!='all'){
	        /* $this->db->like('commodity_abbreviation',$commodity_name);
	        $this->db->or_like('commodity_title',$commodity_name); */
	        $sql .= " AND ( `commodity_abbreviation` LIKE '%".$commodity_name."%' ESCAPE '!' OR `commodity_title` LIKE '%".$commodity_name."%' ESCAPE '!' )";
	    }
	    $sql .= " ORDER BY `addtime` DESC";
	    $query = $this->db->query($sql);
	   /*
	    $this->db->where('userid',$uid);
	    if($sid!='all'){
	        $this->db->where('shopid',$sid);
	    }
	    if($commodity_id!='all'){
	        $this->db->or_like('commodity_id',$commodity_id);
	    }
	    if($commodity_name!='all'){
	        $this->db->or_like('commodity_abbreviation',$commodity_name);
	        $this->db->or_like('commodity_title',$commodity_name);
	    }
	    $query=$this->db->get(self::TBL_ADMIN);*/
	    return $query->num_rows();	    
	}
	public function getListPro($uid,$shopid,$searchkey,$searchword){
	    $this->db->where('status',1);
	    $this->db->where('peostatus',1);
	    $this->db->where('userid',$uid);
	    if($shopid!='all'){
	        $this->db->where('shopid',$shopid);
	    }
	    if($searchword!=''){
	        $this->db->like($searchkey,$searchword);
	    }
	    $this->db->order_by('addtime','desc');
	    $query=$this->db->get(self::TBL_ADMIN);
	    return $query->result();
	}
	public function getArr($arr){
	    $this->db->where_in('id',$arr);
	    $query = $this->db->get(self::TBL_ADMIN);
	    return $query->result();
	}
	
}