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
		<h2 class="page_title">콘텐츠</h2>
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
		<!-- 콘텐츠 -->
		<div class="content_wrap">
			<div class="content_category">
				<ul>
					<li class="blue">
						<a href="#" class="menu1">
							<img src="/images/content/content_menu1.png" alt="">
							<strong>뉴스 기사</strong>
						</a>
					</li>
					<li class="green">
						<a href="#" class="menu2">
							<img src="/images/content/content_menu2.png" alt="">
							<strong>웹툰</strong>
						</a>
					</li>
					<li class="green">
						<a href="#" class="menu3">
							<img src="/images/content/content_menu3.png" alt="">
							<strong>영상</strong>
						</a>
					</li>
					<li class="blue">
						<a href="#" class="menu4">
							<img src="/images/content/content_menu4.png" alt="">
							<strong>퀴즈</strong>
						</a>
					</li>
					<li class="blue">
						<a href="#" class="menu5">
							<img src="/images/content/content_menu5.png" alt="">
							<strong>미니게임</strong>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //콘텐츠 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
