<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\Product;
use Illuminate\Http\Request;
use Log;

class BookController extends Controller
{
  public function toCategory($value='')
  {
    Log::info("进入书籍");
    $categorys = Category::whereNull('parent_id')->get();
    return view('category')->with('categorys',$categorys);
  }

  public function Product($category_id)
  {
    $product = Product::where('category_id',$category_id)->get();
    return view('product')->with('products',$product);
  }

  public function toPdtContent(Request $request,$product_id)
  {

    $bk_cart = $request->cookie('bk_cart');
    $bk_cart_arr = $bk_cart != null ? explode(',',$bk_cart) : array();
    $count = 0;
    //这里必须传应用，因为，这是一个灿亮，不是一个对象.
    foreach ($bk_cart_arr as $value) {
      $index = strpos($value,':');
      if (substr($value,0,$index) == $product_id) {
        $count = (int)substr($value,$index+1);
        break;
      }
    }




    $product = Product::find($product_id);
    $pdt_content = PdtContent::where('product_id',$product_id)->first();
    return view('pdt_content')->with('product',$product)
                              ->with('pdt_content',$pdt_content)
                              ->with('count',$count );




  }

}
