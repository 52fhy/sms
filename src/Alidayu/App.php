<?php
namespace Yjc\Sms\Alidayu;

/**
 * 阿里大于 - APP配置信息
 *
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/25 025
 * Time: 23:48
 */
class App
{
    /**
     * App Key
     * @var string
     */
    public $app_key;

    /**
     * App Secret
     * @var string
     */
    public $app_secret;

    /**
     * 初始化
     * @param array $config 阿里大于配置
     */
    public function __construct($config = [])
    {
        if (array_key_exists('app_key', $config))
            $this->app_key = $config['app_key'];

        if (array_key_exists('app_secret', $config))
            $this->app_secret = $config['app_secret'];
    }

    /**
     * 设置app_key
     * @param string $value app_key
     */
    public function setAppKey($value)
    {
        $this->app_key = $value;

        return $this;
    }

    /**
     * 设置app_secret
     * @param string $value app_key
     */
    public function setAppSecret($value)
    {
        $this->app_secret = $value;

        return $this;
    }
}
