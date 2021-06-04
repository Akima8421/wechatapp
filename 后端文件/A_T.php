<?php
        function request_post ($url = '',$param = ''){
                if (empty($url) || empty($param)) {
                    return false;
                }
                $postUrl = $url;
                $curlPost = $param;
                $curl = curl_init() ;//初始化cur1
                curl_setopt ($curl, CURLOPT_URL, $postUrl);//抓取指定网页
                curl_setopt ($curl, CURLOPT_HEADER, 0);// 设置header
                curl_setopt ($curl,CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上//
                curl_setopt ($curl, CURLOPT_POST, 1) ;//post提交方式
                curl_setopt ($curl, CURLOPT_POSTFIELDS, $curlPost) ;
                curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, false) ;
                $data = curl_exec ($curl) ;//运行curl
                curl_close ($curl) ;
                return $data;
            }
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx174cbe7ce426d805&secret=3215c6400b9d0b99a8e77423d3e2498d' ;
        $res = request_post($url,$url);
        echo $res ;

