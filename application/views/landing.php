<div id="wrap" class="full_height">
	<!-- container -->
	<div id="container">
		<div class="landing_area">
			<div class="landing_visual">
				<!--
				<video autoplay loop muted style="position:absolute;left:0;top:0;width:100%;height:100%;object-fit: fill;">
        <source src="/assets/bg_movie_rewind.mp4" type="video/mp4">
        대체 텍스트
			</video>-->
			<img src="/assets/landing_img.png" width="100%" height="100%"/>
				<span class="fast_join"><em>3초 빠른 가입</em></span>
			</div>
			<div class="start_with">
				<ul class="list_start">
					<li><a href="{kakao_apiURL}" class="kakao">카카오톡으로 시작하기</a></li>
					<li><a href="{naver_apiURL}" class="naver">네이버로 시작하기</a></li>
					<li><a href="{facebook_apiURL}" class="facebook">페이스북으로 시작하기</a></li>
				</ul>
				<ul class="menu">
					<li><a href="/member/join/terms">회원가입</a></li>
					<li><a href="/login">로그인</a></li>
					<!--<li><a href="javascript:getToken()">토큰</a></li>-->
				</ul>
			</div>
		</div>
	</div>
	<!-- //container -->
</div>
<script>
var app_key = "";
$(function(){
  autoLoginCheck();
});
function getToken() {
	var varUA = navigator.userAgent.toLowerCase(); //userAgent 값 얻기
  if ( varUA.indexOf('android') > -1) {
      //안드로이드
			try {
		      app_key = window.androidbridge.getAndroidToken();
					swal(app_key);
		  } catch(e) {

		  }
  } else if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 ) {
    //IOS
		try {
			webkit.messageHandlers.tokenHandler.postMessage("");
			//swal(app_key);
		} catch(e) {
      swal(error);
		}
  }
}


function autoLoginCheck()
{
	var varUA = navigator.userAgent.toLowerCase(); //userAgent 값 얻기
  if ( varUA.indexOf('android') > -1) {
      //안드로이드
			try {
		      app_key = window.androidbridge.getAndroidToken();
					autoLogin();
		  } catch(e) {

		  }
  } else if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 ) {
    //IOS
		try {
			webkit.messageHandlers.tokenHandler.postMessage("");
		} catch(e) {

		}
  }
}

function receiveToken(r)
{
    //swal('IOS RECEIVE');
    // IOS에서 콜하는 JAVASCRIPT
	app_key = r.token+"";
	//info = JSON.stringify(app_key);

	autoLogin();

}

function autoLogin()
{
	var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {
    "app_key" : app_key
  }

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/home/autoLoginCheck",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      if(data.result=="success"){
				//swal(app_key);
        location.href="/main";
      }else{
				swal(data.msg);
			}
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}
</script>
</body>
</html>
