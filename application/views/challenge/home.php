<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">챌린지</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="/feed/write" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 챌린지 -->
		<div class="challenge_wrap">
			<div class="challenge_category">
				<ul>
					<?php for($i=0; $i<count($challengeData); $i++){ ?>
					<li>
						<a href="/challenge/list/<?php echo $challengeData[$i]['challenge_seq']; ?>">
							<img src="/upload/challenge/<?php echo $challengeData[$i]['challenge_thumb'] ?>" class="thumb" alt="">
							<strong><?php echo $challengeData[$i]['challenge_title']; ?><br>챌린지</strong>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- //챌린지 -->
	</div>
	<!-- //container -->
