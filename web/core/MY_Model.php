<?php
/**
 * Created by PhpStorm.
 * User: 81237
 * Date: 2018/3/31
 * Time: 9:21
 */

class  MY_Model extends  CI_Model
{
    protected $uid;
    public function __construct()
    {
        parent::__construct();
        $this -> uid = $this-> session -> userdata('sellerid');
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
        if (!RedisCache::has($cache_name))
        {
            $result = $this -> db -> query($sql) -> $action();
            RedisCache::set($cache_name, $result, $expire);  //缓存15分钟
        }
        return RedisCache::get($cache_name);
    }

}