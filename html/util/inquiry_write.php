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
		<!-- 1:1 문의 -->
		<div class="inquiry_wrap">
			<ul class="tab_type">
				<li><a href="#">자주 묻는 질문</a></li>
				<li><a href="#" class="on">1:1 문의</a></li>
			</ul>
			<div class="inquiry_write">
				<div class="sub_tab">
					<ul>
						<li><a href="#" class="on">문의하기</a></li>
						<li><a href="#">나의 문의 내역</a></li>
					</ul>
				</div>
				<div class="inquiry_form">
					<ul>
						<li>
							<label for="tit_inquiry" class="label_inquiry">제목</label>
							<input type="text" id="tit_inquiry" class="input_inquiry">
						</li>
						<li>
							<label for="cont_inquiry" class="label_inquiry">내용</label>
							<textarea id="cont_inquiry"></textarea>
						</li>
					</ul>
					<a href="#" class="btn_inquiry">등 록 하 기</a>
				</div>
			</div>
		</div>
		<!-- //1:1 문의 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
