<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Taskevaluate_model extends CI_Model{

    const TBL_NAV = 'taskevaluate';
    
	public function getcount($key){
	    $this->db->where('sellerid',$key);
	    $this->db->order_by('id','desc');
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_NAV,$data);
	}// 修改
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
	}
	public function del($id){
	    $this->db->where('id',$id);
	    return $this->db->delete(self::TBL_NAV);
	
	}
	public function getArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    public function getInfoT($key){
        $this->db->where('usertaskid',$key);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }
    public function WillPass($key){
        $this->db->where('sellerid',$key);
        $this->db->where('doing',1);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    public function getList($key,$limit,$offset){
        $this->db->where('sellerid',$key);
        $this->db->order_by('addtime','desc');
        if($limit != 0){
            $this->db->limit($limit,$offset);
        }
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    public function updataPass($arr,$db){
        $this->db->where_in('id',$arr);
        return $this->db->update(self::TBL_NAV,$db);
    }    
    public function SearchList($doing,$start,$end,$selSearch,$txtSearch,$userid,$limit,$offset){
        $sql="SELECT `zxjy_taskevaluate`.*, 
             `zxjy_usertask`.`tasksn` as `tasksn`,
             `zxjy_usertask`.`ordersn` as `ordersn` ,
             `zxjy_shop`.`shopname` as `shopname` ,
             `zxjy_product`.`commodity_id` as `protaobaoid` 
            FROM `zxjy_taskevaluate` 
            LEFT JOIN `zxjy_usertask` ON `zxjy_taskevaluate`.`usertaskid`=`zxjy_usertask`.`id`
            LEFT JOIN `zxjy_shop`  ON `zxjy_shop`.`sid`=`zxjy_usertask`.`shopid`   
            LEFT JOIN `zxjy_product`  ON `zxjy_product`.`id`=`zxjy_usertask`.`proid` WHERE 1
            AND `zxjy_taskevaluate`.`sellerid` = '".$userid."'
            ";
        if($doing!=0){
            $sql .= " AND `zxjy_taskevaluate`.`doing` = '".$doing."'";
        }
        if($start!=''){
            $sql .= " AND `zxjy_taskevaluate`.`addtime` > '".$start."'";
        }
        if($end!=0){
            $sql .= " AND `zxjy_taskevaluate`.`addtime` < '".$end."'";
        }
        if($selSearch == 'shopid'){
            $sql .= " AND `zxjy_shop`.`sid` LIKE '%".$txtSearch."%'";
        }else if($selSearch == 'proid'){
            $sql .= " AND `zxjy_product`.`id` LIKE '%".$txtSearch."%'";
        }else{
            $sql .= " AND `zxjy_usertask`.`".$selSearch."` LIKE '%".$txtSearch."%'";
        }
        $sql .= " ORDER BY `zxjy_taskevaluate`.`addtime` DESC ";
        if($limit!=0){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
       // echo $sql;
        $query =$this->db->query($sql);
        return $query->result();         
    }
    public function SearchCount($doing,$start,$end,$selSearch,$txtSearch,$userid){
        $sql="SELECT `zxjy_taskevaluate`.*,
             `zxjy_usertask`.`tasksn` as `tasksn`,
             `zxjy_usertask`.`ordersn` as `ordersn` ,
             `zxjy_shop`.`shopname` as `shopname` ,
             `zxjy_product`.`commodity_id` as `protaobaoid`
            FROM `zxjy_taskevaluate`
            LEFT JOIN `zxjy_usertask` ON `zxjy_taskevaluate`.`usertaskid`=`zxjy_usertask`.`id`
            LEFT JOIN `zxjy_shop`  ON `zxjy_shop`.`sid`=`zxjy_usertask`.`shopid`
            LEFT JOIN `zxjy_product`  ON `zxjy_product`.`id`=`zxjy_usertask`.`proid` WHERE 1
            AND `zxjy_taskevaluate`.`sellerid` = '".$userid."'
            ";
        if($doing!=0){
            $sql .= " AND `zxjy_taskevaluate`.`doing` = '".$doing."'";
        }
        if($start!=''){
            $sql .= " AND `zxjy_taskevaluate`.`addtime` > '".$start."'";
        }
        if($end!=0){
            $sql .= " AND `zxjy_taskevaluate`.`addtime` < '".$end."'";
        }
        if($selSearch == 'shopid'){
            $sql .= " AND `zxjy_shop`.`sid` LIKE '%".$txtSearch."%'";
        }else if($selSearch == 'proid'){
            $sql .= " AND `zxjy_product`.`id` LIKE '%".$txtSearch."%'";
        }else{
            $sql .= " AND `zxjy_usertask`.`".$selSearch."` LIKE '%".$txtSearch."%'";
        }
        $sql .= " ORDER BY `zxjy_taskevaluate`.`addtime` DESC ";

       // echo $sql;

        $query =$this->db->query($sql);
        return count($query);
         
    }
}