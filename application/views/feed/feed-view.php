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
<?php if(empty($this->session->userdata("admin_id"))){ ?>
<header>
  <h1 class="blind">저탄소 SCHOOL</h1>
  <h2 class="blind">피드</h2>
  <a href="javascript:window.history.back();" class="btn_prev"><span class="blind">뒤로</span></a>
  <ul class="header_menu">
    <li><a href="#" class="menu_write">작성</a></li>
    <li><a href="#" class="menu_side" onClick="handleSideMenuOpen();return false;">사이드메뉴</a></li>
  </ul>
</header>
<?php } ?>
  <!-- container -->
  <div id="container">
    <div class="main_content" id="feed_wrap">

    </div>
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
  var select_feed_seq = 0;
  var select_comment_seq = 0;

  function moreView(is_me,feed_seq)
  {
    select_feed_seq = feed_seq;
    if(is_me == "Y"){
      uiLayer.open('#mainContentMore_me');
    }else{
      uiLayer.open('#mainContentMore_other');
    }

  }

  //신고
  function reportFeed()
  {
    var report_type = $('input[name="feed_report_category"]:checked').val();
    if(report_type==undefined){
      swal("신고이유를 선택해주세요");
      return;
    }

    var report_text = $('#feed_report_content').val();

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = {
      "feed_seq" : select_feed_seq,
      "report_type" : report_type,
      "report_text" : report_text
    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/feed/feedReportProc",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result == "success"){
          swal("신고되었습니다.");
          uiLayer.close('#mainContentReport');
        }else{
          swal("이미 신고하셨습니다.");
        }


      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  //공유
  function shareFeed()
  {
    if (navigator.share) {
      navigator.share({
          title: '피드공유',
          text: '피드공유 테스트',
          url: 'https://zero.thmvp.kr',
      })
        .then(() => uiLayer.close('#mainContentMore_other'))
        .catch((error) => console.log('공유 실패', error));
    }
  }

  function deleteFeed()
  {
    swal({
        title: "정말 삭제하시겠습니까?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          var csrf_name = $('#csrf').attr("name");
          var csrf_val = $('#csrf').val();

          var data = {
            "feed_seq" : select_feed_seq,
          };

          data[csrf_name] = csrf_val;

          $.ajax({
            type: "POST",
            url : "/feed/feedDeleteProc",
            data: data,
            dataType:"json",
            success : function(data, status, xhr) {
              if(data.result == "success"){
                swal("삭제 되었습니다.", {
                  icon: "success",
                }).then((value)=>{
                  location.reload();
                });

              }


            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR.responseText);
            }
          });

        }
      });
  }

  function commentView(feed_seq,$str="Y")
  {
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = {
      "feed_seq" : feed_seq
    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/feed/feedCommentLoad",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        select_feed_seq = feed_seq;
        select_comment_seq = 0;

        $('#comment_wrap').html(makeComment(data.data));
        if($str=="Y"){
          uiPage.open('#uipage_reply');
        }



      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  function makeComment($data)
  {

    var html = "";
    //본문
    html += '<div class="origin_content">';
    html += '<div class="user_info">';
    if($data.profile_img){
      html += '<img src="/upload/member/'+$data.profile_img+'" class="profile" alt="">';

    }else{
      html += '<img src="/images/common/user.png" class="profile" alt="">';
    }

    html += '<span class="about">';
    if($data.school_name==null){
      $data.school_name = "";
      html += '<span class="name" style="margin-top:9px;">'+$data.user_id+'</span>';
    }else{
      html += '<span class="name">'+$data.user_id+'</span>';
    }
    html += '<span class="school">'+$data.school_name+'</span>';
    html += '<span class="time">'+$data.write_time+'</span>';
    html += '</span>';
    html += '</div>';
    html += '<div class="cont">'+$data.feed_content+'</div>';
    html += '</div>';
    //본문 끝
    html += '<div class="list_reply">';
    if($data.comment.length>0){
      html += '<ul>';
      //댓글시작
      for(var i=0; i<$data.comment.length; i++){
        html += '<li>';
        html += '<div class="user_info">';
        if($data.comment[i].profile_img){
          html += '<img src="/upload/member/'+$data.comment[i].profile_img+'" class="profile" alt="">';
        }else{
          html += '<img src="/images/common/user.png" class="profile" alt="">';
        }

        html += '<span class="about">';
        if($data.comment[i].school_name==null){
           html += '<span class="name" style="margin-top:9px;">'+$data.comment[i].user_id+'</span>';
           $data.comment[i].school_name = "";
        }else{
          html += '<span class="name">'+$data.comment[i].user_id+'</span>';
        }
        html += '<span class="school">'+$data.comment[i].school_name+'</span>';
        html += '<span class="time">'+$data.comment[i].write_time+'</span>';
    		html += '</span>';
        html += '</div>';
        html += '<div class="cont">'+$data.comment[i].comment+'</div>';
        html += '<div class="bottom_area">';
        html += '<span class="like">좋아요 <span id="like_num_'+$data.comment[i].feed_comment_seq+'">'+$data.comment[i].like_total+'</span>개</span>';
        html += '<a href="#" class="btn_reply" onclick="commentWrite(\''+$data.comment[i].feed_comment_seq+'\')">답글 달기</a>';
        html += '</div>';
        if($data.comment[i].is_like=="Y"){
          html += '<a href="#" class="btn_like_on" data-comment_seq="'+$data.comment[i].feed_comment_seq+'" onclick="replyLike(this)">좋아요</a>';
        }else {
          html += '<a href="#" class="btn_like" data-comment_seq="'+$data.comment[i].feed_comment_seq+'" onclick="replyLike(this)">좋아요</a>';
        }

        //대댓글 있을경우
        if($data.comment[i].comment_to_comment.length>0){
          html += '<a href="#" class="btn_replay_more">답글 '+$data.comment[i].comment_to_comment.length+'개</a>';
          html += '<ul class="list_rereply">';
          for(var j=0; j<$data.comment[i].comment_to_comment.length; j++){
            html += '<li>';
            html += '<div class="user_info">';
            if($data.comment[i].comment_to_comment[j].profile_img){
              html += '<img src="/upload/member/'+$data.comment[i].comment_to_comment[j].profile_img+'" class="profile" alt="">';
            }else{
              html += '<img src="/images/common/user.png" class="profile" alt="">';
            }

            html += '<span class="about">';
            if($data.comment[i].comment_to_comment[j].school_name==null){
              html += '<span class="name" style="margin-top:9px;">'+$data.comment[i].comment_to_comment[j].user_id+'</span>';
              $data.comment[i].comment_to_comment[j].school_name = "";
            }else{
              html += '<span class="name">'+$data.comment[i].comment_to_comment[j].user_id+'</span>';
            }
            html += '<span class="school">'+$data.comment[i].comment_to_comment[j].school_name+'</span>';
            html += '<span class="time">'+$data.comment[i].comment_to_comment[j].write_time+'</span>';
            html += '</span>';
            html += '</div>';
            html += '<div class="cont">'+$data.comment[i].comment_to_comment[j].comment+'</div>';
            html += '<div class="bottom_area">';
            html += '<span class="like">좋아요  <span id="like_num_'+$data.comment[i].comment_to_comment[j].feed_comment_seq+'">'+$data.comment[i].comment_to_comment[j].like_total+'</span>개</span>';
            html += '<a href="#" class="btn_reply" onclick="commentWrite(\''+$data.comment[i].comment_to_comment[j].feed_comment_seq+'\')">답글 달기</a>';
            html += '</div>';
            if($data.comment[i].comment_to_comment[j].is_like == "Y"){
              html += '<a href="#" class="btn_like_on" data-comment_seq="'+$data.comment[i].comment_to_comment[j].feed_comment_seq+'" onclick="replyLike(this)">좋아요</a>';
            }else {
              html += '<a href="#" class="btn_like" data-comment_seq="'+$data.comment[i].comment_to_comment[j].feed_comment_seq+'" onclick="replyLike(this)">좋아요</a>';
            }

            html += '</li>';
          }

          html += '</ul>';
        }
      }

      //대댓글 끝
      html += '</li>';
      html += '</ul>';
    }
    html += '</div>';

    //입력창
    html += '<div class="reply_form">';
    <?php if(!empty($userData['profile_img'])){ ?>
      html += '<img src="/upload/member/<?php echo $userData['profile_img']; ?>" class="profile" alt="">';
    <?php }else{ ?>
      html += '<img src="/images/common/user.png" class="profile" alt="">';
    <?php } ?>
    html += '<input type="text" id="commentInput" class="input_reply" placeholder="<?php echo $userData['user_id'] ?>(으)로 댓글 달기">';
		html += '<a href="#" class="btn_submit" onclick="writeComment()">게시</a>';
    html += '</div>';
    //입력창 끝

    return html;

  }

  function commentWrite(comment_seq)
  {
    select_comment_seq = comment_seq;
    $('#commentInput').focus();
  }

  function writeComment()
  {
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();
    var comment = $('#commentInput').val();

    var data = {
      "comment_seq" : select_comment_seq,
      "feed_seq"  : select_feed_seq,
      "comment" : comment
    };

    data[csrf_name] = csrf_val;
    loadView('Y');

    $.ajax({
      type: "POST",
      url : "/feed/writeCommentProc",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        loadView('N');
        select_comment_seq = 0;
        commentView(select_feed_seq,"N");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function replyLike(obj)
  {
    var class_name = $(obj).hasClass("btn_like");
    var comment_seq = $(obj).data("comment_seq");
    var like_num = Number($('#like_num_'+comment_seq).text());

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var val = "";

    if(class_name){
      val = "Y";
      //좋아요 처리
      $(obj).removeClass("btn_like");
      $(obj).addClass("btn_like_on");
      $('#like_num_'+comment_seq).text(like_num+1);

    }else{
      val = "N";
      //좋아요 취소 처리
      $(obj).removeClass("btn_like_on");
      $(obj).addClass("btn_like");
      $('#like_num_'+comment_seq).text(like_num-1);

    }

    var data = {
      "comment_seq" : comment_seq,
      "val" : val
    };

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/feed/commentLike",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(val=="Y"){
          $(obj).removeClass("btn_like");
          $(obj).addClass("btn_like_on");
          $('#like_num_'+comment_seq).text(like_num+1);
        }else{
          //좋아요 취소 처리
          $(obj).removeClass("btn_like_on");
          $(obj).addClass("btn_like");
          $('#like_num_'+comment_seq).text(like_num-1);
        }
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
    });

    var num = 0;
    var mySwiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      pagination: {
        el: ".swiper-pagination",
      },
    });

    function feedLoad()
    {
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var data = {
        "feed_seq"  : {feed_seq}
      };

      data[csrf_name] = csrf_val;

      $.ajax({
        type: "POST",
        url : "/feed/feedViewLoad",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {
          var html = "";
          if(data.data.feedList.length>0){
            for(var i = 0; i<data.data.feedList.length; i++){
              html += makeFeedHtml(data.data.feedList[i]);
            }


          }
          $('#feed_wrap').html(html);


          mySwiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            pagination: {
              el: ".swiper-pagination",
            },
          });


        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });

    }

    function makeFeedHtml($data)
    {

      var html = "";
      html += '<div class="content_item">';
      html += '<div class="content_info">';
      html += '<div class="user">';
      html += '<a href="#">';
      if($data.profile_img != ""){
        html += '<img src="/upload/member/'+$data.profile_img+'" class="img" alt="">';
      }else{
        html += '<img src="/images/common/user.png" class="img" alt="">';
      }

      if($data.school_name==null){
        $data.school_name = "";
        html += '<span class="name" style="margin-top:9px;">'+$data.user_id+'</span>';
      }else{
        html += '<span class="name">'+$data.user_id+'</span>';
      }
      html += '<span class="school">'+$data.school_name+'</span>';
      html += '</a>';
      html += '</div>';
      html += '<span class="category">'+$data.challenge_title+'</span>';
      html += '<a href="javascript:moreView(\''+$data.is_me+'\',\''+$data.feed_seq+'\')" class="btn_more">메뉴</a>';
      html += '</div>';
      html += '<div class="content_img">';
      html += '<div class="swiper-container">';

      html += '<div class="swiper-wrapper">';
      //image
      for(var i = 0; i<$data.images.length; i++){
        html += '<div class="swiper-slide">';
        html += '<div class="img square-container"><img src="/upload/member/feed/'+$data.images[i]+'" alt=""></div>';
        html += '</div>';
      }
      //image end
      html += '</div>';
      html += '<div class="swiper-pagination"></div>';
      html += '</div>';
      html += '</div>';


      //comment
      html += '<div class="content_etc" id="feed_'+$data.feed_seq+'">';
      html += '<div class="icon">';
      if($data.is_like=="Y"){
        html += '<a href="javascript:likeDel(\'feed_'+$data.feed_seq+'\');"><img src="/images/common/icon_like_on.png" class="icon_like" alt=""></a>';
      }else{
        html += '<a href="javascript:likeAdd(\'feed_'+$data.feed_seq+'\');"><img src="/images/common/icon_like.png" class="icon_like" alt=""></a>';
      }

      html += '<img src="/images/common/icon_reply.png" class="icon_reply" alt="">';
      html += '</div>';
      html += '<div class="cont_like">';
      html += '<span class="count">좋아요 <span id="feed_like_'+$data.feed_seq+'">'+$data.like_total+'</span>개</span>';
      html += '<ul>';
      html += '<li>';
      html += '<span class="name">'+$data.user_id+'</span>';
      html += $data.feed_content;
      //html += '<a href="#" class="btn_more">더보기</a>';
      html += '</li>';
      html += '</ul>';
      html += '</div>';
      html += '<div class="cont_reply">';
      if($data.comment_total>0){
        html += '<a href="javascript:commentView(\''+$data.feed_seq+'\')" class="count">댓글 '+$data.comment_total+'개 모두 보기</a>';
      }else{
        html += '<a href="javascript:commentView(\''+$data.feed_seq+'\')" class="count">댓글달기</a>';
      }
      //comment view
      if($data.comment_total>0){
        html += '<ul>';
        for(var i=0; i<$data.comment.length; i++){
          if(i<3){
            html += '<li>';
            html += '<span class="name">'+$data.comment[i].user_id+'</span>';
            html += $data.comment[i].comment;
            html += '</li>';
          }
        }
        html += '</ul>';
      }

      //comment view end
      html += '</div>';
      html += '<div class="time">'+$data.write_time+'</div>';
      html += '</div>';
      html += '</div>';

      return html;

    }

    function likeDel($obj)
    {
      var img = $('#'+$obj).find(".icon img:eq(0)");
      $(img).attr("src","/images/common/icon_like.png");
      var a_tag = $('#'+$obj).find(".icon a:eq(0)");
      $(a_tag).attr("href","javascript:likeAdd('"+$obj+"')");

      var obj_arr = $obj.split('_');
      var feed_seq = obj_arr[1];

      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var like_num = Number($('#feed_like_'+feed_seq).text());

      $('#feed_like_'+feed_seq).text(like_num-1);

      var data = {
        "feed_seq"  : feed_seq
      };

      data[csrf_name] = csrf_val;

      $.ajax({
        type: "POST",
        url : "/feed/feedLikeDel",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }

    function likeAdd($obj)
    {
      var img = $('#'+$obj).find(".icon img:eq(0)");
      $(img).attr("src","/images/common/icon_like_on.png");
      var a_tag = $('#'+$obj).find(".icon a:eq(0)");
      $(a_tag).attr("href","javascript:likeDel('"+$obj+"')");



      var obj_arr = $obj.split('_');
      var feed_seq = obj_arr[1];

      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var like_num = Number($('#feed_like_'+feed_seq).text());

      $('#feed_like_'+feed_seq).text(like_num+1);


      var data = {
        "feed_seq"  : feed_seq
      };

      data[csrf_name] = csrf_val;

      $.ajax({
        type: "POST",
        url : "/feed/feedLikeAdd",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {

        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  </script>
