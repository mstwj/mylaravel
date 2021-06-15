<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Models\M3Result;

class BookController extends Controller
{
  public function getCategoryByParentId($parent_id)
  {
    //如果是数据库查询的结果，LAARVEL 自动JSON结果返回.
    $categorys = Category::where('parent_id',$parent_id)->get();

    $m3_reusult = new M3Result;
    $m3_reusult->status = 0;
    $m3_reusult->message = '成功';
    $m3_reusult->categorys = $categorys;

    return $m3_reusult->toJson();
  }

}
