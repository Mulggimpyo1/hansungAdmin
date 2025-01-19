<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];
$second_part = $components[2];
?>
	<div class="header_wrap">
		<header>
			<div class="header">
				<h1 class="logo">
					<a href="/html/index.php"><img src="/images/layout/logo.png" alt="SORI BOX" /></a>
				</h1>
				<a href="#" class="btn_menu" onclick="handleSideMenuOpen();return false;"><span>MENU</span></a>
			</div>
			<div class="gnb">
				<ul>
					<li<?php if ($second_part=="index.php") {echo " class='active'"; }?>><a href="/html/index.php">HOME</a></li>
					<li><a href="/html/audio_list.php">SEARCH</a></li>
					<li<?php if ($second_part=="my_page.php" || $second_part=="my_page_insight.php") {echo " class='active'"; }?>><a href="/html/my_page.php">MY PAGE</a></li>
				</ul>
			</div>
		</header>
	</div>

	<!-- aside -->
	<div class="aside_diimmed"></div>
	<div class="aside">
		<div class="aside_close"><a href="#" class="btn_close" onclick="handleSideMenuClose();return false;">닫기</a></div>
		<div class="asdie_scroll">
			<div class="aside_menu aside_top">
				<div class="logo"><img src="/images/layout/logo_aside.png" alt="" /></div>
				<ul class="list">
					<li class="updated"><a href="/html/notice_company.php"><span>본사 공지사항</span></a></li>
					<li><a href="/html/notice_center.php"><span>학원 공지사항</span></a></li>
				</ul>
			</div>
			<div class="aside_menu aside_bottom">
				<ul class="list">
					<li><a href="/html/my_profile.php"><span>MY 프로필</span></a></li>
					<li><a href="#"><span>이용 안내</span></a></li>
					<li><a href="/html/contact.php"><span>고객센터</span></a></li>
				</ul>
				<ul class="etc">
					<li><a href="#">버전</a></li>
					<li><a href="/html/terms.php">약관/정책</a></li>
				</ul>
				<a href="/html/member/login.php" class="btn_logout">로그아웃</a>
			</div>
		</div>
	</div>
	<!-- //aside -->
