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
		<h2 class="page_title">탄소중립 지식백과</h2>
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
		<!-- 탄소중립지식백과 -->
		<div class="carbon_wrap">
			<div class="carbon_list">
				<ul>
					<li>
						<a href="#">
							<div class="thumb">
								<img src="/images/temp/carbon.gif" class="img" alt="">
							</div>
							<div class="txt">①탄소중립</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="thumb">
								<img src="/images/temp/carbon.gif" class="img" alt="">
								<span class="lock"><img src="/images/util/icon_lock.png" alt=""></span>
							</div>
							<div class="txt">①탄소중립</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="thumb">
								<img src="/images/temp/carbon.gif" class="img" alt="">
								<span class="lock"><img src="/images/util/icon_lock.png" alt=""></span>
							</div>
							<div class="txt">①탄소중립</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="thumb">
								<img src="/images/temp/carbon.gif" class="img" alt="">
								<span class="lock"><img src="/images/util/icon_lock.png" alt=""></span>
							</div>
							<div class="txt">①탄소중립</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //탄소중립지식백과 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
