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
    <button class="weui_btn weui_btn_default">结算(<span id="cart_num" class="m3_price">{{$count}}</span>)
  </div>
</div>

@endsection

@section('my-js')
<script type="text/javascript">
  function _addCart() {

    //如果JS报错，前面的都不能使用了..就都错了.
    var product_id = "{{$product->id}}";
    $.ajax({
      type: "GET",
      url: '/service/cart/add/' + product_id,
      dataType: 'json',
      cache: false,
      success: function(data) {
        if(data == null) {
          console.log(data);
          $('.bk_toptips').show();
          $('.bk_toptips span').html('服务端错误');
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          return;
        }
        if(data.status != 0) {

          console.log(data);
          $('.bk_toptips').show();
          $('.bk_toptips span').html(data.message);
          setTimeout(function() {$('.bk_toptips').hide();}, 2000);
          return;
        }

        var num = $('#cart_num').html();
        if (num == '') num = 0;
        $('#cart_num').html(Number(num) + 1);


      },
      error: function(xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
      }
    });


  }
</script>
@endsection
