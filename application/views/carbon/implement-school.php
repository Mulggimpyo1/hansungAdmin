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
					<li><a href="/carbon/implement/city">지역별</a></li>
					<li><a href="/carbon/implement/school" class="on">학교별</a></li>
				</ul>
				<div class="list_implement school">
					<ul>
						<?php for($i=0; $i<count($oauthData['rankData']); $i++){ ?>
						<li>
							<span class="cate"><img src="/images/util/school_icon.png" style="width:20px;margin:0px 5px 3px 0px;"><?php echo empty($oauthData['rankData'][$i]['school_name'])?"개인":$oauthData['rankData'][$i]['school_name']; ?></span>
							<div class="graph">
								<span class="bar" style="width:<?php echo $oauthData['rankData'][$i]['per'] ?>%"></span>
								<span class="num"><?php echo $oauthData['rankData'][$i]['cnt'] ?></span>
							</div>
						</li>
						<?php } ?>
					</ul>
					<?php if($oauthData['myRank']>10){ ?>
					<div class="my_school">
						<span class="cate">내 학교</span>
						<div class="graph">
							<span class="bar" style="width:<?php echo $oauthData['myPer'] ?>%"></span>
							<span class="num"><?php echo $oauthData['myTotal'] ?></span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- //실천서약현황 -->
	</div>
	<!-- //container -->
