<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">{page_title}</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="/feed/write" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 챌린지상세 -->
		<div class="challenge_wrap">
			<div class="challenge_detail">
				<div class="challenge_img" style="overflow:hidden">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php for($i=0; $i<10; $i++){ ?>
								<?php if(!empty($challengeData['image'.($i+1)])){ ?>
							<div class="swiper-slide">
								<div class="img"><img src="/upload/challenge/<?php echo $challengeData['image'.($i+1)]; ?>" alt=""></div>
							</div>
							<?php } ?>
							<?php } ?>
						</div>
						 <div class="swiper-pagination"></div>
					</div>
				</div>
				<a href="/feed/write?challenge_1={challenge_1}&challenge_2={challenge_2}" class="btn_challenge">챌 린 지 하 러 가 기</a>
			</div>
		</div>
		<!-- //챌린지상세 -->
	</div>
	<!-- //container -->
	<script type="text/javascript">
		new Swiper('.challenge_img .swiper-container', {
			slidesPerView: 1,
			pagination: {
				el: ".swiper-pagination",
			},
		});
	</script>
