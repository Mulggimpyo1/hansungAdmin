<script src="https://kit.fontawesome.com/ab06f23d17.js" crossorigin="anonymous"></script>
<style type="text/css">
.multiselect-native-select{
  float:right;
  margin-top:5px;
}
.multiselect-native-select .btn-group{
  width: 250px;
}
div.gallery img {
    width: 100%;
    height: auto;
    height: 290px;
    text-align: center;
    filter: brightness(100%);
    transition:0.5s all;
}
div.desc {
    height:40px;
    padding-top: 6px;
    padding-bottom:6px;
    text-align: center;
}
.responsive {
    margin-top: 10px;
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    padding: 0 6px;
    float: left;
    width: 20%;  // 기본값으로 5개씩으로 설정
    position:relative;

}

.responsive a{
  text-decoration: none!important; /* 링크의 밑줄 제거 */
  color: inherit!important; /* 링크의 색상 제거 */
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

.more {
  position: absolute;
  top: 40%;
  left: 50%;
  opacity: 0;
  transition:0.5s all;
  transform: translate(-50%, -50%);
  z-index: 10;
}
.del {
  position: absolute;
  top: 50%;
  left: 50%;
  opacity: 0;
  transition:0.5s all;
  transform: translate(-50%, -50%);
  z-index: 10;
}

.chk {
  position: absolute;
  margin-top : 10px;
  margin-left : 10px;
  zoom:1.5;
  z-index: 10;
}

.delete-cover {
  position: absolute;
  margin-top : 10px;
  margin-left : 10px;
  width:100px;
  border-radius:4px;
  font-weight: 600;
  padding:5px;
  text-align: center;
  background-color: #dc3545;
  color:#fff;
  z-index: 10;
}

.responsive:hover .more {opacity:1}
.responsive:hover .del {opacity:1}
.responsive:hover img{filter: brightness(50%); }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{title}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">{sub_title}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <form id="content_form" method="get">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" id="edu_display_yn" name="edu_display_yn" value=""/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="status" id="status">
                    <option value="all" <?php echo ($status=="all") ? "selected": ""; ?>>상태</option>
                    <option value="Y" <?php echo ($status=="Y") ? "selected": ""; ?>>게시</option>
                    <option value="N" <?php echo ($status=="N") ? "selected": ""; ?>>비게시</option>
                    <option value="D" <?php echo ($status=="D") ? "selected": ""; ?>>관리자삭제</option>
                    <option value="F" <?php echo ($status=="F") ? "selected": ""; ?>>신고피드</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="user_level" id="user_level">
                    <option value="all" <?php echo ($user_level=="all") ? "selected": ""; ?>>등급</option>
                    <option value="0" <?php echo ($user_level=="0") ? "selected": ""; ?>>본사관리자</option>
                    <option value="1" <?php echo ($user_level=="1") ? "selected": ""; ?>>기관관리자</option>
                    <option value="2" <?php echo ($user_level=="2") ? "selected": ""; ?>>학급관리자</option>
                    <option value="6" <?php echo ($user_level=="6") ? "selected": ""; ?>>학생회원</option>
                    <option value="7" <?php echo ($user_level=="7") ? "selected": ""; ?>>일반회원</option>
                  </select>
                  <?php if($this->session->userdata("admin_level")<=1){ ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="school_year" id="school_year">
                    <option value="all" <?php echo ($school_year=="all") ? "selected": ""; ?>>전체</option>
                    <?php for($i=0; $i<6; $i++){ ?>
                    <option value="<?php echo ($i+1); ?>" <?php echo ($school_year==($i+1)) ? "selected": ""; ?>><?php echo ($i+1)."학년" ?></option>
                    <?php } ?>
                    <option value="None" <?php echo ($school_year=="None") ? "selected": ""; ?>>None</option>
                  </select>
                <?php }else{ ?>
                  <input type="hidden" name="school_year" id="school_year" value="<?php echo $this->session->userdata("school_year"); ?>"/>
                <?php } ?>
                  <?php if($this->session->userdata("admin_level")==0){ ?>
                  <select class="form-control col-2 float-right select2" style="margin:5px 5px 5px 5px;" name="school_seq" id="school_seq">
                    <option value="all" <?php echo ($school_seq=="all") ? "selected": ""; ?>>기관</option>
                    <?php for($i=0; $i<count($schoolList); $i++){ ?>
                      <option value="<?php echo $schoolList[$i]['school_seq']; ?>"><?php echo $schoolList[$i]['school_name'];?></option>
                    <?php } ?>
                  </select>
                  <?php }else{ ?>
                    <input type="hidden" name="school_seq" id="school_seq" value="<?php echo $this->session->userdata("school_seq"); ?>"/>
                  <?php } ?>
                  <select class="form-control col-1 float-right" multiple="multiple" style="margin:5px 5px 5px 5px;" name="challenge_cate_id[]" id="challenge_cate_id">
                    <?php for($i=0; $i<count($challengeList); $i++){ ?>
                      <option value="<?php echo $challengeList[$i]['challenge_cate_id']; ?>"><?php echo $challengeList[$i]['challenge_title']; ?></option>
                    <?php } ?>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}개</span>
                </div>

                <div class="clearfix"></div>
                <?php if(count($feedList)>0){ ?>
                <?php for($i=0; $i<count($feedList); $i++){ ?>
                <div class="responsive" style="position:relative;">
                  <?php if($feedList[$i]['status']=="D"){ ?>
                  <div class="delete-cover">삭제</div>
                  <button type="button" class="btn btn-block btn-default del" style="width:150px;" onclick="statusChange('<?php echo $feedList[$i]['feed_seq']; ?>');">복구</button>
                  <?php }else{ ?>
                  <input type="checkbox" class="chk" name="chk[]" value="<?php echo $feedList[$i]['feed_seq']; ?>"/>
                  <button type="button" class="btn btn-block btn-primary more" style="width:150px;" onclick="viewFeed('<?php echo $feedList[$i]['feed_seq']; ?>')">상세보기</button>
                  <button type="button" class="btn btn-block btn-default del" style="width:150px;" onclick="viewReport('<?php echo $feedList[$i]['feed_seq']; ?>');">삭제</button>
                  <?php } ?>

                  <div class="gallery">
                    <a href="#" href="img_fjords.jpg">
                      <img src="/upload/member/feed/<?php echo $feedList[$i]['feed_img'][0]; ?>">
                    </a>
                    <div class="desc">
                      <span class="float-left"><a href="#">♥ <?php echo $feedList[$i]['like_total']; ?></a></span>
                      <span class="float-left ml-2"><a href="#"><i class="fa-solid fa-comment"></i><?php echo $feedList[$i]['comment_total']; ?></a></span>
                      <?php if(!empty($feedList[$i]['report_total'])){ ?>
                      <span class="float-left ml-2" style="color:red"><a href="javascript:viewReport('<?php echo $feedList[$i]['feed_seq']; ?>');"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo $feedList[$i]['report_total']; ?></a></span>
                      <?php } ?>
                      <span class="float-right"><a href="#"><?php echo $feedList[$i]['user_name']; ?>(<?php echo $feedList[$i]['user_id']; ?>)</a></span>
                    </div>
                  </div>
                </div>
                <?php } ?>
                <?php }else{ ?>
                  <div class="mt-4 mb-4" style="width:100%;text-align:center">
                    피드가 없습니다.
                  </div>
                <?php } ?>
              </div>
            </form>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-left">
                {paging}
                {no}
                {/paging}
              </ul>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceDelete()">선택삭제</button>
              </span>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/css/multi-select.css">

<!-- Latest compiled and minified JavaScript -->
<script src="/js/multi-select.js"></script>
<script>

  $(function(){
    $('#challenge_cate_id').multiselect();
    $('.select2').select2();
    $('.select2').css("float","right");
      $('#allCheck').on("click",function(){
        allCheckClick();
      });
  });

  function viewReport($feed_seq)
  {
    window.open("/admin/contentAdm/feedReportPop/"+$feed_seq,"feedReportPop","width=470, height=500");
  }

  function goModify($edu_seq)
  {
    location.href = "/admin/contentAdm/eduModify/"+$edu_seq+"{param}";
  }

  function allCheckClick()
  {
    if($('#allCheck').is(":checked") == true ){
      $('input[name="chk[]"]').prop("checked",true);
    }else{
      $('input[name="chk[]"]').prop("checked",false);
    }
  }

  function choiceDelete()
  {
    var chkBool = false;
    $('input[name="chk[]"]').each(function(){
      if($(this).is(":checked")){
        chkBool = true;
        return;
      }
    });


    if(chkBool == false){
      alert("삭제할 피드를 선택해주세요.");
      return;
    }

    if(confirm("정말 삭제하시겠습니까?")){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var data = $('#content_form').serialize();

      data[csrf_name] = csrf_val;

      $.ajax({
        type: "POST",
        url : "/admin/contentAdm/deleteChoiceFeed",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {
          alert("삭제 되었습니다.");
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }

  }

  function statusChange($feed_seq)
  {
    if(confirm("복구 하시겠습니까?")){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();
      var data = {
        "feed_seq"  : $feed_seq
      };

      data[csrf_name] = csrf_val;

      $.ajax({
        type: "POST",
        url : "/admin/contentAdm/feedStatusChange",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {
          alert("복구 되었습니다.");
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function viewFeed($feed_seq)
  {
    window.open("/feed/feedView/"+$feed_seq, "Feed", "width=400,height=667");
  }


  function writeEdu()
  {
    location.href="/admin/contentAdm/eduWrite{param}";
  }

</script>
