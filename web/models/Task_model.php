<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Task_model extends CI_Model{

    const TBL_NAV = 'task';
    const TBL_TIME = 'tasktime';
    const TBL_MODEL = 'taskmodel';
    

	public function add($data){
	    return $this->db->insert(self::TBL_NAV,$data);
	}// 添加
	public function updata($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_NAV,$data);
	}// 修改	
	public function del($id){
	    $this->db->where('sid',$id);
	    return $this->db->delete(self::TBL_NAV);
	
	} //删除
	public function getInfo($key){
	    $this->db->where('id',$key);
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->first_row();
	}
	public function getUserid($userid){
        $sql = 'select t.*, m.commission, m.express from zxjy_task as t left join zxjy_taskmodel as m on t.mark = m.pid WHERE t.userid = ' . $userid . ' AND (t.number - t.qrnumber - t.del) > 0 order by t.id asc';
	    return $this -> db -> query($sql) -> result();
//	    $this->db->where('userid',$userid);
//	    $this->db->order_by('id','asc');
//	    $query=$this->db->get(self::TBL_NAV);
//	    return $query->result();
	}
	public function Prodel($userid,$proid)
    {
	    $this->db->where('userid',$userid);
	    $this->db->where('proid',$proid);
	    $this->db->order_by('id','asc');
	    $query=$this->db->get(self::TBL_NAV);
	    return $query->num_rows();
	}
    public function getArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
    public function getNoArr($userid){
        $this->db->where('userid',$userid);
        $this->db->order_by('id','desc');
        $query = $this->db->get(self::TBL_NAV);
        return $query->result();
    }
	
	
	//根据时间获取页面信息
	public function SevenDay($start,$end,$userid)
    {
        $sql = 'SELECT tt.date, IF(tt.close > UNIX_TIMESTAMP(NOW()), t.number, t.qrnumber) as number, t.del FROM zxjy_task as t 
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                WHERE t.userid = ' . $userid . ' AND date > ' . $start;
        return $this -> db -> query($sql) -> result();
//	    $this->db->where('userid',$userid);
//	    $this->db->where('date >',$start);
//	    $this->db->where('end >',$start);
//                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $this->db->where('date <',$end);
//	    $query=$this->db->get(self::TBL_TIME);
//	    return $query->result();
	}
	public function addtime($data){
	    return $this->db->insert(self::TBL_TIME,$data);
	}
	public function getThisTime($userid)
    {
	    $sql = 'select id, pid, close, number, takenumber, del from zxjy_tasktime where userid = ' . $userid . ' AND (number - takenumber - del) > 0 order by id asc';
	    return $this -> db -> query($sql) -> result();
//	    $this->db->where('userid',$userid);
//	    $this->db->order_by('id','asc');
//	    $query=$this->db->get(self::TBL_TIME);
//	    return $query->result();
	}	
	public function updatatime($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_TIME,$data);
	}// 修改
    public function getTimeArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_TIME);
        return $query->result();
    }
    public function getNoTimeArr($userid){
        $this->db->where('userid',$userid);
        $this->db->order_by('id','desc');
        $query = $this->db->get(self::TBL_TIME);
        return $query->result();
    }
    public function getInfoTime($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_TIME);
        return $query->first_row();
    }
    public function getBuyPidTime($pid){
        $this->db->where('pid',$pid);
        $query = $this->db->get(self::TBL_TIME);
        return $query->result();
    }
	
	
	
	// 类型
	public function addmodel($data){
	    return $this->db->insert(self::TBL_MODEL,$data);
	}
	public function updatamodel($id,$data){
	    $this->db->where('id',$id);
	    return $this->db->update(self::TBL_MODEL,$data);
	}// 修改	
	public function getModel($userid){
	    $sql = 'select id, pid, number, takenumber, del,  commission from zxjy_taskmodel where userid = ' . $userid . ' AND (number - takenumber - del) > 0 order by id asc';
	    return $this -> db -> query($sql) -> result();
//	    $this->db->where('userid',$userid);
//	    $this->db->order_by('id','asc');
//	    $query=$this->db->get(self::TBL_MODEL);
//	    return $query->result();
	}
    public function getModelArr($arr){
        $this->db->where_in('id',$arr);
        $query = $this->db->get(self::TBL_MODEL);
        return $query->result();
    }
    public function getNoModelArr($userid)
    {
        $this->db->where('userid', $userid);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get(self::TBL_MODEL);
        return $query->first_row();
    }

    public function getInfoModel($id){
        $this->db->where('id',$id);
        $query = $this->db->get(self::TBL_MODEL);
        return $query->first_row();
    }
    public function getBuyPidModel($pid){
        $this->db->where('pid',$pid);
        $query = $this->db->get(self::TBL_MODEL);
        return $query->result();
    }
}