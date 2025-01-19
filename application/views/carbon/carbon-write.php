<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">탄소서약서</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 탄소서약서 -->
		<div class="carbon_wrap">
			<ul class="tab_type">
				<li><a href="/carbon/oath" class="on">탄소서약서</a></li>
				<li><a href="/carbon/implement">실천 서약 현황</a></li>
			</ul>

			<div class="carbon_write">
				<p class="desc">
					나는 기후위기를 극복하고 다음 세대에게 깨끗하고 밝은<br>
					미래를 전해주기 위하여 연간 탄소 1톤 줄이기 운동에<br>
					적극 참여할 것을 서약합니다.
				</p>
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
	            <label for="carbon-school" class="dt">학교</label>
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
		</div>
		<!-- //탄소서약서 -->
	</div>
	<!-- //container -->
<script>
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
					document.location.href = "/carbon/oath";
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
</script>
