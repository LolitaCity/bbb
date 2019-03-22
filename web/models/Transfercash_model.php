<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Transfercash_model extends CI_Model{

    const TBL_NAV = 'transfercash';
    

    public function checked($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_NAV);
        return $query->first_row();
    }
	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
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
	public function getListAll($pid){
	    $this->db->where('merchantid',$pid);
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getList($pid,$limit,$offset){
/*	    $this->db->where('transfercash.merchantid',$pid);
	    $this->db->order_by('transfercash.addtime','desc');
	    $this->db->limit($limit,$offset);
        $this->db->select('transfercash.*,usertask.id as ibfo');
        $this->db->from(self::TBL_NAV);
        $this->db->join('transfercash','transfercash.usertaskid=usertask.id','left');

        select zxjy_transfercash.*,zxjy_usertask.id
from zxjy_transfercash
left join  zxjy_usertask on zxjy_transfercash.usertaskid=zxjy_usertask.id
where `zxjy_transfercash`.`merchantid`='83' and zxjy_usertask.id is not null

	    $query = $this->db->get(self::TBL_NAV);
	   // echo $this->db->last_query();
	    return $query->result();*/
        $sql = @"select A.*, B.id as sid , B.userid , C.truename as  truename2
from zxjy_transfercash A
left join  zxjy_usertask B  on A.usertaskid=B.id 
LEFT JOIN zxjy_user C ON  C.id = B.userid
 where A.merchantid ='{$pid}' and B.id is not null      		
 order by A.addtime DESC   ";
         
        if($limit !=0 ){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }
	public function CountList($pid){
		$sql = @"select 1
		from zxjy_transfercash A
		left join  zxjy_usertask B  on A.usertaskid=B.id
		LEFT JOIN zxjy_user C ON  C.id = B.userid
		where A.merchantid ='{$pid}' and B.id is not null  ";
		/*
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` 
                on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` where `zxjy_transfercash`.`merchantid` =".$pid." and `zxjy_usertask`.`id` is not null";
                */
        $query = $this->db->query($sql);
        return $query->num_rows();
	  /*  $this->db->where('merchantid',$pid);
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();*/
	}
	public function getSearchUnTime($pid,$limit,$offset,$exceloutstatus,$ordersn,$start,$end){
	    $this->db->where('merchantid',$pid);
	    if($start!=0){
	       $this->db->where('addtime >',$start);
	    }
	    if($end !=0){
	       $this->db->where('addtime <',$end);
	    }
	    $this->db->like('ordersn',$ordersn);
	    if($exceloutstatus!='-1'){
	        $this->db->where('excelout',$exceloutstatus);
	    }
	    $this->db->limit($limit,$offset);
	    $this->db->order_by('addtime','desc');
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getSearchunTimeCount($pid,$exceloutstatus,$ordersn,$start,$end){
	    $this->db->where('merchantid',$pid);
	    if($start!=0){
	       $this->db->where('addtime >',$start);
	    }
	    if($end !=0){
	       $this->db->where('addtime <',$end);
	    }
	    $this->db->like('ordersn',$ordersn);
	    $this->db->order_by('addtime','desc');
	    if($exceloutstatus!='-1'){
	        $this->db->where('excelout',$exceloutstatus);
	    }
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->num_rows();	    
	}
    public function updataPass($arr,$db){
        $this->db->where_in('id',$arr);
        return $this->db->update(self::TBL_NAV,$db);
    }	
    public function getListAllNo($pid){
	    $this->db->where('merchantid',$pid);
	    $this->db->where('transferstatus',1);
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getResult($pid,$limit,$offset){
	    /*$this->db->where('merchantid',$pid);
	    $this->db->where('transferstatus >',1);
	    $this->db->order_by('addtime','desc');
	    if($limit != 0){
	       $this->db->limit($limit,$offset);
	    }
	    $query = $this->db->get(self::TBL_NAV);*/
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask`on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where `zxjy_transfercash`.`merchantid` =".$pid." and `zxjy_usertask`.`id` is not null and `zxjy_transfercash`.`transferstatus` > '1'";
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        if($limit !=0 ){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
	}
	public function getCountResult($pid){
	    /*$this->db->where('merchantid',$pid);
	    $this->db->where('transferstatus >',1);
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);*/

        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where `zxjy_transfercash`.`merchantid` =".$pid." and `zxjy_usertask`.`id` is not null and `zxjy_transfercash`.`transferstatus` > '1'
                order by `zxjy_transfercash`.`addtime` DESC";
        $query = $this->db->query($sql);
	    return $query->num_rows();
	}	                        
	public function getSearchResult($pid,$limit,$offset,$ordersn,$statustype,$start,$end){
/*	    $this->db->where('merchantid',$pid);
	    $this->db->like('ordersn',$ordersn);
	    $this->db->where('transferstatus >',1);
	    if($statustype!=0){
	       $this->db->where('transferstatus',$statustype);
	    }
	    if($start !=0){
	        $this->db->where('updatetime >',$start);
	    }
	    if($end !=0){
	        $this->db->where('updatetime <',$end);
	    }
	    $this->db->order_by('addtime','desc');
	    if($limit != 0){
	       $this->db->limit($limit,$offset);
	    }
	    $query = $this->db->get(self::TBL_NAV);*/

	   // echo $this->db->last_query();
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null and `zxjy_transfercash`.`merchantid` =".$pid." AND (`zxjy_transfercash`.`ordersn` like '%".$ordersn."%') AND `zxjy_transfercash`.`transferstatus` >'1' ";
        if($statustype!=0){
           // $this->db->where('transferstatus',$statustype);
            $sql .= " AND `zxjy_transfercash`.`transferstatus` = ".$statustype ;
        }
        if($start !=0){
           // $this->db->where('updatetime >',$start);
            $sql .= " AND `zxjy_transfercash`.`updatetime` > ".$start ;
        }
        if($end !=0){
           // $this->db->where('updatetime <',$end);
            $sql .= " AND `zxjy_transfercash`.`updatetime` < ".$end ;
        }
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        if($limit !=0 ){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
        //echo $sql;
        $query = $this->db->query($sql);

	    return $query->result();
	}
	public function getCountSearchResult($pid,$ordersn,$statustype,$start,$end){
	   /* $this->db->where('merchantid',$pid);
	    $this->db->like('ordersn',$ordersn);;
	    $this->db->where('transferstatus >',1);
	    if($statustype!=0){
	       $this->db->where('transferstatus',$statustype);
	    }
	    if($start !=0){
	        $this->db->where('updatetime >',$start);
	    }
	    if($end !=0){
	        $this->db->where('updatetime <',$end);
	    }
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);*/
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null 
                AND `zxjy_transfercash`.`merchantid` =".$pid." 
                AND (`zxjy_transfercash`.`ordersn` like '%".$ordersn."%') 
                AND `zxjy_transfercash`.`transferstatus` >1 ";
        if($statustype!=0){
            // $this->db->where('transferstatus',$statustype);
            $sql .= " AND `zxjy_transfercash`.`transferstatus` = ".$statustype ;
        }
        if($start !=0){
            // $this->db->where('updatetime >',$start);
            $sql .= " AND `zxjy_transfercash`.`updatetime` > ".$start ;
        }
        if($end !=0){
            // $this->db->where('updatetime <',$end);
            $sql .= " AND `zxjy_transfercash`.`updatetime` < ".$end ;
        }
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        $query = $this->db->query($sql);
	    return $query->num_rows();
	}
	public function getNoInfo($userid,$limit,$offset){
	    /*$this->db->where('merchantid',$userid);
	    $this->db->where('transferstatus',4);
	    if($limit==0){
	       $this->db->limit($limit,$offset);
	    }
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);*/
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null 
                AND `zxjy_transfercash`.`merchantid` =".$userid."
                AND `zxjy_transfercash`.`transferstatus` ='4'";
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        if($limit!=0){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
        $query = $this->db->query($sql);
	    return $query->result();
	}
	public function getNoInfoCount($userid){
	    /*$this->db->where('merchantid',$userid);
	    $this->db->where('transferstatus',4);
	    $query = $this->db->get(self::TBL_NAV);*/

        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null 
                AND `zxjy_transfercash`.`merchantid` =".$userid."
                AND `zxjy_transfercash`.`transferstatus` ='4'";
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        $query = $this->db->query($sql);
	    return $query->num_rows();
	}
	
	public function getNoList($userid,$limit,$offset,$ordersn,$start,$end){
	    /*$this->db->where('merchantid',$userid);
	    $this->db->like('ordersn',$ordersn);
	    if($start!=0){
	        $this->db->where('addtime >',$start);
	    }
	    if($end!=0){
	        $this->db->where('addtime <',$end);
	    }
	    $this->db->limit($limit,$offset);
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);*/

        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null 
                AND `zxjy_transfercash`.`merchantid` =".$userid."
                AND (`zxjy_transfercash`.`ordersn`) like '%".$ordersn."%' 
                AND `zxjy_transfercash`.`transferstatus` ='4'             
                ";
        if($start!=0){
            $sql .= " AND `zxjy_transfercash`.`addtime` >".$start;
        }
        if($end!=0){
            $sql .= " AND `zxjy_transfercash`.`addtime` <".$end;
        }
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        if($limit!=0){
            $sql .= " LIMIT ".$offset.",".$limit."";
        }
        $query = $this->db->query($sql);
	    return $query->result();
	}
	public function getNoCount($userid,$ordersn,$start,$end){
	  /*  $this->db->where('merchantid',$userid);
	    $this->db->like('ordersn',$ordersn);
	    if($start!=0){
	        $this->db->where('addtime >',$start);
	    }
	    if($end!=0){
	        $this->db->where('addtime <',$end);
	    }
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);*/

        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask` on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where  `zxjy_usertask`.`id` is not null 
                AND `zxjy_transfercash`.`merchantid` =".$userid."
                AND (`zxjy_transfercash`.`ordersn`) like '%".$ordersn."%' 
                AND `zxjy_transfercash`.`transferstatus` ='4'                  
                ";
        if($start!=0){
            $sql .= " AND `zxjy_transfercash`.`addtime` >".$start;
        }
        if($end!=0){
            $sql .= " AND `zxjy_transfercash`.`addtime` <".$end;
        }
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        $query = $this->db->query($sql);
	    return $query->num_rows();
	}
	public function TimeOut($time){
        $this->db->where('addtime >',$time);
        $this->db->where('addtime <',$time+24*60*60);
	    $this->db->where('transferstatus <',2);
	    $query = $this->db->get(self::TBL_NAV);
         echo $this->db->last_query();
	    return $query->result();
	}
	public function OutExcel($id){
	    /*$this->db->where('merchantid',$id);
	    $this->db->where('transferstatus','1');
	    $query = $this->db->get(self::TBL_NAV);*/
	    //echo $this->db->last_query();
        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid 
                from `zxjy_transfercash` left join  `zxjy_usertask`on `zxjy_transfercash`.`usertaskid`=`zxjy_usertask`.`id` 
                where `zxjy_transfercash`.`merchantid` =".$id." and `zxjy_usertask`.`id` is not null and `zxjy_transfercash`.`transferstatus` = '1'";
        $sql .=" order by `zxjy_transfercash`.`addtime` DESC";
        $query = $this->db->query($sql);
	    return $query->result();	    
	}
	public function OutExcelAll($id){
	    $this->db->where('merchantid',$id);
	    $query = $this->db->get(self::TBL_NAV);
	    //echo $this->db->last_query();
	    return $query->result();	    
	}
	public function getListSearch($id,$start,$end){
	    $this->db->where('merchantid',$id);
	    if($start!=0){
	        $this->db->where('addtime >',$start);
	    }
	    if($end!=0){
	        $this->db->where('addtime <',$end);
	    }
	    $this->db->order_by('addtime','desc');
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getSearchTime($pid,$exceloutstatus,$ordersn,$start,$end,$page){
	 /*   $this->db->where('transfercash.merchantid',$pid);
	    if($start!=0){
	        $this->db->where('transfercash.addtime >',$start);
	    }
	    if($end !=0){
	        $this->db->where('transfercash.addtime <',$end);
	    }
	    $this->db->like('transfercash.ordersn',$ordersn);
	    if($exceloutstatus!='-1'){
	        $this->db->where('transfercash.transferstatus',$exceloutstatus);
	    }
	    $this->db->order_by('transfercash.addtime','desc');
	    $query=$this->db->get(self::TBL_NAV);*/
        $sql = 'SELECT bw.wangwang, tc.id, tc.ordersn, tc.money, tc.truename, tc.transferstatus, tc.addtime, bl.bankAccount, bl.bankName, bl.subbranch, u.TrueName FROM zxjy_transfercash as tc
                LEFT JOIN zxjy_usertask as ut on ut.id = tc.usertaskid
                LEFT JOIN zxjy_user as u on u.id = ut.userid
                LEFT JOIN zxjy_banklist as bl on bl.id = tc.bankid
                LEFT JOIN zxjy_blindwangwang as bw on bw.userid = u.id
                WHERE tc.merchantid = ' . $pid ;  //zxjy_transfercash中的userid不可取
//        $sql = "select `zxjy_transfercash`.*,`zxjy_usertask`.`id` as sid ,`zxjy_user`.truename as truename2
//                from `zxjy_transfercash`
//                left join  `zxjy_usertask` on `zxjy_usertask`.`id`=`zxjy_transfercash`.`usertaskid`
//        		left join  `zxjy_user` on `zxjy_user`.`id`=`zxjy_usertask`.`userid`
//                where `zxjy_transfercash`.`merchantid` =".$pid." and `zxjy_usertask`.`id` is not null";
        $count_sql = 'SELECT COUNT(1) as sum FROM zxjy_transfercash as tc WHERE tc.merchantid = ' . $pid ;
        if($start!=0){
            $count_sql .= " and `tc`.`addtime`>".$start;
            $sql .= " and `tc`.`addtime`>".$start;
        }
        if($end !=0){
            $count_sql .= " and `tc`.`addtime`<".$end;
            $sql .= " and `tc`.`addtime`<".$end;
        }
        $count_sql .= " and (`tc`.`ordersn` like '%".$ordersn."%')";
        $sql .= " and (`tc`.`ordersn` like '%".$ordersn."%')";
        if($exceloutstatus!=''){
            $count_sql .= " and (`tc`.`transferstatus` ='".$exceloutstatus."')";
            $sql .= " and (`tc`.`transferstatus` ='".$exceloutstatus."')";
        }
        $sql .=" order by `tc`.`id` DESC LIMIT " . $page . ', 10';
       // echo $sql;
        return [
            'list' => $this -> db -> query($sql) -> result(),
            'count' => $this -> db -> query($count_sql) -> row() -> sum,
        ];
	}

}