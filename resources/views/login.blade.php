@extends('master')

@section('title','登入')

@section('content')
<div class="weui_cells_title"></div>
<div class="weui_cells weui_cells_form">
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">帐号</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="tel" placeholder="邮箱或手机号" name='username'/>
      </div>
  </div>
  <div class="weui_cell">
      <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" type="tel" placeholder="不少于6位" name='password'/>
      </div>
  </div>
  <div class="weui_cell weui_vcode">
      <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
      <div class="weui_cell_bd weui_cell_primary">
          <input class="weui_input" placeholder="请输入验证码" name='validate_code'/>
      </div>
      <div class="weui_cell_ft">
          <img src="/service/validate_code/create" class="bk_validate_code"/>
      </div>
  </div>
</div>
<div class="weui_cells_tips"></div>
<div class="weui_btn_area">
  <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onLoginClick();">登录</a>
</div>
<a href="/register" class="bk_bottom_tips bk_important">没有帐号? 去注册</a>



@endsection()

@section('my-js')
<script type="text/javascript">

  

  //这里必须加随机数，因为浏览器的缓存如果发现是一个地址，就不会去更新了.
  $('.bk_validate_code').click(function () {

    $(this).attr('src','/service/validate_code/create?random='+Math.random());
  });

  function onLoginClick() {

    var username = $('input[name=username]').val();
    if (username.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('账号不能为空');
      setTimeout(function() {$('.bk_toptips').hide();},2000);
      return;
    }

    var password = $('input[name=password]').val();
    if (password.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('密码不能为空');
      setTimeout(function() {$('.bk_toptips').hide();},2000);
      return;
    }

    var validate_code = $('input[name=validate_code]').val();
    if (validate_code.length == 0) {
      $('.bk_toptips').show();
      $('.bk_toptips span').html('验证码不能为空');
      setTimeout(function() {$('.bk_toptips').hide();},2000);
      return;
    }


    //如果JS报错，前面的都不能使用了..就都错了.
    $.ajax({
      type: "POST",
      url: '/service/login',
      dataType: 'json',
      cache: false,
      data: {username:username,password:password,validate_code:validate_code,_token: "{{csrf_token()}}"},
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
        $('.bk_toptips').show();
        $('.bk_toptips span').html('登入成功');
        setTimeout(function() {$('.bk_toptips').hide();}, 2000);

        location.href="/category";

      },
      error: function(xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
      }
    });

  }


</script>
@endsection()
