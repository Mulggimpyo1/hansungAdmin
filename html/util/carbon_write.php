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
		<h2 class="page_title">탄소서약서</h2>
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
		<!-- 탄소서약서 -->
		<div class="carbon_wrap">
			<ul class="tab_type">
				<li><a href="#" class="on">탄소서약서</a></li>
				<li><a href="#">실천 서약 현황</a></li>
			</ul>

			<div class="carbon_write">
				<p class="desc">
					나는 기후위기를 극복하고 다음 세대에게 깨끗하고 밝은<br>
					미래를 전해주기 위하여 연간 탄소 1톤 줄이기 운동에<br>
					적극 참여할 것을 서약합니다.
				</p>
				<div class="form_carbon_pledge">
					<ul class="list_carbon_pledge">
						<li>
							<label for="carbon-name" class="dt">이름</label>
							<div class="dd">
								<input type="text" id="carbon-name" class="input_carbon" style="width:165px">
							</div>
						</li>
						<li>
							<label for="carbon-birth" class="dt">생년월일</label>
							<div class="dd">
								<select class="uiselect" id="carbon-birth" style="width:90px">
									<option>년</option>
								</select>
								<select class="uiselect" style="width:67px">
									<option>월</option>
								</select>
								<select class="uiselect" style="width:67px">
									<option>일</option>
								</select>
							</div>
						</li>
						<li>
							<label for="" class="dt">성별</label>
							<div class="dd">
								<div class="gender_select">
									<input type="radio" id="carbon-male" class="radio_gender" name="carbon-gender" checked>
									<label for="carbon-male" class="label_gender">남자</label>
								</div>
								<div class="gender_select">
									<input type="radio" id="carbon-female" class="radio_gender" name="carbon-gender">
									<label for="carbon-female" class="label_gender">여자</label>
								</div>
							</div>
						</li>
						<li>
							<label for="carbon-phone" class="dt">연락처</label>
							<div class="dd">
								<input type="text" id="carbon-phone" class="input_carbon" style="width:230px">
							</div>
						</li>
						<li>
							<label for="carbon-email" class="dt">이메일</label>
							<div class="dd">
								<input type="text" id="carbon-email" class="input_carbon" style="width:230px">
								<div class="no_email">
									<span class="uicheckbox_wrap uicheckbox_size17">
										<input type="checkbox" id="noEmail" class="uicheckbox_check">
										<label for="noEmail" class="uicheckbox_label">이메일 없음</label>
									</span>
								</div>
							</div>
						</li>
						<li>
							<label for="carbon-city" class="dt">지역</label>
							<div class="dd">
								<select class="uiselect" id="carbon-city" style="width:114px">
									<option>선택</option>
								</select>
								<select class="uiselect" style="width:114px">
									<option>선택</option>
								</select>
							</div>
						</li>
						<li>
							<label for="carbon-school" class="dt">학교</label>
							<div class="dd">
								<input type="text" id="carbon-school" class="input_carbon" style="width:165px;">
							</div>
						</li>
					</ul>
					<div class="carbon_terms">
						<span class="uicheckbox_wrap uicheckbox_size17">
							<input type="checkbox" id="carbonTerms" class="uicheckbox_check">
							<label for="carbonTerms" class="uicheckbox_label">개인정보 수집 및 이용 동의</label>
						</span>
						<div class="terms_cont">
							▶수집항목: 이름,연락처, 지역(시/군/구)<br>
							▶수집목적: 저탄소스쿨 소식 전달을 위한 뉴스레터 또는 정보 제공 이메일 발송<br>
							▶보유기간: 사용자가 개인정보 제공에 동의하신 시점부터 해지를 요청하여 처리된 시점까지이며, 회원 탈퇴 및 사용자의 요청에 의해 삭제 또는 파기 가능<br>
						</div>
					</div>
					<a href="#" class="btn_agree">서 약 하 기</a>
				</div>
			</div>
		</div>
		<!-- //탄소서약서 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
