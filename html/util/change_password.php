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
		<h2 class="page_title">비밀번호 변경하기</h2>
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
		<!-- 비밀번호변경 -->
		<div class="join_area">
			<div class="join_form">
				<ul class="list_join_info">
					<li>
						<label for="change-pw1" class="label">현재 비밀번호</label>
						<div class="input_area">
							<input type="password" id="change-pw1" class="input_join">
							<button type="button" class="btn_type_toggle" onclick="pwTypeToggle(this, '#change-pw1');">비밀번호보기</button>
						</div>
					</li>
					<li>
						<label for="change-pw2" class="label">새 비밀번호</label>
						<div class="input_area">
							<input type="password" id="change-pw2" class="input_join">
							<button type="button" class="btn_type_toggle" onclick="pwTypeToggle(this, '#change-pw2');">비밀번호보기</button>
						</div>
					</li>
					<li>
						<label for="change-pw3" class="label">새 비밀번호 확인</label>
						<div class="input_area">
							<input type="password" id="change-pw3" class="input_join">
							<button type="button" class="btn_type_toggle" onclick="pwTypeToggle(this, '#change-pw3');">비밀번호보기</button>
						</div>
					</li>
				</ul>
				<a href="#" class="btn_join_next">저 장</a>
			</div>
		</div>
		<!-- //비밀번호변경 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
