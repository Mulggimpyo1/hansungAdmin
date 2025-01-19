<?php if(empty($this->session->userdata("admin_id"))){ ?>
<footer>
	<div id="footer">
		<strong class="logo"><a href="/main"><img src="/images/layout/footer_logo.png" alt=""></a></strong>
		<ul class="footer_menu">
			<li class="menu1 <?php echo $depth1 == "content" ? "active" : "" ?>"><a href="/content/home">콘텐츠</a></li>
			<li class="menu2 <?php echo $depth1 == "challenge" ? "active" : "" ?>"><a href="/challenge/home">챌린지</a></li>
			<li class="menu3 <?php echo $depth1 == "ranking" ? "active" : "" ?>"><a href="/rank/achieve">랭킹</a></li>
			<li class="menu4">
				<a href="/feed/myList">
					<?php if(empty($userData['profile_img'])){ ?>
					<img src="/images/common/user.png" class="user" alt="">
					<?php }else{ ?>
					<img src="/upload/member/<?php echo $userData['profile_img'] ?>" alt="" width="50" height="50">
					<?php } ?>

				</a>
				<?php if($total_like>0 || $total_comment>0){ ?>
				<div class="my_noti">
					<?php if($total_like>0){ ?>
					<div class="group like" onclick="location.href='/alarm'">
						<span class="dt">좋아요</span>
						<span class="dd"><?php echo number_format($total_like); ?></span>
					</div>
					<?php } ?>
					<?php if($total_comment>0){ ?>
					<div class="group reply" onclick="location.href='/alarm'">
						<span class="dt">댓글</span>
						<span class="dd"><?php echo number_format($total_comment); ?></span>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
			</li>
		</ul>
	</div>
</footer>
<?php } ?>


<!-- 레이어:탄소서약서 -->
<?php if($userData['oauth_yn']=="N"&&$depth1=="home"&&empty($this->session->userdata("admin_id"))){ ?>
<div id="mainCarbonPledge" class="uilayer_wrap">
  <div class="uilayer_dimmed"></div>
  <div class="uilayer_content uilayer_main_carbon_pledge">
    <div class="layer_top">
      <strong class="tit">탄소서약서</strong>
      <p class="desc">나는 기후위기를 극복하고 다음 세대에게 깨끗하고 밝은<br> 미래를 전해주기 위하여 연간 탄소 1톤 줄이기 운동에<br> 적극 참여할 것을 서약합니다.</p>
    </div>
    <div class="layer_body">
      <div class="form_carbon_pledge">
        <ul class="list_carbon_pledge">
          <li>
            <label for="carbon-name" class="dt">이름</label>
            <div class="dd">
              <input type="text" id="carbon-name" name="oauth_name" class="input_carbon" style="width:165px" value="<?php echo $userData['user_name']; ?>">
            </div>
          </li>
          <li>
            <label for="carbon-birth" class="dt">생년월일</label>
						<?php
						$birth_year = "";
						$birth_month = "";
						$birth_day = "";
						if(!empty($userData['birthday'])){
							$birthArr = explode("-",$userData['birthday']);
							$birth_year = $birthArr[0];
							$birth_month = sprintf('%02d',$birthArr[1]);
							$birth_day = sprintf('%02d',$birthArr[2]);
						}
						?>
            <div class="dd">
              <select class="uiselect" id="carbon-year" name="oauth_year" style="width:90px">
								<option value="">년</option>
                <?php for($i=1900; $i<=date("Y"); $i++){ ?>
                  <option value="<?php echo $i; ?>" <?php echo $birth_year==$i?"selected":"" ?>><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <select class="uiselect" id="carbon-month" name="oauth_month" style="width:67px">
								<option value="">월</option>
                <?php for($i=1; $i<=12; $i++){ ?>
                  <option value="<?php echo sprintf('%02d',$i); ?>" <?php echo $birth_month==$i?"selected":"" ?>><?php echo $i; ?></option>
                <?php } ?>
              </select>
              <select class="uiselect" id="carbon-day" name="oauth_day" style="width:67px">
								<option value="">일</option>
                <?php for($i=1; $i<=31; $i++){ ?>
                  <option value="<?php echo sprintf('%02d',$i); ?>" <?php echo $birth_day==$i?"selected":"" ?>><?php echo $i; ?></option>
                <?php } ?>
              </select>
            </div>
          </li>
          <li>
            <label for="" class="dt">성별</label>
            <div class="dd">
              <div class="gender_select">
                <input type="radio" id="carbon-male" name="oauth_gender" class="radio_gender" name="oauth_gender" <?php echo $userData['gender']=="M"?"checked":"" ?> value="M">
                <label for="carbon-male" class="label_gender">남자</label>
              </div>
              <div class="gender_select">
                <input type="radio" id="carbon-female" class="radio_gender" name="oauth_gender" <?php echo $userData['gender']=="W"?"checked":"" ?> value="W">
                <label for="carbon-female" class="label_gender">여자</label>
              </div>
            </div>
          </li>
          <li>
            <label for="carbon-phone" class="dt">연락처</label>
            <div class="dd">
              <input type="text" id="carbon-phone" name="oauth_phone" class="input_carbon" style="width:230px" value="<?php echo $userData['phone']; ?>">
            </div>
          </li>
          <li>
            <label for="carbon-email" class="dt">이메일</label>
            <div class="dd">
              <input type="text" id="carbon-email" name="oauth_email" class="input_carbon" style="width:230px" value="<?php echo $userData['email'] ?>">
            </div>
          </li>
          <li>
            <label for="carbon-city" class="dt">지역</label>
            <div class="dd">
              <select class="uiselect" id="carbon-location" name="oauth_location" style="width:114px">
								<option value="">지역</option>
								<?php for($i=0; $i<count($locationData); $i++){ ?>
									<option value="<?php echo $locationData[$i]['value']; ?>" <?php echo $userData['location']==$locationData[$i]['value']?"selected":"" ?>><?php echo $locationData[$i]['value']; ?></option>
								<?php } ?>
              </select>
            </div>
          </li>
          <li>
            <label for="carbon-school" class="dt">기관</label>
            <div class="dd">
              <input type="text" id="carbon-school" name="oauth_school" class="input_carbon" style="width:165px;" value="<?php echo $userData['school_name']; ?>">
            </div>
          </li>
        </ul>
        <div class="carbon_terms">
          <span class="uicheckbox_wrap uicheckbox_size17">
            <input type="checkbox" id="carbonTerms" class="uicheckbox_check">
            <label for="carbonTerms" class="uicheckbox_label">개인정보 수집 및 이용 동의</label>
          </span>
          <div class="terms_cont">
            ▶수집항목: 이름,연락처, 지역(시/군/구)<br>
            ▶수집목적: 저탄소스쿨 소식 전달을 위한 뉴스레터 또는 정보 제공 이메일 발송<br>
            ▶보유기간: 사용자가 개인정보 제공에 동의하신 시점부터 해지를 요청하여 처리된 시점까지이며, 회원 탈퇴 및 사용자의 요청에 의해 삭제 또는 파기 가능<br>
          </div>
        </div>
        <a href="javascript:oauthProc();" class="btn_agree">서 약 하 기</a>
      </div>
    </div>
    <div class="layer_close">
			<span class="uicheckbox_wrap uicheckbox_size17" style="float:left;margin-top:5px;margin-left:5px">
				<input type="checkbox" id="todayView" class="uicheckbox_check" value="Y">
				<label for="todayView" class="uicheckbox_label">오늘하루 보지않기</label>
			</span>
      <button type="button" class="btn_close" onClick="uiLayer.close('#mainCarbonPledge');">닫기</button>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
<?php if($userData['oauth_yn']=="N"&&$depth1=="home"&&empty($this->session->userdata("admin_id"))){ ?>
	if(!getCookie("oauthPop")){
		uiLayer.open('#mainCarbonPledge');
	}

<?php } ?>

function logout(){
	var csrf_name = $('#csrf').attr("name");
	var csrf_val = $('#csrf').val();

	var data = {};

	data[csrf_name] = csrf_val;

	$.ajax({
		type: "POST",
		url : "/home/logout",
		data: data,
		dataType:"json",
		success : function(data, status, xhr) {
			swal("로그아웃 되었습니다.", {
				icon: "success",
			}).then((value)=>{
				location.href="/login";
			});

		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText);
		}
	});
}
<?php if($userData['oauth_yn']=="N"&&$depth1=="home"&&empty($this->session->userdata("admin_id"))){ ?>
function oauthProc()
{
	var user_name = $('#carbon-name').val();
	var birth_year = $('#carbon-year').val();
	var birth_month = $('#carbon-month').val();
	var birth_day = $('#carbon-day').val();
	var gender = $('input[name="oauth_gender"]:checked').val();
	var phone = $('#carbon-phone').val();
	var email = $('#carbon-email').val();
	var location = $('#carbon-location').val();
	var school_name = $('#carbon-school').val();

	if(user_name == ""){
		swal("이름을 작성해주세요");
		return;
	}

	if(birth_year == ""){
		swal("생년월일을 선택해주세요");
		return;
	}

	if(birth_month == ""){
		swal("생년월일을 선택해주세요");
		return;
	}

	if(birth_day == ""){
		swal("생년월일을 선택해주세요");
		return;
	}

	if(phone == ""){
		swal("연락처를 작성해주세요");
		return;
	}

	if(email == ""){
		swal("이메일을 작성해주세요");
		return;
	}

	if(location == ""){
		swal("지역을 선택해주세요");
		return;
	}

	if(!$('#carbonTerms').is(":checked")){
			swal("개인정보 수집에 동의해주세요");
			return
	}

	var csrf_name = $('#csrf').attr("name");
	var csrf_val = $('#csrf').val();

	var data = {
		"user_name"	:	user_name,
		"birth_year"	:	birth_year,
		"birth_month"	:	birth_month,
		"birth_day"	:	birth_day,
		"gender"	:	gender,
		"phone"	:	phone,
		"email"	:	email,
		"location"	:	location,
		"school_name"	:	school_name
	};

	data[csrf_name] = csrf_val;

	$.ajax({
		type: "POST",
		url : "/home/oauth_proc",
		data: data,
		dataType:"json",
		success : function(data, status, xhr) {
			if(data.result=="success"){
				swal("서약을 완료했습니다.", {
					icon: "success",
				}).then((value)=>{
					document.location.reload();
				});

			}else{
				document.location.reload();
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(jqXHR.responseText);
		}
	});
}

$(function(){
	$('#todayView').on("click",function(){
		if($(this).is(":checked")){
			setCookie('oauthPop', 'Y' , 1 );
		}else{
			setCookie('oauthPop', '' , 0 );
		}
	});
});

<?php } ?>

function setCookie( name, value, expiredays ) {
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + '=' + escape( value ) + '; path=/; expires=' + todayDate.toGMTString() + ';'
}

//쿠키 불러오기
function getCookie(name)
{
    var obj = name + "=";
    var x = 0;
    while ( x <= document.cookie.length )
    {
        var y = (x+obj.length);
        if ( document.cookie.substring( x, y ) == obj )
        {
            if ((endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                endOfCookie = document.cookie.length;
            return unescape( document.cookie.substring( y, endOfCookie ) );
        }
        x = document.cookie.indexOf( " ", x ) + 1;

        if ( x == 0 ) break;
    }
    return "";
}
function deleteCookie(cookieName){
    document.cookie = cookieName + '=; expires=Thu, 01 Jan 1999 00:00:10 GMT;';
}
</script>
<!-- //레이어:탄소서약서 -->

<!-- 레이어:더보기[자신] -->
<div id="mainContentMore_me" class="uilayer_wrap">
  <div class="uilayer_dimmed"></div>
  <div class="uilayer_content uilayer_main_content_more">
    <button type="button" class="btn_close" onClick="uiLayer.close('#mainContentMore_me');">닫기</button>
    <ul class="list_fn">
      <li><a href="javascript:shareFeed()" class="btn_share">공유하기</a></li>
      <li><a href="javascript:modifyFeed()" class="btn_edit">수정하기</a></li>
      <li><a href="javascript:deleteFeed()" class="btn_delete">삭제하기</a></li>
    </ul>
  </div>
</div>
<!-- //레이어:더보기 -->

<!-- 레이어:더보기[상대] -->
<div id="mainContentMore_other" class="uilayer_wrap">
  <div class="uilayer_dimmed"></div>
  <div class="uilayer_content uilayer_main_content_more">
    <button type="button" class="btn_close" onClick="uiLayer.close('#mainContentMore_other');">닫기</button>
    <ul class="list_fn">
      <li><a href="javascript:shareFeed()" class="btn_share">공유하기</a></li>
      <li><a href="#" class="btn_report" onClick="uiLayer.close('#mainContentMore_other');uiLayer.open('#mainContentReport');return false;">신고하기</a></li>
    </ul>
  </div>
</div>
<!-- //레이어:더보기 -->

<!-- 레이어:더보기[광고] -->
<div id="mainContentMore_ad" class="uilayer_wrap">
  <div class="uilayer_dimmed"></div>
  <div class="uilayer_content uilayer_main_content_more">
    <button type="button" class="btn_close" onClick="uiLayer.close('#mainContentMore_ad');">닫기</button>
    <ul class="list_fn">
      <li><a href="javascript:shareAdFeed()" class="btn_share">공유하기</a></li>
    </ul>
  </div>
</div>
<!-- //레이어:더보기 -->

<!-- 레이어:게시물신고 -->
<div id="mainContentReport" class="uilayer_wrap">
  <div class="uilayer_dimmed"></div>
  <div class="uilayer_content uilayer_main_content_report">
    <button type="button" class="btn_close" onClick="uiLayer.close('#mainContentReport');">닫기</button>
    <strong class="tit">게시물 신고</strong>
    <ul class="list_reason">
      <li>
        <input type="radio" id="report-reason1" class="radio_report" name="feed_report_category" value="A">
        <label for="report-reason1" class="label">부적절한 사진</label>
      </li>
      <li>
        <input type="radio" id="report-reason2" class="radio_report" name="feed_report_category" value="B">
        <label for="report-reason2" class="label">욕설</label>
      </li>
      <li>
        <input type="radio" id="report-reason3" class="radio_report" name="feed_report_category" value="C">
        <label for="report-reason3" class="label">챌린지와 관련 없는 내용</label>
      </li>
      <li>
        <input type="radio" id="report-reason4" class="radio_report" name="feed_report_category" value="D">
        <label for="report-reason4" class="label">수칙 미준수</label>
      </li>
      <li>
        <input type="radio" id="report-reason5" class="radio_report" name="feed_report_category" value="E">
        <label for="report-reason5" class="label">기타</label>
      </li>
    </ul>
    <div class="write_reason">
      <textarea placeholder="내용을 입력하세요" id="feed_report_content" name="feed_report_content"></textarea>
    </div>
    <a href="#" class="btn_report" onClick="reportFeed();">신 고 하 기</a>
  </div>
</div>
<!-- //레이어:게시물신고 -->
</div>
<!-- 댓글 -->
<div class="uipage_dimmed"></div>
<div id="uipage_reply" class="uipage_side uipage_reply">
	<div class="uipage_header">
		<strong class="uipage_title">댓글</strong>
		<button type="button" class="btn_uipage_close" onClick="uiPage.close('#uipage_reply');"><span class="blind">닫기</span></button>
	</div>
	<div class="uipage_body" id="comment_wrap">

	</div>
</div>
<!-- //댓글 -->
<div class="overlay" style="display:none">
	<div class="spinner"></div>
</div>
</body>
</html>
<script>
$(function(){
    if(document.clientHeight>document.scrollHeight-document.scrollTop){
    return;
    }        
});

</script>