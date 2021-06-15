<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\M3Result;
use App\Entity\Member;
use App\Entity\TempPhone;

class MemberController extends Controller
{
  public function register(Request $request)
  {
    $email = $request->input('email', '');
    $phone = $request->input('phone', '');
    $password = $request->input('password', '');
    $confirm = $request->input('confirm', '');
    $phone_code = $request->input('phone_code', '');
    $validate_code = $request->input('validate_code', '');

    $m3_result = new M3Result;

    if($email == '' && $phone == '') {
      $m3_result->status = 1;
      $m3_result->message = '手机号或邮箱不能为空';
      return $m3_result->toJson();
    }
    if($password == '' || strlen($password) < 6) {
      $m3_result->status = 2;
      $m3_result->message = '密码不少于6位';
      return $m3_result->toJson();
    }
    if($confirm == '' || strlen($confirm) < 6) {
      $m3_result->status = 3;
      $m3_result->message = '确认密码不少于6位';
      return $m3_result->toJson();
    }
    if($password != $confirm) {
      $m3_result->status = 4;
      $m3_result->message = '两次密码不相同';
      return $m3_result->toJson();
    }

    // 手机号注册
    if($phone != '') {
      if($phone_code == '' || strlen($phone_code) != 6) {
        $m3_result->status = 5;
        $m3_result->message = '手机验证码为6位';
        return $m3_result->toJson();
      }
      //注意，这里如果查不到就是一个空了..--这里注意
      //这里放回的是第一个注册的数值，不是现在刚刚的.
      $tempPhone = TempPhone::where('phone', $phone)->first();

      if($tempPhone->code == $phone_code) {
      	//判断当前时间是不是大于传过来的时间.
        //数据库读取的是一个时间字符串，这里TIME是一个时间戳.
        if(time() > strtotime($tempPhone->deadline)) {
          $m3_result->status = 7;
          $m3_result->message = '手机验证码过期';
          return $m3_result->toJson();
        }


        $test = TempMember::where('id', '1')->first();

        $member = new TempMember;
        $member->phone = $phone;
        //$member->password = md5('bk' + $password);--妈的，坑的的东西，害老子-下载新的
        //工具，害老子，重新下载WALP，害老子使用新的工具，害老子5个小时.
        $member->password = $password;
        $member->save();

        $m3_result->status = 0;
        $m3_result->message = '注册成功';
        return $m3_result->toJson();

      } else {
        $m3_result->status = 7;
        $m3_result->message = '手机验证码不正确';
        return $m3_result->toJson();
      }

    // 邮箱注册
    }
    /*
    else {

       if($validate_code == '' || strlen($validate_code) != 4) {
         $m3_result->status = 6;
         $m3_result->message = '验证码为4位';
         return $m3_result->toJson();
       }
        //如果使用LARAVEL框架就不要使用其他方法去取，因为框架会加密.
         $validate_code_session = $request->session()->get('validate_code', '');
       if($validate_code_session != $validate_code) {
         $m3_result->status = 8;
         $m3_result->message = '验证码不正确';
         return $m3_result->toJson();
       }

       //果然，这里他掉了一个字段.email... 坑呀.
       $member = new Member;
       $member->email = $email;
       //$member->password = md5('bk' + $password);
       $member->password = $password;
       $member->save();

    //   $uuid = UUID::create();

    //   $m3_email = new M3Email;
    //   $m3_email->to = $email;
    //   $m3_email->cc = 'magina@speakez.cn';
    //   $m3_email->subject = '凯恩书店验证';
    //   $m3_email->content = '请于24小时点击该链接完成验证. http://book.magina.com/service/validate_email'
    //                     . '?member_id=' . $member->id
    //                     . '&code=' . $uuid;

    //   $tempEmail = new TempEmail;
    //   $tempEmail->member_id = $member->id;
    //   $tempEmail->code = $uuid;
    //   $tempEmail->deadline = date('Y-m-d H-i-s', time() + 24*60*60);
    //   $tempEmail->save();

       //Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
            //$m->from('hello@app.com', 'Your Application');
           //$m->to($m3_email->to, '尊敬的用户')
             //->cc($m3_email->cc)
             //->subject($m3_email->subject);
       //});

       $m3_result->status = 0;
       $m3_result->message = '注册成功';
       return $m3_result->toJson();
     }
    */

  }

  public function login(Request $request) {

    $username = $request->get('username','');
    $password = $request->get('password','');
    $validate_code= $request->get('validate_code','');

    $m3_result = new M3Result;

    $validate_code_seesion = $request->session()->get('validate_code');

    
    //echo $validate_code;
    //echo $validate_code_seesion;

    if ($validate_code_seesion != $validate_code) {
        $m3_result->status = 1;
        $m3_result->message = '验证码错误了';
        return $m3_result->toJson(); //进行JSON编码.
    }

    if (strpos($username,'@') == true)
    {
      //如果是邮箱.
      $member = Member::where('email',$username)->first();
    } else {
      $member = Member::where('phone',$username)->first();
    }

    if ($member == null) {
      $m3_result->status = 1;
      $m3_result->message = '用户不存在';
      return $m3_result->toJson(); //进行JSON编码.
    } else {
      if ($password != $member->password) {
        $m3_result->status = 1;
        $m3_result->message = '密码错误';
        return $m3_result->toJson(); //进行JSON编码.
      }

      $request->session()->put('member',$member);

      $m3_result->status = 0;
      $m3_result->message = '登入成功';
      return $m3_result->toJson(); //进行JSON编码.
    }
  }

}
