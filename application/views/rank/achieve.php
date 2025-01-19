<div id="wrap">
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
	<div id="container">
		<!-- 성취도 -->
		<div class="ranking_wrap">
			<ul class="tab_type">
				<li><a href="/rank/achieve" class="on">성취도</a></li>
				<li><a href="/rank/ranking">랭킹</a></li>
			</ul>
			<div class="act_section act_year">
				<strong class="tit">올해 탄소 절감량</strong>
				<div class="cont">
					<div style="width:250px;margin:0 auto;text-align:center"><canvas id="tree_chart" width="100%"></canvas></div>
					<div class="result">지금까지 <span class="num" id="tree_num"></span>그루의 나무를<br>심은 것과 같아요!  </div>
				</div>
			</div>
			<div class="act_section act_month">
				<strong class="tit">월별 탄소 절감량</strong>
				<div class="cont">
					<div class="swiper-container">
						<div class="swiper-wrapper" id="monthWrap">

						</div>
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>

				</div>
				<script type="text/javascript">

				</script>
			</div>
			<div class="act_section my_point">
				<strong class="tit">내 포인트</strong>
				<div class="cont">
					<div class="icon">
						<img src="/images/ranking/lv<?php echo $point_level; ?>.gif" alt="">
					</div><!-- 이미지: icon_point1 ~ icon_point5 -->
					<div class="graph_wrap">
						<?php if($point_level<5){ ?>
						<div class="info_level start_level">
							Lv.<?php echo $point_level; ?>
							<span class="level_point"><?php echo $start_num; ?></span>
						</div>
						<?php } ?>
						<div class="graph">
							<span class="num" style="left:<?php echo $point_per; ?>%"><?php echo $user_total_point; ?></span><!-- 그래프길이와 동일한값 적용 -->
							<div class="bar_wrap">
								<div class="bar" style="width:<?php echo $point_per; ?>%"></div>
							</div>
						</div>
						<div class="info_level end_level">
							Lv.<?php echo ($point_level+1)<5?$point_level+1:5; ?>
							<span class="level_point"><?php echo $end_num; ?></span>
						</div>
					</div>
					<ul class="list_point">
						<li>
							<span class="dt">퀴즈를 통해 획득한 포인트 </span>
							<span class="dd"><?php echo $user_quiz_point; ?> point</span>
						</li>
						<li>
							<span class="dt">챌린지를 통해 획득한 포인트</span>
							<span class="dd"><?php echo $user_challenge_point; ?> point</span>
						</li>
						<li>
							<span class="dt">콘텐츠를 통해 획득한 포인트 </span>
							<span class="dd"><?php echo $user_contents_point; ?> point</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- //성취도 -->
	</div>
	<!-- //container -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
	<script>
	$(function(){
		treeChartLoad();
		loadMonthChart();
	});

	function treeChartLoad()
	{
		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = {

    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/rank/carbonTreeLoad",
      data: data,
      dataType:"json",
      success : function($data, status, xhr) {
				$('#tree_num').text($data.data.tree_num);
				var ctx = document.getElementById("tree_chart");

				var margin_num = 1000-$data.data.carbon_point;
				if(margin_num<=0){
					margin_num = 0;
				}


				const data = {
					labels: ['Score','Gray Area'],
					datasets: [{
						label: 'wwww',
						data: [$data.data.carbon_point,margin_num],
						backgroundColor:[
							'rgba(255.26,104,0.2)',
							'rgba(0,0,0,0.2)'
						],
						borderColor:[
							'rgba(255,26,104,1)',
							'rgba(0,0,0,0.2)'
						],
						borderWidth: 1,
						cutout: '90%',
						circumference: 180,
						rotation: 270
					}]
				};

				const gaugeChartText = {
					id: 'gaugeChartText',
					afterDatasetsDraw(chart,args,pluginOptions){
						const { ctx, data, chartArea: {top, bottom, left, right,width,height},scales: {r}} = chart;
						ctx.save();
						const xCoor = chart.getDatasetMeta(0).data[0].x;
						const yCoor = chart.getDatasetMeta(0).data[0].y;
						const score = data.datasets[0].data[0];




						ctx.font = '15px sans-serif';
						ctx.fillStyle = '#666';
						ctx.textBaseLine = 'top';
						ctx.textAlign = "left";
						ctx.fillText('0kg',left,yCoor + 15);

						ctx.textAlign = "right";
						ctx.fillText('1,000kg',right-5, yCoor + 15);

						ctx.font = '40px sans-serif';
						ctx.textAlign = "center";
						ctx.textBaseLine = 'bottom';
						var kg = score;
						if(kg==null){
							kg = 0;
						}
						ctx.fillText(kg+'kg',xCoor, yCoor );
					}
				}

				const config = {
					type: 'doughnut',
					data,
					options:{
						aspectRatio: 1.5,
						plugins: {
							legend:{
								display: false
							},
							tooltip:{
								enabled: false
							}
						}
					},
					plugins: [gaugeChartText]
				};

				const treeChart = new Chart(
					ctx,
					config
				);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
	}

	function loadMonthChart()
	{


		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var formData = {

    };

    formData[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/rank/monthCarbonLoad",
      data: formData,
      dataType:"json",
      success : function($data, status, xhr) {
				var monthLength = $data.monthData.length;
				var html = "";
				for(var i = 0; i < monthLength; i++){
					html += '<div class="swiper-slide">';
					html += '<div class="month"><span>'+$data.monthData[i].month+'월</span></div>';
					html += '<div class="img">';
					html += '<div style="width:250px;margin:0 auto"><canvas id="month_'+(i+1)+'" width="100%"></canvas></div>';
					html += '</div>';
					html += '</div>';
				}
				$('#monthWrap').html(html);
				new Swiper('.act_month .swiper-container', {
					slidesPerView: 1,
					 navigation: {
						nextEl: ".swiper-button-next",
						prevEl: ".swiper-button-prev",
					},
				});

				for(var i = 0; i<$data.monthData.length; i++){
					makeMonthChart($data.monthData[i],(i+1));
				}
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
	}

	function makeMonthChart($data,$no)
	{
		var labelArr = [];
		var userData = [];
		for(var i = 0; i<$data.userData.length; i++){
			userData[i] = $data.userData[i].per;
			labelArr[i] = $data.userData[i].challenge_title;
		}
		const data = {
      labels: labelArr,
      datasets: [{
				label:'%',
				datalabels : {
            anchor: 'end', // 표시 위치
            align: 'top',  // 표시위치에서 어디쪽으로 배치할지
						formatter:function(value,context){
		          // data 에 넣은 데이타 순번. 물론 0 부터 시작
		          var idx = context.dataIndex;
		          // 여기선 첫번째 데이타엔 단위를 '원' 으로, 그 다음 데이타엔 'P' 를 사용
		          // addComma() 는 여기서 기술하지 않았지만, 천단위 세팅. ChartJS 의 data 엔 숫자만 입력
		         return labelArr[idx]+ '\n' +value+'%';
		       },
					 display:false

        },
        data: userData,
        backgroundColor: [
          'rgba(255, 26, 104, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(0, 0, 0, 0.2)'
        ],
        borderColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(0, 0, 0, 1)'
        ],
        borderWidth: 1,
				cutout: '60%'
      }]
    };

		const centerTextDoughnut = {
			id: 'centerTextDoughnut',
			afterDatasetsDraw(chart,args,pluginOptions){
				const { ctx } = chart;
				ctx.textAlign = 'center';
				ctx.textBaseline = 'middle';
				ctx.font = 'bold 20px sans-serif';
				const text = $data.user_total+'kg';
				const textWidth = ctx.measureText(text).width;
				const x = chart.getDatasetMeta(0).data[0].x;
				const y = chart.getDatasetMeta(0).data[0].y;
				ctx.fillText(text, x, y);
			}
		}

    // config
    const config = {
      type: 'doughnut',
      data,
      options: {
				plugins: {
					legend: {
						position: 'bottom',
						labels: {
							boxWidth:10
						}
					}
				}
      },
			plugins: [centerTextDoughnut,ChartDataLabels]
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('month_'+$no),
      config
    );
	}
	</script>
