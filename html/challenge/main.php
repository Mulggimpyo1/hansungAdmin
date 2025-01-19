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
		<h2 class="page_title">챌린지</h2>
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
		<!-- 챌린지 -->
		<div class="challenge_wrap">
			<div class="challenge_category">
				<ul>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu1.jpg" class="thumb" alt="">
							<strong>줍깅(플로깅)<br>챌린지</strong>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu2.jpg" class="thumb" alt="">
							<strong>에너지<br>챌린지</strong>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu3.jpg" class="thumb" alt="">
							<strong>B·M·W<br>챌린지</strong>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu4.jpg" class="thumb" alt="">
							<strong>재활용<br>챌린지</strong>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu5.jpg" class="thumb" alt="">
							<strong>나무심기<br>챌린지</strong>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/challenge/challenge_menu6.jpg" class="thumb" alt="">
							<strong>잔반zero<br>챌린지</strong>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //챌린지 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
