<div id="wrap" class="full_height">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">랭킹</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container" class="ranking_container">
		<!-- 랭킹 -->
		<div class="ranking_wrap">
			<div class="ranking_top">
				<ul class="tab_type">
          <li><a href="/rank/achieve">성취도</a></li>
					<li><a href="/rank/ranking" class="on">랭킹</a></li>
				</ul>
				<div class="ranking_search">
					<div class="date">
						<span class="label">기간</span>
						<select class="uiselect uiselect_size25" id="search_year" style="width:75px" onchange="loadRank()">
							<?php for($i=2022; $i<=date("Y");$i++){ ?>
								<option value="<?php echo $i ?>" <?php echo date("Y")==$i?"selected":""; ?>><?php echo $i ?>년</option>
							<?php } ?>
						</select>
						<select class="uiselect uiselect_size25" id="search_month" style="width:75px" onchange="loadRank()">
							<?php for($i=1; $i<=12; $i++){ ?>
								<option value="<?php echo sprintf('%02d',$i) ?>" <?php echo date("m")==sprintf('%02d',$i)?"selected":""; ?>><?php echo sprintf('%02d',$i) ?>월</option>
								<?php } ?>
						</select>
					</div>
					<div class="sub_tab">
						<ul>
              <li><a href="/rank/ranking">개인 랭킹</a></li>
							<li><a href="/rank/rankClass">학급 랭킹</a></li>
							<li><a href="/rank/rankSchool" class="on">학교 랭킹</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ranking_body">
				<div class="ranking_scroll">
					<div class="list_ranking">
						<ul id="rankWrap">

						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- //랭킹 -->
	</div>
	<!-- //container -->
	<script>
	$(function(){
		loadRank();
	});

	function loadRank()
	{
		var search_year = $('#search_year').val();
		var search_month = $('#search_month').val();

		var csrf_name = $('#csrf').attr("name");
		var csrf_val = $('#csrf').val();

		var formData = {
			"search_year"	:	search_year,
			"search_month"	:	search_month
		};

		formData[csrf_name] = csrf_val;

		$.ajax({
			type: "POST",
			url : "/rank/schoolRank",
			data: formData,
			dataType:"json",
			success : function($data, status, xhr) {
				console.log($data.data);
				makeRank($data.data);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText);
			}
		});
	}

	function makeRank($data)
	{
		var html = "";
		if($data.rankArr.length>0){
			for(var i = 0; i<$data.rankArr.length; i++){
				html += '<li>';
				if(i<3){
					html += '<span class="rank_num rank'+(i+1)+'">'+i+'</span>';
				}else{
					html += '<span class="rank_num">'+(i+1)+'</span>';
				}
				if($data.rankArr[i].school_name==null){
					html += '<span class="user">일반</span>';
				}else{
					html += '<span class="user">'+$data.rankArr[i].school_name+'</span>';
				}

				html += '<span class="co2">'+Number($data.rankArr[i].carbon).toFixed(1)+'kg</span>';
				html += '</li>';
			}

			if($data.myRank > 10){
				var rate = ($data.myRank / $data.total_point_school) * 100;
				html += '<li class="my_rank">';
				html += '<span class="rank_num">'+$data.myRank+'</span>';
				html += '<span class="user">'+$data.userData.school_name+'<span class="rate">상위'+rate+'%</span></span>';
				html += '<span class="co2">'+Number($data.my_carbon).toFixed(1)+'kg</span>';
				html += '</li>';
			}

		}



		$('#rankWrap').html(html);
	}
	</script>
