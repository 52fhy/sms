# sms
云之讯等短信接口SDK汇聚

将常用的各大验证码短信提供商的接口汇聚在一起，方便实际应用。会不断完善补充。

## 安装
推荐使用`composer`安装：
```
composer require yjc/sms
```

或者在composer.json里追加：
```
"require": {
	"yjc/sms": "1.0"
},
```

然后在命令行执行自动加载的更新：
```
composer dump-autoload
```

## 使用示例
首先需要到各大提供商注册并审核。然后进行配置。

极光验证码：
``` php
$sms = new \Yjc\Sms\Jsms('appkey', 'masterkey');
$sms->send('13482827633', 'temp_id');
```
可以在SDK里配置appkey和masterkey，也可以代码里实时配置。

云之讯：
``` php
$sms = new \Yjc\Sms\Ucpaas('token', 'appid', 'accountsid');
$sms->send('13482827633', 'temp_id');
```



