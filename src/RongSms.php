<?php
/**
 * Created by PhpStorm.
 * User: YJC
 * Date: 2016/9/26 026
 * Time: 0:07
 */

namespace Yjc\Sms;
use Yjc\Sms\Ronglian\CCPRest;

class RongSms implements SmsInterface
{

    /**
     * 容联云通讯配置
     * @author YJC 2015-3-20 14:53:34
     * @link http://www.yuntongxun.com/
     */
    private static $yun= array(
        'accountSid'=> '',	//主帐号
        'accountToken'=> '',	//主帐号Token
        'serverIP'=>'app.cloopen.com',	//请求地址，格式如下，不需要写https://
        'serverPort'=>'8883',//请求端口
        'softVersion'=>'2013-12-26',		//REST版本号
        'appid' => '',   //应用id
    );

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
    public function send($mobile, $temp_id, $params = '')
    {
        //主帐号
        $accountSid = self::$yun['accountSid'];

        //主帐号Token
        $accountToken = self::$yun['accountToken'];

        //应用Id
        $appId = self::$yun['appid'];

        //请求地址，格式如下，不需要写https://
        $serverIP = self::$yun['serverIP'];

        //请求端口
        $serverPort = self::$yun['serverPort'];

        //REST版本号
        $softVersion = self::$yun['softVersion'];

        if(is_array($mobile)){
            $mobile= implode(',', $mobile);
        }

        $rest = new CCPRest($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        $result = $rest->sendTemplateSMS($mobile, $params, $temp_id);
        if($result == NULL ) {
            return false;
        }

        if($result->statusCode!=0) {
            //echo "error code :" . $result->statusCode . "<br>";
            //echo "error msg :" . $result->statusMsg . "<br>";
            $msg = $mobile .':'.json_encode($params). '---' . 'error code :' . $result->statusCode.'---' .'error msg :' . $result->statusMsg;
            //Logger::writeSMSLog($msg);
        }

        return ($result->statusCode == 0) ? TRUE : FALSE;
    }

    /**
     * 发送语音短信
     * @param $mobile
     * @return mixed
     */
    public function sendVoice($mobile, $vcode)
    {
        //主帐号
        $accountSid = self::$yun['accountSid'];

        //主帐号Token
        $accountToken = self::$yun['accountToken'];

        //应用Id
        $appId = self::$yun['appid'];

        //请求地址，格式如下，不需要写https://
        $serverIP = self::$yun['serverIP'];

        //请求端口
        $serverPort = self::$yun['serverPort'];

        //REST版本号
        $softVersion = self::$yun['softVersion'];

        $rest = new CCPRest($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        $result = $rest->voiceVerify($vcode, 2, $mobile, '', '');
        if($result == NULL ) {
            return false;
        }

        if($result->statusCode!=0) {
            //echo "error code :" . $result->statusCode . "<br>";
            //echo "error msg :" . $result->statusMsg . "<br>";
            $msg = $mobile .':'.$vcode. '---' . 'error code :' . $result->statusCode.'---' .'error msg :' . $result->statusMsg;
            //Logger::writeSMSLog($msg);
        }

        return ($result->statusCode == 0) ? TRUE : FALSE;
    }

    /**
     * 融联云通讯查询余额
     * @date: 2015-3-19 12:45:36
     * @author: YJC
     */
    public static function checkBalance(){
        //主帐号
        $accountSid = self::$yun['accountSid'];

        //主帐号Token
        $accountToken = self::$yun['accountToken'];

        //应用Id
        $appId = self::$yun['appid'];

        //请求地址，格式如下，不需要写https://
        $serverIP = self::$yun['serverIP'];

        //请求端口
        $serverPort = self::$yun['serverPort'];

        //REST版本号
        $softVersion = self::$yun['softVersion'];

        $rest = new CCPRest($serverIP,$serverPort,$softVersion);
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);

        $result = $rest->queryAccountInfo();

        if($result == NULL ) {
            return 0;
        }
        if($result->statusCode!= 0) {
            //echo "error code :" . $result->statusCode . "<br>";
            //echo "error msg :" . $result->statusMsg . "<br>";
            return 'ERROR';
        }

        return intval($result->Account->balance);
    }
}