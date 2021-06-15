<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Entity\TempMember;
use App\Entity\TempPhone;
use App\Good;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
  public function test()
  {
    //以下是OK的..
    $TempGood = new Good;
    $TempGood->name = '111';
    $TempGood->save();

    $member = new TempMember;
    $member->phone = '15272596066';
    //$member->password = md5('bk' + $password);
    $member->password = '111111';
    $member->save();

    //var_dump($TempGood);

    //$member->phone = '1111111111';
    //$password = '1111111111';
    //$member->password = md5('bk' + $password);
    //$member->save();



    //$TempPhone = new TempMember;
    //var_dump($TempPhone);

    //$Good = new Good;
    //var_dump($Good);


  }
}
