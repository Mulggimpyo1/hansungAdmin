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
		<h2 class="page_title">로그인</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 로그인 -->
		<div class="login_area">
			<div class="logo"><img src="/images/member/login_logo.png" alt="저탄소 SCHOOL"></div>
			<div class="login_form">
				<ul class="login_input">
					<li><input type="text" class="input_login" placeholder="아이디"></li>
					<li>
						<input type="password" id="loginPassword" class="input_login" placeholder="비밀번호">
						<button type="button" class="btn_type_toggle" onClick="pwTypeToggle(this, '#loginPassword');">비밀번호보기</button>
					</li>
				</ul>
				<ul class="login_option">
					<li>
						<span class="uicheckbox_wrap uicheckbox_size12">
							<input type="checkbox" id="idSave" class="uicheckbox_check">
							<label for="idSave" class="uicheckbox_label">아이디 저장</label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size12">
							<input type="checkbox" id="autoLogin" class="uicheckbox_check">
							<label for="autoLogin" class="uicheckbox_label">자동 로그인</label>
						</span>
					</li>
				</ul>

				<a href="#" class="btn_login">로 그 인</a>
				<ul class="login_menu">
					<li><a href="#">아이디 찾기</a></li>
					<li><a href="#">비밀번호 찾기</a></li>
					<li><a href="#">회원가입</a></li>
				</ul>
				<ul class="login_terms">
					<li><a href="#">이용약관</a></li>
					<li><a href="#">개인정보 취급방침</a></li>
				</ul>
			</div>
		</div>
		<!-- //로그인 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
