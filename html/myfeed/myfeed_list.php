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
		<h2 class="blind">피드</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_write">작성</a></li>
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
			<div class="user_info">
				<div class="photo">
					<img src="/images/common/user.png" class="user" alt="">
					<span class="icon"><img src="/images/feed/icon_photo.png" alt=""></span>
					<input type="file" class="input_photo">
				</div>
				<div class="name">홍길동 <img src="/images/feed/icon_star.png" class="icon_star" alt=""></div>
				<div class="school">옥천초등학교 3-2</div>
			</div>
			<div class="cate_feed">
				<ul>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate1.png" class="icon_cate icon_all" alt="">
							<div class="txt">전체<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate2.png" class="icon_cate" alt="">
							<div class="txt">재활용<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate3.png" class="icon_cate" alt="">
							<div class="txt">줍깅<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate4.png" class="icon_cate" alt="">
							<div class="txt">나무심기<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate5.png" class="icon_cate" alt="">
							<div class="txt">에너지<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate6.png" class="icon_cate" alt="">
							<div class="txt">B&middot;M&middot;W<span class="num">100</span></div>
						</a>
					</li>
					<li>
						<a href="#">
							<img src="/images/feed/feed_cate7.png" class="icon_cate" alt="">
							<div class="txt">식단<span class="num">100</span></div>
						</a>
					</li>
				</ul>
			</div>
			<div class="feed_content">
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
							<a href="#" class="count">댓글 0000개 모두 보기</a>
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
							<a href="#" class="count">댓글 0000개 모두 보기</a>
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
		<!-- //피드 -->
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
</body>
</html>
