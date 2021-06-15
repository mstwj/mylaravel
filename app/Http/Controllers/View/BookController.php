<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\Product;
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

  public function toPdtContent($product_id)
  {
    $product = Product::find($product_id);
    $pdt_content = PdtContent::where('product_id',$product_id)->first();
    return view('pdt_content')->with('product',$product)
                              ->with('pdt_content',$pdt_content);

  }

}
