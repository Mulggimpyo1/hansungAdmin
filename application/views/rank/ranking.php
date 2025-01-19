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
							<li><a href="/rank/ranking" class="on">개인 랭킹</a></li>
							<?php if($this->CONFIG_DATA['userData']['user_level']<7){ ?>
							<li><a href="/rank/rankClass">학급 랭킹</a></li>
							<li><a href="/rank/rankSchool">학교 랭킹</a></li>
							<?php } ?>
						</ul>
					</div>
					<?php if($this->CONFIG_DATA['userData']['user_level']<7){ ?>
					<div class="only_check">
						<span class="uicheckbox_wrap uicheckbox_size12">
							<input type="checkbox" id="only-my" name="my_group" value="Y" class="uicheckbox_check" onchange="loadRank()">
							<label for="only-my" class="uicheckbox_label">내 소속만 보기</label>
						</span>
					</div>
				<?php }else{ ?>
					<input type="hidden" id="only-my" name="my_group" value="N">
				<?php } ?>
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
		var my_group = $('input[name="my_group"]:checked').val();

		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var formData = {
			"search_year"	:	search_year,
			"search_month"	:	search_month,
			"my_group"	:	my_group
    };

    formData[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/rank/soloRank",
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
				if($data.rankArr[i].school_name==null||$data.rankArr[i].school_name==''){
					html += '<span class="user">'+$data.rankArr[i].user_name+'<span class="school">(일반)</span></span>';
				}else{
					html += '<span class="user">'+$data.rankArr[i].user_name+'<span class="school">('+$data.rankArr[i].school_name+'-'+$data.rankArr[i].school_year+'학년'+'-'+$data.rankArr[i].school_class+')</span></span>';
				}

				html += '<span class="co2">'+Number($data.rankArr[i].carbon).toFixed(1)+'kg</span>';
				html += '</li>';
			}

			if($data.myRank > 10){
				var rate = ($data.myRank / $data.total_point_member) * 100;
				html += '<li class="my_rank">';
				html += '<span class="rank_num">'+$data.myRank+'</span>';
				if($data.userData.school_name==null){
					html += '<span class="user">'+$data.userData.user_name+'<span class="school">('+$data.userData.school_name+'-'+$data.userData.school_year+'학년-'+$data.userData.school_class+'반)</span><span class="rate">상위'+rate+'%</span></span>';
				}else{
					html += '<span class="user">'+$data.userData.user_name+'<span class="school">(일반)</span><span class="rate">상위'+rate+'%</span></span>';
				}

				html += '<span class="co2">'+$data.my_carbon+'kg</span>';
				html += '</li>';
			}

		}


		$('#rankWrap').html(html);
	}
	</script>
