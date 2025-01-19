<!DOCTYPE html>
<html lang="ko">
<head>
<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/head.php'); ?>
</head>
<body>
<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">공지사항</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>		
	</header>
	<!-- //header -->

	<!-- aside -->
	<?php include($_SERVER['DOCUMENT_ROOT'].'/html/include/aside.php'); ?>
	<!-- //aside -->

	<!-- container -->
	<div id="container">
		<!-- 공지사항 -->
		<div class="notice_wrap">
			<ul>
				<li>
					<div class="title">
						<a href="#" onclick="handleNoticeToggle(this);return false;">
							<strong class="tit">저탄소스쿨 App 런칭 안내(샘플)</strong>
							<span class="date">2022-07-14</span>
						</a>
					</div>
					<div class="cont">
						내용
					</div>
				</li>
				<li>
					<div class="title">
						<a href="#" onclick="handleNoticeToggle(this);return false;">
							<strong class="tit">저탄소스쿨 App 런칭 안내(샘플)</strong>
							<span class="date">2022-07-14</span>
						</a>
					</div>
					<div class="cont">
						내용
					</div>
				</li>
				<li>
					<div class="title">
						<a href="#" onclick="handleNoticeToggle(this);return false;">
							<strong class="tit">저탄소스쿨 App 런칭 안내(샘플)</strong>
							<span class="date">2022-07-14</span>
						</a>
					</div>
					<div class="cont">
						내용
					</div>
				</li>
			</ul>
		</div>
		<!-- //공지사항 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
