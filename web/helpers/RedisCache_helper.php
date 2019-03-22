<?php
/**
 * Redis缓存类
 * Created by PhpStorm.
 * User: 81237
 * Date: 2018/3/29
 * Time: 13:11
 */

class RedisCache
{
    private static $instance;  //静态私有的对象保存该类对象

    /*
     * 私有化构造函数，防止类外实例化
     */
    private function __construct()
    {
        self::getinstance();
    }

    /*
     * 获取单例模式下的实例化对象
     */
    private static function getinstance()
    {
        if (!self::$instance instanceof Redis)   //如果没有对象实例化Redis，并主动实例化并返回
        {
            self::$instance = new \Redis();
            self::$instance -> connect('180.76.190.150', 6379);
			self::$instance -> select(1);
        }
        return self::$instance;
    }

    /*
     * 私有化克路函数，防止对象被clone
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 设置字符串缓存
     * @param $key  键名
     * @param $value  缓存值
     * @param int $expire   过期时间，默认为永久
     * @return mixed
     */
    public static function set($key, $value, $expire = 0)
    {
        self::getinstance();
        if (is_array($value) || is_object($value))  //序列数组/对象存储
            $value = serialize($value);
        return self::$instance -> set($key, $value, $expire);
    }

    /**
     * 根据键名获取缓存值
     * @param $key  键名
     * @return mixed
     */
    public static function get($key)
    {
        self::getinstance();
        $value = self::$instance -> get($key);
        $value_arr =  @unserialize($value);
        return is_array($value_arr) || is_object($value_arr) ? $value_arr : $value;
    }

    /**
     * 指定键是否存在
     * @param $key  指定键名
     * @return mixed
     */
    public static function has($key)
    {
        self::getinstance();
        return self::$instance -> exists($key);
    }

    /**
     * 若指定键不存在，则创建这个缓存
     * @param $key
     * @param $value
     */
    public static function setnx($key, $value, $expire)
    {
        self::getinstance();
        self::$instance -> multi();   //Multi/Exec 包裹起来以确保请求的原子性
        self::$instance -> setnx($key, $value);
        self::$instance -> expire($key, $expire);
        return self::$instance -> exec();
    }

    /**
     * 删除指定缓存
     * @param $key  缓存键名
     * @return mixed
     */
    public static function del($key)
    {
        self::getinstance();
        return self::$instance -> delete($key);
    }
}