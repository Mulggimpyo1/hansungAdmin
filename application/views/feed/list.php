<div id="wrap">
  <!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">{page_title}</h2>
		<a href="/challenge/home" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="/feed/write" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

  <!-- container -->
  <div id="container">
    <div class="main_content">
      <div class="content_item">
        <!-- 컨텐츠상단 -->
        <div class="content_info">
          <div class="user">
            <a href="#">
              <img src="/images/common/user.png" class="img" alt="">
              <span class="name">username</span>
              <span class="school">초등학교</span>
            </a>
          </div>
          <span class="category">줍깅 챌린지</span>
          <a href="#" class="btn_more" onClick="uiLayer.open('#mainContentMore');return false;">메뉴</a>
        </div>
        <!-- //컨텐츠상단 -->
        <!-- 컨텐츠이미지 -->
        <div class="content_img">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="img"><img src="/images/temp/main_content.png" alt=""></div>
              </div>
              <div class="swiper-slide">
                <div class="img"><img src="/images/temp/main_content.png" alt=""></div>
              </div>
            </div>
             <div class="swiper-pagination"></div>
          </div>
        </div>
        <!-- //컨텐츠이미지 -->
        <!-- 컨텐츠댓글 -->
        <div class="content_etc">
          <div class="icon">
            <a href="#"><img src="/images/common/icon_like.png" class="icon_like" alt=""></a>
            <a href="#"><img src="/images/common/icon_like_on.png" class="icon_like" alt=""></a>
            <img src="/images/common/icon_reply.png" class="icon_reply" alt="">
          </div>
          <div class="cont_like">
            <span class="count">좋아요 00000개</span>
            <ul>
              <li>
                <span class="name">username</span>
                좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요...
                <a href="#" class="btn_more">더보기</a>
              </li>
            </ul>
          </div>
          <div class="cont_reply">
            <a href="#" class="count" onClick="uiPage.open('#uipage_reply');return false">댓글 0000개 모두 보기</a>
            <ul>
              <li>
                <span class="name">usernameuser</span>
                나도 여기 있었는데!
              </li>
              <li>
                <span class="name">usernameusername</span>
                나도 여기 있었는데!
              </li>
            </ul>
          </div>
          <div class="time">24분 전</div>
        </div>
        <!-- //컨텐츠댓글 -->
      </div>

      <div class="content_item">
        <!-- 컨텐츠상단 -->
        <div class="content_info">
          <div class="user">
            <a href="#">
              <img src="/images/common/user.png" class="img" alt="">
              <span class="name">username</span>
              <span class="school">초등학교</span>
            </a>
          </div>
          <span class="category">줍깅 챌린지</span>
          <a href="#" class="btn_more" onClick="uiLayer.open('#mainContentMore');return false;">메뉴</a>
        </div>
        <!-- //컨텐츠상단 -->
        <!-- 컨텐츠이미지 -->
        <div class="content_img">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="img"><img src="/images/temp/main_content.png" alt=""></div>
              </div>
              <div class="swiper-slide">
                <div class="img"><img src="/images/temp/main_content.png" alt=""></div>
              </div>
            </div>
             <div class="swiper-pagination"></div>
          </div>
        </div>
        <!-- //컨텐츠이미지 -->
        <!-- 컨텐츠댓글 -->
        <div class="content_etc">
          <div class="icon">
            <a href="#"><img src="/images/common/icon_like.png" class="icon_like" alt=""></a>
            <a href="#"><img src="/images/common/icon_like_on.png" class="icon_like" alt=""></a>
            <img src="/images/common/icon_reply.png" class="icon_reply" alt="">
          </div>
          <div class="cont_like">
            <span class="count">좋아요 00000개</span>
            <ul>
              <li>
                <span class="name">username</span>
                좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요좋아요...
                <a href="#" class="btn_more">더보기</a>
              </li>
            </ul>
          </div>
          <div class="cont_reply">
            <a href="#" class="count" onClick="uiPage.open('#uipage_reply');return false">댓글 0000개 모두 보기</a>
            <ul>
              <li>
                <span class="name">usernameuser</span>
                나도 여기 있었는데!
              </li>
              <li>
                <span class="name">usernameusername</span>
                나도 여기 있었는데!
              </li>
            </ul>
          </div>
          <div class="time">24분 전</div>
        </div>
        <!-- //컨텐츠댓글 -->
      </div>
    </div>
  </div>
  <!-- //container -->
  <script type="text/javascript">
    new Swiper('.content_img .swiper-container', {
      slidesPerView: 1,
      pagination: {
        el: ".swiper-pagination",
      },
    });
  </script>
