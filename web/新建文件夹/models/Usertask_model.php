<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Usertask_model extends CI_Model{

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
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
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
	    $this->db->order_by('addtime','desc');

        $this->db->select('usertask.*,task.tasktype as typeinfo');// 任务分类 1（销量任务） 3 （复购任务）
        $this->db->select('usertask.*,task.addtime as typeaddtime');
        $this->db->from(self::TBL_NAV);
        $this->db->join('task','usertask.taskid=task.id','left');

	    $query = $this->db->get();
	    return $query->result();
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
        $this->db->where('shopid',$userid);
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
       /**/ 
        $sql="SELECT `zxjy_usertask`.*, `zxjy_task`.`tasktype` as `typeinfo`, `zxjy_task`.`addtime` as `typeaddtime` FROM `zxjy_usertask` LEFT JOIN `zxjy_task` ON `zxjy_usertask`.`taskid`=`zxjy_task`.`id` WHERE `zxjy_usertask`.`".$key."` LIKE '%".$txt."%' ESCAPE '!'";
        if($id !=null){
            $sql .=" AND `zxjy_usertask`.`merchantid` = ".$id." ";
        }
        if($status !='all'){
            $sql .=" AND `zxjy_usertask`.`status` = ".$status." ";
        }
        if($begin != 0){
            $sql .= "AND `zxjy_usertask`.`addtime` > ".$begin." ";
        }
        if($end != 0){
            $sql .= "AND `zxjy_usertask`.`addtime` < ".$end." ";
        }
        if($type!='all'){
            $sql .= "AND `zxjy_task`.`tasktype` = ".$type." ";
        }
        $sql .= " ORDER BY `zxjy_usertask`.`addtime` DESC ";
        if($num !=0 ){
           $sql .= " LIMIT ".$offset.",".$num."";
        }
        $query = $this->db->query($sql);
        return $query->result();        
    }
    public function searchCount($id,$status,$key,$txt,$begin,$end,$type){
        $sql="SELECT `zxjy_usertask`.*, `zxjy_task`.`tasktype` as `typeinfo`, `zxjy_task`.`addtime` as `typeaddtime` FROM `zxjy_usertask` LEFT JOIN `zxjy_task` ON `zxjy_usertask`.`taskid`=`zxjy_task`.`id` WHERE `zxjy_usertask`.`".$key."` LIKE '%".$txt."%' ESCAPE '!'";
        if($id !=null){
            $sql .=" AND `zxjy_usertask`.`merchantid` = ".$id." ";
        }
        if($status !='all'){
            $sql .=" AND `zxjy_usertask`.`status` = ".$status." ";
        }
        if($begin != 0){
            $sql .= "AND `zxjy_usertask`.`addtime` > ".$begin." ";
        }
        if($end != 0){
            $sql .= "AND `zxjy_usertask`.`addtime` < ".$end." ";
        }
        if($type!='all'){
            $sql .= "AND `zxjy_task`.`tasktype` = ".$type." ";
        }
        $query = $this->db->query($sql);
        return count($query);  
    }
    public function getAllToday(){
        $this->db->where('status',3);
        $this->db->where('updatetime <',@strtotime(date('Y-m-d')));
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
}