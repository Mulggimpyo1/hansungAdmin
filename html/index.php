<!DOCTYPE html>
<html lang="ko">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/head.php'); ?>
</head>
<body>
<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="logo"><img src="/images/layout/logo.png" alt="저탄소 SCHOOL"></h1>
		<ul class="header_menu">
			<li><a href="#" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_noti">알림<span class="new">new</span></a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- aside -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/aside.php'); ?>
	<!-- //aside -->

	<!-- container -->
	<div id="container">
		<div class="main_filter">
			<select class="select_filter">
				<option>전체 범위</option>
			</select>
			<select class="select_filter">
				<option>전체 챌린지</option>
			</select>
		</div>
		<div class="main_content">
			<div class="content_item">
				<!-- 컨텐츠상단 -->
				<div class="content_info">
					<div class="user">
						<a href="#">
							<img src="/images/common/user.png" class="img" alt="">
							<span class="name">username</span>
							<span class="school">초등학교</span>
						</a>
					</div>
					<span class="category">줍깅 챌린지</span>
					<a href="#" class="btn_more" onClick="uiLayer.open('#mainContentMore');return false;">메뉴</a>
				</div>
				<!-- //컨텐츠상단 -->
				<!-- 컨텐츠이미지 -->
				<div class="content_img">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
						</div>
						 <div class="swiper-pagination"></div>
					</div>
				</div>
				<!-- //컨텐츠이미지 -->
				<!-- 컨텐츠댓글 -->
				<div class="content_etc">
					<div class="icon">
						<a href="#"><img src="/images/common/icon_like.png" class="icon_like" alt=""></a>
						<a href="#"><img src="/images/common/icon_like_on.png" class="icon_like" alt=""></a>
						<img src="/images/common/icon_reply.png" class="icon_reply" alt="">
					</div>
					<div class="cont_like">
						<span class="count">좋아요 00000개</span>
						<ul>
							<li>
								<span class="name">username</span>
								좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요...
								<a href="#" class="btn_more">더보기</a>
							</li>
						</ul>
					</div>
					<div class="cont_reply">
						<a href="#" class="count" onClick="uiPage.open('#uipage_reply');return false">댓글 0000개 모두 보기</a>
						<ul>
							<li>
								<span class="name">usernameuser</span>
								나도 여기 있었는데!
							</li>
							<li>
								<span class="name">usernameusername</span>
								나도 여기 있었는데!
							</li>
						</ul>
					</div>
					<div class="time">24분 전</div>
				</div>
				<!-- //컨텐츠댓글 -->
			</div>

			<div class="content_item">
				<!-- 컨텐츠상단 -->
				<div class="content_info">
					<div class="user">
						<a href="#">
							<img src="/images/common/user.png" class="img" alt="">
							<span class="name">username</span>
							<span class="school">초등학교</span>
						</a>
					</div>
					<span class="category">줍깅 챌린지</span>
					<a href="#" class="btn_more" onClick="uiLayer.open('#mainContentMore');return false;">메뉴</a>
				</div>
				<!-- //컨텐츠상단 -->
				<!-- 컨텐츠이미지 -->
				<div class="content_img">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
							<div class="swiper-slide">
								<div class="img"><img src="/images/temp/main_content.png" alt=""></div>
							</div>
						</div>
						 <div class="swiper-pagination"></div>
					</div>
				</div>
				<!-- //컨텐츠이미지 -->
				<!-- 컨텐츠댓글 -->
				<div class="content_etc">
					<div class="icon">
						<a href="#"><img src="/images/common/icon_like.png" class="icon_like" alt=""></a>
						<a href="#"><img src="/images/common/icon_like_on.png" class="icon_like" alt=""></a>
						<img src="/images/common/icon_reply.png" class="icon_reply" alt="">
					</div>
					<div class="cont_like">
						<span class="count">좋아요 00000개</span>
						<ul>
							<li>
								<span class="name">username</span>
								좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요...
								<a href="#" class="btn_more">더보기</a>
							</li>
						</ul>
					</div>
					<div class="cont_reply">
						<a href="#" class="count" onClick="uiPage.open('#uipage_reply');return false">댓글 0000개 모두 보기</a>
						<ul>
							<li>
								<span class="name">usernameuser</span>
								나도 여기 있었는데!
							</li>
							<li>
								<span class="name">usernameusername</span>
								나도 여기 있었는데!
							</li>
						</ul>
					</div>
					<div class="time">24분 전</div>
				</div>
				<!-- //컨텐츠댓글 -->
			</div>
		</div>
	</div>
	<!-- //container -->
	<script type="text/javascript">
		new Swiper('.content_img .swiper-container', {
			slidesPerView: 1,
			pagination: {
				el: ".swiper-pagination",
			},
		});
	</script>

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->

	<!-- 레이어:탄소서약서 -->
	<div id="mainCarbonPledge" class="uilayer_wrap">
		<div class="uilayer_dimmed"></div>
		<div class="uilayer_content uilayer_main_carbon_pledge">
			<div class="layer_top">
				<strong class="tit">탄소서약서</strong>
				<p class="desc">나는 기후위기를 극복하고 다음 세대에게 깨끗하고 밝은<br> 미래를 전해주기 위하여 연간 탄소 1톤 줄이기 운동에<br> 적극 참여할 것을 서약합니다.</p>
			</div>
			<div class="layer_body">
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
			<div class="layer_close">
				<button type="button" class="btn_close" onClick="uiLayer.close('#mainCarbonPledge');">닫기</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		uiLayer.open('#mainCarbonPledge');
	</script>
	<!-- //레이어:탄소서약서 -->

	<!-- 레이어:더보기 -->
	<div id="mainContentMore" class="uilayer_wrap">
		<div class="uilayer_dimmed"></div>
		<div class="uilayer_content uilayer_main_content_more">
			<button type="button" class="btn_close" onClick="uiLayer.close('#mainContentMore');">닫기</button>
			<ul class="list_fn">
				<li><a href="#" class="btn_share">공유하기</a></li>
				<li><a href="#" class="btn_report" onClick="uiLayer.close('#mainContentMore');uiLayer.open('#mainContentReport');return false;">신고하기</a></li>
				<li><a href="#" class="btn_edit">수정하기</a></li>
				<li><a href="#" class="btn_delete">삭제하기</a></li>
			</ul>
		</div>
	</div>
	<!-- //레이어:더보기 -->

	<!-- 레이어:게시물신고 -->
	<div id="mainContentReport" class="uilayer_wrap">
		<div class="uilayer_dimmed"></div>
		<div class="uilayer_content uilayer_main_content_report">
			<button type="button" class="btn_close" onClick="uiLayer.close('#mainContentReport');">닫기</button>
			<strong class="tit">게시물 신고</strong>
			<ul class="list_reason">
				<li>
					<input type="radio" id="report-reason1" class="radio_report" name="report-reason">
					<label for="report-reason1" class="label">부적절한 사진</label>
				</li>
				<li>
					<input type="radio" id="report-reason2" class="radio_report" name="report-reason">
					<label for="report-reason2" class="label">욕설</label>
				</li>
				<li>
					<input type="radio" id="report-reason3" class="radio_report" name="report-reason">
					<label for="report-reason3" class="label">챌린지와 관련 없는 내용</label>
				</li>
				<li>
					<input type="radio" id="report-reason4" class="radio_report" name="report-reason">
					<label for="report-reason4" class="label">수칙 미준수</label>
				</li>
				<li>
					<input type="radio" id="report-reason5" class="radio_report" name="report-reason">
					<label for="report-reason5" class="label">기타</label>
				</li>
			</ul>
			<div class="write_reason">
				<textarea placeholder="내용을 입력하세요"></textarea>
			</div>
			<a href="#" class="btn_report" onClick="uiLayer.close('#mainContentReport');return false;">신 고 하 기</a>
		</div>
	</div>
	<!-- //레이어:게시물신고 -->
</div>

<!-- 댓글 -->
<div class="uipage_dimmed"></div>
<div id="uipage_reply" class="uipage_side uipage_reply">
	<div class="uipage_header">
		<strong class="uipage_title">댓글</strong>
		<button type="button" class="btn_uipage_close" onClick="uiPage.close('#uipage_reply');"><span class="blind">닫기</span></button>
	</div>
	<div class="uipage_body">
		<div class="origin_content">
			<div class="user_info">
				<img src="/images/common/user.png" class="profile" alt="">
				<span class="about">
					<span class="name">username</span>
					<span class="school">옥천초등학교</span>
					<span class="time">24분 전</span>
				</span>
			</div>
			<div class="cont">좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요</div>
		</div>
		<div class="list_reply">
			<ul>
				<li>
					<div class="user_info">
						<img src="/images/common/user.png" class="profile" alt="">
						<span class="about">
							<span class="name">username</span>
							<span class="school">옥천초등학교</span>
							<span class="time">24분 전</span>
						</span>
					</div>
					<div class="cont">좋아요좋아요</div>
					<div class="bottom_area">
						<span class="like">좋아요 1개</span>
						<a href="#" class="btn_reply">답글 달기</a>
					</div>
					<a href="#" class="btn_like">좋아요</a>
				</li>
				<li>
					<div class="user_info">
						<img src="/images/common/user.png" class="profile" alt="">
						<span class="about">
							<span class="name">username</span>
							<span class="school">옥천초등학교</span>
							<span class="time">24분 전</span>
						</span>
					</div>
					<div class="cont">좋아요좋아요</div>
					<div class="bottom_area">
						<span class="like">좋아요 1개</span>
						<a href="#" class="btn_reply">답글 달기</a>
					</div>
					<a href="#" class="btn_like">좋아요</a>
				</li>
				<li>
					<div class="user_info">
						<img src="/images/common/user.png" class="profile" alt="">
						<span class="about">
							<span class="name">username</span>
							<span class="school">옥천초등학교</span>
							<span class="time">24분 전</span>
						</span>
					</div>
					<div class="cont">좋아요좋아요</div>
					<div class="bottom_area">
						<span class="like">좋아요 1개</span>
						<a href="#" class="btn_reply">답글 달기</a>
					</div>
					<a href="#" class="btn_like">좋아요</a>
					<a href="#" class="btn_replay_more">답글 00개 보기</a>
					<!-- 대댓글 -->
					<ul class="list_rereply">
						<li>
							<div class="user_info">
								<img src="/images/common/user.png" class="profile" alt="">
								<span class="about">
									<span class="name">username</span>
									<span class="school">옥천초등학교</span>
									<span class="time">24분 전</span>
								</span>
							</div>
							<div class="cont">좋아요좋아요</div>
							<div class="bottom_area">
								<span class="like">좋아요 1개</span>
								<a href="#" class="btn_reply">답글 달기</a>
							</div>
							<a href="#" class="btn_like">좋아요</a>
						</li>
						<li>
							<div class="user_info">
								<img src="/images/common/user.png" class="profile" alt="">
								<span class="about">
									<span class="name">username</span>
									<span class="school">옥천초등학교</span>
									<span class="time">24분 전</span>
								</span>
							</div>
							<div class="cont">좋아요좋아요</div>
							<div class="bottom_area">
								<span class="like">좋아요 1개</span>
								<a href="#" class="btn_reply">답글 달기</a>
							</div>
							<a href="#" class="btn_like">좋아요</a>
						</li>
					</ul>
					<!-- //대댓글 -->
				</li>
			</ul>
		</div>
		<div class="reply_form">
			<img src="/images/common/user.png" class="profile" alt="">
			<input type="text" class="input_reply" placeholder="username(으)로 댓글 달기">
			<a href="#" class="btn_submit">게시</a>
		</div>
	</div>
</div>
<!-- //댓글 -->
</body>
</html>
