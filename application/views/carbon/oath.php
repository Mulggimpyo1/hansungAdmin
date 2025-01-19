<style>
@font-face {
   font-family: 'MaruBuri-SemiBold';
   src: url(/font/MaruBuri-SemiBold.otf) format('opentype');
 }
</style>
<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">탄소서약서</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 탄소서약서 -->
		<div class="carbon_wrap">
			<ul class="tab_type">
				<li><a href="/carbon/oath" class="on">탄소서약서</a></li>
				<li><a href="/carbon/implement">실천 서약 현황</a></li>
			</ul>

			<?php if(!is_array($carbonData)){ ?>
			<div class="carbon_ready">
				<img src="/images/util/icon_carbon_ready.png" class="img" alt="SAVE ME">
				<p class="msg">기후위기 극복을 위한 탄소저감 실천 서약에<br>동참해 주세요!</p>
				<a href="/carbon/write" class="btn">서 약 하 기</a>
			</div>
		<?php }else{ ?>
      <!-- 탄소서약서 -->
  		<div class="carbon_pledge">
  			<div class="frame">
  				<img src="/images/util/pledge.png" alt="">
  				<div class="name" style="font-weight:bold;font-family: 'MaruBuri-SemiBold';"><?php echo $carbonData['user_name'] ?></div>
  				<div class="date" style="font-weight:bold;font-family: 'MaruBuri-SemiBold';"><?php echo date("Y년 m월 d일",strtotime($carbonData['reg_date'])); ?></div>
  			</div>
  		</div>
  		<!-- //탄소서약서 -->
		<?php } ?>
		</div>
		<!-- //탄소서약서 -->




	</div>
	<!-- //container -->
