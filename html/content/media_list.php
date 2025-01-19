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
		<h2 class="page_title">영상</h2>
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
		<!-- 영상 -->
		<div class="content_wrap">
			<div class="media_list">
				<ul>
					<li>
						<a href="#">
							<div class="thumb"><img src="/images/temp/main_content.png" alt=""></div>
							<div class="desc">제목 제목 제목</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="thumb"><img src="/images/temp/main_content.png" alt=""></div>
							<div class="desc">제목 제목 제목</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="thumb"><img src="/images/temp/main_content.png" alt=""></div>
							<div class="desc">제목 제목 제목</div>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- //영상 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
