<?php

namespace Yjc\Sms;
use \Exception;

/**
 * 极光验证码
 * Created by PhpStorm.
 * @author: YJC
 * @date: 2016/9/21
 *
 * @link http://docs.jiguang.cn/jsms/server/rest_api_jsms/
 */
class Jsms implements SmsInterface
{

    private $appkey;
    private $masterkey;
    private $url = 'https://api.sms.jpush.cn';

    public function __construct($appkey = '', $masterkey = '')
    {
        if($appkey) $this->appkey = $appkey;
        if($masterkey) $this->masterkey = $masterkey;

        if (empty ($this->appkey) || empty ($this->masterkey)) {
            throw new Exception('invalid appkey or masterkey');
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
     * @param int $mobile
     * @param string $temp_id
     * @return mixed
     *  发送成功示例 {"msg_id":"f847dabd-48c1-4f9f-809f-ac3bfd86f57f"}
     *  发送失败示例 {"error":{"code":50013,"message":"invalid temp_id"}}
     */
    public function send($mobile, $temp_id, $params = '')
    {
        $url = $this->url . "/v1/codes";
        $options = array(
            "mobile" => $mobile, //版本号
            "temp_id" => $temp_id,  //模板ID
        );
        $result = $this->postCurl($url, $options);
        return $result;
    }

    /**
     * 发送语音短信
     * @param $mobile
     * @param $temp_id
     * @return mixed
     */
    public function sendVoice($mobile, $temp_id)
    {
        return false;
    }

    /**
     * 获取HTTP HEADER
     */
    private function getHttpAuthHeader($header = array())
    {
        $basic = base64_encode($this->appkey . ":" . $this->masterkey);
        $header_array = array();
        $header_array[] = "Authorization: Basic " . $basic;
        $header_array[] = "Content-type: application/json; charset=utf-8";
        if (!empty($header)) {
            return array_merge($header_array, $header);
        }
        return $header_array;
    }
    /**
     * CURL Post
     */
    private function postCurl($url, $option, $header = array(), $type = 'POST')
    {
        $header = $this->getHttpAuthHeader($header);
        $ssl = stripos($url, 'https://') === 0 ? true : false;
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //在HTTP请求中包含一个"User-Agent: "头的字符串。
        curl_setopt($curl, CURLOPT_HEADER, 0); //启用时会将头文件的信息作为数据流输出。
        if (!empty ($option)) {
            $options = json_encode($option);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $options); // Post提交的数据包
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        if (!empty($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // 设置HTTP头
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $type);
        $result = curl_exec($curl); // 执行操作
        $res['status'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $res = json_decode($result, true);
        /*   if(empty($res)){
               $res['result'] = $result;
           }*/
        curl_close($curl); // 关闭CURL会话
        return $res;
    }
}