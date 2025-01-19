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
		<h2 class="page_title">탄소서약서</h2>
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
		<!-- 탄소서약서 -->
		<div class="carbon_wrap">
			<ul class="tab_type">
				<li><a href="#" class="on">탄소서약서</a></li>
				<li><a href="#">실천 서약 현황</a></li>
			</ul>

			<div class="carbon_pledge">
				<div class="frame">
					<img src="/images/util/pledge.png" alt="">
					<div class="name">홍 길 동</div>
					<div class="date">2022년 1월 1일</div>
				</div>
			</div>
		</div>
		<!-- //탄소서약서 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
