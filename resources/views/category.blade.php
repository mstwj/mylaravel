@extends('master')

@section('title','书籍类别')

@section('content')
<div class="weui_cells_title">选择书籍类别</div>
<div class="weui_cells weui_cells_split">
  <div class="weui_cell weui_cell_select">
    <div class="weui_cell_bd weui_cell_primary">
      <select class="weui_select" name="category">
        @foreach ($categorys as $category)
          <option value="{{$category->id}}"->{{$category->name}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div>



<div class="weui_cells weui_cells_access">
  <a class="weui_cell" href="javascript:;">
    <div class="weui_cell_bd weui_cell_primary">
      <p>cell asate </p>
    </div>
    <div class="weui_cell_ft">说明文字</div>
  </a>
  <a class="weui_cell" href="javascript:;">
    <div class="weui_cell_bd weui_cell_primary">
      <p>cell asate </p>
    </div>
    <div class="weui_cell_ft">说明文字</div>
  </a>
</div>

@endsection

@section('my-js')
<script type="text/javascript">

//这里得到了用户选择的ID..

  _getCategory();
  $('.weui_select').change(function(event) {
    _getCategory();
  });


  function _getCategory() {

    var parent_id = $('.weui_select option:selected').val();
    console.log(parent_id);

    $.ajax({
      type: "GET",
      url: '/service/category/parent_id/' + parent_id,
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
        console.log(data);


        $('.weui_cells_access').html(''); //清空前面的数据.
        for (var i=0; i<data.categorys.length;i++) {
          var next = '/product/category_id/'+data.categorys[i].id;
          var node = '<a class="weui_cell" href="' + next + '">' +
                        '<div class="weui_cell_bd weui_cell_primary">' +
                          '<p>'+ data.categorys[i].name +'</p>' +
                        '</div>' +
                        '<div class="weui_cell_ft"></div>' +
                        '</a>';
          $('.weui_cells_access').append(node);
        }

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
