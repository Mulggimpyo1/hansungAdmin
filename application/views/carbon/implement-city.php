<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">실천 서약 현황</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 실천서약현황 -->
		<div class="carbon_wrap">
			<ul class="tab_type">
				<li><a href="/carbon/oath">탄소서약서</a></li>
				<li><a href="/carbon/implement" class="on">실천 서약 현황</a></li>
			</ul>

			<div class="cont_implement">
				<ul class="sub_tab">
					<li><a href="/carbon/implement/city" class="on">지역별</a></li>
					<li><a href="/carbon/implement/school">학교별</a></li>
				</ul>
				<div class="list_implement">
					<ul>
						<li>
							<span class="cate">전체</span>
							<div class="graph">
								<span class="bar" style="width:100%"></span>
								<span class="num numbers"><?php echo $oauthData['oauthTotal'] ?></span>
							</div>
						</li>
						<?php for($i=0; $i<count($oauthData['oauthList']); $i++){ ?>
						<li>
							<span class="cate"><?php echo $oauthData['oauthList'][$i]['value']; ?></span>
							<div class="graph">
								<span class="bar" style="width:<?php echo $oauthData['oauthList'][$i]['per']; ?>%"></span>
								<span class="num numbers"><?php echo $oauthData['oauthList'][$i]['cnt']; ?></span>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<!-- //실천서약현황 -->
	</div>
	<!-- //container -->
<script>
$(function(){
  $('.numbers').each(function(d){
    var num = $(this).text();
    if( num == 0){
      $(this).text(0);
    }else{
      $(this).text(numberToKorean(num));
    }

  });
});

function numberFormat(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function numberToKorean(number){
    var inputNumber  = number < 0 ? false : number;
    var unitWords    = ['', 'k', 'm'];
    var splitUnit    = 1000;
    var splitCount   = unitWords.length;
    var resultArray  = [];
    var resultString = '';

    for (var i = 0; i < splitCount; i++){
        var unitResult = (inputNumber % Math.pow(splitUnit, i + 1)) / Math.pow(splitUnit, i);
        unitResult = Math.floor(unitResult);
        if (unitResult > 0){
            resultArray[i] = unitResult;
        }
    }

    for (var i = 0; i < resultArray.length; i++){
        if(!resultArray[i]) continue;
        resultString = String(numberFormat(resultArray[i])) + unitWords[i];
    }

    return resultString;
}
</script>
