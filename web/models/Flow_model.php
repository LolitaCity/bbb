<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Flow_model extends CI_Model{

    const TBL_NAV = 'flow';
    

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
	public function getUserList($userid){
	    $this->db->where('userid',$userid);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getUserCount($userid){
	    $this->db->where('userid',$userid);
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
	public function getList($userid,$begintime,$endtime,$type,$type2,$search,$limit,$offset){
	    $this->db->where('userid',$userid);
	    $this->db->where('addtime >',$begintime);
	    if($endtime !=0){
	        $this->db->where('addtime <',$endtime);
	    }
	    if($type != 0){
	       $this->db->where('remark',$type);
	    }
	    if($type2 != 0){
	       if($type2 == 1){
        	    if($search != ''){
        	        $this->db->like('taskid',$search);
        	    }
	       }elseif($type2 == 2){
        	    if($search != ''){
        	        $this->db->like('shopname',$search);
        	    }
	       }elseif($type2 == 3){
        	    if($search != ''){
        	        $this->db->like('protbid',$search);
        	    }
	       }
	    }
	    if($limit != 0 ){
	        $this->db->limit($limit,$offset);
	    }
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();
	}
	public function getListCount($userid,$begintime,$endtime,$type,$type2,$search){
	    $this->db->where('userid',$userid);
	    $this->db->where('addtime >',$begintime);
	    if($endtime !=0){
	        $this->db->where('addtime <',$endtime);
	    }
	    if($type != 0){
	        $this->db->where('remark',$type);
	    }
	    if($type2 != 0){
	        if($type2 == 1){
	            if($search != ''){
	                $this->db->like('taskid',$search);
	            }
	        }elseif($type2 == 2){
	            if($search != ''){
	                $this->db->like('shopname',$search);
	            }
	        }elseif($type2 == 3){
	            if($search != ''){
	                $this->db->like('protbid',$search);
	            }
	        }
	    }
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
    public function getListSearch($begintime,$endtime,$fanncance,$select,$search){
        $this->db->where('addtime >',$begintime);
	    if($endtime !=0){
	        $this->db->where('addtime <',$endtime);
	    }
	    if($fanncance != 0){
	        $this->db->where('remark',$fanncance);
	    }
	    if($select != 0){
	        if($select == 1){
	            if($search != ''){
	                $this->db->like('taskid',$search);
	            }
	        }elseif($select == 2){
	            if($search != ''){
	                $this->db->like('shopname',$search);
	            }
	        }elseif($select == 3){
	            if($search != ''){
	                $this->db->like('protbid',$search);
	            }
	        }
	    }
	    $query = $this->db->get(self::TBL_NAV);
	    return $query->result();	    
    }
	
	
}