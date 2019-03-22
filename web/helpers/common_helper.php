<?php
/**
 * Created by PhpStorm.
 * User: 81237
 * Date: 2018/3/30
 * Time: 15:54
 */

/**
 * ajax返回数据
 * @param string $status  状态码
 * @param array|string $message  状态信息
 * @param array $data  携带数据
 */
function show($status, $message = '', $data = [])
{
    exit(json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ]));
}
