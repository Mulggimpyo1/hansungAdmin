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
		<h2 class="page_title">웹툰</h2>
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
		<!-- 웹툰 -->
		<div class="content_wrap">
			<div class="webtoon_list">
				<ul>
					<li>
						<a href="#">
							<img src="/images/temp/main_content.png" class="thumb" alt="">
							<div class="desc">기후위기<br>농업보고서①</div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/temp/main_content.png" class="thumb" alt="">
							<div class="desc">기후위기<br>농업보고서①</div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/temp/main_content.png" class="thumb" alt="">
							<div class="desc">기후위기<br>농업보고서①</div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/temp/main_content.png" class="thumb" alt="">
							<div class="desc">기후위기<br>농업보고서①</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //웹툰 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
