<?php
/**
 * 控制器基类
 * Created by PhpStorm.
 * User: 81237
 * Date: 2018/3/30
 * Time: 22:37
 */
class MY_Controller extends CI_Controller
{

    protected $uid;
    public $platform;

    public function __construct()
    {
        parent::__construct();
        $this -> uid = $this-> session -> userdata('sellerid');
        $sql = 'SELECT value FROM zxjy_system WHERE varname = "platform"';
        $this -> platform = $this -> cacheSqlQuery('platform_name', $sql, 0, true, 'row') -> value;
 //       if (!empty($this -> uid) && $this -> uid != 89)
//        {
  //         exit('系统正在调试');
   //     }
    }
	

    /*
     * 获取并缓存系统设置的客服QQ号信息
     */
    public function getServerInfo($showstatus = 1)
    {
        $cache_name = 'server_info_' . $this -> uid;
        if (!RedisCache::has($cache_name) || !RedisCache::has('server_info') || true)
        {
            $sql = 'SELECT value from zxjy_system WHERE varname in ("merchantQQkefu1", "merchantQQkefu2", "cash_deposit", "use_helper") ORDER BY id ASC';  //排序需注意id升序
            $result = $this -> cacheSqlQuery('server_info', $sql, 60, true);
            $server_info = [
                'service1' => $result[0],
                'service2' => $result[1],
                'cash_deposit' => $result[2],
                'use_helper' => $result[3],
            ];
            $sql = 'select id, Username, ShowStatus, Status, Money, PassWord, RegTime, maxtask, ispromoter, bond, SafePwd, QQToken, wechat, service_charge, pay_time, alloutcash from zxjy_user where id = ' . $this -> uid;
            $server_info['info'] = $this -> db -> query($sql) -> first_row();
            $sql = 'SELECT number FROM zxjy_buytasknum WHERE uid = '  . $this -> uid . ' AND state = 1 AND DATE_ADD(FROM_UNIXTIME(updatetime), INTERVAL 30 DAY) >= NOW() ORDER BY id DESC LIMIT 1';  //是否存在有效购买的单量
            $has_buy = $this -> db -> query($sql) -> first_row();
            if (!empty($has_buy))
            {
                $server_info['info'] -> maxtask = $has_buy -> number;
            }
            $server_info['showcontent'] = 1;
            RedisCache::set($cache_name, $server_info, 60 * 5 );  //缓存5分钟
        }
		$infos = RedisCache::get($cache_name);
        $sql = 'SELECT sid, COUNT(1) as has, api_expiration_time FROM zxjy_shop WHERE (seller_userid IS NULL OR seller_userid = "" OR api_expiration_time <= UNIX_TIMESTAMP()) AND userid = ' . $this -> uid;
        $shop_helper_infos = $this -> cacheSqlQuery('has_no_bound_', $sql, 60 * 1, false, 'first_row');
        if ($infos['use_helper'] -> value == 2 && $shop_helper_infos -> has)  //如果是兼容模式，则判断商家是否存在未绑定或过期的店铺
        {
            $infos['use_helper'] -> value = 0;
        }
        $infos['api_expiration_time'] = $shop_helper_infos -> api_expiration_time;
        return $infos;
        //return RedisCache::get($cache_name);
    }

    /**
     * 缓存某条sql语句的查询结果
     * @param $cache_name  缓存键值
     * @param $sql  SQL语句
     * @param int $expire  过期时间，默认15分钟
     * @param int $common  是否为公用缓存类，默认为私有
     * @param int $action  以何种方法返回结果集， 默认result
     * @return mixed
     */
    public function cacheSqlQuery($cache_name, $sql, $expire = 900, $common = false, $action = 'result')
    {
        $cache_name = $common ? $cache_name : $cache_name . $this -> uid;
        if (!RedisCache::has($cache_name) || true)
        {
            $result = $this -> db -> query($sql) -> $action();
            RedisCache::set($cache_name, $result, $expire);  //缓存15分钟
        }
        return RedisCache::get($cache_name);
    }
	
	
	/**
     *  控制台请求操作
     * @param $action_tag  接口标志
     * @param $post_data 请求参数
     * @param $is_post 是否为POST请求
     * @param $retries  curl重试次数
     * @return mixed
     */
    public function consoleCurlHandle($action_tag, $post_data, $is_post = true, $retries = 3)
    {
        $curl_url = BKC_URL . "?ActionTag=" . $action_tag;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $curl_url);
        if (!$is_post)  //非POST请求
        {
            $curl_url .= http_build_query($post_data);
        }
        else
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($curl, CURLOPT_URL, $curl_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "qianyunlai.com's CURL Example beta");
        $response_info = json_decode(curl_exec($curl)); // 执行操作
        $curl_error = curl_error($curl);
        while (($curl_error || !$response_info -> IsOK) && $retries--)  //请求有误，重试
        {
            $response_info = json_decode(curl_exec($curl));
            $curl_error = curl_error($curl);
        }
        curl_close($curl); // 关闭CURL会话
        return $curl_error ? show(0, $curl_error) : $response_info;
    }

    /*
     * 更新三张任务表中的del字段（超时取消）
     */
    public function updateTaskDel()
    {
        $this->load->model ( 'Task_model', 'task' );
        $uid = $this-> session -> userdata('sellerid');
        $timelist = $this->task->getThisTime ($uid);
        // 获取到模型表
        $modellist = $this->task->getModel ($uid);
        // 获取任务总表信息
        $tasklist = $this->task->getUserid ($uid);
        // var_dump($oldtasklist);
        $thistime = time();
        foreach ( $timelist as $vo )
        {
			if ($vo->close < $thistime) {
				if ($vo->number > ($vo->takenumber + $vo->del)) {
					$needdeltask = $needdelmodel = $dbt ['del'] = $vo->number - $vo->takenumber;
					$this->task->updatatime ( $vo->id, $dbt );
					/* 修改模型表数据 */
					foreach ( $modellist as $vml ) {
						if ($vml->pid == $vo->pid) {
							if ($vml->number > ($vml->takenumber + $vml->del)) {
								// 需要删除数量 $needdelmodel
								if ($needdelmodel > 0) {
									$delmodel = $vml->number - ($vml->takenumber + $vml->del);
									if ($needdelmodel > $delmodel) {
										$needdelmodel = $needdelmodel - $delmodel;
										$dbm ['del'] = $delmodel + $vml->del;
									} else {
										$dbm ['del'] = $needdelmodel + $vml->del;
										$needdelmodel = 0;
									}
									$this->task->updatamodel ( $vml->id, $dbm );
								}
							}
						}
						// echo $dbt['del'].'<br>';
					}
					/* 模型表修改完成 */
					/* 修改任务总表信息 */
					foreach ( $tasklist as $vtl ) {
						if ($vo->pid == $vtl->mark) {
							if ($vtl->number > ($vtl->qrnumber + $vtl->del)) {
								$deltask = $vtl->number - $vtl->qrnumber - $vtl->del;
								if ($needdeltask > $deltask) {
									$needdeltask = $needdeltask - $deltask;
									$dba ['del'] = $deltask + $vtl->del;
								} else {
									$dba ['del'] = $needdeltask + $vtl->del;
								}
								$this->task->updata ( $vtl->id, $dba );
							}
						}
					}
					/* 任务总表修改完成 */
				}
			}
		}
    }

    /**
     * 上传文件
     * @param $file  文件信息
     * @param int $size_limit  //大小限制，默认2M
     * @param array $type_limit  类型限制，数组格式
     * @return array  //返回序列化后的文件存储路径
     */
    public  function uploadFile($file, $size_limit = 2048000, $type_limit = ['image/gif', 'image/jpeg', 'image/png', 'image/jpg'])
    {
        if ($this -> checkFileErr($file['error']))  //文件上传都无误
        {
            $saveway = "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) . '/';
            if (! file_exists ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) )) //根据当前月创建新的文件夹
            {
                mkdir ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ), 0777, true );
            }
            $n = $m = 0;
            $arr = [];
            foreach ($file['tmp_name'] as $k => $v) {
                if (in_array($file['type'][$k], $type_limit))  //文件格式正确
                {
                    if ($file['size'][$k] < $size_limit)
                    {
                        if (is_uploaded_file ($file['tmp_name'][$k]))
                        {
                            $savename = md5(uniqid(microtime(true),true)) . '.png';
                            if (move_uploaded_file ($file['tmp_name'][$k], $saveway . $savename))
                            {
                                $arr [$m ++] = site_url () . $saveway . $savename;
                            }
                            else
                                show(0, '存储文件失败，请稍后再试');
                        }
                    }
                    else
                        show(0, '上传的文件超出限制大小, 单张图片文件大小不大于2M');
                }
                else
                    show(0, '请上传文件格式为' . implode('/', $type_limit) . '的图片。否则无法保存！');
            }
            return empty($arr) ? show(0, '图片上传失败，请稍后再试') : serialize($arr);  //返回序列化后的存储路径
        }
    }
    public  function uploadFilePF($file, $size_limit = 4194304, $type_limit = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/octet-stream'])
    {
        if ($this -> checkFileErr($file['error']))  //文件上传都无误
        {
            $saveway = "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) . '/excel/';
            if (! file_exists ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ). '/excel/' )) //根据当前月创建新的文件夹
            {
                mkdir ( "./uploads/" . @date ( 'Y' ) . '/' . @date ( 'm' ) . '/excel', 0777, true );
            }
            $n = $m = 0;
            $arr = [];
            foreach ($file['tmp_name'] as $k => $v) {
                if (in_array($file['type'][$k], $type_limit))  //文件格式正确
                {
                    if ($file['size'][$k] <= $size_limit)
                    {
                        if (is_uploaded_file ($file['tmp_name'][$k]))
                        {
                            if($file['type'][$k] =='application/vnd.ms-excel'){
                                $savename = md5(uniqid(microtime(true),true)) . '.xls';
                            }else{
                                $savename = md5(uniqid(microtime(true),true)) . '.xlsx';
                            }
                            if (move_uploaded_file ($file['tmp_name'][$k], $saveway . $savename))
                            {
                                $arr [$m ++] = site_url () . $saveway . $savename;
                            }
                            else
                                show(0, '存储文件失败，请稍后再试');
                        }
                    }
                    else
                        show(0, '上传的文件超出限制大小,文件大小不大于' . ($size_limit / 1024 / 1024) . 'M');
                }
                else
                    show(0, '请上传正确文件格式为的excel表格。否则无法保存！当前格式为:'.$file['type'][$k]);
            }
            return empty($arr) ? show(0, 'excel文件上传失败，请稍后再试') : serialize($arr);  //返回序列化后的存储路径
        }
    }

    /*
	 * 文件上传error信息
	 */
    public function checkFileErr($file_error)
    {
        foreach ($file_error as $v)
        {
            switch ($v) {
                case 0:
                    break;
                case 1:
                    show(0, '文件大小超出了服务器的空间大小');
                    break;
                case 2:
                    show(0, '要上传的文件大小超出浏览器限制');
                    break;
                case 3:
                    show(0, '文件仅部分被上传');
                    break;
                case 4:
                    show(0, '没有找到要上传的文件');
                    break;
                case 5:
                    show(0, '服务器临时文件夹丢失');
                    break;
                case 6:
                    show(0, '文件写入到临时文件夹出错');
                    break;
                default:
                    show(0, '未知错误 ：' . $v);
                    break;
            }
        }
        return true;
    }

    /**
     * 批量删除缓存
     * @param array $cache_name  缓存名
     * @param bool $is_common  是否为公用缓存
     */
    public function delCache($cache_name = [], $is_common = false)
    {
        $uid = $is_common ? '' : $this -> uid;
        foreach ($cache_name as $v)
        {
            $res = RedisCache::del($v . $uid);
            return $res;
        }
    }
	
	/**
     *  请求服务接口，获取信息
     * @param $shopid  本地店铺ID，用以获取商家在淘宝后台的信息
     * @param $curl_args  请求参数
     * @param $top_api  淘宝开放平台对应的API名称
     */
    public function curlApi($seller_userid, $curl_args, $top_api = 'getCommodityDetail')
    {
		/**
        $accessToken_cache_name = 'top_token';
        //缓存accessToken
        if (!RedisCache::has($accessToken_cache_name) || true)
        {
            $now = date('Y-m-d H:i:s');
            $args = 'appid=' . TOP_APPID . '&secret=' . strtoupper(MD5(TOP_SECRET)) . '&timestamp=' . $now;
            $sign = strtoupper(MD5($args));
            $auth_url = 'http://top.mishion.com/api/top/apiLogin?appid=' . TOP_APPID . '&sign=' . $sign . '&timestamp=' . urlencode($now);
            $auth_infos = $this -> _curl($auth_url);  //获取accessToken
            RedisCache::set($accessToken_cache_name, $auth_infos, $auth_infos['tmpInfo'] -> data -> expireIn - 5);
        }
        $cache_value = RedisCache::get($accessToken_cache_name);
        $auth_infos = $cache_value ? $cache_value : [
            "tmpInfo：" => null,
            'curl_error' => '获取token无效',
        ];
		*/
		$getTokenUrl = 'http://aaa.698mn.com/task/getTopToken';
        $auth_infos = $this -> _curl($getTokenUrl);
        if (empty($auth_infos['curl_error']) && $auth_infos['tmpInfo'] -> code == 1)
        {
            $auth_info = $auth_infos['tmpInfo'] -> data;
            $return_data = [];
            $original_args = array_merge([
                'Pid' => TOP_APPID,
                'Key' => TOP_SECRET,
            ], $curl_args);
            $args = $this -> encryptionArgs($original_args, $auth_info -> desKey);  //入参加密
            $api_url = 'http://top.mishion.com/api/top/' . $top_api . '/' . $seller_userid . '?' . $args;
            $curl_result = $this -> _curl($api_url, $auth_info -> token);
            if (empty($curl_result['curl_error']) && $curl_result['tmpInfo'] -> code == 1)
            {
                $curl_result['tmpInfo'] -> data = json_decode($this -> decrypt($curl_result['tmpInfo'] -> data, $auth_info -> desKey));  //解密数据
            }
            return $curl_result;
        }
        else
            return $auth_infos;
    }

    public function _curl($url, $accessToken = null, $retries = 4)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        if (!empty($accessToken))
        {
            $header = [
                "Authorization: {$accessToken}",
                'Content-Type: application/json',
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);  //携带header信息
        }
        $return_data['tmpInfo'] = json_decode(curl_exec($curl)); // 执行操作
        $return_data['curl_error'] = curl_error($curl);
        while (($return_data['curl_error'] || $return_data['tmpInfo'] -> code == 0) && $retries--)  //请求有误，重试
        {
            $return_data['tmpInfo'] = json_decode(curl_exec($curl));
            $return_data['curl_error'] = curl_error($curl);
        }
        curl_close($curl); // 关闭CURL会话
        return $return_data;
    }

    /*
     * 对相关参数进行加密
     */
    public function encryptionArgs($args, $deskey)
    {
        foreach ($args as $k => &$v)
        {
            if (!in_array($k, ['fields', 'flag']))
                $v = $this->encrypt($v, $deskey);
        }
        return http_build_query($args);
    }


    /*
     * 在采用DES加密算法,cbc模式,pkcs5Padding字符填充方式下,对明文进行加密函数
     */
    public function encrypt($input, $key, $iv = 'RzysIaWR')
    {
        $size = 8; //填充块的大小,单位为bite    初始向量iv的位数要和进行pading的分组块大小相等!!!
        $input = $this -> pkcs5_pad($input, $size);  //对明文进行字符填充
        $td = mcrypt_module_open(MCRYPT_DES, '', 'cbc', '');    //MCRYPT_DES代表用DES算法加解密;'cbc'代表使用cbc模式进行加解密.
        mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);    //对$input进行加密
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);   //对加密后的密文进行base64编码
        return $data;
    }

    /*
     * 在采用DES加密算法,cbc模式,pkcs5Padding字符填充方式,对密文进行解密函数
     */

    function decrypt($crypt, $key, $iv = 'RzysIaWR')
    {
        $crypt = base64_decode($crypt);   //对加密后的密文进行解base64编码
        $td = mcrypt_module_open(MCRYPT_DES, '', 'cbc', '');    //MCRYPT_DES代表用DES算法加解密;'cbc'代表使用cbc模式进行加解密.
        mcrypt_generic_init($td, $key, $iv);
        $decrypted_data = mdecrypt_generic($td, $crypt);    //对$input进行解密
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $decrypted_data = $this -> pkcs5_unpad($decrypted_data); //对解密后的明文进行去掉字符填充
        $decrypted_data = rtrim($decrypted_data);   //去空格
        return $decrypted_data;
    }

    /*
     * 对明文进行给定块大小的字符填充
     */

    function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /*
     * 对解密后的已字符填充的明文进行去掉填充字符
     */

    function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        return substr($text, 0, -1 * $pad);
    }
}