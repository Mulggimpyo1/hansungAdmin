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
		<h2 class="page_title">회원가입</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 학교정보입력 -->
		<div class="join_area">
			<ol class="join_step">
				<li class="current">1. 회원정보입력</li>
				<li class="current">2. 학교정보입력</li>
				<li>3. 가입완료</li>
			</ol>
			
			<div class="join_form">
				<ul class="list_join_info">
					<li>
						<label for="join-school" class="label">학교명</label>
						<div class="input_area">
							<input type="text" id="join-school" class="input_join">
							<a href="#" class="btn_verification on">검색</a>
						</div>
					</li>
				</ul>
				<ul class="add_join_info">
					<li>
						<label for="join-class" class="label">학년</label>
						<select class="uiselect" id="join-class" style="width:120px">
							<option>선택하세요</option>
						</select>
					</li>
					<li>
						<label for="join-class2" class="label">반</label>
						<select class="uiselect" id="join-class2" style="width:120px">
							<option>선택하세요</option>
						</select>
					</li>
				</ul>
				<div class="no_school">
					<span class="uicheckbox_wrap uicheckbox_size17">
						<input type="checkbox" id="noSchool" class="uicheckbox_check">
						<label for="noSchool" class="uicheckbox_label">학교 선택 안함</label>
					</span>
				</div>
				<a href="#" class="btn_join_next">다 음</a>
			</div>
		</div>
		<!-- //학교정보입력 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
