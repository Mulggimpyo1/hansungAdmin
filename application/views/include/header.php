<!-- header -->
<header>
	<h1 class="logo"><img src="/images/layout/logo.png" alt="저탄소 SCHOOL"></h1>
	<ul class="header_menu">
		<li><a href="/feed/write" class="menu_write">작성</a></li>
		<li><a href="/alarm" class="menu_noti">알림<?php if(count($alarmData)>0){ ?><span class="new">new</span><?php } ?></a></li>
		<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
	</ul>
</header>
<!-- //header -->
<script>
var varUA = navigator.userAgent.toLowerCase(); //userAgent 값 얻기
if ( varUA.indexOf('android') > -1) {
		//안드로이드
		try {
				app_key = window.androidbridge.getAndroidToken();
				//alert("앱입니다.");
		} catch(e) {
			//alert("웹입니다.");
		}
} else if ( varUA.indexOf("iphone") > -1||varUA.indexOf("ipad") > -1||varUA.indexOf("ipod") > -1 ) {
	//IOS
	try {

		webkit.messageHandlers.tokenHandler.postMessage("");
	} catch(e) {
		//alert("웹입니다");
	}
}

function receiveToken(r)
{
	//alert("앱입니다.");
}
</script>
