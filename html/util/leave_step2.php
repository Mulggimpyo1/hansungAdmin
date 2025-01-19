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
		<h2 class="page_title">회원탈퇴</h2>
		<a href="#" class="btn_prev"><span class="blind">뒤로</span></a>
	</header>
	<!-- //header -->

	<!-- container -->
	<div id="container">
		<!-- 회원탈퇴 -->
		<div class="leave_wrap">
			<div class="leave_box">
				<strong class="tit">계정을 삭제하려는이유는 무엇인가요? </strong>
				<ul class="list_reason">
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason1" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason1" class="uicheckbox_label">기록 삭제 목적</label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason2" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason2" class="uicheckbox_label">이용이 불편하고 장애가 많아서 </label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason3" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason3" class="uicheckbox_label">사용 빈도가 낮아서 </label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason4" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason4" class="uicheckbox_label">콘텐츠 불만 </label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason5" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason5" class="uicheckbox_label">개인정보 유출 우려</label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason6" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason6" class="uicheckbox_label">새로운 계정 생성</label>
						</span>
					</li>
					<li>
						<span class="uicheckbox_wrap uicheckbox_size20">
							<input type="radio" id="leaveReason7" class="uicheckbox_check" name="leaveReason">
							<label for="leaveReason7" class="uicheckbox_label">기타</label>
						</span>
						<div class="reason_write">
							<textarea></textarea>
						</div>
					</li>
				</ul>
			</div>
			<div class="leave_next">
				<span class="uicheckbox_wrap uicheckbox_size20">
					<input type="checkbox" id="leaveCheckAll" class="uicheckbox_check">
					<label for="leaveCheckAll" class="uicheckbox_label">전부 삭제하고 탈퇴하겠습니다.</label>
				</span>
				<div class="btn_area">
					<a href="#" class="btn_leave_next2">탈퇴하기</a>
					<a href="#" class="btn_leave_next2">취소하기</a>
				</div>
			</div>
		</div>
		<!-- //회원탈퇴 -->
	</div>
	<!-- //container -->
</div>
</body>
</html>
