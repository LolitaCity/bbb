<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Usertask_model extends MY_Model {

    const TBL_NAV = 'usertask';
    

    public function checked($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }
	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function upDataPass($arr,$db){
	    $this->db->where_in('id',$arr);
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
	public function getInfo($key)
    {
        $sql = 'select * from zxjy_usertask WHERE id = ' . $key . ' AND merchantid = ' . $this -> uid;
        return $this -> db -> query($sql) -> first_row();
//	    $this->db->where('id',$key);
//	    $query=$this->db->get(self::TBL_NAV);
//	    return $query->first_row();
	}	
	public function today($startime,$endtime,$userid){
	    $this->db->where('addtime >',$startime);
	    $this->db->where('addtime <',$endtime);
	    $this->db->where('userid',$userid);
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getlist($userid,$status,$limit,$offset){
	    $this->db->where('usertask.merchantid',$userid);
	    if($status!='all'){
	         $this->db->where('usertask.status',$status);
	    }
	    if($limit!=0){
	       $this->db->limit($limit,$offset);
	    }
	    $this->db->order_by('usertask.addtime','desc');

        $this->db->select('usertask.*,task.tasktype as typeinfo');// 任务分类 1（销量任务） 3 （复购任务）
        $this->db->select('usertask.*,task.addtime as typeaddtime');
        $this->db->from(self::TBL_NAV);
        $this->db->join('task','usertask.taskid=task.id','left');

	    $query = $this->db->get();
	    return $query->result();
	}
	public function getNowUser($userid,$status){
        $sql = "select count(1) as num from zxjy_usertask  as us LEFT JOIN zxjy_task as ta on us.taskid = ta.id WHERE us.`status` = {$status} and us.merchantid = {$userid};";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
	public function  getListCount($userid,$status){
	    $this->db->where('merchantid',$userid);
	    if($status!='all'){
	        $this->db->where('status',$status);
	    }
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
	public function getCount($time,$userid){
        $this->db->where('merchantid',$userid);
        $this->db->where('addtime <',$time);
        $query = $this->db->get(self::TBL_NAV);
        return $query->num_rows();
    }
    public function getCountShop($time,$userid){
        $this->db->where('proid',$userid);
        $this->db->where('addtime <',$time);
        $query = $this->db->get(self::TBL_NAV);
        return $query->num_rows();
    }
    public function getArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
	
    public function searchList($id,$status,$key,$txt,$begin,$end,$num,$offset,$type){
        //$end = time(); 
       /* 
        $sql=@"
SELECT `zxjy_usertask`.*, `zxjy_task`.`tasktype` as `typeinfo`, `zxjy_task`.`addtime` as `typeaddtime` 
FROM `zxjy_usertask` LEFT JOIN `zxjy_task` ON `zxjy_usertask`.`taskid`=`zxjy_task`.`id` 
WHERE '".$key."'  LIKE '%".$txt."%' ESCAPE '!'";
        */
        $sql = 'SELECT t.top, FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, ut.id, ut.tasksn, ut.ordersn, ut.taskid, ut.userid, ut.shopid, ut.taskmodelid, ut.status, ut.addtime, ut.expressnum, ut.buyerid, ut.taskid, ut.complaint, ut.showpicbtn, t.addtime as typeaddtime, t.tasktype, ww.wangwang, s.shopname, tm.price, tm.express, tm.commission, tm.new_keyword, tm.how_browse, tm.how_search from zxjy_usertask as ut 
                LEFT JOIN zxjy_task as t on ut.taskid = t.id
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                where ut.merchantid =  ' . $id;
//    	$sql=@"
//SELECT  A.*,  B.tasktype  as typeinfo,  B.addtime as  typeaddtime , C.shopname
//FROM zxjy_usertask A
//LEFT JOIN zxjy_task B ON A.taskid =B.id
//LEFT JOIN zxjy_shop C ON A.shopid =C.sid
//WHERE 1=1 "  ;
    	if($key){
    		$sql .= " AND {$key} LIKE '%{$txt}%' ESCAPE '!'";
    	}
//        if($id !=null){
//            $sql .=" AND A.merchantid ={$id} ";
//        }
        if($status !='all'){
            $sql .=" AND ut.`status` ={$status}  ";
        }
        if($begin > 0){
            $sql .= "AND ut.addtime >{$begin} ";
        }
        if($end > 0){
            $sql .= "AND ut.addtime <{$end} ";
        }
        if($type!='all'){
            $sql .= "AND t.tasktype ={$type} ";
        }
        $sql .= " ORDER BY ut.addtime DESC ";
        
        
        if($num !=0 ){
           $sql .= " LIMIT {$offset},{$num}";
        }
        
        $query = $this->db->query($sql);
        return $query->result();        
    }


    public function searchCount($id,$status,$key,$txt,$begin,$end,$type){
    	/*
        $sql="SELECT  count(1) as cc FROM `zxjy_usertask` LEFT JOIN `zxjy_task` ON `zxjy_usertask`.`taskid`=`zxjy_task`.`id` 
WHERE '".$key."' LIKE '%".$txt."%' ESCAPE '!'";
*/
    	
    	$sql=@"
SELECT  count(1) as cc
FROM zxjy_usertask as ut
LEFT JOIN zxjy_task B ON ut.taskid =B.id
LEFT JOIN zxjy_shop s ON ut.shopid =s.sid
LEFT JOIN zxjy_product as p on p.id = ut.proid
WHERE 1=1 ";
    	
    	if($key){
    		$sql .= " AND {$key} LIKE '%{$txt}%' ESCAPE '!'";
    	}
    	
    	if($id !=null){
    		$sql .=" AND ut.merchantid ={$id} ";
    	}
    	if($status !='all'){
    		$sql .=" AND ut.`status` ={$status}  ";
    	}
    	if($begin > 0){
    		$sql .= "AND ut.addtime >{$begin} ";
    	}
    	if($end > 0){
    		$sql .= "AND ut.addtime <{$end} ";
    	}
    	if($type!='all'){
    		$sql .= "AND B.tasktype ={$type} ";
    	}
    	$sql .= " ORDER BY ut.addtime DESC ";
    	
    	
        $query = $this->db->query($sql)->row();
        return $query->cc ;  
    }
    public function getAllToday(){
        $this->db->where('status',3);
        $this->db->where('updatetime <',@strtotime(date('Y-m-d')));
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
}