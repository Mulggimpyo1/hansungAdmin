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
		<h2 class="page_title">퀴즈</h2>
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
		<!-- 퀴즈 -->
		<div class="quiz_wrap">
			<div class="quiz_question">
				<div class="cont_question">
					<div class="tit">문제</div>
					<div class="cont">칫솔은 재활용품 쓰레기다.</div>
					<span class="pagination">1/10</span>
				</div>
				<!-- OX타입 -->
				<div class="answer">
					<a href="#"><img src="/images/content/quiz_o.png" alt="O"></a>
					<a href="#"><img src="/images/content/quiz_x.png" alt="X"></a>
				</div>
				<!-- //OX타입 -->

				<!-- 3지선다 -->
				<div class="answer">
					<ul>
						<li>
							<input type="radio" id="answer1" class="radio_answer" name="answer">
							<label for="answer1" class="label_answer">1. 정답</label>
						</li>
						<li>
							<input type="radio" id="answer2" class="radio_answer" name="answer">
							<label for="answer2" class="label_answer">2. 정답</label>
						</li>
						<li>
							<input type="radio" id="answer3" class="radio_answer" name="answer">
							<label for="answer3" class="label_answer">3. 정답</label>
						</li>
					</ul>					
				</div>
				<!-- //3지선다 -->
			</div>
		</div>
		<!-- //퀴즈 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
