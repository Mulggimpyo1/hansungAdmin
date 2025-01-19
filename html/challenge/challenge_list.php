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
		<h2 class="page_title">에너지 챌린지</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>		
	</header>
	<!-- //header -->

	<!-- aside -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/aside.php'); ?>
	<!-- //aside -->

	<!-- container -->
	<div id="container">
		<!-- 챌린지리스트 -->
		<div class="challenge_wrap">
			<div class="list_challenge">
				<ul>
					<li>
						<a href="#">여름철 에어컨 사용 1시간 줄이기</a>
					</li>
					<li>
						<a href="#">여름철 에어컨 사용 1시간 줄이기</a>
					</li>
					<li>
						<a href="#">여름철 에어컨 사용 1시간 줄이기</a>
					</li>
					<li>
						<a href="#">여름철 에어컨 사용 1시간 줄이기</a>
					</li>
					<li>
						<a href="#">여름철 에어컨 사용 1시간 줄이기</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //챌린지리스트 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
