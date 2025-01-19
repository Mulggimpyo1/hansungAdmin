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
		<!-- 챌린지상세 -->
		<div class="challenge_wrap">
			<div class="challenge_detail">
				<div class="challenge_img">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
						</div>
						 <div class="swiper-pagination"></div>
					</div>
				</div>
				<a href="#" class="btn_challenge">챌 린 지 하 러 가 기</a>
			</div>
		</div>
		<!-- //챌린지상세 -->
	</div>
	<!-- //container -->
	<script type="text/javascript">
		new Swiper('.challenge_img .swiper-container', {
			slidesPerView: 1,
			pagination: {
				el: ".swiper-pagination",
			},
		});
	</script>

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
