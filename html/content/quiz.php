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
		<h2 class="page_title">퀴즈</h2>
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
		<!-- 퀴즈 -->
		<div class="quiz_wrap">
			<div class="quiz_start">
				<div class="logo">
					<img src="/images/content/quiz_logo.png" alt="">
					<span class="already">이미<br> 풀었어요!</span>
				</div>
				<strong class="quiz_info">2022년 8월<br>4주차 퀴즈</strong>
				<a href="#" class="btn_quiz">S T A R T</a>
				<!-- 이미풀었을때 -->
				<div class="my_result">
					<span class="dt">내 점수</span>
					<span class="dd">100</span>
				</div>
				<a href="#" class="btn_quiz">결 과 보 기</a>
				<a href="#" class="btn_quiz">다 시 풀 기</a>
				<!-- //이미풀었을때 -->
			</div>
		</div>
		<!-- //퀴즈 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
