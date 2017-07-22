<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017060807447596",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAwdd6ZFlVFoFsZlzj4fxTzIqZjYkal0tLov389bdYAhy1guCGf+CxPj4I1Dr9ztPiHcU2ZRAts/GTpqspXw4460h/2botdf96lhRK4V6qAMjO9HNklb8FqRPvc+9kFAqC16pSUS4fBtRQbKg9Kr5jrdp4U9DqxGE3j4YoLFFDbxZEXE6Ks8TuYgGpUUg3BZFVSBLaT1p6tS0b60u45pRqbGZZeyKDa+l6xF6gQvBPppw7wumFgfYb/GaDv7HbsDTo89aRcA6fOdlp6TxLTJ9/mISAw9eMsBjYeb4iG87W6PX5I447EyY5qKcAiCK0BXMC8pHO59jgi78ZGNSDYtqCFQIDAQABAoIBAEpQ+IWckjisqgicuGmduesDgFd5Jw62OWtmASObhUxaAWUJ+8bvOETqt6vWahRvu5M6Vt5sU3lXtwoBOT1OUJg0FYA+FsvUhQUhBoxdJMRkOKQT0Y5vzBXEpNtH/pCIbx2MGT8ydYbCw4rE/Z5zm/e9eMB5qmhb9Vc7Ug+boEToEzLKSvpOzYApHgz7+iJ5ivF1rKS0jvdEmlcnjCJ7glgSgp5LIr28XjDERbtzSecPLWHGz451f9Wj+OAoY+z0CKdmSoKtaOI/4kemahhCb9MWzC5qozlMfjZcA0vUBHM64lMBTqMsyKmnOGvDgYaaFsGB9pQytQIyh4Q6ttygPwkCgYEA8YOaOZ4Hv5PuW78bvYDLEQrPR1UO5rMyhmnZrJ+AHtaLqbJfEE11gPeoC8kAYALcPAoChbp2ifncFyduUojqEUBeUQNdJymBMlGxV/M1J+b3szisSidOPuqHxm0p6M/gqbnvYsZgCVesxI/P9Agn/LonrOcBK7S5xU1+R2jPaq8CgYEAzXfgamMsyo8qFSpkUUTVdB2h0W4l9wsNFzByZtBNuv4I3/0dgb2wuKRSGC14ojPOdllkWMEHKGxsUlj1gp56xiQ/mosjQqNWrveIfM7DSeHwk90Ol7uDbUqPFZs2GFkIs4HKrh0tv3EniECp1FMqu5pR9udWZnByOf0oMNuBwHsCgYBVwdw2j1XDAh1GOLL59Eym7YaylpJm+sR7FAT2FeDhkl8fT7YPzOFnfQkPvjzC2uEm9Ir2v0IuNimfkyHKbtFmdMvIyn/+Uu+MVZO6XiLG222jFwGehxxynMa/f628/GuS+PH2yef6CUbQuRwnU+oXBGboL1KsGU1JsP2hD6dvAwKBgQCfw5m1P55hdsajJI5SfvJ20l+z6DEPEgHAyUP7W/dE8ijWegtKicPzHppTAHBvt1bPwZx8QsOdFAl6Un+8bBxNG3x1X8EwHK/XZtQzL9a8CTo2z0l8hCqifboac9CxR/GzGrYNgtTCqmqx0I39chmlPE6FbMZK6x52prlsnBIdJwKBgBR3kG9LssNP49QZbwHg2kfOjlU/nYzxikU1HKLxQGF5EmuUkyehdaLi2RofKZXJSlgnj1DPsk/rA+NzkVJUYLgEtJ37oh3t8FtIQdgpJ/uww5y2k9bW0OH2TBaZisaMEptnlDTG5g4t33UyJ3Wja86xoP6HzcJDDotILZ5zrXuL",
		
		//异步通知地址
		'notify_url' => "http://qft.pluscar.cn/home/AliPay/aliNotify",
		
		//同步跳转
		'return_url' => "http://qft.pluscar.cn/",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAztwyzL5gFFmUHWlAUunoPI26a84F9JLeKvuDUdC63cXyqPMt2gjoJyM4RqlIQa+BJdvy8ZQ4VIuJzMfr8obHiP4XNBcwzGC/UITPKve0FWt+D7NkrgUH/ZkEUwHxN9yyOfk6W0aMoqTzZ7+0xYbbe3OQgdBQY/4/fGnVqWcrpa3JUl3JdPjEde/PCYAlF0EAUpBw8ml3Z3zcvN7ZX3eB1yfhcmc6kO18XUzhjQzAU+LI+s85xV3Kd7FFEWrrxQgmVV3EsWl1+i36/CJYYKwm78YFA7GeTZScRM6r8DAaDjdwC+vHO5n53yDtpf7yYm4suqfnpsJ/J+FvqD6RGrlrMwIDAQAB",
);