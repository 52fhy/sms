<?php
namespace Yjc\Sms\Alidayu\Requests;

/**
 * 阿里大于 - 请求接口类
 *
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/25 025
 * Time: 23:48
 */
Interface IRequest
{
    /**
     * 获取接口名称
     * @return string
     */
    public function getMethod();

    /**
     * 获取请求参数
     * @return array 
     */
    public function getParams();
}
