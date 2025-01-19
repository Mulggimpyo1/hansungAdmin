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
		<h2 class="page_title">탄소발자국 계산기</h2>
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
		<!-- 탄소발자국 계산기 -->
		<div class="calculate_wrap">
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt">이름</span>
						<input type="text" class="input_calculate">
					</li>
					<li>
						<span class="dt">가족 수</span>
						<input type="text" class="input_calculate">
						<span class="unit">명</span>						
					</li>
					<li>
						<span class="dt">지역</span>
						<select class="uiselect" style="width:90px;margin-right:2px">
							<option>선택</option>
						</select>
						<select class="uiselect" style="width:90px">
							<option>선택</option>
						</select>
					</li>
				</ul>
			</div>
			<strong class="tit_calculate_group">가정에서</strong>
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt">가스</span>
						<input type="text" class="input_calculate">
						<span class="unit">m<span class="sup">3</span>/월</span>
					</li>
					<li>
						<span class="dt">수도</span>
						<input type="text" class="input_calculate">
						<span class="unit">m<span class="sup">3</span>/월</span>
					</li>
					<li>
						<span class="dt">전기</span>
						<input type="text" class="input_calculate">
						<span class="unit">kWh/월</span>						
					</li>
					<li>
						<span class="dt">쓰레기</span>
						<input type="text" class="input_calculate">
						<span class="unit">L/월</span>						
					</li>
				</ul>
			</div>
			<strong class="tit_calculate_group">교통</strong>
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt">자가용</span>
						<input type="text" class="input_calculate">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt">버스</span>
						<input type="text" class="input_calculate">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt">지하철</span>
						<input type="text" class="input_calculate">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt">일반기차</span>
						<input type="text" class="input_calculate">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt">KTX</span>
						<input type="text" class="input_calculate">
						<span class="unit">km/월</span>
					</li>
				</ul>
			</div>
			<a href="#" class="btn_calculate">계 산 하 기</a>
		</div>
		<!-- //탄소발자국 계산기 -->
	</div>
	<!-- //container -->

	<!-- footer -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/footer.php'); ?>
	<!-- //footer -->
</div>
</body>
</html>
