<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Sales extends MY_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public $redis;

	public function __construct() {
		$this->memberlogin = true;
		parent::__construct ();
		$this->load->model ( 'User_model', 'user' );
		$this->load->model ( 'Sys_model', 'sys' );
		$this->load->model ( 'Shop_model', 'shop' );
		$this->load->model ( 'Product_model', 'product' );
		$this->load->model ( 'Task_model', 'task' );
		$this->load->model ( 'Usertask_model', 'usertask' );
		$this->load->model ( 'Blindwangwang_model', 'bindwangwang' );
		$this->load->model ( 'Buyer_model', 'buyer' );
		$this->load->model ( 'Taskevaluate_model', 'taskevaluate' );
		$this->load->model ( 'Complaint_model', 'complaint' );
		$this->load->model ( 'System_model', 'system' );
		$this -> load -> driver('cache');
		$this -> redis = $this -> cache -> redis;
	}
	/*
	 * 获取当前用户信息和系统配置信息
	 */
	public function _include()
    {
        $id = $_SESSION['sellerid'];
        $db = $this -> getServerInfo();
        //$db ['showcontent'] = 1;
        $db['shops'] = $this->shop->getlist ( $id, 1, 0, 0, 0 );
        return $db;
	}


	/*
	 * 检查店铺是否被多次绑定
	 */
	public function checkBondShopNum()
    {
        if (isset($_POST['proid']))
        {
            $sql = 'SELECT COUNT(1) as sum FROM zxjy_shop WHERE shopname = (SELECT shopname FROM zxjy_shop as s
                LEFT JOIN zxjy_product as p on p.shopid = s.sid
                WHERE p.id = ' . $_POST ['proid']. ') AND auditing = 1';
            $count = $this -> db -> query($sql) -> first_row() -> sum;
            $count <= 1 ? show(1, '选择商品成功，正在跳转页面...') : show(0, '所选店铺被多个账号绑定，这可能导致平台复购管控失效，您可以（1）删除无30天内任务信息的店铺；（2）固定一个账号的店铺进行发布任务。是否继续发布任务');
        }
        else
            show(0, '参数错误');
    }


	/*
	 * 商家发布任务首页
	 */
	public function index()
    {
		//if (!empty($this -> uid))
        //{
        //    $sql = "SELECT COUNT(1) as has FROM zxjy_1111survey WHERE uid = {$this -> uid}";
        //    $has = $this -> db -> query($sql) -> first_row() ->  has;
        //    if(!$has && !in_array($this -> router -> fetch_method(), ['ecPaycallback', 'ecPayErrorHandle', 'apiTest', 'survey', 'submit_survey']) && !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
        //    {
        //        exit('<script>location.href =  "/user/survey"</script>');
        //   }
        //}
		$db = $this->_include ();  //获取客服信息以及当前用户信息
		if ($db ['info']->Status == 0)  //账号状态正常
		{
		    $sql = 'SELECT value FROM zxjy_system WHERE varname = "service_charge"';
		    $has_service_charge = $this -> cacheSqlQuery('service_charge_info', $sql, 0, true, 'first_row') -> value;
            $sql = 'SELECT IF(TO_DAYS(NOW()) - TO_DAYS(FROM_UNIXTIME(pay_time)) <= 31 OR isagent = 1, 1, 0) as has_pay FROM zxjy_user where id = ' . $this -> uid;
            if ($this -> db -> query($sql) -> first_row() -> has_pay || $has_service_charge == 0)
            {
                $id = @$_GET ['id'] == '' ? 0 : @$_GET ['id'];  //标志任务分类类型【1-销量任务、3-复购任务】,如果为0，则为进入发布任务首页的状态
                $db ['myint'] = $id;
                $proid = @$_GET ['proid'] == '' ? 0 : @$_GET ['proid'];
                if ($proid != 0)
                {
                    $db ['proinfo'] = $this->product->getInfo ( $proid );
                }
                $db ['proid'] = $proid;
                $db ['shop'] = $this->shop->getlist ( $db ['info']->id, 1, 0, 0, 0 );

                $this->session->set_userdata ( 'typepage', $id );
                setcookie ( 'typepage', $id );

                if ($id == 3)   //复购任务
                {
                    $time = @strtotime ( @date ( "Y-m-d", @strtotime ( "-1 month" ) ) );  //标志当前月的1号
                    $db ['counttask'] = $this->usertask->getCount ( $time, $db ['info']->id );  //查询这个月之前是否有用户完成了该店铺的任务
                    // var_dump($db['proinfo']);
                    // $this->load->view('rebuy', $db);
                    // $db['counttask'] =50;

                    if ($db ['counttask'] == 0) {
                        if ($proid != 0) {
                            $db ['counttaskshop'] = $this->usertask->getCountShop ( $time, $proid );  //查询该商品这个月之前是否有完成的任务
                            if ($db ['counttaskshop'] != 0) {
                                $this->load->view ( 'rebuy', $db );
                            } else {
                                echo "<script>alert('您选择的产品还没有潜在用户哦！！');</script>";
                                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sales\" >";
                            }
                        } else {
                            $this->load->view ( 'rebuy', $db );  //复购任务界面
                        }
                    } else {
                        echo "<script>alert('您还没有潜在用户可以接到您的复购任务哦！');</script>";
                        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=sales\" >";
                    }
                } else {
                    $this->load->view ( 'release', $db );  //销量任务界面
                }
            }
            else
            {
                echo "<script>alert('您尚未缴纳服务费或者已经过期，不能发布任务');</script>";
                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../user\" >";
            }
		}
		else   //账号被冻结
        {
			echo "<script>alert('您的账户已经被冻结了，请检查是否有今日之前的未转账记录');</script>";
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../user\" >";
		}
	}

	/*
	 * 再次发布
	 */
	public function republish()
    {
        if (isset($_GET['taskid']))
        {
            $sql = 'SELECT p.commodity_id, p.commodity_abbreviation, p.commodity_title, p.commodity_url, s.shopname, t.intlet, t.keyword, t.number, tm.price, tm.auction, tm.express, 
                      t.gettime, FROM_UNIXTIME(tt.start, "%H:%m") as "start", FROM_UNIXTIME(tt.end, "%H:%m") as "end", FROM_UNIXTIME(close, "%H:%m") as "close", t.top, t.remark , tm.how_browse,
                      tm.how_search, tm.new_keyword, t.tasktype, t.order, t.price as other_price, t.sendaddress, t.other, s.sid FROM zxjy_task as t
                    LEFT JOIN zxjy_taskmodel as tm on tm.pid = t.mark
                    LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                    LEFT JOIN zxjy_shop as s on s.sid = t.shopid
                    LEFT JOIN zxjy_product as p on p.id = t.proid
                    WHERE t.id = ' . $_GET['taskid'];
            if ($infos = $this -> db -> query($sql) -> first_row())
            {
                $gards_type = $infos -> tasktype > 3 ? 'precommission_seller' : 'commission_seller';
                $sql = 'SELECT value FROM zxjy_system WHERE varname = "' . $gards_type . '"';
                $infos -> commission_gards = $this -> db -> query($sql) -> first_row();
                $this->load->view ( 'republish', $infos);
            }
            else
                echo  '无该任务信息';
        }
        else
            echo  '参数错误';
    }
    
    public function republishDB()
    {
        if (isset($_POST['taskid']))
        {
            extract($_POST);
            $mark = time() . $this -> generate_password();
            $sql = 'SELECT * FROM zxjy_task WHERE id = ' . $taskid;
            $task = $this -> db -> query($sql) -> row_array();
            //对task表进行重插
            $task_diff_data = [
                'intlet' => $intlet,
                'keyword' => $keyword,
                'number' => $number,
                'qrnumber' => 0,
                'del' => 0,
                'order' => $order,
                'price' => $price_min . '^' . $price_max,
                'sendaddress' => $sendaddress,
                'other' => $other,
                'top' => isset($top) ? $top : 0,
                'remark' => $remark,
                'addtime' => time(),
                'gettime' => $gettime,
                'mark' => $mark,
            ];
            if ($new_taskid = $this->republish_handler('task', $task, $task_diff_data))
            {
                $sql = 'SELECT * FROM zxjy_taskmodel WHERE pid = "' . $task['mark'] . '"';
                $taskmodel = $this -> db -> query($sql) -> row_array();
                $taskmodel_diff_data = [
                    'pid' => $mark,
                    'price' => $price,
                    'auction' => $auction,
                    'express' => $express,
                    'number' => $number,
                    'takenumber' => 0,
                    'del' => 0,
                    'commission' => $commission,
                    'new_keyword' => @$new_keyword,
                    'how_browse' => @$how_browse,
                    'how_search' => @$how_search,
                ];
                if ($new_taskmodelid = $this->republish_handler('taskmodel', $taskmodel, $taskmodel_diff_data))
                {
                    $sql = 'SELECT * FROM zxjy_tasktime WHERE pid = "' . $task['mark'] . '"';
                    $tasktime = $this -> db -> query($sql) -> row_array();
                    $average_time = $gettime == 1 ? explode( ' - ', $average_time) : false;
                    $tasktime_diff_data = [
                        'pid' => $mark,
                        'start' => $average_time ? strtotime($average_time[0]) : time(),
                        'end' => $average_time ? strtotime($average_time[1]) : strtotime($close),
                        'close' => strtotime($close),
                        'date' => strtotime(date('Y-m-d')),
                        'number' => $number,
                        'takenumber' => 0,
                        'del' => 0,
                        'beginPay' => strtotime(date('Y-m-d', ($average_time ? strtotime($average_time[0]) : time()) + 60 * 60 * 24) . ' 09:00:00'),
                        'EndPay' => strtotime(date('Y-m-d', ($average_time ? strtotime($average_time[0]) : time()) + 60 * 60 * 24) . ' 23:59:59'),
                    ];
                    if (!$this->republish_handler('tasktime', $tasktime, $tasktime_diff_data))
                    {
                        $this -> db -> delete('taskmodel', ['id' => $new_taskmodelid]);
                        show(0, '插入数据失败！！！');
                    }
                    else
                        show(1, '再次发布任务成功');
                }
                else
                {
                    $this -> db -> delete('task', ['id' => $new_taskid]);
                    show(0, '插入数据失败！！');
                }
            }
            else
                show(0, '写入数据失败！');
        }
        else
            show(0, '参数错误');
    }

    public function republish_handler($table_name, $old_data, $diff_data)
    {
        unset($old_data['id']);  //删除主键
        $insert = array_merge($old_data, $diff_data);
        return $this -> db -> insert($table_name, $insert) ? true : $this -> db -> insert_id();

    }


	/*
	 * 弹窗显示任务类型供商家选择
	 */
	public function infoshow()
    { // 弹窗先选类型···
        $sql = 'SELECT value from zxjy_system WHERE id = 99';
        $has_lock = $this -> cacheSqlQuery('taskOpen', $sql, 0, true, 'first_row');
		$this->load->view ( 'MsgTaskType', [
		    'has_lock' => $has_lock -> value,
        ]);
	}
	public function choosepro() {
		$db = $this->_include ();
		$this->load->view ( 'SelectProduct', $db );
	}
	public function SelectProduct($key = 0)
    { // 选产品信息
		if ($key != 0)
        {
			$db = $this->_include ();
			$db ['shopid'] = @$_GET ['ShopID'] == '' ? '0' : @$_GET ['ShopID'];
			$db ['serachtype'] = @$_GET ['SelSearch'] == '' ? '' : @$_GET ['SelSearch'];
			$db ['TxtSearch'] = @$_GET ['TxtSearch'] == '' ? '' : @$_GET ['TxtSearch'];
			$db ['abbreviation'] = @$_GET ['abbreviation'] == '' ? '' : @$_GET ['abbreviation'];
            $shopid = $db ['shopid'] ? $shopid = $db ['shopid'] : 'all';
			$db ['pros'] = $this->product->getListPro ( $db ['info']->id, $shopid, $db ['serachtype'], $db ['TxtSearch'], $db ['abbreviation']);
			$db ['infoint'] = $key;
			$this->load->view ( 'SelectProduct', $db );
		}
		else
        {
            echo "<script>alert('请不要测试错误链接！谢谢！');history.back();</script>";
        }
	}
	/*
	 * 未接任务
	 */
	public function taskno()
    {
		$db = $this->_include ();
        //筛选出商家发布的任务中，发布类型为【立即发布】且超时取消时间大于当前或者发布类型为【今日/多条平均发布】且结束时间大于当前时间，且计划任务数大于已接任务数，即为未接任务数
        $sql = 'SELECT t.top,  FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, tm.how_browse, tm.how_search, tm.new_keyword, tm.handsel, tm.Payment, t.mark, t.userid, t.id, t.tasktype, t.number, t.qrnumber, t.addtime, t.shopid, t.proid, t.keyword, t.status, t.gettime, tt.start, tt.end, tt.close, p.commodity_title, s.shopname, count(distinct tt.id)  from zxjy_task as t
                LEFT JOIN zxjy_tasktime as tt on t.mark = tt.pid
                LEFT JOIN zxjy_taskmodel as tm on t.mark = tm.pid
                LEFT JOIN zxjy_product as p on t.proid = p.id
                LEFT JOIN zxjy_shop as s on t.shopid = s.sid
                WHERE t.userid = ' . $db ['info']->id . ' AND t.del = 0 AND t.number > t.qrnumber AND tt.start >= UNIX_TIMESTAMP(DATE_FORMAT(NOW(), "%Y-%m-%d 00:00")) AND tt.close > UNIX_TIMESTAMP(NOW()) group by t.id order by id desc';
        $db['list'] = $this -> db -> query($sql) -> result();
		$this->load->view ( 'taskno', $db );
	}

	/*
	 * 无效任务
	 */
	public function invalidTask()
    {
        $db = $this -> getServerInfo();
        $page = isset($_GET['page']) ? $_GET ['page'] : 0;
        $start = $page * 10;
        $condition = '';
        extract($_GET);
        $condition .= isset($_GET['taskCategroy'])&& $_GET['taskCategroy']!=0? ' AND t.tasktype = ' . $taskCategroy : ' AND t.tasktype >0 ';
        $condition .= !empty($_GET['txtSearch']) ? ' AND ' . $selSearch . ' like "%' . $txtSearch . '%"' : '';
        $condition .= !empty($_GET['BeginDate']) ? ' AND t.addtime > ' . strtotime($BeginDate) : '';
        $condition .= !empty($_GET['EndDate']) ? ' AND t.addtime < ' . strtotime($EndDate) : '';
        $sql = 'SELECT t.top, FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, tm.how_browse, tm.how_search, tm.new_keyword, tm.handsel, tm.Payment, t.mark, t.userid, t.id, t.tasktype, t.number, t.qrnumber, t.addtime, t.shopid, t.proid, t.keyword, t.status, t.gettime, tt.start, tt.end, tt.close, p.commodity_title, s.shopname, count(distinct tt.id)  from zxjy_task as t
                LEFT JOIN zxjy_tasktime as tt on t.mark = tt.pid
                LEFT JOIN zxjy_taskmodel as tm on t.mark = tm.pid
                LEFT JOIN zxjy_product as p on t.proid = p.id
                LEFT JOIN zxjy_shop as s on t.shopid = s.sid
                WHERE t.userid = ' . $this -> uid . ' AND (t.del > 0 OR UNIX_TIMESTAMP(NOW()) >= tt.close) AND t.number > t.qrnumber ' . $condition . ' GROUP BY t.id ORDER BY id DESC LIMIT ' . $start . ', 10';
        $db['list'] = $this -> db -> query($sql) -> result();
        $sql = 'SELECT count(t.id) as count from zxjy_task as t
                LEFT JOIN zxjy_tasktime as tt on t.mark = tt.pid
                LEFT JOIN zxjy_taskmodel as tm on t.mark = tm.pid
                LEFT JOIN zxjy_product as p on t.proid = p.id
                LEFT JOIN zxjy_shop as s on t.shopid = s.sid
                WHERE t.userid = ' . $this -> uid . ' AND (t.del > 0 OR UNIX_TIMESTAMP(NOW()) >= tt.close) AND t.number > t.qrnumber ' . $condition;
        $db ['count'] = $this -> db -> query($sql) -> row() -> count;  //已接任务总数，用于分页
        $db ['page'] = $page;
        $db['search'] = 1;
        $this->load->view ('taskno', $db );
    }

	public function CloseOne() {
	    if (isset($_POST ['key']))
        {
            $sql = 'update zxjy_task set del = number - qrnumber where mark = "' . $_POST ['key'] . '"';
            $this -> db -> query($sql);
            $sql = 'update zxjy_tasktime set del = number - takenumber where pid = "' . $_POST ['key'] . '"';
            $this -> db -> query($sql);
            $sql = 'update zxjy_taskmodel set del = number - takenumber where pid = "' . $_POST ['key'] . '"';
            $this -> db -> query($sql);
            show(1, '已取消当前未被接手的任务，已接手的任务继续进行');  //innode的回滚机制
        }
        else
            show(0, '请不要测试错误链接');


//		$key = @$_POST ['keys'] == '' ? 0 : @$_POST ['keys'];
//		$json = 0;
//		// echo json_encode($key);
//		if ($key == 0) {
//			$json = 1;
//		} else {
//			$info = $this->task->getInfo ( $key );
//			if ($info != null) {
//				$dbtask ['del'] = $info->del + $info->number - $info->qrnumber; // 总表信息删除
//				// 修改model表信息
//				$dbmodel = $this->task->getBuyPidModel ($info->mark);
//				foreach ( $dbmodel as $vdm ) {
//					if ($vdm->number > ($vdm->del + $vdm->takenumber)) {
//						$dbmodels ['del'] = $vdm->del + $vdm->number - $vdm->takenumber;
//						$this->task->updatamodel ( $vdm->id, $dbmodels );
//					}
//				}
//
//				// 修改时间表信息
//				$dbtime = $this->task->getBuyPidTime ( $info->mark );
//				foreach ( $dbtime as $vdt ) {
//					if ($vdt->number > ($vdt->del + $vdt->takenumber)) {
//						$dbtimes ['del'] = $vdt->del + $vdt->number - $vdt->takenumber;
//						$this->task->updatatime ( $vdt->id, $dbtimes );
//					}
//				}
//
//				// 修改任务总表信息
//				$re = $this->task->updata ( $info->id, $dbtask );
//				if ($re) {
//					$json = 0;
//				} else {
//					$json = 3;
//				}
//			} else {
//				$json = 2;
//			}
//		}
//		echo json_encode ( $json );
	}
	public function hideOne() {
		$key = @$_POST ['keys'] == '' ? 0 : @$_POST ['keys'];
		if (isset($_POST ['keys']))
        {
            $sql = 'update zxjy_task  set status = !status where id = ' . $_POST ['keys'] . ' AND userid = ' . $_SESSION['sellerid'];
            $this -> db -> query($sql);
            $this->db -> affected_rows() ? show(1, '更新该任务状态成功') : show(0, '更新该任务状态失败，请稍后再试');
        }
        else
            show(0, '请指定需要改变状态的任务');
//		$json = 0;
//		if ($key == 0) {
//			$json = 1;
//		} else {
//			$info = $this->task->getInfo ( $key );
//			if ($info != null) {
//				if ($info->status == 1) {
//					$db ['status'] = 0;
//				} else {
//					$db ['status'] = 1;
//				}
//				$re = $this->task->updata ( $info->id, $db );
//				if ($re) {
//					$json = 0;
//				} else {
//					$json = 3;
//				}
//			} else {
//				$json = 2;
//			}
//		}
//		echo json_encode ( $json );
	}
	public function closeTaskAll() {
		$key = $_POST ['key'];
		$json = '';
		if ($key == 0 || $key == '') {
			$json = 1;
		} else {
			$userinfo = $this->user->getInfo ( $key );
			if ($userinfo != null) {
				$list = $this->task->getNoArr ( $key );
				$listmodel = $this->task->getNoModelArr ( $key );
				$listtime = $this->task->getNoTimeArr ( $key );
				foreach ( $list as $vl ) {
					if ($vl->number > ($vl->qrnumber + $vl->del)) {
						$db ['del'] = $vl->number - $vl->qrnumber;
						$this->task->updata ( $vl->id, $db );
					}
				}
				foreach ( $listmodel as $vlm ) {
					if ($vlm->number > ($vlm->takenumber + $vlm->del)) {
						$db ['del'] = $vlm->number - $vlm->takenumber;
						$this->task->updatamodel ( $vlm->id, $db );
					}
				}
				foreach ( $listtime as $vlt ) {
					if ($vlt->number > ($vlt->takenumber + $vlt->del)) {
						$db ['del'] = $vlt->number - $vlt->takenumber;
						$this->task->updatatime ( $vlt->id, $db );
					}
				}
				$json = 0;
			} else {
				$json = 2;
			}
		}
		echo json_decode ( $json );
	}

    /**
     * @param $array  需进行排序的数组
     * @param $keyid  根据某个键值进行排序
     * @param string $method  排序方式，默认升序
     * @param string $type  键值类型，默认整型
     */
    public function sort_array(&$array, $keyid, $method = 'DESC', $type = 'number')
    {
        $array = (array)$array;
        if (is_array($array))
        {
            foreach ($array as $val)
            {
                $order_arr[] = $val -> $keyid;
            }
            $method = ($method == 'DESC') ? SORT_DESC : SORT_ASC;
            $type = ($type == 'number') ? SORT_NUMERIC : SORT_STRING;
            @array_multisort($order_arr, $method, $type, $array);
        }
    }

    /*
     * 查看预单的截图
     */
    public function showPreImg()
    {
        if (isset($_POST['id']))
        {
            $sql = 'SELECT p.tasktwoimg as "支付订金/浏览步骤的搜索截图", p.browseimg as "浏览截图/支付订金截图", p.new_tasktwoimg as "预约单中，若要求以新的关键词搜索产品，对应的截图", p.orderimg as "预订单支付尾款/预约单付款截图"  FROM zxjy_usertask as ut
                    LEFT JOIN zxjy_pretask as p on p.ordersn = ut.ordersn 
                    WHERE ut.id = ' . $_POST['id'];
            $imgs = $this ->db -> query($sql) -> row_array();
            show(1, '获取数据成功', array_filter($imgs));  //去除值为空的元素返回
        }
        else
            show(0, '参数错误');
    }

    /*
     * 暂时预单的历史状态
     */
    public function showPreOldStatus()
    {
        if (isset($_POST['ordersn']))
        {
            $sql = 'SELECT FROM_UNIXTIME(addtime) as addtime, FROM_UNIXTIME(updatetime) as updatetime, handsel, payment, orderprice FROM zxjy_pretask WHERE ordersn = "' . $_POST['ordersn'] . '"';
            $datas = $this -> db -> query($sql) -> row_array();
            show(1, '获取数据成功', $datas);
        }
        else
            show(0, '参数错误');
    }

    // 商家已接任务
	public function taskyes() {
        $db = $this->_include ();
        $page = @$_GET ['page'] == '' ? 0 : @$_GET ['page'];
        //未接任务sql8
	    $sql = 'SELECT t.top, FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, ut.id, ut.tasksn, ut.ordersn, ut.status, ut.addtime, ut.expressnum, ut.userid, ut.taskid, ut.complaint, ut.showpicbtn, t.addtime as typeaddtime, t.tasktype, ww.wangwang, s.shopname, tm.price, tm.express, tm.commission, tm.new_keyword, tm.how_browse, tm.how_search from zxjy_usertask as ut 
                LEFT JOIN zxjy_task as t on ut.taskid = t.id
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                where ut.merchantid =  ' . $db ['info']->id . ' ORDER BY addtime DESC LIMIT ' . $page * 10 . ', 10';
	    $usertask_list = $this ->db -> query($sql) -> result();
	    $sql = 'SELECT t.top, FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, ut.handsel, ut.browseimg, ut.tasktwoimg, ut.id, ut.tasksn, ut.taskid, ut.ordersn, ut.status, ut.addtime, ut.userid, t.addtime as typeaddtime, t.tasktype, ww.wangwang, s.shopname, tm.price, tm.express, tm.commission, tm.new_keyword, tm.how_browse, tm.how_search from zxjy_pretask as ut 
                LEFT JOIN zxjy_task as t on ut.taskid = t.id
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                where ut.merchantid =  ' . $db ['info']->id . ' AND ut.status < 2  ORDER BY addtime DESC LIMIT ' . $page * 10 . ', 10';
        $pretask_list = $this ->db -> query($sql) -> result();
        $db['list'] = array_merge($usertask_list, $pretask_list);
        $this -> sort_array($db['list'], 'addtime');
        $db ['page'] = $page;
        $count_sql = 'SELECT COUNT(1) as count FROM zxjy_usertask WHERE merchantid = ' . $db ['info']->id . '
                      UNION
                      SELECT COUNT(1) as count FROM zxjy_pretask WHERE merchantid = ' . $db ['info']->id . ' AND status < 2';
        $count_arr = $this ->db -> query($count_sql) -> result();
        $db ['count'] = max($count_arr) -> count;  //已接任务总数，用于分页
        $db ['skey'] = 0;
        $db ['search'] = false;
        $this->load->view ( 'task', $db );
	}

	/*
	 * 导出商家'已接任务'数据
	 */
	public function outExcel()
    {
        $post = $_POST;
        $db = $this -> _include();
        $db ['taskCategroy'] = $types = @$_POST ['taskCategroy'] == 0 ? 'all' : @$_POST ['taskCategroy'];
        $db ['status'] = $status = @$_POST ['status'] == 0 ? 'all' : @$_POST ['status'];

        $db ['selSearch'] = $selSearch = @$_POST ['selSearch'];
        $db ['txtSearch'] = $txtSearch = @$_POST ['txtSearch'];
        $db ['BeginDate'] = $start = @$_POST ['BeginDate'] == '' ? 0 : @$_POST ['BeginDate'];
        $db ['EndDate'] = $end = @$_POST ['EndDate'] == '' ? 0 : @$_POST ['EndDate'];

        if (@strtotime ( $start ) > ($end == 0 ? time () : @strtotime ( $end ))) {
            echo "<script>alert('开始时间不能大于结束时间/当前时间');</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
            exit ();
        }
        // echo $selSearch.'<-->'.$txtSearch;
        $db ['list'] = $this->usertask->searchList ( $db ['info']->id, $status, $selSearch, $txtSearch, @strtotime ( $start ), @strtotime ( $end ), 0, 0 * 10, $types );
        if (count($db['list']) === 0)
        {
            echo "<script>alert('暂无数据可以导出');</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/searchtask.html\" >";
            exit ();
        }
        $db ['count'] = $this->usertask->searchCount ( $db ['info']->id, $status, $selSearch, $txtSearch, @strtotime ( $start ), @strtotime ( $end ), $types );
        // if ($db ['count'] != 0) {
        $arrtaskmodel = array ();
        $a = 0;
        $arrtask = array ();
        foreach ( $db ['list'] as $vv ) {
            $arrtask [$a] = $vv->taskid;
            $arrBind [$a] = $vv->userid;
            $arrShop [$a] = $vv->shopid;
            $arrtaskmodel [$a ++] = $vv->taskmodelid;
        }

        if (count ( $arrtask ) != 0 && count ( $arrBind ) != 0 && count ( $arrShop ) != 0 && count ( $arrtaskmodel ) != 0) {
            $db ['taskmodel'] = $this->task->getModelArr ( $arrtaskmodel ); // 获取型号的信息
            $db ['taskbind'] = $this->bindwangwang->getArr ( $arrBind ); // 旺旺号
            $db ['taskshop'] = $this->shop->getArr ( $arrShop ); // 店铺号
            $db ['page'] = 0;
            $db ['skey'] = 1;
            $db ['search'] = true;
            // $this->load->view ( 'task', $db );
        } else {

            $db ['taskmodel'] = ''; // 获取型号的信息
            $db ['taskbind'] = ''; // 旺旺号
            $db ['taskshop'] = ''; // 店铺号
            $db ['page'] = 0;
            $db ['skey'] = 1;
            $db ['search'] = false;
            // echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
        }

        $this->load->library('Classes/PHPExcel');
        $this->load->library('Classes/PHPExcel/IOFactory');
        $reader = new PHPExcel();

        // 修改导出以后每个单元格的宽度
        $reader->getActiveSheet ()->getColumnDimension ( 'A' )->setWidth ( 10 );
        $reader->getActiveSheet ()->getColumnDimension ( 'B' )->setWidth ( 15 );
        $reader->getActiveSheet ()->getColumnDimension ( 'C' )->setWidth ( 15 );
        $reader->getActiveSheet ()->getColumnDimension ( 'D' )->setWidth ( 25 );
        $reader->getActiveSheet ()->getColumnDimension ( 'E' )->setWidth ( 30 );
        $reader->getActiveSheet ()->getColumnDimension ( 'F' )->setWidth ( 30 );
        $reader->getActiveSheet ()->getColumnDimension ( 'G' )->setWidth ( 10 );
        $reader->getActiveSheet ()->getColumnDimension ( 'H' )->setWidth ( 10 );
        $reader->getActiveSheet ()->getColumnDimension ( 'I' )->setWidth ( 10 );
        $reader->getActiveSheet ()->getColumnDimension ( 'J' )->setWidth ( 15 );
        $reader->getActiveSheet ()->getColumnDimension ( 'K' )->setWidth ( 20 );
        $reader->getActiveSheet ()->getColumnDimension ( 'L' )->setWidth ( 20 );
        $reader->getActiveSheet ()->mergeCells ( 'A1:L1' );
        // $reader->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $reader->setActiveSheetIndex ( 0 )->setCellValue ( 'A1', '已接任务汇总表 ' . $start === 0 ? '' : '时间段：' . $start . '至'  . $end)
            ->setCellValue ( 'A2', '序号')
            ->setCellValue ( 'B2', '任务分类' )
            ->setCellValue ( 'C2', '任务编号' )
            ->setCellValue ( 'D2', '订单编号' )
            ->setCellValue ( 'E2', '买号' )
            ->setCellValue ( 'F2', '店铺名称' )
            ->setCellValue ( 'G2', '商品单价/(元)' )
            ->setCellValue ( 'H2', '快递费/(元)' )
            ->setCellValue ( 'I2', '佣金/(元)' )
            ->setCellValue ( 'J2', '任务状态' )
            ->setCellValue ( 'K2', '发布时间' )
            ->setCellValue ( 'L2', '接手时间' );

        $i = 0;
        $shop_name = '';
        foreach ( $db['list'] as $v ) {
            foreach ($db['taskbind'] as $value)
            {
                if ($value -> userid == $v -> userid)
                    $buyer_name = $value -> wangwang;
            }
            foreach ($db['taskshop'] as $val)
            {
                if ($val -> sid == $v -> shopid)
                    $shop_name = $val -> shopname;
            }
            foreach ($db['taskmodel'] as $tm)
            {
                if ($tm -> id == $v -> taskmodelid)
                {
                    $price = $tm -> price;
                    $express  = $tm -> express;
                    $commission = $tm -> commission;
                }
            }
            switch ($v -> status)
            {
                case 0:
                    $task_status = '正在进行';
                    break;
                case 1:
                    $task_status = '待发货';
                    break;
                case 2:
                    $task_status = '待收货';
                    break;
                case 3:
                    $task_status = '收货完成';
                    break;
                case 4:
                    $task_status = '可添加评价';
                    break;
                case 5:
                    $task_status = '待评价';
                    break;
                case 6:
                    $task_status = '确认评价';
                    break;
                case 7:
                    $task_status = '全部完成';
                    break;
            }
            $reader->getActiveSheet ( 0 )->setCellValue ( 'A' . ($i + 3), $i+1);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'B' . ($i + 3), " ".$v -> tasktype ==1 ? '销量任务' : '复购任务');
            $reader->getActiveSheet ( 0 )->setCellValue ( 'C' . ($i + 3), " ".$v -> tasksn);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'D' . ($i + 3), " ".$v -> ordersn);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'E' . ($i + 3), " ".$buyer_name);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'F' . ($i + 3), " ".$shop_name);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'G' . ($i + 3), " ".$price);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'H' . ($i + 3), " ".$express);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'I' . ($i + 3), " ".$commission);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'J' . ($i + 3), " ".$task_status);
            $reader->getActiveSheet ( 0 )->setCellValue ( 'K' . ($i + 3), " ".date('Y-m-d H:i', $v->typeaddtime));
            $reader->getActiveSheet ( 0 )->setCellValue ( 'L' . ($i + 3), " ".date('Y-m-d H:i', $v->addtime));
            $i ++;
        }

        $reader->getActiveSheet ()->setTitle ('已接任务汇总表');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $reader->setActiveSheetIndex ( 0 );

        // Redirect output to a client’s web browser (Excel5)
        ob_end_clean (); // 清除缓冲区,避免乱码
        $filename = "已接任务汇总表";
        header("Content-type: text/html; charset=utf-8");
        header ( 'Content-Type: application/vnd.ms-excel' );
        header ( 'Content-Disposition: attachment;filename="' . $filename . '.xlsx"' );
        header ( 'Cache-Control: max-age=0' );
        $objWriter = IOFactory::createWriter ( $reader, 'Excel2007' );
        $objWriter -> save('php://output');
    }

    /*
     * 已接任务搜索
     */
    public function searchtask()
    {
        $db = $this->_include ();
        $page = @$_GET ['page'] == '' ? 0 : @$_GET ['page'];
        $condition = '';
        extract($_GET);
        $condition .= isset($_GET['taskCategroy'])&& $_GET['taskCategroy']!=0? ' AND t.tasktype = ' . $taskCategroy : ' AND t.tasktype >0 ';
        $condition .= !empty($_GET['txtSearch']) ? ' AND ' . $selSearch . ' like "%' . $txtSearch . '%"' : '';
        $condition .= !empty($_GET['BeginDate']) ? ' AND t.addtime > ' . strtotime($BeginDate) : '';
        $condition .= !empty($_GET['EndDate']) ? ' AND t.addtime < ' . strtotime($EndDate) : '';
        $sql = 'SELECT t.top, FROM_UNIXTIME(tt.beginPay) as beginPay, FROM_UNIXTIME(tt.endPay) as endPay, ut.handsel, ut.browseimg, ut.tasktwoimg, ut.id, ut.tasksn, ut.ordersn, ut.status, ut.addtime, ut.userid, ut.taskid, t.addtime as typeaddtime, t.tasktype, ww.wangwang, s.shopname, tm.price, tm.express, tm.commission, tm.new_keyword, tm.how_browse, tm.how_search from zxjy_pretask as ut 
                LEFT JOIN zxjy_task as t on ut.taskid = t.id
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                where ut.merchantid =  ' . $db ['info']->id . $condition . ' AND ut.status <> 2 ORDER BY addtime DESC LIMIT ' . $page * 10 . ', 10';
        $pretask_list = $this ->db -> query($sql) -> result();
        $db ['types'] = $types = @$_GET ['taskCategroy'] == 0 ? 'all' : @$_GET ['taskCategroy'];
        $db ['status'] = $status = @$_GET ['status'] == '' ? 'all' : @$_GET ['status'];
        $db ['selSearch'] = $selSearch = @$_GET ['selSearch'];
        $db ['txtSearch'] = $txtSearch = @$_GET ['txtSearch'];
        $db ['start'] = $start = @$_GET ['BeginDate'] == '' ? 0 : @strtotime($_GET ['BeginDate']);
        $db ['end'] = $end = @$_GET ['EndDate'] == '' ? 0 : @strtotime($_GET ['EndDate']);
        $usertask_list = $this -> usertask -> searchList($db ['info']->id, $status, $selSearch, $txtSearch, $start,  $end , 10, $page * 10, $types);
        $db['list'] = array_merge($usertask_list, $pretask_list);
        $this -> sort_array($db['list'], 'addtime');
        $db ['page'] = $page;
        $count_sql = 'SELECT COUNT(1) as count FROM zxjy_usertask as ut 
                      LEFT JOIN zxjy_task as t on ut.taskid = t.id 
                      LEFT JOIN zxjy_shop as s on s.sid = t.shopid
                      LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                      LEFT JOIN zxjy_product as p on p.id = ut.proid
                      WHERE merchantid = ' . $db ['info']->id . $condition . '
                      UNION
                      SELECT COUNT(1) as count FROM zxjy_pretask as ut 
                      LEFT JOIN zxjy_task as t on ut.taskid = t.id 
                      LEFT JOIN zxjy_shop as s on s.sid = t.shopid
                      LEFT JOIN zxjy_blindwangwang as ww on ww.userid = ut.userid
                      LEFT JOIN zxjy_product as p on p.id = ut.proid
                      WHERE merchantid = ' . $db ['info']->id . ' AND ut.status < 2' . $condition;
        $count_arr = $this ->db -> query($count_sql) -> result();
        $db ['count'] = max($count_arr) -> count;  //已接任务总数，用于分页
        $db ['skey'] = 1;
        $db ['search'] = true;
        $this->load->view ( 'task', $db );
    }

	/*
	 * 查看买号信息
	 */
	public function buyerinfo()
    {
		$sql = 'SELECT u.RegTime, u.sex, ww.wangwang, bb.account_info from zxjy_user as u
                LEFT JOIN zxjy_bindbuyer as bb on bb.userid = u.id
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = u.id
                where u.id = ' . $_GET ['buyer'];
        $db['buyerinfo'] = $this -> db -> query($sql) -> first_row();
        $this -> load -> view('GetDetailInfo', $db);
//      $buyer = $_GET ['buyer'] == '' ? 0 : $_GET ['buyer'];
//		if ($buyer == 0) {
//			echo "<script>alert('读取刷手信息出错，稍后重试！');history.back();</script>";
//		} else {
//			$buyerinfo = $this->buyer->getInfo ( $buyer );
//			if ($buyerinfo != null) {
//				$db ['buyerinfo'] = $buyerinfo;
//				$db ['userinfo'] = $this->user->UseID ( $buyerinfo->userid );
//				$db ['wangwang'] = $this->bindwangwang->getInfo ( $buyerinfo->wangwangid );
//				$this->load->view ( 'GetDetailInfo', $db );
//			} else {
//				echo "<script>alert('买号信息获取失败！');history.back();</script>";
//			}
//		}
	}
	public function seepic() {
		$id = $_GET ['key'] == '' ? 0 : $_GET ['key'];
		if ($id == 0) {
			echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
		} else {
			$info = $this->usertask->getInfo ( $id );
			if ($info != null) {
				$up ['showpicbtn'] = 1;
				$this->usertask->updata ( $info->id, $up );
				$db ['info'] = $this->usertask->getInfo ( $info->id );
				$db ['proinfo'] = $this->task->getInfo ( $db ['info']->taskid );
				$this->load->view ( 'GetPictures', $db );
			} else {
				echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
			}
		}
	}

	/*
	 * 显示修改备注信息的页面
	 */
	public function remark()
    {
		$id = $_GET ['key'] == '' ? 0 : $_GET ['key'];
		if ($id == 0) {
			echo "<script>alert('请不要尝试错误链接');history.back();</script>";
		} else {
		    $sql = 'SELECT id, tasksn, remark FROM ' . ($_GET['type'] ? 'zxjy_pretask' : 'zxjy_usertask') . ' WHERE id = ' . $id;
            $info = $this -> db -> query($sql) -> row();
			//$info = $this->usertask->getInfo ( $id );
			if ($info != null) {
			    $info -> type = $_GET['type'];
				$db ['info'] = $info;
				$this->load->view ( 'EditTaskRemark', $db );
			} else {
				echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
			}
		}
	}

	/*
	 * 完成修改订单备注信息
	 */
	public function remarkDB()
    {
		$id = @$_POST ['id'];
		$TaskID = @$_POST ['tasksnid'];
		$db ['remark'] = $_POST ['TaskRemark'];
		$table = $_POST['type'] ? 'zxjy_pretask' : 'zxjy_usertask';
		$sql = 'SELECT count(1) FROM ' . $table . ' WHERE id = ' . $id;
		$reinfo = $this -> db -> query($sql) -> row();
		//$reinfo = $this->usertask->checked ( $id, $TaskID );
		if ($reinfo != null) {
		    $sql = 'UPDATE ' . $table . ' SET remark = "' . $_POST ['TaskRemark'] . '" WHERE id = ' . $id;
		    $re = $this -> db -> query($sql);
//			$re = $this->usertask->updata ( $id, $db );
			if ($re) {
			    show(1, '修改备注信息成功');
				//echo "<script>alert('提交成功！'); parent.location.reload();</script>";
			} else {
			    show(0, '更新备注信息失败,请稍后再试');
				//echo "<script>alert('系统现在繁忙中，请稍后重试！');parent.location.reload();</script>";
			}
		} else {
		    show(0, '错误链接信息');
			//echo "<script>alert('错误链接信息！');parent.location.reload();</script>";
		}
	}
	public function sendGoods() {
		$id = $_GET ['key'] == '' ? 0 : $_GET ['key'];
		if ($id == 0) {
			echo "<script>alert('请不要尝试错误链接');history.back();</script>";
		} else {
			$info = $this->usertask->getInfo ( $id );
			if ($info != null) {
				$db ['info'] = $info;
				$this->load->view ( 'FaHuo', $db );
			} else {
				echo "<script>alert('错误连接信息！');history.back();</script>";
			}
		}
	}
	public function sendGoodsDB() {
		$id = @$_POST ['id'] == '' ? 0 : $_POST ['id'];
		if ($id == 0) {
			echo "<script>alert('请不要尝试错误链接！');parent.location.reload();</script>";
		} else {
			$re = $this->usertask->getInfo ( $id );
			if ($re != null) {
				$company = $_POST ['ExpressCompany'];
				$express = $_POST ['ExpressNumber'];
				$db ['expressnum'] = $company . '&' . $express;
				$db ['status'] = 2;
				$re = $this->usertask->updata ( $id, $db );
				if ($re) {
					echo "<script>alert('提交成功！');parent.location.reload();</script>";
				} else {
					echo "<script>alert('系统繁忙中，请稍后重试！');parent.location.reload();</script>";
				}
			} else {
				echo "<script>alert('错误链接信息！');parent.location.reload();</script>";
			}
		}
	}

	/*
	 * 查看任务详情
	 */
	public function taskInfoDetail()
    {
        $common_args = 't.remark, t.intlet, t.tasktype, t.keyword, t.price, t.sendaddress, t.order, t.other, tm.price as price2, tm.auction, tm.modelname, tm.car_img, p.commodity_title, p.commodity_url, p.commodity_image, p.through_train_1, p.through_train_2, p.through_train_3, p.through_train_4, p.app_img';
        $tag = isset($_GET['tag']) ? $_GET['tag'] : 'ut';
        if ($tag == 'ut')
        {
            $sql = 'SELECT ut.tasksn, ut.ordersn, ut.status, ' . $common_args . ' from ' . ($_GET['type'] ? 'zxjy_pretask' : 'zxjy_usertask') . ' as ut
                    LEFT JOIN zxjy_tasktime as tt on tt.id = ut.tasktimeid
                    LEFT JOIN zxjy_taskmodel as tm on tm.id = ut.taskmodelid
                    LEFT JOIN zxjy_task as t on t.id = ut.taskid
                    LEFT JOIN zxjy_product as p on p.id = ut.proid
                    where ' . $tag . '.id = ' . $_GET ['key'] . ' AND ut.merchantid = ' . $this -> uid;
        }
        else
        {
            $sql = 'SELECT ' . $common_args . ' from zxjy_task as t
                    LEFT JOIN zxjy_tasktime as tt on t.mark = tt.pid
                    LEFT JOIN zxjy_taskmodel as tm on tm.pid = t.mark
                    LEFT JOIN zxjy_product as p on p.id = t.proid
                    where ' . $tag . '.id = ' . $_GET ['key'] . ' AND t.userid = ' . $this -> uid;
        }
        $db['info'] = $this -> db -> query($sql) -> first_row();
        $this->load->view ('GetTaskDatailInfo', $db);
	}

    /**
     * 商家确认付款
     */
	public function sendMoney()
    {
		$key = @$_GET ['key'] == '' ? 0 : @$_GET ['key'];
		if ($key == 0) {
			echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
		} else {
			$info = $this->usertask->getInfo ( $key );
			if ($info != null) {
				$dbusertask ['Status'] = 4;
				$this->usertask->updata ( $info->id, $dbusertask );
				
				$shuashou = $this->user->getInfo ( $info->userid );
				$db ['Money'] = $shuashou->Money + $info->commission;
				$db ['Score'] = $shuashou->Score + 10;
				// 修改刷手获取佣金
				
				$reuser = $this->user->updata ( $info->userid, $db );
				if ($reuser) {
					$this->load->model ( 'Cash_model', 'cashlog' );
					// 现金记录
					$dbcls ['type'] = '任务佣金';
					$dbcls ['remoney'] = $shuashou->Money + $info->commission;
					$dbcls ['increase'] = '+' . $info->commission;
					$dbcls ['beizhu'] = '完成任务获取';
					$dbcls ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
					$dbcls ['userid'] = $info->userid;
					$dbcls ['usertaskid'] = $info->id;
					$dbcls ['proid'] = $info->proid;
					$dbcls ['shopid'] = $info->shopid;
					$this->cashlog->add ( $dbcls );
					
					// 刷手积分
					$this->load->model ( 'Score_model', 'sc' );
					$sc ['userid'] = $shuashou->id;
					$sc ['original_score'] = $shuashou->Score;
					$sc ['score_info'] = '+10';
					$sc ['score_now'] = $db ['Score'];
					$sc ['description'] = '完成任务获得积分';
					$sc ['add_time'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
					$this->sc->add ( $sc );
					
					// 计算刷手获取推广金
					$this->load->model ( 'System_model', 'system' );
					// 没有佣金情况
					if ($shuashou->IdNumber != '') {
						$getcommissionuser = $this->user->getInfo ( $shuashou->IdNumber );
						// 不用返还佣金
						if ($getcommissionuser->iscommission == '1' && $getcommissionuser->ispromoter == '1') {
							// 获取佣金
							$shuashoutuiguang = $this->system->getInfo ( 83 ); // 推广需要添加的费用
							$gcum ['Money'] = $getcommissionuser->Money + $shuashoutuiguang->value;
							$this->user->updata ( $getcommissionuser->id, $gcum );
							
							$dbcl ['type'] = '任务佣金';
							$dbcl ['remoney'] = $getcommissionuser->Money + $shuashoutuiguang->value;
							$dbcl ['increase'] = '+' . $shuashoutuiguang->value;
							$dbcl ['beizhu'] = '推广人员完成任务返现';
							$dbcl ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
							$dbcl ['userid'] = $getcommissionuser->id;
							$dbcl ['usertaskid'] = $info->id;
							$dbcl ['proid'] = $info->proid;
							$dbcl ['shopid'] = $info->shopid;
							$this->cashlog->add ( $dbcl );
						}
					}
					
					// 商家推广获取推广金
					$thisshop = $this->user->getInfo ( $info->merchantid ); // 商家信息
					if ($thisshop->parentid != '') {
						$parentshop = $this->user->getInfo ( $thisshop->parentid ); // 商家上级信息
						if ($parentshop->iscommission == '1' && $parentshop->ispromoter == '1') {
							$shoptuiguangjin = $this->system->getInfo ( 82 ); // 推广需要添加的费用
							$pcum ['Money'] = $parentshop->Money + $shoptuiguangjin->value;
							$this->user->updata ( $parentshop->id, $pcum );
							
							$dbsl ['type'] = '任务佣金';
							$dbsl ['remoney'] = $pcum ['Money'];
							$dbsl ['increase'] = '+' . $shoptuiguangjin->value;
							$dbsl ['beizhu'] = '推广商家完成发布任务获得';
							$dbsl ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
							$dbsl ['userid'] = $parentshop->id;
							$dbsl ['usertaskid'] = $info->id;
							$dbsl ['proid'] = $info->proid;
							$dbsl ['shopid'] = $info->shopid;
							$this->cashlog->add ( $dbsl );
						}
					}
				} else {
					echo "<script>alert('系统现在正在繁忙中，请稍后再来确认吧！');history.back();</script>";
				}
			} else {
				echo "<script>alert('错误链接信息！');history.back();</script>";
			}
		}
	}
	public function AddEvaluate()
    {
		$key = @$_GET ['key'] == '' ? 0 : @$_GET ['key'];
		if ($key == 0) {
			echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
		} else {
			$usertask = $this->usertask->getInfo ( $key );
			if ($usertask != null) {
                $sql = 'select value from zxjy_system where id in (84, 85)';
                $res = $this -> db -> query($sql) -> result();
                $db = [
                    'word' => $res[0],
                    'pic' => $res[1],
                    'info' => $usertask,
                ];
				$this->load->view ( 'AddEvaluate', $db );
			} else {
				echo "<script>alert('获取数据失败了，请时刷新页面后重新尝试!');history.back();</script>";
			}
		}
	}

    /**
     * 将秒数转换成分秒
     * @param $seconds
     * @return string
     */
    public function time2second($seconds)
    {
        $seconds = (int)$seconds;
        if( $seconds < 86400 )
        {//如果不到一天
            $seconds = 6420;
            $format_time = gmstrftime('%H:%M:%S', $seconds);
        }
        else
        {
            $time = explode(' ', gmstrftime('%j %H %M %S', $seconds));//Array ( [0] => 04 [1] => 14 [2] => 14 [3] => 35 )
            $format_time = ($time[0]-1). '天' . $time[1] . '时' . $time[2] . '分' . $time[3] . '秒';
        }
        return $format_time;
    }

	
	/*
	 * 商家发布评价任务
	 */
	public function addEvaluateDB()
    {
        if (isset($_POST ['id']))
        {
            $usertaskid = $_POST ['id'];  //用户任务表id
            $usertaskinfo = $this -> usertask -> getInfo ($usertaskid);
            $limit = 60 * 60 * 80;  //80个小时之后方可发布
            $distance = time() - $usertaskinfo -> updatetime;
            $sql = 'SELECT seller_userid FROM zxjy_shop WHERE api_expiration_time > UNIX_TIMESTAMP() AND sid = ' . $usertaskinfo -> shopid;
            $shop_infos = $this -> db -> query($sql) -> first_row();
            if (!empty($shop_infos -> seller_userid))  //如果有订购小助手并且尚未过期，判断订单信息以及状态是否符合
            {
                $curl_args = 'tid=' . $usertaskinfo -> ordersn . '&fields=status,consign_time';
                $curl_exe = $this -> curlApi($shop_infos -> seller_userid, $curl_args);
                extract($curl_exe);
                if (!$curl_error)  //curl无误
                {
                    if (!$tmpInfo -> IsError)  //成功获取订单信息
                    {
                        if (in_array($tmpInfo -> Trade -> Status, ['WAIT_BUYER_CONFIRM_GOODS', 'TRADE_BUYER_SIGNED', 'TRADE_FINISHED']))  //订单状态为[卖家已发货]
                        {
                            $sql = 'SELECT count(1) as has FROM zxjy_schedual WHERE questionid = 33 AND usertaskid = ' . $usertaskinfo -> id;
                            if (!$this -> db -> query($sql) -> first_row() -> has)  //不存在工单为[买错商品]的工单
                            {
                                $distance_helper = time() - strtotime($tmpInfo -> Trade -> ConsignTime);
                                if ($tmpInfo -> Trade -> Status == 'WAIT_BUYER_CONFIRM_GOODS' && $distance_helper < $limit)  //订单状态为[卖家已发货]且发货时间小于80小时
                                {
                                    show(0, '当前订单状态为[商家已发货，等待买家确认]，发货时间为' . $tmpInfo -> Trade -> ConsignTime . '，需' . $this -> time2second($limit - $distance_helper) . '之后才可发布评价任务');
                                }
                            }
                            else
                                show(0, '该任务存在类型为[买错商品]的工单，无法发布任务');
                        }
                        else
                            show(0, '当前订单状态存在以下情况[尚未发货、存在退款行为]，暂无法发布任务');
                    }
                    else
                        show(0, $tmpInfo -> SubErrMsg);
                }
                else
                    show(0, $curl_error);
            }
            elseif ($distance < $limit)  //无小助手，判断任务时间
            {
                show(0, $this -> time2second($limit - $distance) . '之后方可发布评价任务');
            }
            //符合发布评价任务的条件
            $db ['usertaskid'] = $usertaskinfo->id;  //任务表id
            $db ['content'] = (@$_POST['con_type'] ? '要求：' : '') . $_POST ['content'];  //要求评价内容
            $db ['status'] = $_POST ['picstatus'];  //是否为图片评价0否1是
            $this -> load -> model ('System_model', 'system');
            if ($db['status'])  //图文评价
            {
                $db ['imgcontent'] = $this -> uploadFile($_FILES ['inputimage']);
            }
            $post_data = json_encode([
                'UserTaskID' => $db ['usertaskid'],
                "IsByImg" => ($db ['status'] == 1),
                "Content" => $db ['content'],
                "ImgContent" => isset($db ['imgcontent']) ? $db ['imgcontent'] : '',
            ]);
            $response = $this -> consoleCurlHandle('Publish_TaskEvaluateInfo', $post_data);
            $response -> IsOK == true  ? show(1, '评价任务提交成功', $usertaskid) : show(0, $response -> Description);
        }
        else
            show(0, '参数异常，请检查当前文件是否过大');
	}

	public function seeEvaluatePics() {
		$id = $_GET ['key'] == '' ? 0 : $_GET ['key'];
		if ($id == 0) {
			echo "<script>alert('请不要尝试错误链接谢谢！');history.back();</script>";
		} else {
			$info = $this->usertask->getInfo ( $id );
			if ($info != null) {
				$up ['showpicbtn'] = 1;
				$this->usertask->updata ( $info->id, $up );
				$db ['info'] = $this->usertask->getInfo ( $info->id );
				$db ['proinfo'] = $this->task->getInfo ( $db ['info']->taskid );
				$db ['evaluateinfo'] = $this->taskevaluate->getInfoT ( $info->id );
				// var_dump($info->id);
				$this->load->view ( 'GetEvaluatePictures', $db );
			} else {
				echo "<script>alert('您要查看的信息数据不存在了，请重新加载页面后尝试！');history.back();</script>";
			}
		}
	}
	
	/*
	 * 确认评价并支付
	 */
	public function saveEvaluateMoney()
    {
        $usertask = $this->usertask->getInfo ($_POST['key']);
        if ($usertask)
        {
            $eval = $this->taskevaluate->getInfoT ( $usertask->id );
            $taskEvaluateID = $eval -> id;  //评价任务id
            $fp = fopen (BKC_URL . "?ActionTag=User_TaskEvaluate_OK&TaskEvaluateID={$taskEvaluateID}", 'r' );
            $strJson = '';
            while (!feof($fp))
            {
                $line = fgets ( $fp, 1024 ); // 每读取一行
                $strJson = $strJson . $line;
            }
            fclose ( $fp );
            !empty($strJson) && json_decode($strJson) -> IsOK ? show(1, '已成功支付该笔订单佣金') : show(0, '请求失效或处理失败，支付佣金失败');
        }
        else
            show(0, '未获取到该笔订单信息，请稍后再试');
//		$id = 0 ;
//		if(isset($_GET['key'] ) ) $id = $_GET['key']    ;
//		if ($id > 0) {
//			$usertask = $this->usertask->getInfo ( $id );
//			if ($usertask != null) {
//
//				$eval = $this->taskevaluate->getInfoT ( $usertask->id );
//				$taskEvaluateID = $eval->id;
//				$fp = fopen ( BKC_URL."?ActionTag=User_TaskEvaluate_OK&TaskEvaluateID={$taskEvaluateID}", 'r' );
//				$strJson = '';
//				while ( ! feof ( $fp ) ) {
//					$line = fgets ( $fp, 1024 ); // 每读取一行
//					$strJson = $strJson . $line;
//				}
//				fclose ( $fp );
//				if (empty ( $strJson ) == false) {
//					$jsonObject = json_decode ( $strJson );
//					exit ( $strJson ) ;
//				}
//			}
//		}
//		$rs ['IsOK'] = false;
//		$rs ['Description'] = "操作失败";
//		exit( json_encode ( $rs ) ) ;
	}
	public function countSenvenDay() {
		$db = $this->_include ();
		$start = @strtotime ( @date ( 'Y-m-d' ) ) - 1;
		$end = @strtotime ( "+7 day" ) + 1;
		$id = $this->session->userdata ( 'sellerid' );
        $sql = 'SELECT tt.date, IF(tt.close < UNIX_TIMESTAMP() AND t.del = 0, t.qrnumber, t.number) as number, IF(t.del = 0, 0, t.number - t.qrnumber) as del FROM zxjy_task as t 
                LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                WHERE t.userid = ' . $id . ' AND date > ' . $start;
        $db['list'] = $this -> db -> query($sql) -> result();
		// var_dump($db['list']);
		$this->load->view ( 'GetDayTaskCount', $db );
	}

	/*
	 * 商家发布任务第一个【下一步】
	 */
	public function taskStepOne() {
        if (isset($_POST['SearchType']))
        {
            $_POST ['proid'] = $_POST ['proid'] == '' ? 0 : $_POST ['proid'];
            RedisCache::set('taskStepOne_value', $_POST);
        }
        $post = RedisCache::get('taskStepOne_value');
		$proid = $post['proid'];
		$SearchType = @$post ['SearchType']; // 入口
		$SearchKey = @$post ['SearchKey']; // 关键字
		$KeyWordCount = @$post ['KeyWordCount']; // 数量
		$IDdelOrder = @$post ['order']; // 排序方式
		$IDdelPrice = @$post ['price']; // 价格区间
		$IDdelAddress = @$post ['address']; // 发货地
		$IDdelOther = @$post ['other']; // 其他条件

		/*
		 * $arrSearchType=implode('&',$SearchType);
		 * $arrSearchKey=implode('&',$SearchKey);uuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu
		 * $arrIDdelOrder=implode('&',$IDdelOrder);
		 * $arrIDdelPrice=implode('&',$IDdelPrice);
		 * $arrIDdelAddress=implode('&',$IDdelAddress);
		 * $arrIDdelOther=implode('&',$IDdelOther);
		 */
		setcookie ( 'proid', $proid );
		setcookie ( 'SearchType', implode ( '&', $post['SearchType'] ) );
		setcookie ( 'car_img', implode ( '&', $post['car_img'] ) );
		setcookie ( 'SearchKey', implode ( '&', $post['SearchKey'] ) );
		setcookie ( 'KeyWordCount', implode ( '&', $post['KeyWordCount'] ) );
		setcookie ( 'IDorder', implode ( '&', $post['order'] ) );
		setcookie ( 'IDprice', implode ( '&', $post['price'] ) );
		setcookie ( 'IDaddress', implode ( '&', $post['address'] ) );
		setcookie ( 'IDother', implode ( '&', $post['other'] ) );

		if (!isset($_POST['proid'])) {
			echo "<script>alert('页面数据加载错误！');</script>";
			$this->index ();
		} else {
			$db = $this->_include ();
            $pro_info = $this -> redis -> get('proinfo');
            $db ['proinfo'] = $pro_info ? $pro_info : $this->product->getInfo ($proid);
			$db ['searchtype'] = $SearchType;
			$db ['KeyWordCount'] = $KeyWordCount;
			$db ['SearchKey'] = $SearchKey;
			//$db ['shops'] = $this->shop->getlist ( $db ['info']->id, 1, 0, 0, 0 );
			$start = @strtotime ( @date ( 'Y-m-d' ) ) - 1;
			$end = @strtotime ( "+7 day" ) + 1;
			$db ['list'] = $this->task->SevenDay ( $start, $end, $db ['info']->id );
			$tasktype = $this->session->userdata('typepage');
			$value = $this->system->getInfo (in_array($tasktype, [4, 5]) ? 98 : 90 );
			$db ['arr'] = $value->value;
			$this->load->view ( 'VipTaskTwo', $db );
		}
	}
	/*
	 * public function retaskStepOne(){
	 * $proid = @$_POST['proid']==''?0:@$_POST['proid'];
	 * $SearchType = @$_POST['SearchType'];// 入口
	 * $SearchKey = @$_POST['SearchKey'];// 关键字
	 * $KeyWordCount = @$_POST['KeyWordCount'];// 数量
	 * $IDdelOrder = @$_POST['order'];// 排序方式
	 * $IDdelPrice = @$_POST['price'];// 价格区间
	 * $IDdelAddress = @$_POST['address'];// 发货地
	 * $IDdelOther = @$_POST['other'];// 其他条件
	 *
	 * setcookie('proid',$proid);
	 * setcookie('SearchType',implode('&',$SearchType));
	 * setcookie('SearchKey',implode('&',$SearchKey));
	 * setcookie('KeyWordCount',implode('&',$KeyWordCount));
	 * setcookie('IDorder',implode('&',$IDdelOrder));
	 * setcookie('IDprice',implode('&',$IDdelPrice));
	 * setcookie('IDaddress',implode('&',$IDdelAddress));
	 * setcookie('IDother',implode('&',$IDdelOther));
	 *
	 * if($proid==0){
	 * echo "<script>alert('页面数据加载错误！');</script>";
	 * $this->index();
	 * }else {
	 * $db=$this->_include();
	 * $db['proinfo']=$this->product->getInfo($proid);
	 * $db['searchtype']=$SearchType;
	 * $db['KeyWordCount']=$KeyWordCount;
	 * $db['shops'] = $this->shop->getlist($db['info']->id,1,0,0,0);
	 * $start=strtotime(@date('Y-m-d'))-1;
	 * $end=strtotime("+7 day")+1;
	 * $db['list']=$this->task->SevenDay($start,$end,$db['info']->id);
	 *
	 * $value = $this->system->getInfo(90);
	 * $db['arr'] =$value->value;
	 * /* $arr = explode('|', $value->value);
	 * $money =array();$point=array();
	 * foreach($arr as $key=>$va){
	 * $money[$key] = $vamoney = substr($va, 0,strpos($va,'='));
	 * $point[$key] = $vapoint = substr($va, strpos($va,'=')+1);
	 * }
	 * sort($money);
	 * $this->load->view('reVipTaskTwo', $db);
	 * }
	 * }
	 */

	/*
	 * 发布任务第二个【下一步】提交的地方
	 */
	public function taskStepTwo() {
		$db = $this->_include ();
        $sql = 'SELECT value FROM zxjy_system WHERE varname = "cash_deposit"';
        $db['cash_deposit'] = $this -> cacheSqlQuery('cash_deposit', $sql, 0, true, 'row') -> value;
		$proid = @$_POST ['proid'];  //任务对应的商品id
		$db ['proinfo'] = $this->product->getInfo ( $proid );  //任务对应的商品信息
        if (!empty ($_COOKIE ['SearchType']) && !empty($_COOKIE ['KeyWordCount']))
        {
            $db ['searchtype'] = explode ( '&', $_COOKIE['SearchType']);
            $db ['KeyWordCount'] = explode ( '&', $_COOKIE['KeyWordCount']);
        }
        else
        {
            echo "<script>alert('数据出错了，请重新发布任务！');</script>";
            $this->index ();
        }
		// 基本判断条件
		$IsSingleModel = @$_POST ['IsSingleModel'] == '' ? 0 : @$_POST ['IsSingleModel']; // 发布任务是否为不同型号,1单2多
		$SingleProductPrice = @$_POST ['SingleProductPrice'] == '' ? 0 : @$_POST ['SingleProductPrice'];   // 获取单个产品价格数组
		$ExpressCharge = @$_POST ['ExpressCharge'] == '' ? 0 : @$_POST ['ExpressCharge'];   // 获取单个快递费价格数组
		// 获取单个产品型号数组
		// echo "<script>alert(".$IsSingleModel.");</script>";;
		if ($IsSingleModel == 2)  // 如果为多型号产品，读取商家设置的型号
		{
			$ProductModel = @$_POST ['ProductModel'] == '' ? 0 : @$_POST ['ProductModel'];
			setcookie ( 'ProductModel', implode ( '&', $ProductModel ) );
		}
		$BuyProductCount = @$_POST ['BuyProductCount'] == '' ? 0 : @$_POST ['BuyProductCount'];   // 获取单个产品任务购买产品数量数组，即拍下件数
		$ProductPriceListCount = @$_POST ['ProductPriceListCount'] == '' ? 0 : @$_POST ['ProductPriceListCount'];       // 获取单个产品任务数量数组，即任务数量
		// 获取单模型任务的价格！
		$ProCommission = @$_POST ['inputcomm'] == '' ? 0 : @$_POST ['inputcomm'];  //单任务佣金
		
		/*
		 * 添加了多条任务信息的cookie操作
		 */
		if ($IsSingleModel != 0) //定价类型
		{
			setcookie ( 'IsSingleModel', $IsSingleModel );
		}
		if ($SingleProductPrice != 0)  //商品单价
		{
			setcookie ( 'SingleProductPrice', implode ( '&', $SingleProductPrice ) );
		}
		if ($ExpressCharge != 0)   //快递费
		{
			setcookie ( 'ExpressCharge', implode ( '&', $ExpressCharge ) );
		}
		if ($BuyProductCount != 0) //拍下件数
		{
			setcookie ( 'BuyProductCount', implode ( '&', $BuyProductCount ) );
		}
		if ($ProductPriceListCount != 0) {
			setcookie ( 'ProductPriceListCount', implode ( '&', $ProductPriceListCount ) );
		}
		$thistaskcomm = 0;  //该任务总佣金
		if ($ProCommission != 0) {
			setcookie ( 'ProCommission', implode ( '&', $ProCommission ) );
			// 当前任务所需佣金
			foreach ( $ProCommission as $key => $procom ) {
				$thistaskcomm += $procom * $ProductPriceListCount [$key];
			}
		} else {
			$ProductPriceListCount = explode ( '&', $_COOKIE ['ProductPriceListCount'] );
			$ProCommission = explode ( '&', $_COOKIE ['ProCommission'] );
			foreach ( $ProCommission as $key => $procom ) {
				$thistaskcomm += $procom * $ProductPriceListCount [$key];
			}
		}
		
		$TaskPlanType = @$_POST ['TaskPlanType'] == '' ? - 1 : @$_POST ['TaskPlanType']; // 发布任务时间类型，1立即2今日平均3多日平均
		$StrDate = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
		$TaskDate = @$_POST ['Date'] == '' ? 0 : @$_POST ['Date']; // 日期
		$TaskPlanBeginTimeH = @$_POST ['TaskPlanBeginTimeH']; // 开始时间小时
		$TaskPlanBeginTimeM = @$_POST ['TaskPlanBeginTimeM']; // 开始时间分钟
		$TaskPlanEndTimeH = @$_POST ['TaskPlanEndTimeH']; // 结束时间小时
		$TaskPlanEndTimeTimeM = @$_POST ['TaskPlanEndTimeTimeM']; // 结束时间分钟
		$TimeoutTimeH = @$_POST ['TimeoutTimeH']; // 关闭时间小时，超时取消小时数
		$TimeoutTimeM = @$_POST ['TimeoutTimeM']; // 关闭时间分钟，超时取消分钟数

		// echo $db['info']->Money.'<br>';//当前账户金额
		$countmoney = 0; // 获取到已发任务的佣金金额
		                 // 获取到时间表
//		$timelist = $this->task->getThisTime ( $db ['info']->id );
//		// 获取到模型表
//		$modellist = $this->task->getModel ( $db ['info']->id );
//		// 获取任务总表信息
//		$tasklist = $this->task->getUserid ( $db ['info']->id );
//		// var_dump($oldtasklist);
//		$thistime = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
//
//		//更新taskmodel和tasktime表的del字段
//		foreach ( $timelist as $vo ) {
//			if ($vo->close < $thistime)  //已过期任务
//			{
//				if ($vo->number > ($vo->takenumber + $vo->del))  //还有任务未被接
//				{
//					$needdeltask = $needdelmodel = $dbt ['del'] = $vo->number - $vo->takenumber;  //超时任务的个数
//					$this->task->updatatime ( $vo->id, $dbt );  //更新超时任务个数
//					/* 修改模型表数据 */
//					foreach ( $modellist as $vml ) {
//						if ($vml->pid == $vo->pid)  //任务模型表里面对应的过期任务
//						{
//							if ($vml->number > ($vml->takenumber + $vml->del))  //还有未更新的del
//							{
//								// 需要删除数量 $needdelmodel
//								if ($needdelmodel > 0) {
//									$delmodel = $vml->number - ($vml->takenumber + $vml->del);  //模型表内剩余任务数量
//									if ($needdelmodel > $delmodel) {
//										$needdelmodel = $needdelmodel - $delmodel;
//										$dbm ['del'] = $delmodel + $vml->del;
//									} else {
//										$dbm ['del'] = $needdelmodel + $vml->del;
//										$needdelmodel = 0;
//									}
//									$this->task->updatamodel ( $vml->id, $dbm );
//								}
//							}
//						}
//						// echo $dbt['del'].'<br>';
//					}
//					/* 模型表修改完成 */
//					/* 修改任务总表信息 */
//					foreach ( $tasklist as $vtl ) {
//						if ($vo->pid == $vtl->mark) {
//							if ($deltask = $vtl->number - $vtl->qrnumber - $vtl->del)
//							{
//								if ($needdeltask > $deltask) {
//									$needdeltask = $needdeltask - $deltask;
//									$dba ['del'] = $deltask + $vtl->del;
//								} else {
//									$dba ['del'] = $needdeltask + $vtl->del;
//								}
//								$this->task->updata ( $vtl->id, $dba );
//							}
//						}
//					}
//					/* 任务总表修改完成 */
//				}
//			}
//		}
//        // 获取完成所有已发布任务所需金额
//        $countmoney = 0;
//        $counttop = 0;
//        foreach ( $tasklist as $vml ) {
//            if ($hastask = $vml->number - $vml->qrnumber - $vml->del)
//            {
//                $countmoney += $hastask * $vml->commission;
//                $counttop += $hastask * $vml->top;
//            }
//        }
//		// 单件置顶费用信息
////		$counttop = 0;
////		foreach ( $tasklist as $vtl ) {
////			if ($hastask = $vml->number - $vml->qrnumber - $vml->del)
////			{
////				$counttop += $hastask * $vtl->top;
////			}
////		}
//		$countmoney = $countmoney + $counttop;
//		if ($db ['info']->Money < ($countmoney + $thistaskcomm + $db ['info']->bond)) {
//			// if($db['info']->Money < $db['info']->bond + $thistaskcomm ){
//			echo "<script>alert('账户内余额不足以支付所有已发布的任务了！请充值、减少需要发布的任务数量或取消已发布的任务后再发布任务！');</script>";
//			$this->index ();
//		} else {
			if ($TaskPlanType == - 1)  //未设置发布类型，如立即发布等，这是在
			{
				if (! empty ( $_COOKIE ['proid'] )) {
					$db ['proinfo'] = $this->product->getInfo ( $_COOKIE ['proid'] );
				} else {
					echo "<script>alert('数据出错了，请重新发布任务！');</script>";
					$this->index ();
				}
				$db ['TaskPlanCount'] = explode ( '&', $_COOKIE ['TaskPlanCount'] );
				if ($TaskDate != 0) {
					$db ['StrTaskPlan'] = implode ( '&', $TaskDate );
				} else {
					$db ['StrTaskPlan'] = $_COOKIE ['TaskPlanCount'];
				}
				if (empty ( $_COOKIE ['SearchType'] )) {
					$db ['SearchType'] = $_COOKIE ['SearchType'];
					$db ['searchtype'] = explode ( '&', $db ['SearchType'] );
				} else {
				}
				
				$db ['SearchType'] = $_COOKIE ['SearchType'];
				$db ['searchtype'] = explode ( '&', $db ['SearchType'] );
				$db ['KeyWordCount'] = $_COOKIE ['KeyWordCount'];
				// var_dump($_COOKIE['starttime']);
				
				if ($SingleProductPrice != 0) {
					$db ['SingleProductPrice'] = $SingleProductPrice;
				} else {
					$db ['SingleProductPrice'] = explode ( '&', $_COOKIE ['SingleProductPrice'] );
				}
				if ($ExpressCharge != 0) {
					$db ['ExpressCharge'] = $ExpressCharge;
				} else {
					$db ['ExpressCharge'] = explode ( '&', $_COOKIE ['ExpressCharge'] );
				}
				if ($BuyProductCount != 0) {
					$db ['BuyProductCount'] = $BuyProductCount;
				} else {
					$db ['BuyProductCount'] = explode ( '&', $_COOKIE ['BuyProductCount'] );
				}
				if ($ProductPriceListCount != 0) {
					$db ['ProductPriceListCount'] = $ProductPriceListCount;
				} else {
					$db ['ProductPriceListCount'] = explode ( '&', $_COOKIE ['ProductPriceListCount'] );
				}
				if ($TaskDate != 0) {
					$db ['TaskDate'] = $TaskDate;
				} else {
					$db ['TaskDate'] = explode ( '&', $_COOKIE ['TaskDate'] );
				}
				if ($TaskDate != 0) {
					$db ['ProCommission'] = $ProCommission;
				} else {
					$db ['ProCommission'] = explode ( '&', $_COOKIE ['ProCommission'] );
				}
				
				$db ['ProductPriceListCount'] = $ProductPriceListCount;
				
				$db ['reload'] = 1;
				$this->load->view ( 'VipTaskThree', $db );
			} else { // 直接下一步到这里执行代码段
				if ($TaskPlanType == 2) //多天平均发布
				{
					$TaskPlanCount = @$_POST ['TaskPlanCount'] == '' ? 0 : @$_POST ['TaskPlanCount'];
					; // 任务数量
					  // var_dump($TaskPlanCount);
					$starttime = array ();
					$endtime = array ();
					$closetime = array ();
					//$taskcount = count(explode('&', get_cookie('SearchKey')));
					$taskcount = count($TaskPlanCount);
					for($n = 0; $n < $taskcount; $n ++) {
						$starttime [$n] = $TaskDate [$n] . ' ' . ($TaskPlanBeginTimeH [$n] == '' ? '00' : $TaskPlanBeginTimeH [$n]) . ':' . ($TaskPlanBeginTimeM [$n] == '' ? '00' : $TaskPlanBeginTimeM [$n]) . ':00';
						$endtime [$n] = $TaskDate [$n] . ' ' . ($TaskPlanEndTimeH [$n] == '' ? '00' : $TaskPlanEndTimeH [$n]) . ':' . ($TaskPlanEndTimeTimeM [$n] == '' ? '00' : $TaskPlanEndTimeTimeM [$n]) . ':00';
						$closetime [$n] = $TaskDate [$n] . ' ' . ($TimeoutTimeH [$n] == '' ? '23' : $TimeoutTimeH [$n]) . ':' . ($TimeoutTimeM [$n] == '' ? '59:59' : $TimeoutTimeM [$n]);
					}
					$Starttime = implode ( '&', $starttime );
					$Endtime = implode ( '&', $endtime );
					$Closetime = implode ( '&', $closetime );
					$StrTaskPlan = implode ( '&', $closetime );
					$TaskPlanCount = implode ( '&', $TaskPlanCount );
				} else {
					$TaskPlanCount = 0;
					foreach ( $ProductPriceListCount as $v ) {
						$TaskPlanCount += $v;
					}
					$StrTaskPlan = $TaskPlanCount;
					if ($TaskPlanType == 0) //立即发布
					{
						$Starttime = @date ( 'Y-m-d H:i:s', $StrDate );
						$Endtime = @date ( 'Y-m-d' ) . ' 23:59:59';
						$Closetime = $TaskDate [0] . ' ' . ($TimeoutTimeH [0] == '' ? '23' : $TimeoutTimeH [0]) . ':' . ($TimeoutTimeM [0] == '' ? '59:59' : $TimeoutTimeM [0]);
					}
					else  //今日平均
                    {
						$Starttime = $TaskDate [0] . ' ' . $TaskPlanBeginTimeH [0] . ':' . $TaskPlanBeginTimeM [0] . ':00';
						$Endtime = $TaskDate [0] . ' ' . $TaskPlanEndTimeH [0] . ':' . $TaskPlanEndTimeTimeM [0] . ':00';
						$Closetime = $TaskDate [0] . ' ' . ($TimeoutTimeH [0] == '' ? '23' : $TimeoutTimeH [0]) . ':' . ($TimeoutTimeM [0] == '' ? '59:59' : $TimeoutTimeM [0]);
					}
				}
				//预订单参数设置
                setcookie ( 'how_browse', @$_POST['how_browse'] );
                setcookie ( 'how_search', @$_POST['how_search']);
                setcookie ( 'new_keyword', @$_POST['new_keyword']);

                setcookie ( 'handsel', @$_POST['handsel']);
                setcookie ( 'Payment', @$_POST['Payment']);
                setcookie ( 'beginPay', @$_POST['BeginDate2']);
                setcookie ( 'EndPay', @$_POST['EndDate2']);

				setcookie ( 'TaskPlanType', $TaskPlanType );
				setcookie ( 'TaskDate', implode ( '&', $TaskDate ) );
				setcookie ( 'TaskPlanCount', $TaskPlanCount );
				setcookie ( 'starttime', $Starttime );
				setcookie ( 'endtime', $Endtime );
				setcookie ( 'closetime', $Closetime );


				
				$db ['shops'] = $this->shop->getlist ( $db ['info']->id, 1, 0, 0, 0 ); // 店铺名称
				if (! empty ( $_COOKIE ['proid'] )) {
					$db ['proinfo'] = $this->product->getInfo ( $_COOKIE ['proid'] );
				} else {
					echo "<script>alert('数据出错了，请重新发布任务！');</script>";
					$this->index ();
				}
				$db ['TaskPlanCount'] = explode ( '&', $TaskPlanCount );
				$db ['StrTaskPlan'] = implode ( '&', $TaskDate );
				$db ['SearchType'] = $_COOKIE ['SearchType'];
				$db ['searchtype'] = explode ( '&', $db ['SearchType'] );
				$db ['KeyWordCount'] = $_COOKIE ['KeyWordCount'];
				// var_dump($_COOKIE['starttime']);
				
				$db ['SingleProductPrice'] = $SingleProductPrice;
				$db ['ExpressCharge'] = $ExpressCharge;
				$db ['BuyProductCount'] = $BuyProductCount;
				$db ['ProductPriceListCount'] = $ProductPriceListCount;
				$db ['ProCommission'] = $ProCommission;
				$db ['TaskDate'] = $TaskDate;
				
				$db ['reload'] = 0;
				
				$this->load->view ( 'VipTaskThree', $db );
			}
//		}
	}

    /**
     * 验证支付密码以及当前资产是否富余
     */
    public function checkPayPasswd()
    {
        if (isset($_POST ['TradersPassword']))
        {
            $db = $this -> getServerInfo();
            $sql = 'SELECT COUNT(1) as has, api_expiration_time FROM zxjy_shop WHERE (seller_userid IS NULL OR seller_userid = "" OR api_expiration_time <= UNIX_TIMESTAMP()) AND sid = ' . $_POST['ShopID'];
            $shop_is_Fail = $this -> db -> query($sql) -> first_row() -> has;
            if ($shop_is_Fail == 0 || $db['use_helper'] -> value != 1)
            {
                $number = isset($_POST['number']) ? $_POST['number'] : array_sum(explode ( '&', $_COOKIE ['KeyWordCount'] ));  //每个关键词对应的数量
                $sql = 'SELECT SUM(if(tt.close < UNIX_TIMESTAMP() OR t.del > 0, t.qrnumber, t.number)) as has FROM zxjy_task as t 
                        LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                        WHERE t.userid = ' . $this -> uid . ' AND TO_DAYS(FROM_UNIXTIME(tt.start)) = TO_DAYS(NOW())';
                /**
                $sql = 'SELECT SUM(if(t.number > 0, t.number, 0)) as has FROM zxjy_task as t
                    LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                    WHERE t.userid = ' . $this -> uid . ' AND TO_DAYS(FROM_UNIXTIME(tt.start)) = TO_DAYS(NOW()) AND t.del = 0 AND tt.close >= UNIX_TIMESTAMP()';
                */
                $has_release = $this -> db -> query($sql) -> first_row() -> has;
                $TaskPlanType = isset($_POST['gettime']) ? $_POST['gettime'] : $_COOKIE ['TaskPlanType'];
                if (($db['info'] -> maxtask - $has_release) >= $number || $TaskPlanType == 2)  //多天平均任务不做判断
                {
                    $sql = 'SELECT value FROM zxjy_system WHERE varname = "return_cash_way"';
                    $return_cash_way = $this -> cacheSqlQuery('return_cash_way', $sql, 0, true, 'first_row') -> value;
                    $sum_field = $return_cash_way ? 'top * number + commission + tm.price * auction + express' : 'commission';
                    $sql = 'SELECT SUM(' . $sum_field . ') as no_pay FROM zxjy_task as t
                        LEFT JOIN zxjy_tasktime as tt on tt.pid = t.mark
                        LEFT JOIN zxjy_taskmodel as tm on tm.pid = t.mark
                        WHERE close > UNIX_TIMESTAMP(NOW()) AND t.del = 0 AND t.number > t.qrnumber AND t.userid = ' . $this -> uid;
                    $has_no_pay = $this -> db -> query($sql) -> first_row() -> no_pay + $_POST['action_commission'] + $_POST['top_count'];
                    $sql = 'SELECT value FROM zxjy_system WHERE varname = "cash_deposit"';
                    $cash_deposit = $this -> cacheSqlQuery('cash_deposit', $sql, 0, true, 'first_row') -> value;
                    if ($db['info'] -> Money - $cash_deposit - $has_no_pay >= 0)
                    {
                        if (md5($_POST ['TradersPassword']) == $db ['info'] -> SafePwd)  //支付密码正确
                        {
                            if (!RedisCache::has('IsMoney_' . $this -> uid))
                            {
                                !isset($_POST['is_republish']) ? $this -> taskStepDB() : $this -> republishDB();
                            }
                            else
                                show(2, '注：当前余额不足以支付佣金，继续发布任务不会被接手，请先充值');
                        }
                        else
                            show(0, '密码错误');
                    }
                    else
                        show(3, '当前余额(' . $db['info'] -> Money . ')不足以支付剩余有效任务和待发布任务的佣金费用(' . $has_no_pay . ')，请先充值再发布');
                }
                else
                    show(0, '超出今日单量限制, 请检查任务情况, 当前剩余单量' . ($db['info'] -> maxtask - $has_release));
            }
            else
                show(0, '所选店铺尚未绑定小助手或已过期，无法发布任务');
        }
        else
            show(0, '参数异常, 请刷新页面再试');
    }

	public function test2()
    {
        echo (date('Y-m-d', strtotime('2018-08-29 09:00')) . ' 09:00');
    }


    // 商家提交任务数据
    public function taskStepDB()
    {
		$tasktype = $_COOKIE ['typepage'];  //任务类型（1销量/2复购）
		if ($tasktype == 0) {
			$tasktype = $this->session->userdata('typepage');
		}
        if (isset($_POST ['remark']) && $tasktype)
        {
            $cache_name = 'release_time_' . $this -> uid;
            $limit_time = 30;
            if (!RedisCache::has($cache_name))
            {
                RedisCache::set($cache_name, time(), $limit_time - 1);
                $db = $this->getServerInfo();
                $id = $userid = $db ['info']->id;

                // var_dump($dbtask['tasktype']);
                $proid = $_COOKIE ['proid'];
                $number = explode('&', $_COOKIE ['KeyWordCount']);  //每个关键词对应的数量
                $proinfo = $this->product->getInfo($_COOKIE ['proid']);
                $shopid = !empty($proinfo) ? $proinfo->shopid : show(0, '参数异常, 请重新开始发布任务'); // 需要根据proid来获取
                $intlet = explode('&', $_COOKIE ['SearchType']);  //流量入口
                $keyword = empty ($_COOKIE ['SearchKey']) ? '' : explode('&', $_COOKIE ['SearchKey']);  //搜索关键词
                $car_img = empty ($_COOKIE ['car_img']) ? '' : explode('&', $_COOKIE ['car_img']);  //搜索关键词
                $order = explode('&', $_COOKIE ['IDorder']);  //其它搜索条件：排序方式
                $price = explode('&', $_COOKIE ['IDprice']);  //其它搜索条件：价格区间
                $sendaddress = explode('&', $_COOKIE ['IDaddress']);   //其它搜索条件：发货地
                $other = explode('&', $_COOKIE ['IDother']);    //其它搜索条件：其它

                $top = @$_POST ['AddToPoint'] <= 50 ? @$_POST ['AddToPoint'] : show(0, '平台限制置顶费用的最高金额为50元');  //置顶费用
                $remark = $_POST ['remark'];   //任务说明
                $addtime = time();
                $status = $db ['info']->ShowStatus; // 任务是否影藏需要根据用户状态获取 0正常（显示） 1 冻结（隐藏）

                $model = $_COOKIE ['IsSingleModel'];  //单型号/多型号
                $gettime = $_COOKIE ['TaskPlanType'];  //发布时间

                /* 这里存储为总任务表信息 */
                $dbtask = array();
                $m = 0;
                //模型表数据
                $price2 = explode('&', $_COOKIE ['SingleProductPrice']);  //商品单价
                $auction = explode('&', $_COOKIE ['BuyProductCount']);  //拍下件数
                $express = explode('&', $_COOKIE ['ExpressCharge']);  //快递费
                $number2 = explode('&', $_COOKIE ['ProductPriceListCount']);  //任务数量
                $commission = explode('&', $_COOKIE ['ProCommission']);  //单任务佣金
                $dbtaskmodel = array();
                $n = 0;
                /* 时间分表 */
                $starttime = explode('&', $_COOKIE ['starttime']);  //开始时间
                $endtime = explode('&', $_COOKIE ['endtime']);  //结束时间
                $closetime = explode('&', $_COOKIE ['closetime']);  //超时取消
                $date = explode('&', $_COOKIE ['TaskDate']);  //任务日期
                $number3 = explode('&', $_COOKIE ['TaskPlanCount']);  //任务数
                $dbtasktime = array();
                $t = 0;
                $is_success = true;
                if ($model == 2)  //如果为多类型任务
                {
                    $modelname = explode('&', @$_COOKIE ['ProductModel']);  //【指定型号】
                }
                // echo $mark;
                //以流量入口的数目作为插入的条数
                $last = 0;
                if ($commission[0])
                {
                    foreach ($intlet as $vi)
                    {
                        $mark = time() . $this->generate_password();
                        $dbtask [$m] ['userid'] = $userid;
                        $dbtask [$m] ['tasktype'] = $tasktype;
                        $dbtask [$m] ['proid'] = $proid;
                        $dbtask [$m] ['shopid'] = $shopid;
                        $dbtask [$m] ['intlet'] = $vi;
                        $dbtask [$m] ['keyword'] = !empty($keyword) ? $keyword [$m] : '';
                        $dbtask [$m] ['number'] = $number [$m];
                        $dbtask [$m] ['order'] = $order [$m];
                        $dbtask [$m] ['price'] = $price [$m];
                        $dbtask [$m] ['sendaddress'] = $sendaddress [$m];
                        $dbtask [$m] ['other'] = $other [$m];
                        $dbtask [$m] ['top'] = $top;
                        $dbtask [$m] ['remark'] = $remark;
                        $dbtask [$m] ['addtime'] = $addtime;
                        $dbtask [$m] ['status'] = $status;
                        $dbtask [$m] ['model'] = $model;
                        $dbtask [$m] ['gettime'] = $gettime;
                        $dbtask [$m] ['mark'] = $mark;

                        //以商品单价作为插入点
                        $dbtaskmodel [$n] ['pid'] = $mark;
                        if ($model == 2) {
                            $dbtaskmodel [$n] ['modelname'] = $modelname [0];
                        }
                        $dbtaskmodel [$n] ['price'] = $price2 [0];
                        $dbtaskmodel [$n] ['auction'] = $auction [0];
                        $dbtaskmodel [$n] ['express'] = $express [0];
                        $dbtaskmodel [$n] ['number'] = $number [$n];
                        $dbtaskmodel [$n] ['car_img'] = @$car_img [$n];
                        $dbtaskmodel [$n] ['userid'] = $id;
                        $dbtaskmodel [$n] ['commission'] = $commission [0];
                        $dbtaskmodel [$n] ['handsel'] = @$_COOKIE['handsel'];
                        $dbtaskmodel [$n] ['Payment'] = @$_COOKIE['Payment'];
                        $dbtaskmodel [$n] ['Payment'] = @$_COOKIE['Payment'];

                        //tasktime表插入
                        if ($gettime == '2')  //多天平均发布
                        {
                            if (@strtotime($starttime [$m]) >= @strtotime($endtime [$m]))
                            {
                                show(0, '第' . ($m + 1) . '天任务的开始时间必须小于结束时间');
                            }
                            if (@strtotime($endtime [$m]) >= @strtotime($closetime [$m]) && $gettime > 0)
                            {
                                show(0, '第' . ($m + 1) . '天任务的结束平均发布时间必须小于超时取消的时间');
                            }
                            $dbtasktime [$m] ['pid'] = $mark;
                            $dbtasktime [$m] ['start'] = @strtotime($starttime [$m]);
                            $dbtasktime [$m] ['end'] = @strtotime($endtime [$m]);
                            $dbtasktime [$m] ['close'] = @strtotime($closetime [$m]);
                            $dbtasktime [$m] ['date'] = @strtotime($date [$m]);
                            $dbtasktime [$m] ['number'] = $number [$m];
                            $dbtasktime [$m] ['userid'] = $id;
                        } elseif ($gettime == '1')  //今日平均发布
                        {
                            if (@strtotime($starttime [0]) >= @strtotime($endtime [0]))
                            {
                                show(0, '任务的开始平均发布时间必须小于结束平均发布时间');
                            }
                            if (@strtotime($endtime [0]) >= @strtotime($closetime [0]))
                            {
                                show(0, '任务的结束平均发布时间必须小于超时取消的时间');
                            }
                            $interval = (@strtotime($endtime [0]) - @strtotime($starttime [0])) / array_sum($number);  //每个任务的时间间隔
                            $last += $number[$m >= 1 ? $m - 1 : $m];
                            $dbtasktime [$m] ['pid'] = $mark;
                            $dbtasktime [$m] ['start'] = $m === 0 ? @strtotime($starttime [0]) : @strtotime($starttime [0]) + $interval * ($last - $number[0]);
                            $dbtasktime [$m] ['end'] = $m !== count($intlet) - 1 ? $dbtasktime [$m] ['start'] + $interval * $number[$m] : @strtotime($endtime [0]);
                            $dbtasktime [$m] ['close'] = @strtotime($closetime [0]);
                            $dbtasktime [$m] ['date'] = @strtotime($date [0]);
                            $dbtasktime [$m] ['number'] = $number [$m];
                            $dbtasktime [$m] ['userid'] = $id;
                        }
                        else  //立即发布
                        {
                            $dbtasktime [$m] ['pid'] = $mark;
                            $dbtasktime [$m] ['start'] = @strtotime($starttime [0]);
                            $dbtasktime [$m] ['end'] = @strtotime($closetime [0]);
                            $dbtasktime [$m] ['close'] = @strtotime($closetime [0]);
                            $dbtasktime [$m] ['date'] = @strtotime($date [0]);
                            $dbtasktime [$m] ['number'] = $number [$m];
                            $dbtasktime [$m] ['userid'] = $id;
                        }
                        if ($tasktype == 4)  //预订单
                        {
                            $dbtasktime [$m] ['beginPay'] = strtotime(@$_COOKIE['beginPay']);
                            $dbtasktime [$m] ['EndPay'] = strtotime(@$_COOKIE['EndPay']);
                        } elseif ($tasktype == 5)  //预约单
                        {
                            $index = $gettime == '2' ? $m : 0;
                            $dbtasktime [$m] ['beginPay'] = strtotime(date('Y-m-d', strtotime($starttime[$index]) + 60 * 60 * 24) . ' 09:00:00');
                            $dbtasktime [$m] ['EndPay'] = strtotime(date('Y-m-d', strtotime($starttime[$index]) + 60 * 60 * 24) . ' 23:59:59');

                            $dbtaskmodel[$n]['how_browse'] = @$_COOKIE['how_browse'];
                            $dbtaskmodel[$n]['how_search'] = @$_COOKIE['how_search'];
                            $dbtaskmodel[$n]['new_keyword'] = @$_COOKIE['new_keyword'];
                        }

                        $n++;
                        $m++;
                    }
                    $is_success = $is_success && $this->db->insert_batch('zxjy_task', $dbtask); // 这个可以直接添加多行数据
                    $is_success = $is_success && $this->db->insert_batch('zxjy_taskmodel', $dbtaskmodel);
                    //以任务数作为插入点
                    $is_success = $is_success && $this->db->insert_batch('zxjy_tasktime', $dbtasktime);
                    $is_success ? show(1, '发布任务成功') : show(0, '插入任务记录失败，请稍后重试');
                }
                else
                    show(0, '任务参数错误，请重新发布任务');
            }
            else
            {
                $other_msg = time() - RedisCache::get($cache_name) < 10 ? '为防止重复发布任务，建议检查任务发布情况' : '';
                show(0, $limit_time . '秒内频繁发布任务，请' . (RedisCache::get($cache_name) + $limit_time - time()) . '秒后再试。' . $other_msg);
            }
        }
        else
            show(0, '参数异常, 请刷新页面后再试');
    }

    // 商家提交任务数据
	public function taskStepDB2()
    {
        $db = $this -> getServerInfo();
        $id = $userid = $db ['info']->id;
        $tasktype = $_COOKIE ['typepage'];  //任务类型（1销量/2复购）
        if ($tasktype == 0) {
            $tasktype = $this->session->userdata ( 'typepage' );
        }

        // var_dump($dbtask['tasktype']);
        $proid = $_COOKIE ['proid'];

        $proinfo = $this->product->getInfo ( $_COOKIE ['proid'] );
        $shopid = $proinfo->shopid; // 需要根据proid来获取
        $intlet = explode ( '&', $_COOKIE ['SearchType'] );  //流量入口
        $keyword = empty ( $_COOKIE ['SearchKey'] ) ? [] : explode ( '&', $_COOKIE ['SearchKey'] );  //搜索关键词
        $number = explode ( '&', $_COOKIE ['KeyWordCount'] );  //每个关键词对应的数量
        $order = explode ( '&', $_COOKIE ['IDorder'] );  //其它搜索条件：排序方式
        $price = explode ( '&', $_COOKIE ['IDprice'] );  //其它搜索条件：价格区间
        $sendaddress = explode ( '&', $_COOKIE ['IDaddress'] );   //其它搜索条件：发货地
        $other = explode ( '&', $_COOKIE ['IDother'] );    //其它搜索条件：其它

        $top = $_POST ['AddToPoint'];  //置顶费用
        $remark = $_POST ['remark'];   //任务说明
        $addtime = time ();
        $status = $db ['info']->ShowStatus; // 任务是否影藏需要根据用户状态获取 0正常（显示） 1 冻结（隐藏）

        $model = $_COOKIE ['IsSingleModel'];  //单型号/多型号
        $gettime = $_COOKIE ['TaskPlanType'];  //发布时间

        /* 这里存储为总任务表信息 */
        $dbtask = array ();
        $m = 0;
        $mark = time () . $this->generate_password ();
        $is_success = true;
        // echo $mark;
        //以流量入口的数目作为插入的条数
        foreach ( $intlet as $vi ) {
            $dbtask [$m] ['userid'] = $userid;
            $dbtask [$m] ['tasktype'] = $tasktype;
            $dbtask [$m] ['proid'] = $proid;
            $dbtask [$m] ['shopid'] = $shopid;
            $dbtask [$m] ['intlet'] = $vi;
            $dbtask [$m] ['keyword'] = $keyword [$m];
            $dbtask [$m] ['number'] = $number [$m];
            $dbtask [$m] ['order'] = $order [$m];
            $dbtask [$m] ['price'] = $price [$m];
            $dbtask [$m] ['sendaddress'] = $sendaddress [$m];
            $dbtask [$m] ['other'] = $other [$m];
            $dbtask [$m] ['top'] = $top;
            $dbtask [$m] ['remark'] = $remark;
            $dbtask [$m] ['addtime'] = $addtime;
            $dbtask [$m] ['status'] = $status;
            $dbtask [$m] ['model'] = $model;
            $dbtask [$m] ['gettime'] = $gettime;
            $dbtask [$m] ['mark'] = $mark;
            $m ++;
        }
        $is_success = $is_success && $this->db->insert_batch ( 'zxjy_task', $dbtask ); // 这个可以直接添加多行数据

        /* model 分表 */

        // echo $model;
        // echo $_COOKIE['ProductModel'];
        if ($model == 2)  //如果为多类型任务
        {
            $modelname = explode ( '&', $_COOKIE ['ProductModel'] );  //【指定型号】
            // var_dump($modelname);
        }
        $price = explode ( '&', $_COOKIE ['SingleProductPrice'] );  //商品单价
        $auction = explode ( '&', $_COOKIE ['BuyProductCount'] );  //拍下件数
        $express = explode ( '&', $_COOKIE ['ExpressCharge'] );  //快递费
        $number = explode ( '&', $_COOKIE ['ProductPriceListCount'] );  //任务数量
        $commission = explode ( '&', $_COOKIE ['ProCommission'] );  //单任务佣金
        $dbtaskmodel = array ();
        $n = 0;
        //以商品单价作为插入点
        foreach ( $price as $vp ) {
            $dbtaskmodel [$n] ['pid'] = $mark;
            if ($model == 2) {
                $dbtaskmodel [$n] ['modelname'] = $modelname [$n];
            }
            $dbtaskmodel [$n] ['price'] = $price [$n];
            $dbtaskmodel [$n] ['auction'] = $auction [$n];
            $dbtaskmodel [$n] ['express'] = $express [$n];
            $dbtaskmodel [$n] ['number'] = $number [$n];
            $dbtaskmodel [$n] ['userid'] = $id;
            $dbtaskmodel [$n] ['commission'] = $commission [$n];
            $n ++;
        }
        $is_success = $is_success && $this->db->insert_batch ( 'zxjy_taskmodel', $dbtaskmodel );

        /* 时间分表 */
        $starttime = explode ( '&', $_COOKIE ['starttime'] );  //开始时间
        $endtime = explode ( '&', $_COOKIE ['endtime'] );  //结束时间
        $closetime = explode ( '&', $_COOKIE ['closetime'] );  //超时取消
        $date = explode ( '&', $_COOKIE ['TaskDate'] );  //任务日期
        $number = explode ( '&', $_COOKIE ['TaskPlanCount'] );  //任务数

        $dbtasktime = array ();
        $t = 0;
        //以任务数作为插入点
        foreach ( $number as $key => $vn ) {
            if ($vn != 0) {
                $dbtasktime [$t] ['pid'] = $mark;
                $dbtasktime [$t] ['start'] = @strtotime ( $starttime [$key] );
                $dbtasktime [$t] ['end'] = @strtotime ( $endtime [$key] );
                $dbtasktime [$t] ['close'] = @strtotime ( $closetime [$key] );
                $dbtasktime [$t] ['date'] = @strtotime ( $date [$key] );
                $dbtasktime [$t] ['number'] = $number [$key];
                $dbtasktime [$t] ['userid'] = $id;
                $t ++;
            }
        }
        $is_success = $is_success && $this->db->insert_batch ( 'zxjy_tasktime', $dbtasktime );
        $is_success ? show(1, '发布任务成功') : show(0, '插入任务记录失败，请稍后重试');
    }

	public function evaluation()
    {
        $db = $this -> _include();
        $db ['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $db ['countall'] = $this->taskevaluate->WillPass ($this -> uid);  //待支付佣金任务数
        $start = 10 * $db ['page'];
        $sql = 'select te.*, ut.tasksn, ut.ordersn, ut.expressnum, ww.wangwang, s.shopname, bb.account_info, p.commodity_abbreviation from zxjy_taskevaluate as te
                LEFT JOIN zxjy_usertask as ut on ut.id = te.usertaskid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = te.doid
                LEFT JOIN zxjy_bindbuyer as bb on bb.userid = te.doid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                WHERE te.sellerid = ' . $this -> uid . ' ORDER BY te.id desc limit ' . $start .  ', 10 ';
        //printf($sql);
        $db ['list'] = $this -> db -> query($sql) -> result();
        $db ['count'] = $this->taskevaluate->getcount ($this -> uid);
        $db ['search'] = false;
        $this->load->view ('evaluation', $db );

//		$page = @$_GET ['page'] == '' ? 0 : @$_GET ['page'];
//		$id = $this->session->userdata ( 'sellerid' );
//		$db ['info'] = $this->user->getInfo ( $id );
//		$db ['showcontent'] = 1;
//		$db ['service1'] = $this->system->getInfo ( 87 );
//		$db ['service2'] = $this->system->getInfo ( 88 );
//		$db ['countall'] = $this->taskevaluate->WillPass ( $id );
//		$db ['list'] = $this->taskevaluate->getList ( $id, 10, 10 * $page );
//		$db ['count'] = $this->taskevaluate->getcount ( $id );
//		$db ['page'] = 0;
//		$arr = array ();
//		$m = 0;
//		$arrdo = array ();
//		foreach ( $db ['list'] as $vdbl ) {
//			$arrdo [$m] = $vdbl->doid;
//			$arr [$m ++] = $vdbl->usertaskid;
//		}
//		if (count ( $db ['list'] ) != 0) {
//			$db ['usertask'] = $this->usertask->getArr ( $arr );
//			// 买手信息
//			$db ['wangwangs'] = $this->bindwangwang->getArr ( $arrdo );
//			$db ['buyers'] = $this->buyer->getArr ( $arrdo );
//			// var_dump($db['wangwangs']);
//			// 商品信息
//			$arrgoods = array ();
//			foreach ( $db ['usertask'] as $key => $vut ) {
//				$arrgoods [$key] = $vut->proid;
//			}
//			if (count ( $arrgoods ) != 0) {
//				$db ['goods'] = $this->product->getArr ( $arrgoods );
//				$arrshop = array ();
//				$arrpro = array ();
//				$n = 0;
//				if (count ( $db ['usertask'] ) != 0) {
//					foreach ( $db ['usertask'] as $vdu ) {
//						$arrshop [$n] = $vdu->shopid;
//						$arrpro [$n ++] = $vdu->proid;
//					}
//					// var_dump($arrpro);
//					$db ['shop'] = $this->shop->getArr ( $arrshop );
//					$db ['product'] = $this->product->getArr ( $arrpro );
//					// var_dump($db['product']);
//					$db ['search'] = false;
//					$this->load->view ( 'evaluation', $db );
//				} else {
//					echo "<script>alert('暂无数据信息');history.back();</script>";
//				}
//			} else {
//				echo "<script>alert('数据丢失！');history.back();</script>";
//			}
//		} else {
//			echo "<script>alert('暂无数据信息');history.back();</script>";
//		}
	}
	public function evaluationSearch() {
        $db = $this -> _include();
        $db ['countall'] = $this->taskevaluate->WillPass ($this -> uid);  //待支付佣金任务数
        $db ['page'] = isset($_GET['page']) ? $_GET['page'] : 0;
        $db ['status'] = $status = @$_POST ['status'];
        $db ['selSearch'] = $selSearch = @$_POST ['selSearch'];
        $db ['txtSearch'] = $txtSearch = @$_POST ['txtSearch'];
        $BeginDate = @$_POST ['BeginDate'] == '' ? strtotime('2017-01-01 00:00:00') : @strtotime ( @$_POST ['BeginDate'] );
        $EndDate = @$_POST ['EndDate'] == '' ? time() : @strtotime ( @$_POST ['EndDate'] );
        $start = 10 * $db ['page'];
        $condition = 'te.sellerid = ' . $this -> uid;
        if (!empty($status))
            $condition .= ' AND doing = ' . $status;
        if (!empty($txtSearch))
            $condition .= ' AND ' . $selSearch . ' = "' . $txtSearch . '"';
        $sql = 'select te.*, ut.tasksn, ut.ordersn, ut.expressnum, ww.wangwang, s.shopname, bb.account_info, p.commodity_abbreviation from zxjy_taskevaluate as te
                LEFT JOIN zxjy_usertask as ut on ut.id = te.usertaskid
                LEFT JOIN zxjy_blindwangwang as ww on ww.userid = te.doid
                LEFT JOIN zxjy_bindbuyer as bb on bb.userid = te.doid
                LEFT JOIN zxjy_shop as s on s.sid = ut.shopid
                LEFT JOIN zxjy_product as p on p.id = ut.proid
                WHERE ' . $condition . ' AND te.addtime > ' . $BeginDate . ' AND te.addtime < ' . $EndDate . ' ORDER BY te.id desc limit ' . $start .  ', 10 ';
        $db ['list'] = $this -> db -> query($sql) -> result();
        $db ['count'] = $this->taskevaluate->getcount ($this -> uid);
        $db ['search'] = TRUE;
        $this->load->view ( 'evaluation', $db );


//		$page = @$_GET ['page'] == '' ? 0 : @$_GET ['page'];
//		$id = $this->session->userdata ( 'sellerid' );
//		$db ['info'] = $this->user->getInfo ( $id );
//		$db ['showcontent'] = 1;
//		$db ['service1'] = $this->system->getInfo ( 87 );
//		$db ['service2'] = $this->system->getInfo ( 88 );
//		$db ['countall'] = $this->taskevaluate->WillPass ( $id );
//
//		$db ['status'] = $status = @$_POST ['status'];
//		$db ['selSearch'] = $selSearch = @$_POST ['selSearch'];
//		$db ['txtSearch'] = $txtSearch = @$_POST ['txtSearch'];
//		$BeginDate = @$_POST ['BeginDate'] == '' ? 0 : @strtotime ( @$_POST ['BeginDate'] );
//		$EndDate = @$_POST ['EndDate'] == '' ? 0 : @strtotime ( @$_POST ['EndDate'] );
//
//		// echo "<script>alert('".$selSearch."');</script>";
//
//		$db ['BeginDate'] = $BeginDate == 0 ? '' : $BeginDate;
//		$db ['EndDate'] = $EndDate == 0 ? '' : $EndDate;
//		// $doing,$start,$end,$selSearch,$txtSearch,$userid,$limit,$offset
//		$db ['list'] = $this->taskevaluate->SearchList ( $status, $BeginDate, $EndDate, $selSearch, $txtSearch, $id, 10, 10 * $page );
//		$db ['count'] = $this->taskevaluate->SearchCount ( $status, $BeginDate, $EndDate, $selSearch, $txtSearch, $id );
//
//		$db ['page'] = 0;
//		$arr = array ();
//		$m = 0;
//		$arrdo = array ();
//		foreach ( $db ['list'] as $vdbl ) {
//			$arrdo [$m] = $vdbl->doid;
//			$arr [$m ++] = $vdbl->usertaskid;
//		}
//		if (count ( $db ['list'] ) != 0) {
//			$db ['usertask'] = $this->usertask->getArr ( $arr );
//			// 买手信息
//			$db ['wangwangs'] = $this->bindwangwang->getArr ( $arrdo );
//			$db ['buyers'] = $this->buyer->getArr ( $arrdo );
//			// var_dump($db['wangwangs']);
//			// 商品信息
//			$arrgoods = array ();
//			foreach ( $db ['usertask'] as $key => $vut ) {
//				$arrgoods [$key] = $vut->proid;
//			}
//			if (count ( $arrgoods ) != 0) {
//				$db ['goods'] = $this->product->getArr ( $arrgoods );
//				$arrshop = array ();
//				$arrpro = array ();
//				$n = 0;
//				if (count ( $db ['usertask'] ) != 0) {
//					foreach ( $db ['usertask'] as $vdu ) {
//						$arrshop [$n] = $vdu->shopid;
//						$arrpro [$n ++] = $vdu->proid;
//					}
//					// var_dump($arrpro);
//					$db ['shop'] = $this->shop->getArr ( $arrshop );
//					$db ['product'] = $this->product->getArr ( $arrpro );
//					// var_dump($db['product']);
//					$db ['search'] = true;
//					$this->load->view ( 'evaluation', $db );
//				} else {
//					echo "<script>alert('暂无数据信息');</script>";
//					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
//				}
//			} else {
//				echo "<script>alert('数据丢失！');</script>";
//				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
//			}
//		} else {
//			echo "<script>alert('暂无数据信息');</script>";
//			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/evaluation.html\" >";
//		}
	}

	/*
	 * 取消评价任务
	 */
	public function CancelOne()
    {
        if (isset($_POST['key']))
        {
            $res = true;  //判断数据库是否都执行成功
            $info = $this -> taskevaluate -> getInfo ($_POST['key']);
            $usertaskinfo = $this -> usertask -> getInfo ($info->usertaskid);
            if ($info && $usertaskinfo)
            {
                $dbut ['status'] = 4;
                $this -> usertask -> updata($info -> usertaskid, $dbut);
                $db ['doing'] = 3;
                $res = $res && $this -> taskevaluate -> del($info->id);
                // 取消评价任务返还给用户已扣空金额
                $seller = $this -> user -> getInfo ($this -> uid);
                $dbuser ['Money'] = $seller->Money + $info->iscommission;
                $res = $res && $this -> user -> updata ($seller -> id, $dbuser); // 还钱成功
                $this->load->model ('Cash_model', 'cash');
                $dbcash = [
                    'type' => '取消评价任务',
                    'remoney' => $dbuser ['Money'],
                    'increase' => '+' . $info -> iscommission,
                    'beizhu' => '取消评价任务返还佣金',
                    'addtime' => time(),
                    'userid' => $seller -> id,
                    'usertaskid' => $info -> usertaskid,
                    'proid' => $usertaskinfo -> proid,
                    'shopid' => $usertaskinfo -> shopid,
                ];
                $res = $res && $this -> cash -> add($dbcash);
                $res ? show(1, '该评价任务已被成功取消') : show(0, '数据库操作异常，您的部分状态可能已被修改，有疑问请找客服');
            }
            else
                show(0, '获取数据信息失败，请稍后再试');
        }
        show(0, '请求异常，请稍后再试');  //无post值或者评价任务表不存在此记录
	}
	public function passOne() {
		if (@$_GET ['key'] == '') {
			echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
			exit ();
		}
		$getone = $this->taskevaluate->getInfo ( @$_GET ['key'] );
		$db ['doing'] = 2;
		$this->taskevaluate->updataPass ( $getone->id, $db );
		$dbusertask ['status'] = 6;
		$this->usertask->upDataPass ( $getone->usertaskid, $dbusertask );
	}

	/*
	 * 一键支付评价佣金
	 */
	public function PassAll()
    {
		$id = $this->session->userdata ( 'sellerid' );
		$sql = 'select * from zxjy_taskevaluate where sellerid = ' . $id . ' AND doing = 1';
		$getall = $this -> db -> query($sql) -> result();
		if ($getall)
        {
            $arr = [];
            $n = 0;
            $arrtask = [];
            foreach ($getall as $vga)
            {
                $arrtask[$n] = $vga -> usertaskid;
                $arr[$n ++] = $vga -> id;
            }
            $res = true;
            //更新评价任务表和用户任务表的相关状态
            $db ['doing'] = 2;
            $res = $res && $this -> taskevaluate -> updataPass ($arr, $db);
            $dbusertask ['status'] = 7;
            $res = $res && $this -> usertask -> upDataPass($arrtask, $dbusertask);

            foreach ( $getall as $v ) {
                $shuashouinfo = $this -> user -> getInfo($v->doid);
                $dbshuashou['Money'] = $shuashouinfo -> Money + $v -> iscommission;
                $res = $res && $this -> user -> updata($shuashouinfo->id, $dbshuashou);  //给刷手加钱
                // 给刷手添加资金记录
                $usertask = $this -> usertask -> getInfo ( $v->usertaskid );
                $this->load->model ( 'Cash_model', 'cashlog' );
                $dbsl = [
                    'type' => '评价佣金',
                    'remoney' => $shuashouinfo -> Money + $v -> iscommission,
                    'increase' => '+' . $v->iscommission,
                    'beizhu' => '完成评价任务获取任务佣金',
                    'addtime' => time(),
                    'userid' => $v->doid,
                    'usertaskid' => $v->usertaskid,
                    'proid' => $usertask->proid,
                    'shopid' => $usertask->shopid,
                ];
//			$dbsl ['type'] = '评价佣金';
//			$dbsl ['remoney'] = $shuashouinfo->Money + $v->iscommission;
//			$dbsl ['increase'] = '+' . $v->iscommission;
//			$dbsl ['beizhu'] = '完成评价任务获取任务佣金';
//			$dbsl ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
//			$dbsl ['userid'] = $v->doid;
//			$dbsl ['usertaskid'] = $v->sellerid;
//			$dbsl ['proid'] = $usertask->proid;
//			$dbsl ['shopid'] = $usertask->shopid;
                $res = $res && $this -> cashlog -> add ( $dbsl );
            }
            $res ? show(1, '已成功支付所有评价佣金') : show(0, '数据库操作异常，您的部分状态可能已被修改，有疑问请找客服');
        }
        else
            show(0, '暂无需要通过审核的评价任务');

	}

	public function CreateTaskError() {
		$key = @$_GET ['key'] == '' ? 0 : @$_GET ['key'];
		if ($key == 0) {
			echo "<script>alert('请不要尝试错误链接！');history.back();</script>";
		} else {
			$usertask = $this->usertask->getInfo ( $key );
			if ($usertask != null) {
				$db ['classify'] = $this->complaint->getAll ();
				$db ['taskinfo'] = $usertask;
				$this->load->view ( 'CreateTaskError', $db );
			} else {
				echo '<script>alert("数据出错了，请刷新页面后重新尝试！");history.back();</script>';
			}
		}
	}

	public function test()
    {
        var_dump($this -> time2second(6420));
//        $db = [
//            'usertaskid' => '123',
//            'typeid' => 'dwadwa',
//            'questionid' => 'dwadwa',
//            'merchantid' => 2,
//            'buyerid' => 3,
//            'tasksn' => 'dwadwa',
//            'ordersn' => 'dwadwa',
//            'status' => 0,
//            'addtime' => time(),
//            'mark' => time () . $this->generate_password (),
//        ];
//        var_dump($this -> complaint -> add($db));
//        var_dump($this -> db -> insert_id());
    }

	/*
	 * 提交工单数据到数据库
	 */
	public function CreateTaskErrorDB()
    {
        $master = $this -> load -> database('master', TRUE);  //连接主库，预防主从同步延迟导致的重复插入工单
        if (isset($_POST ['TaskID']))
        {
            $sql = "SELECT COUNT(1) as has FROM zxjy_schedual WHERE usertaskid = {$_POST['TaskID']}";
            if (!$master -> query($sql) -> row() -> has)  //无该笔任务工单记录
            {
                $contentimg =  isset($_FILES ['multiple']) ? $this -> uploadFile($_FILES ['multiple']) : '';  //保存工单图片并返回序列化路径
                $res = true;
                $usertask = $this -> usertask -> getInfo($_POST['TaskID']);
                //新增工单表记录
                $db = [
                    'usertaskid' => $_POST ['TaskID'],
                    'typeid' => $_POST ['Category1ID'],
                    'questionid' => $_POST ['Category2ID'],
                    'merchantid' => $usertask -> merchantid,
                    'buyerid' => $usertask -> userid,
                    'tasksn' => $usertask -> tasksn,
                    'ordersn' => $usertask -> ordersn,
                    'status' => 0,
                    'addtime' => time(),
                    'mark' => time () . $this->generate_password (),
                ];
                $res = $res && $this -> complaint -> add($db);
                $res = $res && $this -> usertask -> updata($usertask->id, ['complaint' => 1]);  //更新任务用户表complaint字段
                //新增
                $sql = 'select id from zxjy_schedual where mark = "' . $db['mark'] . '"';
                $insert_id = $this -> db -> query($sql) -> first_row();
                $insert = [
                    'schedualid' => $insert_id -> id,
                    'addtime' => time(),
                    'status' => 0,
                    'content' => $_POST ['Content'],
                    'sellerid' => $usertask->merchantid,
                    'contentimg' => $contentimg,
                ];
                $res = $res && $this -> complaint -> addTalk($insert);
                $res ? show(1, '工单信息已经提交到后台,我们的工作人员会尽快处理', $_POST ['TaskID']) : show(0, '工单插入数据库失败，请稍后再试');
            }
            else
                show(0, '订单已经提交过工单了, 请不要重复提交');
        }
        else
            show(0, '请求异常，请检查文件是否超过' . ini_get('upload_max_filesize'));
//        $infosnum = $this -> complaint -> geyInfoByUsertaskID($db['usertaskid']);
//		$db ['usertaskid'] = $_POST ['TaskID'];
//		$db ['typeid'] = $_POST ['Category1ID'];
//		$db ['questionid'] = $_POST ['Category2ID'];
//		$usertask = $this->usertask->getInfo ( $db ['usertaskid'] );
//		$db ['merchantid'] = $usertask->merchantid;
//		$db ['buyerid'] = $usertask->userid;
//
//		$db ['tasksn'] = $usertask->tasksn;
//		$db ['ordersn'] = $usertask->ordersn;
//		$db ['status'] = 0;
//		$db ['addtime'] = time ();
//		$db ['mark'] = time () . $this->generate_password ();
//		$infosnum = $this->complaint->geyInfoByUsertaskID ( $db ['usertaskid'] );
//		if ($infosnum != 0) {
//			echo "<script>alert('订单已经提交过工单了，请不要重复提交！');history.back();</script>";
//			exit ();
//		}
//		$this->complaint->add ( $db );
//		$com = $this->complaint->getInfoByMark ( $db ['mark'] );
//
//		$dbusertask ['complaint'] = 1;
//		$this->usertask->updata ( $usertask->id, $dbusertask );
//
//		$dbt ['schedualid'] = $com->id;
//		$dbt ['addtime'] = time ();
//		$dbt ['status'] = 0;
//		$dbt ['content'] = $_POST ['Content'];
//		$dbt ['sellerid'] = $usertask->merchantid;
		
//		$files = $_FILES ['multiple'];
//		$arr = array ();
		// var_dump(empty($_FILES['multiple']));
//		if ($files ['error'] [0] == 0) {
//			$saveway = "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) . '/';
//			if (! file_exists ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) )) {
//				mkdir ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ), 0777, true );
//			}
//			// $files=array_filter($files,'check');
//			// $array = array_filter($_FILES['inputimage']['name'],'check');
//
//			$n = 0;
//			$m = 0;
//			foreach ( $_FILES ['multiple'] ['tmp_name'] as $k => $v ) {
//				if (($_FILES ['multiple'] ['type'] [$k] == "image/gif") || ($_FILES ['multiple'] ['type'] [$k] == "image/jpeg") || ($_FILES ['multiple'] ['type'] [$k] == "image/png")) {
//					if ($_FILES ['multiple'] ['type'] [$k] < 2048000) {
//						if (is_uploaded_file ( $_FILES ['multiple'] ['tmp_name'] [$k] )) {
//							$oldname = explode ( '.', $_FILES ['multiple'] ['name'] [$k] );
//							$savename = uniqid () . $n ++ . '.' . $oldname [1];
//							if (move_uploaded_file ( $_FILES ['multiple'] ['tmp_name'] [$k], $saveway . $savename )) {
//								$arr [$m ++] = site_url () . $saveway . $savename;
//								// echo $saveway.$savename;
//							}
//						}
//					} else {
//						echo "<script>alert('上传的文件超出限制大小！(单张图片文件大小不大于2M)');history.back();</script>";
//						exit ();
//					}
//				} else {
//					echo "<script>alert('请上传文件格式为 gif/png/jpg 的图片。否则无法保存！');history.back();</script>";
//					exit ();
//				}
//			}
//		}
		// var_dump($arr);
		// if(count($arr) != 0){
//		$dbt ['contentimg'] = $this -> uploadFile();
		// }
//        if ($re) {
//            echo "<script>alert('工单信息已经提交到后台。我们的工作人员会尽快处理！');parent.location.reload();</script>";
//        } else {
//            echo "<script>alert('系统现在繁忙中，请稍后重试！');history.back();</script>";
//        }
//        $dbt ['contentimg'] = $this -> uploadFile($_FILES ['multiple']);
//		$re = $this -> complaint -> addTalk($dbt);
//		$re ? show(1, '工单信息已经提交到后台,我们的工作人员会尽快处理') : show(0, '工单插入数据库失败，请稍后再试');
	}


	public function SendAll() {
		$id = $this->session->userdata ( 'sellerid' );
		$list = $this->usertask->getlist ( $id, 1, 0, 0 );
		$allwaitsend = array ();
		if (count ( $list ) == 0) {
			echo "<script>alert('暂无需要发货的信息');history.back();</script>";
			exit ();
		}
		foreach ( $list as $key => $vl ) {
			$allwaitsend [$key] = $vl->id;
		}
		$db ['Status'] = 2;
		$this->usertask->upDataPass ( $allwaitsend, $db );
		
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
	}
	/*
	 * 一键获取佣金
	 */
	public function GiveAll() {
		$id = $this->session->userdata ( 'sellerid' );
		$list = $this->usertask->getlist ( $id, 3, 0, 0 );
		$allwaitsend = array ();
		if (count ( $list ) == 0) {
			echo "<script>alert('暂无需要付款信息');history.back();</script>";
			exit ();
		}
		foreach ( $list as $key => $info ) {
			// $allwaitsend[$key] = $vl->id;
			$dbusertask ['Status'] = 4;
			$this->usertask->updata ( $info->id, $dbusertask );
			
			// 刷手获取佣金 +积分
			$shuashou = $this->user->getInfo ( $info->userid );
			$db ['Money'] = $shuashou->Money + $info->commission;
			$db ['Score'] = $shuashou->Score + 10;
			$reuser = $this->user->updata ( $info->userid, $db );
			if ($reuser) {
				$this->load->model ( 'Cash_model', 'cashlog' );
				// 现金记录
				$dbcls ['type'] = '任务佣金';
				$dbcls ['remoney'] = $shuashou->Money + $info->commission;
				$dbcls ['increase'] = '+' . $info->commission;
				$dbcls ['beizhu'] = '完成任务获取';
				$dbcls ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
				$dbcls ['userid'] = $info->userid;
				$dbcls ['usertaskid'] = $info->id;
				$dbcls ['proid'] = $info->proid;
				$dbcls ['shopid'] = $info->shopid;
				$this->cashlog->add ( $dbcls );
				
				// 刷手积分
				$this->load->model ( 'Score_model', 'sc' );
				$sc ['userid'] = $shuashou->id;
				$sc ['original_score'] = $shuashou->Score;
				$sc ['score_info'] = '+10';
				$sc ['score_now'] = $db ['Score'];
				$sc ['description'] = '完成任务获得积分';
				$sc ['add_time'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
				$this->sc->add ( $sc );
				
				// 计算刷手获取推广金
				$this->load->model ( 'System_model', 'system' );
				if ($shuashou->IdNumber != '') {
					$getcommissionuser = $this->user->getInfo ( $shuashou->IdNumber );
					if ($getcommissionuser->iscommission == '1' && $getcommissionuser->ispromoter == '1') { // 获取佣金
						$shuashoutuiguang = $this->system->getInfo ( 83 ); // 推广需要添加的费用
						$gcum ['Money'] = $getcommissionuser->Money + $shuashoutuiguang->value;
						$this->user->updata ( $getcommissionuser->id, $gcum );
						
						$dbcl ['type'] = '任务佣金';
						$dbcl ['remoney'] = $getcommissionuser->Money + $shuashoutuiguang->value;
						$dbcl ['increase'] = '+' . $shuashoutuiguang->value;
						$dbcl ['beizhu'] = '推广人员完成任务返现';
						$dbcl ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
						$dbcl ['userid'] = $getcommissionuser->id;
						$dbcl ['usertaskid'] = $info->id;
						$dbcl ['proid'] = $info->proid;
						$dbcl ['shopid'] = $info->shopid;
						$this->cashlog->add ( $dbcl );
					} // 不用返还佣金
				} // 没有佣金情况
				  
				// 商家推广获取推广金
				$thisshop = $this->user->getInfo ( $info->merchantid ); // 商家信息
				if ($thisshop->parentid != '') {
					$parentshop = $this->user->getInfo ( $thisshop->parentid ); // 商家上级信息
					if ($parentshop->iscommission == '1' && $parentshop->ispromoter == '1') {
						$shoptuiguangjin = $this->system->getInfo ( 82 ); // 推广需要添加的费用
						$pcum ['Money'] = $parentshop->Money + $shoptuiguangjin->value;
						$this->user->updata ( $parentshop->id, $pcum );
						
						$dbsl ['type'] = '任务佣金';
						$dbsl ['remoney'] = $pcum ['Money'];
						$dbsl ['increase'] = '+' . $shoptuiguangjin->value;
						$dbsl ['beizhu'] = '推广商家完成发布任务获得';
						$dbsl ['addtime'] = @strtotime ( @date ( 'Y-m-d H:i:s' ) );
						$dbsl ['userid'] = $parentshop->id;
						$dbsl ['usertaskid'] = $info->id;
						$dbsl ['proid'] = $info->proid;
						$dbsl ['shopid'] = $info->shopid;
						$this->cashlog->add ( $dbsl );
					}
				}
			} else {
				echo "<script>alert('系统现在正在繁忙中，请稍后再来确认吧！');</script>";
				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
				exit ();
			}
		}
		
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=../sales/taskyes.html\" >";
	}
	function generate_password($length = 6) {
		// 密码字符集，可任意添加你需要的字符
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~+=/?|';
		$password = '';
		for($i = 0; $i < $length; $i ++) {
			// 这里提供两种字符获取方式
			// 第一种是使用 substr 截取$chars中的任意一位字符；
			// 第二种是取字符数组 $chars 的任意元素
			// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
			$password .= $chars [mt_rand ( 0, strlen ( $chars ) - 1 )];
		}
		return $password;
	}
}
