<?php
/**
 * 阿里大于短信验证码
 *
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/25 025
 * Time: 23:48
 */

namespace Yjc\Sms;

use Yjc\Sms\Alidayu\App;
use Yjc\Sms\Alidayu\Client;
use Yjc\Sms\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;

class AliSms implements SmsInterface
{

    // 配置信息
    private $config = [
        'app_key'    => '*****',
        'app_secret' => '************',
    ];

    public function __construct()
    {

    }

    /**
     * 发送内容短信
     * @param $mobile
     * @param $content 短信内容
     * @return mixed
     */
    public function sendNormal($mobile, $content)
    {
        return false;
    }

    /**
     * 发送模板短信
     * @param $mobile
     * @param $temp_id
     * @return mixed
     */
    public function send($mobile, $temp_id, $params = '', $sign_name = '')
    {
        $client = new Client(new App($this->config));
        $req    = new AlibabaAliqinFcSmsNumSend();

        $req->setRecNum($mobile)
            ->setSmsParam($params)
            ->setSmsFreeSignName($sign_name)
            ->setSmsTemplateCode($temp_id);

        return $client->execute($req);
    }

    /**
     * 发送语音短信
     * @param $mobile
     * @return mixed
     */
    public function sendVoice($mobile, $vcode)
    {
        return false;
    }
}