<?php
/**
 * Created by PhpStorm.
 * @author: YJC
 * @date: 2016/9/21
 */

namespace Yjc\Sms;


interface SmsInterface
{

    /**
     * 发送内容短信
     * @param $mobile
     * @param $content 短信内容
     * @return mixed
     */
    public function sendNormal($mobile, $content);

    /**
     * 发送模板短信
     * @param $mobile
     * @param $temp_id
     * @return mixed
     */
    public function send($mobile, $temp_id, $params = '');

    /**
     * 发送语音短信
     * @param $mobile
     * @return mixed
     */
    public function sendVoice($mobile, $vcode);

}