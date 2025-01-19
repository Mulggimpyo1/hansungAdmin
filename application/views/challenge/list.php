<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">{page_title}</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="/feed/write" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 챌린지리스트 -->
		<div class="challenge_wrap">
			<div class="list_challenge">
				<ul>
					<?php for($i=0; $i<count($challenge2Depth); $i++){ ?>
					<li>
						<a href="/challenge/view/<?php echo $challenge2Depth[$i]['challenge_seq']; ?>"><?php echo $challenge2Depth[$i]['challenge_title']; ?></a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- //챌린지리스트 -->
	</div>
	<!-- //container -->
