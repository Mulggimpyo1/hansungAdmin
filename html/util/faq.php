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
		<h2 class="page_title">고객센터</h2>
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
		<!-- 자주 묻는 질문 -->
		<div class="faq_wrap">
			<ul class="tab_type">
				<li><a href="#" class="on">자주 묻는 질문</a></li>
				<li><a href="#">1:1 문의</a></li>
			</ul>
			<div class="faq_list">
				<ul>
					<li>
						<div class="title">
							<a href="#" onclick="handleNoticeToggle(this);return false;">
								<strong class="tit">포인트는 어떻게 모으나요?</strong>
							</a>
						</div>
						<div class="cont">
							내용
						</div>
					</li>
					<li>
						<div class="title">
							<a href="#" onclick="handleNoticeToggle(this);return false;">
								<strong class="tit">포인트는 어떻게 모으나요?</strong>
							</a>
						</div>
						<div class="cont">
							내용
						</div>
					</li>
					<li>
						<div class="title">
							<a href="#" onclick="handleNoticeToggle(this);return false;">
								<strong class="tit">포인트는 어떻게 모으나요?</strong>
							</a>
						</div>
						<div class="cont">
							내용
						</div>
					</li>
				</ul>
			</div>
		</div>
		<!-- //자주 묻는 질문 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
