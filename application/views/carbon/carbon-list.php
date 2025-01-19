<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">탄소중립 지식백과</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 탄소중립지식백과 -->
		<div class="carbon_wrap">
			<div class="carbon_list">
				<ul>
					<?php for($i=0; $i<count($bookList); $i++){ ?>
					<li>
						<a href="<?php echo $book_read_yn=="Y"?"/carbon/viewBook/?file=".urlencode("/upload/board/".$bookList[$i]['book_file']):"#"; ?>" <?php if($book_read_yn=="Y"){ ?> target="_blank"<?php } ?>>
							<div class="thumb">
								<img src="/images/temp/carbon.gif" class="img" alt="">
								<?php if($book_read_yn=="N"){ ?>
									<span class="lock"><img src="/images/util/icon_lock.png" alt=""></span>
								<?php } ?>
							</div>
							<div class="txt"><?php echo $bookList[$i]['book_title'] ?></div>
							<!--<a href="view?url=<?php echo $book_read_yn=="Y"?urlencode("/upload/board/".$bookList[$i]['book_file']):"#"; ?>">VIEW</a>-->
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<!-- //탄소중립지식백과 -->
	</div>
	<!-- //container -->
