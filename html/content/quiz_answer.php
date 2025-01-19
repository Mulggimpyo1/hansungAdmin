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
			<div class="quiz_question">
				<div class="cont_question">
					<div class="tit">정답</div>
					<div class="cont">칫솔은 재활용품 쓰레기다.</div>
					<span class="pagination">1/10</span>
				</div>
				<div class="quiz_explain">
					<div class="expl">
						<div class="icon"><img src="/images/content/quiz_x.png" alt=""></div>
						<div class="txt">정답은 No!<br>칫솔모는 재활용이 불가하여<br>일반쓰레기로 버려야 합니다.</div>
					</div>
					<div class="btn"><a href="#" class="btn_next">다음 문제로</a></div>
				</div>
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
