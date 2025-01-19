<style>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.7); /* 70% 투명한 백색 배경 */
  z-index: 999999; /* 다른 요소들보다 위에 배치 */
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
		<h2 class="blind">피드</h2>
		<a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
		<ul class="header_menu">
			<li><a href="#" class="menu_write">작성</a></li>
			<li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
		</ul>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 피드 -->
		<div class="feed_wrap">
			<form id="profileForm" enctype="multipart/form-data">
				<input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
			<div class="user_info">
				<div class="photo">
					<?php if(empty($userData['profile_img'])){ ?>
					<img src="/images/common/user.png" class="user" alt="">
					<?php }else{ ?>
					<img src="/upload/member/<?php echo $userData['profile_img'] ?>" alt="" style="margin-left:20px;width: 50px; height: 50px;border-radius: 50%;transform: translateX(-50%);">
					<?php } ?>
					<?php if(empty($user_id)){ ?>
					<span class="icon">
						<img src="/images/feed/icon_photo.png" alt="">
					</span>
					<input type="file" class="input_photo" id="profile_img" name="profile_img" onchange="changeProfile()">
				<?php } ?>
				</div>
				<div class="name"><?php echo $userData['user_name'] ?> <?php if($userData['user_level']=="2"){ ?><img src="/images/feed/icon_star.png" class="icon_star" alt=""><?php } ?></div>
				<?php if(!empty($userData['school_seq'])){ ?>
				<div class="school"><?php echo $userData['school_name'] ?> <?php echo $userData['school_year'] ?>학년 <?php echo $userData['school_class']; ?></div>
				<?php } ?>
			</div>
			</form>

			<div class="cate_feed" style="margin-bottom:10px;">
				<ul  >
					<li class="swiper-slide">
						<a href="#" onclick="challenge_parent_seq='all';feedLoad()">
							<img src="/images/feed/feed_cate1.png" class="icon_cate icon_all" alt="">
							<div class="txt"><!--전체--><span class="num"><?php echo number_format($total_challenge); ?></span></div>
						</a>
					</li>
					<?php for($i=0; $i<count($userChallengeCount); $i++){ ?>
					<li class="swiper-slide">
						<a href="#" onclick="challenge_parent_seq='<?php echo $userChallengeCount[$i]['challenge_seq'] ?>';feedLoad()">
							<img src="/upload/challenge/<?php echo $userChallengeCount[$i]['challenge_icon'] ?>" class="icon_cate" alt="">
							<div class="txt"><!--<?php echo $userChallengeCount[$i]['challenge_title'] ?>--><span class="num"><?php echo number_format($userChallengeCount[$i]['total']); ?></span></div>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="list_feed">
				<ul id="feed_wrap">

				</ul>
			</div>
		</div>
		<!-- //피드 -->
	</div>
	<!-- //container -->
	<script type="text/javascript">

	function loadView($str)
	{
		if($str == "Y"){
			$('.overlay').show();
		}else{
			$('.overlay').hide();
		}
	}

	function changeProfile()
	{
		var csrf_name = $('#csrf').attr("name");
		var csrf_val = $('#csrf').val();

		var form = $('#profileForm')[0];
		var formData = new FormData($('#profileForm')[0]);
		try{
				formData.append("profile_img",$("#profile_img")[0].files[0]);
		}catch(e){
			console.log(e);
		}

		formData.append(csrf_name,csrf_val);

		loadView("Y");

		$.ajax({
			type: "POST",
			url : "/member/profileUploadProc",
			data: formData,
			dataType:"json",
			processData: false,
			contentType: false,
			success : function(data, status, xhr) {
				loadView("N");
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText);
			}
		});
	}

		var scrollBool = true;
		var loadBool = true;

		$(function(){
			feedLoad();
			window.onscroll = function(e) {
					//추가되는 임시 콘텐츠
					//if($(window).scrollTop() == $(document).height() - $(window).height()){

					var scrollHeight = $(document).height();
					var scrollPosition = $(window).height() + $(window).scrollTop();

					if (scrollPosition > scrollHeight - 120) {

						if(scrollBool == true){
							scrollBool = false;
							if(loadBool == true){
								num++;
								scrollLoad();
							}


						}

					}
			};
		});

		var num = 0;
		var challenge_parent_seq = "all";

		function feedLoad()
		{
			num = 0;
			var type = "user";
			var same_school = $('#same_school').val();
			var same_class = $('#same_class').val();

			var csrf_name = $('#csrf').attr("name");
			var csrf_val = $('#csrf').val();

			var data = {
				"type" : type,
				"same_school" : same_school,
				"same_class"  : same_class,
				"challenge_parent_seq"  : challenge_parent_seq,
				"num" : num,
				"user_id"	:	"<?php echo $user_id ?>"
			};

			data[csrf_name] = csrf_val;

			$.ajax({
				type: "POST",
				url : "/feed/feedLoad",
				data: data,
				dataType:"json",
				success : function(data, status, xhr) {
					var html = "";
					if(data.data.feedList.length>0){
						for(var i = 0; i<data.data.feedList.length; i++){
							html += makeFeedHtml(data.data.feedList[i]);
						}


					}else{
						html += '<div class="content_item" style="margin-top:100px;text-align:center;"><img src="/images/challenge/wating_challenge.png" style="width:200px;"/></div>';
					}
					$('#feed_wrap').html(html);

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.responseText);
				}
			});

		}

		function scrollLoad()
		{
			loadBool = false;
			var type = "user";
			var same_school = $('#same_school').val();
			var same_class = $('#same_class').val();

			var csrf_name = $('#csrf').attr("name");
			var csrf_val = $('#csrf').val();

			var data = {
				"type" : type,
				"same_school" : same_school,
				"same_class"  : same_class,
				"challenge_parent_seq"  : challenge_parent_seq,
				"num" : num,
				"user_id"	:	"<?php echo $user_id ?>"
			};

			data[csrf_name] = csrf_val;

			$.ajax({
				type: "POST",
				url : "/feed/feedLoad",
				data: data,
				dataType:"json",
				success : function(data, status, xhr) {
					var html = "";
					if(data.data.feedList.length>0){
						loadBool = true;
						for(var i = 0; i<data.data.feedList.length; i++){
							html += makeFeedHtml(data.data.feedList[i]);
						}
					}
					$('#feed_wrap').append(html);
					scrollBool = true;
					if(num == data.total_page){
						scrollBool = false;
						loadBool = false;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(jqXHR.responseText);
				}
			});

		}

		function makeFeedHtml($data)
		{

			var html = "";
			html += '<li><div class="square-container"><a href="/feed/feedView/'+$data.feed_seq+'"><img src="/upload/member/feed/'+$data.images[0]+'" alt="" style="height:112px"></a></div></li>';

			return html;

		}

	</script>
