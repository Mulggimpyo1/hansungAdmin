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
			<div class="inquiry_history">
				<div class="sub_tab">
					<ul>
						<li><a href="#">문의하기</a></li>
						<li><a href="#" class="on">나의 문의 내역</a></li>
					</ul>
				</div>
				<div class="list_inquiry">
					<ul>
						<li>
							<div class="title">
								<a href="#" onclick="handleNoticeToggle(this);return false;">
									<strong class="tit">챌린지 참여는 어떻게 하나요? <span class="answered">답변완료</span></strong>
									<span class="date">2023-04-01</span>
								</a>
							</div>
							<div class="cont">
								챌린지등록이 안 돼요.  어떻게 해야하나요? 
							</div>
							<div class="answer">
								<strong class="tit_answer">답변</strong>
								텍스트 샘플 텍스트 샘플 텍스트 샘플 텍스트 샘플 텍스트 샘플 텍스트 샘플 텍스트 샘플 텍스트 샘플
								<span class="date">2023-04-01</span>
							</div>
						</li>
						<li>
							<div class="title">
								<a href="#" onclick="handleNoticeToggle(this);return false;">
									<strong class="tit">챌린지 참여는 어떻게 하나요? </strong>
									<span class="date">2023-04-01</span>
								</a>
							</div>
							<div class="cont">
								챌린지등록이 안 돼요.  어떻게 해야하나요? 
							</div>
						</li>
					</ul>
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
