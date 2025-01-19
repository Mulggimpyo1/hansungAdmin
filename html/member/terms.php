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
		<h2 class="page_title">약관 동의</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 약관동의 -->
		<div class="terms_area">
			<ul class="terms_list">
				<li class="terms_all_check">
					<span class="uicheckbox_wrap uicheckbox_size17">
						<input type="checkbox" id="termsCheckAll" class="uicheckbox_check">
						<label for="termsCheckAll" class="uicheckbox_label">전체 동의하기</label>
					</span>
				</li>
				<li>
					<span class="uicheckbox_wrap uicheckbox_size17">
						<input type="checkbox" id="termsCheck1" class="uicheckbox_check">
						<label for="termsCheck1" class="uicheckbox_label">(필수) 이용약관</label>
					</span>
					<a href="#" class="btn_more">보기</a>
				</li>
				<li>
					<span class="uicheckbox_wrap uicheckbox_size17">
						<input type="checkbox" id="termsCheck2" class="uicheckbox_check">
						<label for="termsCheck2" class="uicheckbox_label">(필수) 개인정보 수집 및 이용 동의</label>
					</span>
					<a href="#" class="btn_more">보기</a>
				</li>
				<li>
					<span class="uicheckbox_wrap uicheckbox_size17">
						<input type="checkbox" id="termsCheck3" class="uicheckbox_check">
						<label for="termsCheck3" class="uicheckbox_label">(필수) 제3자 제공에 대한 동의</label>
					</span>
					<a href="#" class="btn_more">보기</a>
				</li>
			</ul>
			<div class="member_type_choice">
				<p class="member_type_desc">회원 유형에 따라 가입 절차가 다르니<br>본인에 해당하는 회원 유형을 선택해 주세요.</p>
				<ul>
					<li class="on"><a href="#">일반 회원<span class="age">(만 14세 이상)</span></a></li>
					<li><a href="#">어린이 회원<span class="age">(만 14세 미만)</span></a></li>
				</ul>
			</div>
		</div>
		<!-- //약관동의 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
