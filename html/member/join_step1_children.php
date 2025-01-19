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
		<!-- 회원정보입력 -->
		<div class="join_area">
			<ol class="join_step">
				<li class="current">1. 회원정보입력</li>
				<li>2. 학교정보입력</li>
				<li>3. 가입완료</li>
			</ol>
			
			<div class="join_form">
				<strong class="tit_join">법정대리인 정보</strong>
				<ul class="list_join_info">
					<li>
						<label for="join-parent-name" class="label">이름</label>
						<div class="input_area">
							<input type="text" id="join-parent-name" class="input_join">
						</div>
					</li>
					<li>
						<label for="join-parent-birth" class="label">생년월일</label>
						<div class="input_area">
							<input type="text" id="join-parent-birth" class="input_join">
						</div>
					</li>
					<li>
						<label for="join-parent-phone" class="label">연락처</label>
						<div class="input_area">
							<input type="text" id="join-parent-phone" class="input_join">
						</div>
					</li>
				</ul>

				<strong class="tit_join">회원 정보</strong>
				<ul class="list_join_info">
					<li>
						<label for="join-id" class="label is_confirmed">아이디</label><!-- is_confirmed: 체크아이콘 -->
						<div class="input_area">
							<input type="text" id="join-id" class="input_join">
							<a href="#" class="btn_verification on">중복확인</a><!-- on: 활성화 -->
						</div>
					</li>
					<li>
						<label for="join-pw" class="label">비밀번호</label>
						<div class="input_area">
							<input type="password" id="join-pw" class="input_join">
							<button type="button" class="btn_type_toggle" onClick="pwTypeToggle(this, '#join-pw');">비밀번호보기</button>
						</div>
					</li>
					<li>
						<label for="join-pw2" class="label">비밀번호 확인</label>
						<div class="input_area">
							<input type="password" id="join-pw2" class="input_join">
							<button type="button" class="btn_type_toggle" onClick="pwTypeToggle(this, '#join-pw2');">비밀번호보기</button>
						</div>
					</li>
				</ul>
				<ul class="list_join_info">
					<li>
						<label for="join-name" class="label">이름</label>
						<div class="input_area">
							<input type="text" id="join-name" class="input_join">
						</div>
					</li>
					<li>
						<label for="join-phone" class="label">휴대폰번호</label>
						<div class="input_area">
							<input type="tel" id="join-phone" class="input_join">
							<a href="#" class="btn_verification">인증번호 발송</a>
						</div>
					</li>
					<li>
						<label for="join-phone-certification" class="label">인증번호</label>
						<div class="input_area">
							<input type="tel" id="join-phone-certification" class="input_join">
							<a href="#" class="btn_verification">인증확인</a>
						</div>
					</li>
					<li class="info_email">
						<label for="join-email" class="label">이메일</label>
						<input type="text" id="join-email" class="input_join">
						<div class="mail_domain">
							<span class="at">@</span>
							<select class="uiselect">
								<option>선택하세요</option>
							</select>
						</div>
					</li>
				</ul>
				<ul class="add_join_info">
					<li>
						<label for="join-birth" class="label">생년월일</label>
						<select class="uiselect" id="join-birth" style="width:75px">
							<option>년</option>
						</select>
						<select class="uiselect" style="width:60px">
							<option>월</option>
						</select>
						<select class="uiselect" style="width:60px">
							<option>일</option>
						</select>
					</li>
					<li>
						<label for="join-male" class="label">성별</label>
						<div class="gender_select">
							<input type="radio" id="join-male" class="radio_gender" name="join-gender" checked>
							<label for="join-male" class="label_gender">남자</label>
						</div>
						<div class="gender_select">
							<input type="radio" id="join-female" class="radio_gender" name="join-gender">
							<label for="join-female" class="label_gender">여자</label>
						</div>
					</li>
					<li>
						<label for="join-address" class="label">주소</label>
						<input type="text" id="join-address" class="input_join" style="width:120px">
						<a href="#" class="btn_verification on">우편번호 검색</a>
					</li>
				</ul>
				<div class="info_address">
					<input type="text" class="input_join" style="width:55%">
					<input type="text" class="input_join" style="width:40%">
				</div>
				<a href="#" class="btn_join_next">다 음</a>
			</div>
		</div>
		<!-- //회원정보입력 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
