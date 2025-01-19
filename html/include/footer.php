<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[1];
$second_part = $components[2];
?>
	<footer>
		<div id="footer">
			<strong class="logo"><a href="#"><img src="/images/layout/footer_logo.png" alt=""></a></strong>
			<ul class="footer_menu">
				<li class="menu1<?php if ($second_part=="content") {echo " active"; }?>"><a href="#">콘텐츠</a></li>
				<li class="menu2<?php if ($second_part=="challenge") {echo " active"; }?>"><a href="#">챌린지</a></li>
				<li class="menu3<?php if ($second_part=="ranking") {echo " active"; }?>"><a href="#">랭킹</a></li>
				<li class="menu4">
					<a href="#"><img src="/images/common/user.png" alt="프로필"></a>
					<div class="my_noti">
						<div class="group like">
							<span class="dt">좋아요</span>
							<span class="dd">50</span>
						</div>
						<div class="group reply">
							<span class="dt">댓글</span>
							<span class="dd">100</span>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</footer>
