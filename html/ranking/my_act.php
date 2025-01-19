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
		<h2 class="page_title">랭킹</h2>
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
		<!-- 성취도 -->
		<div class="ranking_wrap">
			<ul class="tab_type">
				<li><a href="#" class="on">성취도</a></li>
				<li><a href="#">랭킹</a></li>
			</ul>
			<div class="act_section act_year">
				<strong class="tit">올해 내가 줄인 탄소량</strong>
				<div class="cont">
					<div style="width:250px;margin:0 auto;text-align:center"><img src="/images/temp/graph1.gif" alt="" style="width:100%"></div>
					<div class="result">지금까지 <span class="num">10</span>그루의 나무를<br>심은 것과 같아요!  </div>
				</div>
			</div>
			<div class="act_section act_month">
				<strong class="tit">월별 탄소 절감량</strong>
				<div class="cont">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="month"><span>1월</span></div>
								<div class="img">
									<div style="width:250px;margin:0 auto"><img src="/images/temp/graph2.gif" alt="" style="width:100%"></div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="month"><span>2월</span></div>
								<div class="img">
									<div style="width:250px;margin:0 auto"><img src="/images/temp/graph2.gif" alt="" style="width:100%"></div>
								</div>
							</div>
						</div>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
				
				</div>
				<script type="text/javascript">
					new Swiper('.act_month .swiper-container', {
						slidesPerView: 1,
						 navigation: {
							nextEl: ".swiper-button-next",
							prevEl: ".swiper-button-prev",
						},
					});
				</script>
			</div>
			<div class="act_section my_point">
				<strong class="tit">내 포인트</strong>
				<div class="cont">
					<div class="icon"><img src="/images/ranking/icon_point1.png" alt=""></div><!-- 이미지: icon_point1 ~ icon_point5 -->
					<div class="graph_wrap">
						<div class="info_level start_level">
							Lv.2
							<span class="level_point">0</span>
						</div>
						<div class="graph">
							<span class="num" style="left:30%">1000</span><!-- 그래프길이와 동일한값 적용 -->
							<div class="bar_wrap">
								<div class="bar" style="width:30%"></div>
							</div>
						</div>
						<div class="info_level end_level">
							Lv.3
							<span class="level_point">10000</span>
						</div>
					</div>
					<ul class="list_point">
						<li>
							<span class="dt">퀴즈를 통해 획득한 포인트 </span>
							<span class="dd">50 point</span>
						</li>
						<li>
							<span class="dt">챌린지를 통해 획득한 포인트</span>
							<span class="dd">50 point</span>
						</li>
						<li>
							<span class="dt">콘텐츠를 통해 획득한 포인트 </span>
							<span class="dd">50 point</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- //성취도 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
