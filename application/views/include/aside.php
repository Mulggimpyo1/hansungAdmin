<div id="aside">
  <div class="aside_dimmed"></div>
  <div class="aside_body">
    <a href="/member/setting" class="btn_setting">설정</a>
    <button type="button" class="btn_aside_close" onClick="handleSideMenuClose();">닫기</button>
    <div class="aside_user_info">
      <div class="img"><a href="/feed/myAlbum">
        <?php if(empty($userData['profile_img'])){ ?>
        <img src="/images/common/user.png" alt="">
      <?php }else{ ?>
        <img src="/upload/member/<?php echo $userData['profile_img'] ?>" alt="">
      <?php } ?>
      </a></div>
      <div class="name"><?php echo $userData['user_name']; ?></div>
      <div class="school"><?php echo $userData['school_name']; ?></div>
      <a href="javascript:logout();" class="btn_logout">로그아웃</a>
    </div>
    <div class="aside_carbon_menu">
      <ul>
        <li class="menu1" onclick="location.href='/carbon/list'"><a href="#"><span class="td"><span class="sub">쉽고 재미있게 알려주는</span><br>탄소중립 지식백과</span></a></li>
        <li class="menu2" onclick="location.href='/carbon/oath'"><a href="#"><span class="td">탄소서약서</span></a></li>
        <li class="menu3" onclick="location.href='/carbon/calculate'"><a href="#"><span class="td">탄소발자국 계산기</span></a></li>
      </ul>
    </div>
    <div class="aside_menu">
      <ul>
        <li><a href="/board/notice">공지사항<?php if($notice_yn=="N"){ ?><span class="new">NEW</span><?php } ?></a></li>
        <li><a href="/board/faq">고객센터</a></li>
        <li><a href="#">앱 활용 가이드</a></li>
      </ul>
    </div>
    <div class="app_info">
      <ul>
        <li><a href="/home/terms">이용약관</a></li>
        <li><a href="/home/privacy">개인정보 취급방침</a></li>
        <li>버전 1.0.0</li>
      </ul>
    </div>
  </div>
</div>
