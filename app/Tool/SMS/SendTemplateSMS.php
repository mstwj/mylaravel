<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */

namespace App\Tool\SMS;

include_once("SmsSDK.php");

use App\Models\M3Result;

class SendTemplateSMS {

  public function send($to, $datas, $tempId) {
    return sendSMS($to, $datas, $tempId);
  }
}

/**
 * 发送模板短信
 * @param to 手机号码集合,用英文逗号分开
 * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
 * @param $tempId 模板Id
 */
function sendSMS($to, $datas, $tempId)
{

    $ms3_result = new M3Result;

    //主帐号
    $accountSid = '8aaf070879f030fc0179fbce43dc0488';
    //主帐号Token
    $accountToken = '0eb7541612134a3bb192c2be88b1bfa8';
    //应用Id
    $appId = '8aaf070879f030fc0179fbce44ba048f';
    //请求地址，格式如下，不需要写https://
    $serverIP = 'app.cloopen.com';
    //请求端口
    $serverPort = '8883';
    //REST版本号
    $softVersion = '2013-12-26';
    // 初始化REST SDK
    $rest = new REST($serverIP, $serverPort, $softVersion);
    $rest->setAccount($accountSid, $accountToken);
    $rest->setAppId($appId);

    // 发送模板短信
    //echo "Sending TemplateSMS to $to <br/>";
    $result = $rest->sendTemplateSMS($to, $datas, $tempId);
    if ($result == NULL) {
        $ms3_result->status = 3;
        $ms3_result->message = 'result error!';
    }
    if ($result->statusCode != 0) {
        $ms3_result->status = $result->statusCode;
        $ms3_result->message = $result->statusMsg;
        //TODO 添加错误处理逻辑
    } else {
        $ms3_result->status = 0;
        $ms3_result->message = '发送成功';
        //echo "Sendind TemplateSMS success!<br/>";
        // 获取返回信息
        //$smsmessage = $result->TemplateSMS;
        //echo "dateCreated:" . $smsmessage->dateCreated . "<br/>";
        //echo "smsMessageSid:" . $smsmessage->smsMessageSid . "<br/>";
        //TODO 添加成功处理逻辑
    }
    return $ms3_result;
}

//Demo调用,参数填入正确后，放开注释可以调用
//sendTemplateSMS("手机号码","内容数据","模板Id");
?>
