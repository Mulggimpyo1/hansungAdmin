<!DOCTYPE html>
<html lang="ko">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/head.php'); ?>
</head>
<body>
<div id="wrap" class="full_height">
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
	<div id="container" class="ranking_container">
		<!-- 랭킹 -->
		<div class="ranking_wrap">
			<div class="ranking_top">
				<ul class="tab_type">
					<li><a href="#">성취도</a></li>
					<li><a href="#" class="on">랭킹</a></li>
				</ul>
				<div class="ranking_search">
					<div class="date">
						<span class="label">기간</span>
						<select class="uiselect uiselect_size25" style="width:75px">
							<option>년도</option>
						</select>
						<select class="uiselect uiselect_size25" style="width:75px">
							<option>월</option>
						</select>
					</div>
					<div class="sub_tab">
						<ul>
							<li><a href="#">개인 랭킹</a></li>
							<li><a href="#">학급 랭킹</a></li>
							<li><a href="#" class="on">학교 랭킹</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ranking_body">
				<div class="ranking_scroll">
					<div class="list_ranking">
						<ul>
							<li>
								<span class="rank_num rank1">1</span>
								<span class="user">문정초등학교</span>
								<span class="co2">4000kg</span>
							</li>
							<li>
								<span class="rank_num rank2">2</span>
								<span class="user">문정초등학교</span>
								<span class="co2">4000kg</span>
							</li>
							<li>
								<span class="rank_num rank3">3</span>
								<span class="user">문정초등학교</span>
								<span class="co2">4000kg</span>
							</li>
							<li>
								<span class="rank_num">4</span>
								<span class="user">문정초등학교</span>
								<span class="co2">4000kg</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- //랭킹 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
