<style>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.7); /* 70% 투명한 백색 배경 */
  z-index: 9999; /* 다른 요소들보다 위에 배치 */
  display: flex;
  justify-content: center;
  align-items: center;
}

.spinner {
  border: 8px solid rgba(0, 0, 0, 0.3); /* 반투명한 검은색 테두리 */
  border-top: 8px solid #333; /* 검은색 실제 로딩바 */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite; /* 회전 애니메이션 */
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div id="wrap">
	<!-- header -->
	<header>
		<h1 class="blind">저탄소 SCHOOL</h1>
		<h2 class="page_title">새 게시물</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 피드 -->
		<form id="feedForm" enctype="multipart/form-data">
			<input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
		<div class="feed_wrap">
			<div class="feed_form">
				<div class="form_tit">
					<ul>
						<li class="date">
							<span class="dt">날짜</span>
							<div class="cont"><?php echo date("Y.m.d") ?></div>
						</li>
						<li class="challenge has_info">
							<span class="dt">챌린지 <a href="#" class="info_challenge" onClick="uiLayer.open('#feedCategory');return false;"><img src="/images/feed/icon_info.png" alt=""></a></span>
							<div class="cont">
								<div class="sel">
									<select class="uiselect" id="challenge1" name="feed_parent_challenge_seq" onchange="challenge1Sel()">
										<option value="">선택하세요</option>
										<?php for($i=0; $i<count($challengeData); $i++){ ?>
											<option value="<?php echo $challengeData[$i]['challenge_seq'] ?>" <?php echo $challenge_1==$challengeData[$i]['challenge_seq']?"selected":""; ?>><?php echo $challengeData[$i]['challenge_title']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="sel">
									<select class="uiselect" id="challenge2" name="feed_challenge_seq" onchange="challenge2Sel()">
										<option value="">선택하세요</option>
										<?php
											for($i=0; $i<count($challengeData); $i++){
												if($challengeData[$i]['challenge_seq']==$challenge_1){
													for($j=0; $j<count($challengeData[$i]['challenge2']); $j++){?>
											<option value="<?php echo $challengeData[$i]['challenge2'][$j]['challenge_seq']; ?>" <?php echo $challengeData[$i]['challenge2'][$j]['challenge_seq']==$challenge_2?"selected":"" ?>><?php echo $challengeData[$i]['challenge2'][$j]['challenge_title']; ?></option>
											<?php
											}
										}
									} ?>
									</select>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="list_photo">
					<ul id="preview_img">
						<li class="btn_more" id="img_add_btn">
							<div class="btn_photo">사진추가<input type="file" class="more_photo" id="img_upload" accept="image/*" multiple></div>
						</li>
					</ul>
				</div>
				<div class="form_cont">
					<textarea placeholder="내용을 입력하세요." name="feed_content" id="feed_content"></textarea>
					<ul class="list_check">
						<li>
							<span class="uicheckbox_wrap uicheckbox_size14">
								<input type="checkbox" id="feedAgree" class="uicheckbox_check">
								<label for="feedAgree" class="uicheckbox_label">(필수) <span id="agree_text"><?php echo empty($agree_text)?"성실하게 챌린지에 참여할 것을 약속합니다.":$agree_text ?></span></label>
							</span>
						</li>
						<li>
							<span class="uicheckbox_wrap uicheckbox_size14">
								<input type="checkbox" id="feedOption" name="comment_yn" value="N" class="uicheckbox_check">
								<label for="feedOption" class="uicheckbox_label">댓글 금지</label>
							</span>
						</li>
					</ul>
				</div>
				<a href="javascript:saveFeed()" class="btn_feed_write">게 시 하 기</a>
			</div>
		</div>
	</form>
		<!-- //피드 -->
	</div>
	<!-- //container -->

	<!-- 레이어:챌린지팝업 -->
	<div id="feedCategory" class="uilayer_wrap">
		<div class="uilayer_dimmed" onClick="uiLayer.close('#feedCategory');"></div>
		<div class="uilayer_pannel">
			<div class="feed_cate_layer">
				<div class="list_depth1">
					<ul>
						<?php for($i=0; $i<count($challengeData); $i++){ ?>
						<li><a href="#" id="dep1_<?php echo $challengeData[$i]['challenge_seq']; ?>" <?php echo $i==0?"class='on'":"" ?> onclick="dep1Click('<?php echo $challengeData[$i]['challenge_seq']; ?>')"><?php echo $challengeData[$i]['challenge_title'] ?><br>챌린지</a></li>
						<?php } ?>
					</ul>
				</div>
				<?php for($i=0; $i<count($challengeData); $i++){ ?>
				<div class="list_depth2" id="depth2_<?php echo $challengeData[$i]['challenge_seq']; ?>" style="<?php echo $i==0?"":"display:none;" ?>">
					<ul>
						<?php for($j=0; $j<count($challengeData[$i]['challenge2']); $j++){ ?>
						<li><a href="#" id="dep2_btn_<?php echo $challengeData[$i]['challenge2'][$j]['challenge_seq']; ?>"<?php echo $j==0?"class='on'":"" ?> onclick="dep2Click('<?php echo $challengeData[$i]['challenge2'][$j]['challenge_seq']; ?>')"><?php echo $j+1 ?></a></li>
						<?php } ?>
					</ul>
				</div>
				<?php } ?>
				<?php
					for($i=0; $i<count($challengeData); $i++){
						for($j=0; $j<count($challengeData[$i]['challenge2']); $j++){
				?>
				<div class="list_depth3" id="depth3_<?php echo $challengeData[$i]['challenge2'][$j]['challenge_seq']?>" style="<?php echo $i==0&&$j==0?"":"display:none;" ?>">
					<div class="swiper-container">
						<div class="swiper-wrapper">
							<?php
								for($t=0; $t<10; $t++){
									if(!empty($challengeData[$i]['challenge2'][$j]['image'.($t+1)])){
							?>
							<div class="swiper-slide">
								<div class="img"><img src="/upload/challenge/<?php echo $challengeData[$i]['challenge2'][$j]['image'.($t+1)]; ?>" alt=""></div>
							</div>
						<?php }
						} ?>
						</div>
						 <div class="swiper-pagination"></div>
					</div>
				</div>
			<?php }
			} ?>
				<script type="text/javascript">
					new Swiper('.feed_cate_layer .list_depth3 .swiper-container', {
						slidesPerView: 1,
						pagination: {
							el: ".swiper-pagination",
						},
					});
				</script>

			</div>
		</div>
	</div>
	<!-- //레이어:챌린지팝업 -->
	<script>

	function dep1Click($challenge_seq)
	{
		var dep1 = $('.list_depth1 ul li a').removeClass("on");
		$('#dep1_'+$challenge_seq).addClass("on");

		$('.list_depth2').hide();
		$('#depth2_'+$challenge_seq).show();

		var dep2_id = $('#depth2_'+$challenge_seq+' li a:eq(0)')[0].id.split("_");
		dep2_id = dep2_id[2];
		dep2Click(dep2_id);
	}

	function dep2Click($challenge_seq)
	{
		var dep1 = $('.list_depth2 ul li a').removeClass("on");
		$('#dep2_btn_'+$challenge_seq).addClass("on");

		$('.list_depth3').hide();
		$('#depth3_'+$challenge_seq).show();
	}

	function challenge1Sel()
	{
		var chal1 = $('#challenge1').val();
		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

		if(chal1==""){
			swal("챌린지를 선택해주세요");
			return
		}

    var data = {
      "chal1" : chal1,
    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/feed/challengeSelect",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.data.length>0){
					var html = "<option value=''>선택하세요</option>";
					for(var i=0; i<data.data.length; i++){
						html += '<option value="'+data.data[i].challenge_seq+'">'+data.data[i].challenge_title+'</option>';
					}
					$('#challenge2').html(html);
				}


      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

	}

  function challenge2Sel()
	{
		var chal2 = $('#challenge2').val();
		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

		if(chal2==""){
			swal("챌린지를 선택해주세요");
			return
		}

    var data = {
      "chal2" : chal2,
    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/feed/challengeSelect2",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        var agree_text = data.agree_text;
        if(agree_text == ""){
          agree_text = "성실하게 챌린지에 참여할 것을 약속합니다.";
        }
        $('#agree_text').text(agree_text);


      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

	}

	$(function(){
		//수정일때
		$('#preview_img li').each(function(e){
			var is_img = $(this).find(".pre_view");
			if($(is_img).hasClass("pre_view")){
				var img_url = $(is_img).attr("src");
				toDataURL(img_url,function(dataUrl){
					$(is_img).attr("src",dataUrl);
				});
			}
		});



		$('#img_upload').on("change",function(e){
			var file_length = ($('#preview_img li').length-1) + $(this)[0].files.length;
			console.log(file_length);
			if (file_length > 5) {
        swal("최대 5개까지 업로드 가능합니다");
				return;
    	}

			const files = e.target.files;
		  const filesArr = Array.prototype.slice.call(files);
		  // 여러장의 이미지를 불러올 경우, 배열화

		  filesArr.forEach(file => {
		    const reader = new FileReader();
		    reader.onload = e => {
		        const image = new Image();
		        image.src = e.target.result;
		        image.onload = imageEvent => {
		          // 이미지가 로드가 되면! 리사이즈 함수가 실행되도록 합니다.
		          resize_image(image);
		      };
		    };
		    reader.readAsDataURL(file);
		  });

		});


	});

	function delClick($obj)
	{
		$($obj).parent().remove();
	}

	function resize_image(image)
	{
		let canvas = document.createElement("canvas"),
    max_size = 1280,
    // 최대 기준을 1280으로 잡음.
    width = image.width,
    height = image.height;

	  if (width > height) {
	    // 가로가 길 경우
	    if (width > max_size) {
	      height *= max_size / width;
	      width = max_size;
	    }
	  } else {
	    // 세로가 길 경우
	    if (height > max_size) {
	      width *= max_size / height;
	      height = max_size;
	    }
	  }
	  canvas.width = width;
	  canvas.height = height;
	  canvas.getContext("2d").drawImage(image, 0, 0, width, height);
	  const dataUrl = canvas.toDataURL("image/jpeg");

		var preview_img_html = '<li><img src="'+dataUrl+'" alt="" class="pre_view"><a onclick="delClick(this)" class="btn_delete"><span>삭제</span></a></li>';
	  // 미리보기 위해서 마크업 추가.
	  $("#img_add_btn").before(preview_img_html);
	}

	function toDataURL(url, callback) {
	  var xhr = new XMLHttpRequest();
	  xhr.onload = function() {
	    var reader = new FileReader();
	    reader.onloadend = function() {
	      callback(reader.result);
	    }
	    reader.readAsDataURL(xhr.response);
	  };
	  xhr.open('GET', url);
	  xhr.responseType = 'blob';
	  xhr.send();
	}

	function saveFeed()
	{
		var challenge_title = $('#challenge2 option:checked').text();

		var challenge1 = $('#challenge1').val();
		var challenge2 = $('#challenge2').val();

		if(challenge1==""){
			swal("챌린지를 선택해주세요");
			return
		}

		if(challenge2==""){
			swal("챌린지를 선택해주세요");
			return
		}

		var fileArr = [];

		$('#preview_img li').each(function(e){
			var is_img = $(this).find(".pre_view");
			if($(is_img).hasClass("pre_view")){
				var dataUrl = $(is_img).attr("src");
				var data = dataURLToBlob(dataUrl);
				fileArr.push(data);
			}

		});

		if(fileArr.length==0){
			swal("이미지를 업로드해주세요.");
			return;
		}

		var feed_content = $('#feed_content').val();
		if(feed_content==""){
			swal("내용을 입력해주세요");
			return;
		}
		var agree_chk = $('#feedAgree').is(":checked");
		if(!agree_chk){
			swal("성실한 참여를 약속해주세요");
			return;
		}

		loadView('Y');

		var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#feedForm')[0];
    var formData = new FormData($('#feedForm')[0]);
    try{
			for(var i=0; i<fileArr.length; i++){
				formData.append("image[]",fileArr[i]);
			}

    }catch(e){
      console.log(e);
    }

		formData.append("feed_challenge_title",challenge_title);

    formData.append(csrf_name,csrf_val);

    $.ajax({
      type: "POST",
      url : "/feed/feedUploadProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
				loadView('N');
        if(data.result=="failed"){
          var challenge_title = $('#challenge2 option:checked').text();
          swal(challenge_title+" 는(은) "+data.limit+"일 1회 작성 가능합니다.");
          return;
        }else if(data.result=="success"){
          swal("작성 되었습니다.", {
            icon: "success",
          }).then((value)=>{
            location.href="/main";
          });
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

		/*var dataUrl = $('#preview_img li:eq(0) img').attr("src");
		var blob_data = dataURLToBlob(dataUrl);
		console.log(blob_data);*/
	}

	function dataURLToBlob(dataURL){
	  const BASE64_MARKER = ";base64,";

	  // base64로 인코딩 되어있지 않을 경우
	  if (dataURL.indexOf(BASE64_MARKER) === -1) {
	    const parts = dataURL.split(",");
	    const contentType = parts[0].split(":")[1];
	    const raw = parts[1];
	    return new Blob([raw], {
	      type: contentType
	    });
	  }
	  // base64로 인코딩 된 이진데이터일 경우
	  const parts = dataURL.split(BASE64_MARKER);
	  const contentType = parts[0].split(":")[1];
	  const raw = window.atob(parts[1]);
	  // atob()는 Base64를 디코딩하는 메서드
	  const rawLength = raw.length;
	  // 부호 없는 1byte 정수 배열을 생성
	  const uInt8Array = new Uint8Array(rawLength); // 길이만 지정된 배열
	  let i = 0;
	  while (i < rawLength) {
	    uInt8Array[i] = raw.charCodeAt(i);
	    i++;
	  }
	  return new Blob([uInt8Array], {
	    type: contentType
	  });
	}

	function loadView($str)
	{
		if($str == "Y"){
			$('.overlay').show();
		}else{
			$('.overlay').hide();
		}
	}
</script>
