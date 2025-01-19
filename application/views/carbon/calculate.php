<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">탄소발자국 계산기</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 탄소발자국 계산기 -->
		<div class="calculate_wrap" id="dep1">
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt">이름</span>
						<input type="text" class="input_calculate" id="user_name">
					</li>
					<li>
						<span class="dt">가족 수</span>
						<input type="number" class="input_calculate" id="family_num">
						<span class="unit">명</span>
					</li>
					<!--
					<li>
						<span class="dt">지역</span>
						<select class="uiselect" style="width:90px;margin-right:2px">
							<option>선택</option>
						</select>
						<select class="uiselect" style="width:90px">
							<option>선택</option>
						</select>
					</li>
				-->
				</ul>
			</div>
			<strong class="tit_calculate_group">가정에서</strong>
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt"><img src="/images/util/gas.png"/>가스</span>
						<input type="number" class="input_calculate" id="gas_num">
						<span class="unit">m<span class="sup">3</span>/월</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/water.png"/>수도</span>
						<input type="number" class="input_calculate" id="water_num">
						<span class="unit">m<span class="sup">3</span>/월</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/elec.png"/>전기</span>
						<input type="number" class="input_calculate" id="elec_num">
						<span class="unit">kWh/월</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/trash.png"/>쓰레기</span>
						<input type="number" class="input_calculate" id="gab_num">
						<span class="unit">L/월</span>
					</li>
				</ul>
			</div>
			<strong class="tit_calculate_group">교통</strong>
			<div class="calculate_group">
				<ul class="form_calculate">
					<li>
						<span class="dt"><img src="/images/util/car.png"/>자가용</span>
						<input type="number" class="input_calculate" id="car_num">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/bus.png"/>버스</span>
						<input type="number" class="input_calculate" id="bus_num">
						<span class="unit">분/일</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/subway.png"/>지하철</span>
						<input type="number" class="input_calculate" id="sub_num">
						<span class="unit">분/일</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/train.png"/>일반기차</span>
						<input type="number" class="input_calculate" id="train_num">
						<span class="unit">km/월</span>
					</li>
					<li>
						<span class="dt"><img src="/images/util/ktx.png"/>KTX</span>
						<input type="number" class="input_calculate" id="ktx_num">
						<span class="unit">km/월</span>
					</li>
				</ul>
			</div>
			<a href="javascript:cal();" class="btn_calculate">계 산 하 기</a>
		</div>
		<!-- //탄소발자국 계산기 -->

    <!-- 탄소발자국 계산기 -->
		<div class="calculate_wrap" id="dep2" style="display:none;">
			<div class="calculate_group">
				<div class="area">
					<div class="row">
						<input type="text" class="input_calculate" style="width:75px;margin-right:5px;" id="an_user_id"> 님은 한달간
						<input type="text" class="input_calculate" style="width:50px;margin:0 5px;" id="an_total_carbon"> kg의 CO<span class="sub">2</span>를 배출합니다.
					</div>
					<div class="row">
						<input type="text" class="input_calculate" style="width:75px;margin-right:5px;" id="an_erase_carbon"> kg의 CO<span class="sub">2</span>를 없애기 위해서는
					</div>
					<div class="row">
						연간 <input type="text" class="input_calculate" style="width:75px;margin:0 5px;" id="an_tree"> 그루의 잣나무를 심어야 해요.
					</div>
				</div>
			</div>
			<strong class="tit_calculate_group">생활 속에서 CO<span class="sub">2</span> 줄이기</strong>
			<div class="calculate_group">
				<div class="area_center">
					<div class="row">
						하루에 TV 시청을 <input type="number" class="input_calculate" style="width:50px;margin:0 5px;" id="tv_num" onkeyup="cal2()"> 시간 줄이면
						<span class="kg"><input type="number" class="input_calculate" style="width:60px;margin-right:5px;" id="tv_val"> kg</span>
					</div>
					<div class="row">
						하루에 컴퓨터를 <input type="number" class="input_calculate" style="width:50px;margin:0 5px;" id="com_num" onkeyup="cal2()"> 시간 줄이면
						<span class="kg"><input type="number" class="input_calculate" style="width:60px;margin-right:5px;" id="com_val" onkeyup="cal2()"> kg</span>
					</div>
					<div class="row">
						한달에 세탁 횟수를 <input type="number" class="input_calculate" style="width:50px;margin:0 5px;" id="wash_num" onkeyup="cal2()"> 회 줄이면
						<span class="kg"><input type="number" class="input_calculate" style="width:60px;margin-right:5px;" id="wash_val"> kg</span>
					</div>
					<div class="row">
						한달에 쓰레기를 <input type="number" class="input_calculate" style="width:50px;margin:0 5px;" id="an_gab_num" onkeyup="cal2()"> L 줄이면
						<span class="kg"><input type="number" class="input_calculate" style="width:60px;margin-right:5px;" id="an_gab_val"> kg</span>
					</div>
				</div>
			</div>
			<div class="calculate_group">
				<div class="row">
					<input type="text" class="input_calculate" style="width:75px;margin-right:5px;" id="an2_user_name"> 님의 실천으로
				</div>
				<div class="row">
					한달간 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;" id="an2_erase_carbon"> kg의 CO<span class="sub">2</span>를 줄일 수 있습니다.
				</div>
				<div class="row">
					<input type="text" class="input_calculate" style="width:50px;margin-right:5px;" id="an2_erase_carbon2"> kg의 CO<span class="sub">2</span>를 없애기 위해서는
				</div>
				<div class="row">
					연간 <input type="text" class="input_calculate" style="width:50px;margin:0 5px;" id="an2_tree"> 그루의 잣나무를 심어야 해요.
				</div>
			</div>
			<a href="/carbon/calculate" class="btn_calculate">다 시 계 산 하 기</a>
		</div>
		<!-- //탄소발자국 계산기 -->
	</div>
	<!-- //container -->
<script>
function cal()
{
	var family_num = $('#family_num').val();
	var user_name = $('#user_name').val();
	var gas_num = $('#gas_num').val();
	var water_num = $('#water_num').val();
	var elec_num = $('#elec_num').val();
	var gab_num = $('#gab_num').val();
	var car_num = $('#car_num').val();
	var bus_num = $('#bus_num').val();
	var sub_num = $('#sub_num').val();
	var train_num = $('#train_num').val();
	var ktx_num = $('#ktx_num').val();

	if(user_name == ""){
		swal("이름을 작성해주세요");
		return;
	}
	if(family_num == ""){
		swal("가족 수를 작성해주세요");
		return;
	}

	if(gas_num == ""){
		gas_num = 0;
	}
	if(water_num == ""){
		water_num = 0;
	}
	if(elec_num == ""){
		elec_num = 0;
	}
	if(gab_num == ""){
		gab_num = 0;
	}
	if(car_num == ""){
		car_num = 0;
	}
	if(bus_num == ""){
		bus_num = 0;
	}
	if(sub_num == ""){
		sub_num = 0;
	}
	if(train_num == ""){
		train_num = 0;
	}
	if(ktx_num == ""){
		ktx_num = 0;
	}

	gas_val = Math.floor((gas_num * 2.22)/family_num);
	water_val = Math.floor((water_num * 1.53)/family_num);
	elec_val = Math.floor((elec_num * 0.42)/family_num);
	gab_val = Math.floor((gab_num * 0.09)/family_num);
	car_val = Math.floor((car_num * 0.28)/family_num);
	bus_val = Math.floor((bus_num * 0.006));
	sub_val = Math.floor((sub_num * 0.006));
	train_val = Math.floor((train_num * 0.023));
	ktx_val = Math.floor((ktx_num * 0.025));

	var total_carbon = Number(gas_val)+Number(water_val)+Number(elec_val)+Number(gab_val)+Number(car_val)+Number(bus_val)+Number(sub_val)+Number(train_val)+Number(ktx_val);

	$('#an_user_id').val(user_name);
	$('#an_total_carbon').val(Math.floor(total_carbon));
	$('#an_erase_carbon').val(Math.floor(total_carbon));
	$('#an_tree').val(Math.floor(total_carbon/0.27));

	$('#dep2').show();
	$('#dep1').hide();


}

function cal2()
{
	var tv_num = $('#tv_num').val();
	var com_num = $('#com_num').val();
	var wash_num = $('#wash_num').val();
	var an_gab_num = $('#an_gab_num').val();
	var family_num = $('#family_num').val();
	var user_name = $('#user_name').val();

	$('#tv_val').val(Math.floor((tv_num*2.82)/family_num));
	$('#com_val').val(Math.floor((com_num*5.72)));
	$('#wash_val').val(Math.floor((wash_num*0.04)/family_num));
	$('#an_gab_val').val(Math.floor((an_gab_num*0.094)/family_num));

	var tv_val = $('#tv_val').val();
	var com_val = $('#com_val').val();
	var wash_val = $('#wash_val').val();
	var an_gab_val = $('#an_gab_val').val();

	var total = Number(tv_val) + Number(com_val) + Number(wash_val) + Number(an_gab_val);

	$('#an2_user_name').val(user_name);
	$('#an2_erase_carbon').val(total);
	$('#an2_erase_carbon2').val(total);
	$('#an2_tree').val(Math.floor(total/0.27));

}
</script>
