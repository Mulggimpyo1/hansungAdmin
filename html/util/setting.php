<!DOCTYPE html>
<html lang="ko">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/head.php'); ?>
</head>
<body>
<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">설정</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>		
	</header>
	<!-- //header -->

	<!-- aside -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/aside.php'); ?>
	<!-- //aside -->

	<!-- container -->
	<div id="container">
		<!-- 설정 -->
		<div class="setting_wrap">
			<div class="setting_group">
				<span class="tit">계정 설정</span>
				<ul class="list_setting">
					<li>
						<span class="dt">아이디</span>
						<div class="dd">abcd</div>
					</li>
					<li>
						<span class="dt">이름</span>
						<div class="dd">홍길동</div>
					</li>
					<li>
						<span class="dt">학교</span>
						<div class="dd">초등학교 3-1<a href="#" class="btn">학교정보변경</a></div>
						
					</li>
					<li>
						<a href="#" class="link_blue">비밀번호 변경하기</a>
					</li>
					<li>
						<a href="#" class="link_red">회원탈퇴하기</a>
					</li>
				</ul>
			</div>

			<div class="setting_group">
				<span class="tit">푸시 알림 설정</span>
				<ul class="list_setting push_setting">
					<li>
						새로운 퀴즈가 등록되었을 때
						<span class="btn_setting_check">
							<input type="checkbox" id="settingCheck1" class="input_setting">
							<label for="settingCheck1" class="label_setting">설정</label>
						</span>
					</li>
					<li>
						누가 내 게시글에 좋아요 했을 때
						<span class="btn_setting_check">
							<input type="checkbox" id="settingCheck2" class="input_setting">
							<label for="settingCheck2" class="label_setting">설정</label>
						</span>
					</li>
					<li>
						누가 내 게시글에 댓글을 달았을 때 
						<span class="btn_setting_check">
							<input type="checkbox" id="settingCheck3" class="input_setting">
							<label for="settingCheck3" class="label_setting">설정</label>
						</span>
					</li>
					<li>
						나의 학급에서 새로운 게시물이 등록되었을 때
						<span class="btn_setting_check">
							<input type="checkbox" id="settingCheck4" class="input_setting">
							<label for="settingCheck4" class="label_setting">설정</label>
						</span>
					</li>
					<li>
						탄소 절감량 100kg 달성할 때마다
						<span class="btn_setting_check">
							<input type="checkbox" id="settingCheck5" class="input_setting">
							<label for="settingCheck5" class="label_setting">설정</label>
						</span>
					</li>
				</ul>
			</div>
		</div>
		<!-- //설정 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
