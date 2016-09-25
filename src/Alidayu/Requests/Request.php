<?php
namespace Yjc\Sms\Alidayu\Requests;

/**
 * 阿里大于 - 请求基类
 *
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/25 025
 * Time: 23:48
 */
abstract class Request implements IRequest
{
    /**
     * 接口名称
     * @var string
     */
    protected $method;

    /**
     * 接口请求参数
     * @var array
     */
    protected $params = [];

    /**
     * 获取接口名称
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 获取请求参数
     * @return [type] [description]
     */
    public function getParams()
    {
        return $this->params;
    }
}
