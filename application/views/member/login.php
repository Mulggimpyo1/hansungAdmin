<style>
.start_with{width:100%;height:250px;}
.start_with .list_start{max-width:560px;margin:0 auto;}
.start_with .list_start li{margin-top:13px}
.start_with .list_start li a{display:block;position:relative;height:34px;border-radius:10px;font-size:14px;line-height:35px;text-align:center}
.start_with .list_start li a:before{content:'';position:absolute;top:50%;transform:translateY(-50%)}
.start_with .list_start li a.kakao{background:#fae100;color:#000}
.start_with .list_start li a.kakao:before{left:15px;width:15px;height:14px;background:url(/images/layout/icon_kakao.png) no-repeat 0 0;background-size:100%}
.start_with .list_start li a.naver{background:#2eb34a;color:#fff}
.start_with .list_start li a.naver:before{left:16px;width:12px;height:11px;background:url(/images/layout/icon_naver.png) no-repeat 0 0;background-size:100%}
.start_with .list_start li a.facebook{background:#1877f2;color:#fff}
.start_with .list_start li a.facebook:before{left:17px;width:10px;height:19px;background:url(/images/layout/icon_facebook.png) no-repeat 0 0;background-size:100%}
.start_with .menu{margin-top:10px;text-align:center}
.start_with .menu li{display:inline-block}
.start_with .menu li a{display:block;margin:0 5px;padding:10px;font-size:12px;color:#000}

</style>
<div id="wrap">
	<!-- header -->
  <header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">{page_title}</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 로그인 -->
		<div class="login_area" style="padding-top:50px;">
      <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
      <input type="hidden" id="app_key" name="app_key"/>
			<div class="logo"><img src="/images/member/login_logo.png" alt="저탄소 SCHOOL"></div>
			<div class="login_form">
				<ul class="login_input">
					<li><input type="text" id="user_id" name="user_id" class="input_login" placeholder="아이디"></li>
					<li>
						<input type="password" id="user_password" name="user_password" class="input_login" onkeypress="if( event.keyCode == 13 ){goLogin();}" placeholder="비밀번호">
						<button type="button" class="btn_type_toggle" onClick="pwTypeToggle(this, '#user_password');">비밀번호보기</button>
					</li>
				</ul>
				<ul class="login_option">
					<li>
						<span class="uicheckbox_wrap uicheckbox_size12">
							<input type="checkbox" id="idSave" class="uicheckbox_check" value="Y">
							<label for="idSave" class="uicheckbox_label">아이디 저장</label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size12">
							<input type="checkbox" id="autoLogin" name="autoLogin" class="uicheckbox_check" value="Y">
							<label for="autoLogin" class="uicheckbox_label">자동 로그인</label>
						</span>
					</li>
				</ul>

				<a href="javascript:goLogin()" class="btn_login">로 그 인</a>

				<ul class="login_menu">
					<li><a href="/member/findId">아이디 찾기</a></li>
					<li><a href="/member/findPw">비밀번호 찾기</a></li>
					<li><a href="/member/join/terms">회원가입</a></li>
				</ul>
        <div class="start_with" style="height:auto">
          <ul class="list_start">
  					<li><a href="{kakao_apiURL}" class="kakao">카카오톡으로 시작하기</a></li>
  					<li><a href="{naver_apiURL}" class="naver">네이버로 시작하기</a></li>
  					<li><a href="{facebook_apiURL}" class="facebook">페이스북으로 시작하기</a></li>
  				</ul>
        </div>
        <ul class="login_terms" >
					<li><a href="/home/terms">이용약관</a></li>
					<li><a href="/home/privacy">개인정보 취급방침</a></li>
				</ul>
			</div>
		</div>
		<!-- //로그인 -->
	</div>
	<!-- //container -->
  <script>
  var app_key = "";
  var login_str = "";
  function goLogin()
  {
    var user_id = $('#user_id').val();
    var user_password = $('#user_password').val();

    if(user_id == ""){
      swal("아이디를 입력해주세요");
      $('#user_id').focus();
      return;
    }

    if(user_password == ""){
      swal("비밀번호를 입력해주세요");
      $('#user_password').focus();
      return;
    }

    osCheck();



  }

  function loginProc()
  {
    var user_id = $('#user_id').val();
    var user_password = $('#user_password').val();

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();
    var auto_login = $('input[name="autoLogin"]:checked').val();

    var data = {
      "user_id" : user_id,
      "user_password" : user_password,
      "auto_login"  : auto_login,
      "app_key" : app_key
    }

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/home/login_proc",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result=="failed"){
          swal(data.msg);
        }else{
          swal("로그인 되었습니다.", {
            icon: "success",
          }).then((value)=>{
            location.href="/main";
          });
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function osCheck()
  {
    var varUA = navigator.userAgent.toLowerCase(); //userAgent 값 얻기
    if ( varUA.indexOf('android') > -1) {
        //안드로이드
  			try {
  		      app_key = window.androidbridge.getAndroidToken();
            loginProc();
  		  } catch(e) {
          app_key = "";
          loginProc();
  		  }
    } else if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 ) {
      //IOS
  		try {
        login_str = "login";
  			webkit.messageHandlers.tokenHandler.postMessage("");
  		} catch(e) {
        loginProc();
        //swal(e);
  		}
    }
  }

  function receiveToken(r)
  {
      //swal('IOS RECEIVE');
      // IOS에서 콜하는 JAVASCRIPT
  	app_key = r.token+"";
  	//info = JSON.stringify(app_key);
    if(login_str == "login"){
      loginProc();
    }else{
      autoLogin();

    }


  }

  $(document).ready(function(){

    //autologinCheck
    autoLoginCheck();

     //저장된 쿠기값을 가져와서 id 칸에 넣어준다 없으면 공백으로 처리
     var key = getCookie("id_save");
     $("#user_id").val(key);


     if($("#user_id").val() !=""){               // 페이지 로딩시 입력 칸에 저장된 id가 표시된 상태라면 id저장하기를 체크 상태로 둔다
        $("#idSave").attr("checked", true); //id저장하기를 체크 상태로 둔다 (.attr()은 요소(element)의 속성(attribute)의 값을 가져오거나 속성을 추가합니다.)
     }

      $("#idSave").change(function(){ // 체크박스에 변화가 있다면,
            if($("#idSave").is(":checked")){ // ID 저장하기 체크했을 때,
                setCookie("id_save", $("#user_id").val(), 7); // 하루 동안 쿠키 보관
            }else{ // ID 저장하기 체크 해제 시,
                deleteCookie("id_save");
            }
      });

        // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
        $("#user_id").keyup(function(){ // ID 입력 칸에 ID를 입력할 때,
            if($("#idsave").is(":checked")){ // ID 저장하기를 체크한 상태라면,
                setCookie("id_save", $("#user_id").val(), 7); // 7일 동안 쿠키 보관
            }
        });
    });

    //쿠키 함수
    function setCookie(cookieName, value, exdays){
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
        document.cookie = cookieName + "=" + cookieValue;
    }

    function deleteCookie(cookieName){
        var expireDate = new Date();
        expireDate.setDate(expireDate.getDate() - 1);
        document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
    }

    function getCookie(cookieName) {
        cookieName = cookieName + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(cookieName);
        var cookieValue = '';
        if(start != -1){
            start += cookieName.length;
            var end = cookieData.indexOf(';', start);
            if(end == -1)end = cookieData.length;
            cookieValue = cookieData.substring(start, end);
        }
        return unescape(cookieValue);
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
          login_str = "";
    			webkit.messageHandlers.tokenHandler.postMessage("");
    		} catch(e) {

    		}
      }
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
            location.href="/main";
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  </script>
