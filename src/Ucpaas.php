<?php
/**
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/25 025
 * Time: 17:11
 */

namespace Yjc\Sms;
use \Exception;
use \Yjc\Sms\Ucpaas\Ucpaas as UcpaasProvider;

class Ucpaas implements SmsInterface
{

    /**
     * 云之讯配置
     * @author YJC 2015-11-8 21:34:47
     *
     * @link http://www.ucpaas.com/
     */
    private static $ucpaas = array(
        'accountsid' => '', //在控制台首页
        'token' => '',
        'appid' => '', //应用id,请登录http://www.ucpaas.com/app/appManager查看:应用管理->应用列表
        'vcode_temp' => '',  //短信验证码模板ID
    );

    public function __construct($token = '', $appid = '', $accountsid = '')
    {
        if($token) $this->token = $token;
        if($appid) $this->appid = $appid;
        if($accountsid) $this->accountsid = $accountsid;

        if (empty ($this->token) || empty ($this->appid) || empty($this->accountsid)) {
            throw new Exception('invalid config');
        }
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
    public function send($mobile, $temp_id, $params = array())
    {
        $ucpass = new UcpaasProvider(self::$ucpaas);

        $appId = self::$ucpaas['appid']; //应用id

        if (is_array($mobile)) {
            $tel = implode(',', $mobile);
        }

        $param = implode(',', $params);

        $res = $ucpass->templateSMS($appId, $mobile, $temp_id, $param);

        $res = json_decode($res, true);
        $errcode = $res['resp']['respCode'];
        if ($errcode !== '000000') {
            $msg = $mobile . ':' . json_encode($params) . '---' . 'errcode:'. $errcode;
            $this->writeLog($msg);
        }

        return ($errcode === '000000') ? TRUE : FALSE;
    }

    /**
     * 发送语音短信
     * @param $mobile
     * @return mixed
     */
    public function sendVoice($mobile, $vcode)
    {
        $ucpass = new UcpaasProvider(self::$ucpaas);

        $appId = self::$ucpaas['appid'];
        $to = $mobile;
        $verifyCode = $vcode;
        $res = $ucpass->voiceCode($appId, $verifyCode, $to);

        $res = json_decode($res, true);
        $errcode = $res['resp']['respCode'];

        if ($errcode !== '000000') {
            $msg = $mobile . ':' . $vcode . '---' . 'errcode:'. $errcode;
            $this->writeLog($msg);
        }

        return ($errcode === '000000') ? TRUE : FALSE;
    }

    /**
     * 发送验证码
     * @param $mobile
     * @param $vcode
     * @param string $vaild_time
     * @return bool
     * @throws Ucpaas\Exception
     */
    public function sendVcode($mobile, $vcode, $vaild_time = '30'){
        //初始化 $options必填
        $ucpass = new UcpaasProvider(self::$ucpaas);

        $appId = self::$ucpaas['appid'];
        $to = $mobile;
        $templateId = self::$ucpaas['vcode_temp'];//模板ID
        $param = "{$vcode},{$vaild_time}";
        $res = $ucpass->templateSMS($appId, $to, $templateId, $param);

        $res = json_decode($res, true);
        $errcode = $res['resp']['respCode'];

        if ($errcode !== '000000') {
            $msg = $mobile . ':' . $vcode . '---' . 'errcode:'. $errcode;
            $this->writeLog($msg);
        }

        return ($errcode === '000000') ? TRUE : FALSE;
    }

    private function writeLog($msg){
        $file = 'log/ucpaas.log';
        //return @error_log($msg, 3, $file);
    }
}