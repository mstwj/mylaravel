@extends('master')

@section('title',$product->name)

@section('content')



<div class="weui_cells_title">
  <span calss="bk_title">{{$product->name}}</span>
  <span class="bk_price" style="float:right;">{{$product->price}}</span>
</div>

<div class="weui_cells">
  <div class="weui_cell">
    <p class="bk_summary">{{$product->summary}}</p>
  </div>
</div>

<div class="weui_cells_title">详细介绍</div>
<div class="weui_cells">
  <div class="weui_cell">

      {!!$pdt_content->content!!}

  </div>
</div>



<div class="bk_fix_bottom">
  <div class="bk_half_area">
    <button class="weui_btn weui_btn_primary" onclick="_addCart();">加入购物车</button>
  </div>

  <div class="bk_half_area">
    <button class="weui_btn weui_btn_default">结算(<span id="cart_num" class="m3_price"></span>)
  </div>
</div>


@endsection

@section('my-js')

@endsection
