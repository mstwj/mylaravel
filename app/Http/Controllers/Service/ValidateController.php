<?php


namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tool\ValidateCode\ValidateCode;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Models\M3Result;

class ValidateController extends Controller
{
    public function create(Request $request) {
        $valueCode = new ValidateCode;
        //底层其实已经分IP了..
        $request->session()->put('validate_code',$valueCode->getCode());
        return $valueCode->doimg();
    }

    public function sendSMS(Request $request) {


		$m3_result = new M3Result;

    	$phone = $request->input('phone','');
    	if ($phone == '') {
    		$m3_result->status = 1;
    		$m3_result->message = '手机号码不能为空';
    		return $m3_result->toJson();
    	}


    	$sendTemplateSMS = new sendTemplateSMS();
		$code = '';
    	$charset = '1234567890';
    	$_len = strlen($charset) -1;
    	for ($i = 0;$i < 6;++$i) {
    		$code .= $charset[mt_rand(0,$_len)];
    	}

	    $m3_result = $sendTemplateSMS->send($phone,array($code,60),1);

        if ($m3_result->status == 0) {
          //这里我懂了，如果你不是NEW出来的，就不是新的. 就是你搜索到的位置.
            $tempPhone = TempPhone::where('phone',$phone)->first();
            if ($tempPhone == null) {
              $tempPhone = new TempPhone;
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline = date('Y-m-d H-i-s',time() + 60*60);
            $tempPhone->save();

        }

    	return $m3_result->toJson();
    }

}
