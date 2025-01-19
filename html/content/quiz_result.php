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
			<div class="quiz_summary">
				<div class="tit">2022년 8월 4주차 퀴즈</div>
				<ul>
					<li>
						<span class="dt">맞은 문제</span>
						<span class="dd">10</span>
					</li>
					<li>
						<span class="dt">틀린 문제</span>
						<span class="dd">10</span>
					</li>
					<li>
						<span class="dt">내 점수</span>
						<span class="dd">10</span>
					</li>
				</ul>
			</div>
			<div class="list_result">
				<ul>
					<li>
						<span class="icon_result wrong">틀림</span>
						<span class="subject">1. 칫솔은 재활용품 쓰레기다. </span>
						<div class="my_answer">
							<span class="dt">나의 답</span>
							<span class="dd">○</span>
						</div>
						<div class="explain">
							<span class="dt">해설</span>
							<span class="dd">정답은 No! 칫솔모는 재활용이 불가하여 일반쓰레기로 버려야 합니다.</span>
						</div>
					</li>
					<li>
						<span class="icon_result right">맞음</span>
						<span class="subject">1. 칫솔은 재활용품 쓰레기다. </span>
						<div class="my_answer">
							<span class="dt">나의 답</span>
							<span class="dd">○</span>
						</div>
						<div class="explain">
							<span class="dt">해설</span>
							<span class="dd">정답은 No! 칫솔모는 재활용이 불가하여 일반쓰레기로 버려야 합니다.</span>
						</div>
					</li>
					<li>
						<span class="icon_result right">맞음</span>
						<span class="subject">1. 칫솔은 재활용품 쓰레기다. </span>
						<div class="my_answer">
							<span class="dt">나의 답</span>
							<span class="dd">○</span>
						</div>
						<div class="explain">
							<span class="dt">해설</span>
							<span class="dd">정답은 No! 칫솔모는 재활용이 불가하여 일반쓰레기로 버려야 합니다.</span>
						</div>
					</li>
				</ul>
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
