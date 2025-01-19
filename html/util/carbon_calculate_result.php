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
				<div class="area">
					<div class="row">
						<input type="text" class="input_calculate" style="width:75px;margin-right:5px;"> 님은 한달간
						<input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> kg의 CO<span class="sub">2</span>를 배출합니다.
					</div>
					<div class="row">
						<input type="text" class="input_calculate" style="width:75px;margin-right:5px;"> kg의 CO<span class="sub">2</span>를 없애기 위해서는
					</div>
					<div class="row">
						연간 <input type="text" class="input_calculate" style="width:75px;margin:0 5px;"> 그루의 잣나무를 심어야 해요.
					</div>
				</div>
			</div>
			<strong class="tit_calculate_group">생활 속에서 CO<span class="sub">2</span> 줄이기</strong>
			<div class="calculate_group">
				<div class="area_center">
					<div class="row">
						하루에 TV 시청을 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> 시간 줄이면
						<span class="kg"><input type="text" class="input_calculate" style="width:60px;margin-right:5px;"> kg</span>
					</div>
					<div class="row">
						하루에 컴퓨터를 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> 시간 줄이면
						<span class="kg"><input type="text" class="input_calculate" style="width:60px;margin-right:5px;"> kg</span>
					</div>
					<div class="row">
						한달에 세탁 횟수를 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> 회 줄이면
						<span class="kg"><input type="text" class="input_calculate" style="width:60px;margin-right:5px;"> kg</span>
					</div>
					<div class="row">
						한달에 쓰레기를 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> L 줄이면
						<span class="kg"><input type="text" class="input_calculate" style="width:60px;margin-right:5px;"> kg</span>
					</div>
				</div>
			</div>
			<div class="calculate_group">
				<div class="row">
					<input type="text" class="input_calculate" style="width:75px;margin-right:5px;"> 님의 실천으로
				</div>
				<div class="row">
					한달간 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> kg의 CO<span class="sub">2</span>를 줄일 수 있습니다.
				</div>
				<div class="row">
					<input type="text" class="input_calculate" style="width:50px;margin-right:5px;"> kg의 CO<span class="sub">2</span>를 없애기 위해서는
				</div>
				<div class="row">
					연간 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;"> 그루의 잣나무를 심어야 해요.
				</div>
			</div>
			<a href="#" class="btn_calculate">다 시 계 산 하 기</a>
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
