<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Sys_model extends CI_Model{	
    
    public function upFile($filename){
		//return $filename;
        $config['upload_path'] = "./uploads/".@date("Y")."/".@date("m");
        if(!file_exists("./uploads/".@date("Y")."/".@date("m")))//检查文件夹中有没有月份这个文件夹
	    {
	         mkdir("./uploads/".@date("Y")."/".@date("m"),0777,true);//创建月份的文件夹
	    }          
	    $config['allowed_types'] = 'doc|docx|xlsx|xl|xls|pdf|rar|7zip|gzip|gz|zip|gif|jpg|png';
		$config['max_size'] = '2048';			
		$config['file_name']  = uniqid();
		$this->load->library('Upload', $config);
		if ($this->upload->do_upload($filename))
		{		
			$fileinfo = $this->upload->data();
			$large_img = $config['upload_path']."/".$fileinfo['file_name'];
			return $large_img;
		}else 
		{
			 return  null;
		}
	}
	
	

	// 需要开启php.ini   extension=php_openssl     windows系统操作
	
	public function get_mobile_area($mobile){// 注释的是 用淘宝的返回数据为json 不过没有城市
	    
	     $sms = array('province'=>'', 'city'=>'');    //初始化变量
	     
	    //根据淘宝的数据库调用返回值
	    // $url = "http://tcc.taobao.com/cc/json/mobile_tel_segment.htm?tel=".$mobile;
	   // $url = "http://life.tenpay.com/cgi-bin/mobile/MobileQueryAttribution.cgi?chgmobile=".$mobile;
	    
	    //https://www.baifubao.com/callback?cmd=1059&callback=phone&phone=13144820030
	    
	    /*
	     $content = file_get_contents($url);
	     $sms['province'] = substr($content, "56", "4");  //截取字符串
	     $sms['supplier'] = substr($content, "81", "4");
	     return $sms;
	    	*/
	 /*    $xml='';
	    $f = fopen($url, 'r');
	    while( $data = fread( $f, 4096 ) ) {
	        $xml .= $data;
	    }
	    fclose( $f );
	    // 上面读取数据
	    preg_match_all( "/\<root\>(.*?)\<\/root\>/s", $xml, $root ); //匹配最外层标签里面的内容
	    foreach( $root[1] as $k=>$human )
	    {
	        preg_match_all( "/\<city\>(.*?)\<\/city\>/", $human, $city ); //匹配出chengshi
	        preg_match_all( "/\<province\>(.*?)\<\/province\>/", $human, $province ); //匹配出shengfeng
	        preg_match_all( "/\<supplier\>(.*?)\<\/supplier\>/", $human, $supplier ); //匹配出yunyinshang
	    }
	    foreach($city[1] as $key=>$val){
	        $sms['province'] = trim(iconv("GB2312","UTF-8",$val));//城市
	    }
	    foreach($province[1] as $key=>$val){
	        $sms['city'] = trim(iconv("GB2312","UTF-8",$val));//省份
	    } */
	    
	    // new moblie  get area 
	    $url = 'http://sj.apidata.cn/?mobile='.$mobile;
	    $json = file_get_contents($url);	    
	    $json = json_decode($json);
	    $sms['province'] =  $json->data->city;
	    $sms['city'] =  $json->data->province;
	    	    
	    return $sms;
	}
	// 以下是IP 地址操作
	
	public function GetIp(){
	    $realip = '';
	    $unknown = 'unknown';
	    if (isset($_SERVER)){
	        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
	            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	            foreach($arr as $ip){
	                $ip = trim($ip);
	                if ($ip != 'unknown'){
	                    $realip = $ip;
	                    break;
	                }
	            }
	        }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
	            $realip = $_SERVER['HTTP_CLIENT_IP'];
	        }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
	            $realip = $_SERVER['REMOTE_ADDR'];
	        }else{
	            $realip = $unknown;
	        }
	    }else{
	        if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
	            $realip = getenv("HTTP_X_FORWARDED_FOR");
	        }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
	            $realip = getenv("HTTP_CLIENT_IP");
	        }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
	            $realip = getenv("REMOTE_ADDR");
	        }else{
	            $realip = $unknown;
	        }
	    }
	    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
	    return $realip;
	}
	
	public function GetIpLookup($ip = ''){
	    if(empty($ip)){
	        $ip = GetIp();
	    }
	    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
	    if(empty($res)){ return false; }
	    $jsonMatches = array();
	    preg_match('#\{.+?\}#', $res, $jsonMatches);
	    if(!isset($jsonMatches[0])){ return false; }
	    $json = json_decode($jsonMatches[0], true);
	    if(isset($json['ret']) && $json['ret'] == 1){
	        $json['ip'] = $ip;
	        unset($json['ret']);
	    }else{
	        return false;
	    }
	    return $json;
	}
	
}