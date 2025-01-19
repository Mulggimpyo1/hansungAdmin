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
		<h2 class="blind">피드</h2>
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
		<!-- 피드 -->
		<div class="feed_wrap">
			<div class="user_info">
				<div class="photo">
					<img src="/images/common/user.png" class="user" alt="">
					<span class="icon"><img src="/images/feed/icon_photo.png" alt=""></span>
					<input type="file" class="input_photo">
				</div>
				<div class="name">홍길동 <img src="/images/feed/icon_star.png" class="icon_star" alt=""></div>
				<div class="school">옥천초등학교 3-2</div>
			</div>
			<div class="cate_feed">
				<ul>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate1.png" class="icon_cate icon_all" alt="">
							<div class="txt">전체<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate2.png" class="icon_cate" alt="">
							<div class="txt">재활용<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate3.png" class="icon_cate" alt="">
							<div class="txt">줍깅<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate4.png" class="icon_cate" alt="">
							<div class="txt">나무심기<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate5.png" class="icon_cate" alt="">
							<div class="txt">에너지<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate6.png" class="icon_cate" alt="">
							<div class="txt">B&middot;M&middot;W<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate7.png" class="icon_cate" alt="">
							<div class="txt">식단<span class="num">100</span></div>
						</a>
					</li>
				</ul>
			</div>
			<div class="list_feed">
				<ul>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
					<li><a href="#"><img src="/images/temp/main_content.png" alt=""></a></li>
				</ul>
			</div>
		</div>
		<!-- //피드 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
