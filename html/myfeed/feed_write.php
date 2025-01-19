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
		<h2 class="page_title">새 게시물</h2>
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
		<!-- 피드 -->
		<div class="feed_wrap">
			<div class="feed_form">
				<div class="form_tit">
					<ul>
						<li class="date">
							<span class="dt">날짜</span>
							<div class="cont">2023.12.12</div>
						</li>
						<li class="challenge">
							<span class="dt">챌린지</span>
							<div class="cont">
								<div class="sel">
									<select class="uiselect">
										<option>선택하세요</option>
									</select>
								</div>
								<div class="sel">
									<select class="uiselect">
										<option>선택하세요</option>
									</select>
								</div>
							</div>
						</li>
						<li class="challenge has_info">
							<span class="dt">챌린지 <a href="#" class="info_challenge" onClick="uiLayer.open('#feedCategory');return false;"><img src="/images/feed/icon_info.png" alt=""></a></span>
							<div class="cont">
								<div class="sel">
									<select class="uiselect">
										<option>선택하세요</option>
									</select>
								</div>
								<div class="sel">
									<select class="uiselect">
										<option>선택하세요</option>
									</select>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="form_photo">
					사진등록
					<input type="file" class="input_photo">
				</div>
				<div class="list_photo">
					<ul>
						<li><img src="/images/temp/main_content.png" alt=""><a href="#" class="btn_delete"><span>삭제</span></a></li>
						<li><img src="/images/temp/main_content.png" alt=""><a href="#" class="btn_delete"><span>삭제</span></a></li>
						<li><img src="/images/temp/main_content.png" alt=""><a href="#" class="btn_delete"><span>삭제</span></a></li>
						<li><img src="/images/temp/main_content.png" alt=""><a href="#" class="btn_delete"><span>삭제</span></a></li>
						<li><img src="/images/temp/main_content.png" alt=""><a href="#" class="btn_delete"><span>삭제</span></a></li>
						<li class="btn_more"><div class="btn_photo">사진추가<input type="file" class="more_photo"></div></li>
					</ul>
				</div>
				<div class="form_cont">
					<textarea placeholder="내용을 입력하세요."></textarea>
					<ul class="list_check">
						<li>
							<span class="uicheckbox_wrap uicheckbox_size14">
								<input type="checkbox" id="feedAgree" class="uicheckbox_check">
								<label for="feedAgree" class="uicheckbox_label">(필수) 일주일동안 성실하게 챌린지에 참여할 것을 약속합니다. </label>
							</span>
						</li>
						<li>
							<span class="uicheckbox_wrap uicheckbox_size14">
								<input type="checkbox" id="feedOption" class="uicheckbox_check">
								<label for="feedOption" class="uicheckbox_label">댓글 금지</label>
							</span>
						</li>
					</ul>
				</div>
				<a href="#" class="btn_feed_write">게 시 하 기</a>
			</div>
		</div>
		<!-- //피드 -->
	</div>
	<!-- //container -->

	<!-- 레이어:챌린지팝업 -->
	<div id="feedCategory" class="uilayer_wrap">
		<div class="uilayer_dimmed" onClick="uiLayer.close('#feedCategory');"></div>
		<div class="uilayer_pannel">
			<div class="feed_cate_layer">
				<div class="list_depth1">
					<ul>
						<li><a href="#">줍깅<br>챌린지</a></li>
						<li><a href="#" class="on">에너지<br>챌린지</a></li>
						<li><a href="#">B·M·W<br>챌린지</a></li>
						<li><a href="#">재활용<br>챌린지</a></li>
						<li><a href="#">나무심기<br>챌린지</a></li>
						<li><a href="#">잔반zero<br>챌린지</a></li>
					</ul>
				</div>
				<div class="list_depth2">
					<ul>
						<li><a href="#">1</a></li>
						<li><a href="#">2</a></li>
						<li><a href="#" class="on">3</a></li>
						<li><a href="#">4</a></li>
						<li><a href="#">5</a></li>
						<li><a href="#">6</a></li>
						<li><a href="#">7</a></li>
					</ul>
				</div>
				<div class="list_depth3">
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
				<script type="text/javascript">
					new Swiper('.feed_cate_layer .list_depth3 .swiper-container', {
						slidesPerView: 1,
						pagination: {
							el: ".swiper-pagination",
						},
					});
				</script>
			</div>
		</div>
	</div>
	<!-- //레이어:챌린지팝업 -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
