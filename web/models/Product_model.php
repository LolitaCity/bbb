<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Product_model extends MY_Model {

	const TBL_ADMIN = 'product';
    

	public function add($data){
	    return $this->db->insert(self::TBL_ADMIN,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    $this->db->where('userid',$this -> uid);
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

    /*
     * 获取商品信息，以商品id唯一标志缓存
     */
	public function getInfo($id)
	{
	    if ($id)  //防止用户在【发布任务-第三步】通过浏览器的回退按钮回退而发生商品id丢失，导致报错
            $_SESSION['pro_id'] = $id;
	    $sql = 'select * from zxjy_product where id = ' . $_SESSION['pro_id'] . ' AND userid = ' . $this -> uid;
        $cache_name = 'pro_model_getInfo_' . $id . '_' . $this -> uid;   //以商品id标志缓存
		return $this -> db -> query($sql) -> first_row();
	    return $this-> cacheSqlQuery($cache_name, $sql, 0, true, 'first_row');  //永久缓存某商品信息，等修改的时候根据商品id删除之
//	    $this->db->where('id', $id);
//	    $query = $this->db->get(self::TBL_ADMIN);
//	    return $query->first_row();
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
	/*
	 * 搜索/展示用户的商品列表，非搜索操作则缓存起来
	 */
	public function getListPro($uid,$shopid,$searchkey,$searchword){
        $sql = 'SELECT * FROM zxjy_product as p
                LEFT JOIN zxjy_shop as s on p.shopid = s.sid
                WHERE s.auditing = 1 AND p.status = 1 AND p.peostatus = 1 AND p.userid = ' . $uid;
//	    $this->db->where('status',1);
//	    $this->db->where('peostatus',1);
//	    $this->db->where('userid',$uid);
	    if($shopid!='all'){
	        //$this->db->where('shopid',$shopid);
            $sql .= ' AND shopid = ' . $shopid;
	    }
	    if($searchword!=''){
	        //$this->db->like($searchkey,$searchword);
            $sql .= ' AND ' . $searchkey . ' like "%' . $searchword . '%"';
	    }
	    $sql .= ' order by id desc';
	    return $shopid!='all' || $searchword!='' ? $this -> db -> query($sql) -> result() : $this -> cacheSqlQuery('pro_model_getListPro_', $sql, 60 * 1);  //非搜索操作缓存10分钟
//	    $this->db->order_by('addtime','desc');
//	    $query=$this->db->get(self::TBL_ADMIN);
//	    return $query->result();
	}
	public function getArr($arr){
	    $this->db->where_in('id',$arr);
	    $query = $this->db->get(self::TBL_ADMIN);
	    return $query->result();
	}
	
}