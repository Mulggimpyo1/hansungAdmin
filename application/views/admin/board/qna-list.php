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
            <form id="search_form">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="comment_yn" id="comment_yn">
                    <option value="all" <?php echo ($comment_yn=="all") ? "selected": ""; ?>>답글상태</option>
                    <option value="Y" <?php echo ($comment_yn=="Y") ? "selected": ""; ?>>답글완료</option>
                    <option value="N" <?php echo ($comment_yn=="N") ? "selected": ""; ?>>답글대기</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="category" id="category">
                    <option value="all" <?php echo ($category=="all") ? "selected": ""; ?>>구분</option>
                    <option value="PROGRAM" <?php echo ($category=="PROGRAM") ? "selected": ""; ?>>프로그램 문의</option>
                    <option value="ERROR" <?php echo ($category=="ERROR") ? "selected": ""; ?>>오류문의</option>
                    <option value="ACCOUNT" <?php echo ($category=="ACCOUNT") ? "selected": ""; ?>>계정문의</option>
                    <option value="POINT" <?php echo ($category=="POINT") ? "selected": ""; ?>>포인트문의</option>
                    <option value="ETC" <?php echo ($category=="ETC") ? "selected": ""; ?>>기타</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="user_level" id="user_level">
                    <option value="all" <?php echo ($user_level=="all") ? "selected": ""; ?>>등급</option>
                    <option value="0" <?php echo ($user_level=="0") ? "selected": ""; ?>>본사관리자</option>
                    <option value="1" <?php echo ($user_level=="1") ? "selected": ""; ?>>기관관리자</option>
                    <option value="2" <?php echo ($user_level=="2") ? "selected": ""; ?>>학급관리자</option>
                    <option value="6" <?php echo ($user_level=="6") ? "selected": ""; ?>>학생회원</option>
                    <option value="7" <?php echo ($user_level=="7") ? "selected": ""; ?>>일반회원</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="school_class" id="school_class">
                    <option value="all" <?php echo ($school_class=="all") ? "selected": ""; ?>>반</option>
                    <?php for($i=0; $i<count($classList); $i++){ ?>
                    <option value="<?php echo $classList[$i]['school_class']; ?>" <?php echo ($classList[$i]['school_class']==$school_class) ? "selected": ""; ?>><?php echo $classList[$i]['school_class']; ?></option>
                    <?php } ?>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="school_year" id="school_year">
                    <option value="all" <?php echo ($school_year=="all") ? "selected": ""; ?>>학년</option>
                    <?php for($i=0; $i<6; $i++){ ?>
                    <option value="<?php echo ($i+1); ?>" <?php echo ($school_year==($i+1)) ? "selected": ""; ?>><?php echo ($i+1)."학년" ?></option>
                    <?php } ?>
                    <option value="None" <?php echo ($school_year=="None") ? "selected": ""; ?>>None</option>
                  </select>
                  <select class="form-control col-2 float-right select2" style="margin:5px 5px 5px 5px;" name="school_seq" id="school_seq">
                    <option value="all" <?php echo ($school_seq=="all") ? "selected": ""; ?>>기관</option>
                    <?php for($i=0; $i<count($schoolList); $i++){ ?>
                    <option value="<?php echo $schoolList[$i]['school_seq']; ?>" <?php echo ($schoolList[$i]['school_seq']==$school_seq) ? "selected": ""; ?>><?php echo $schoolList[$i]['school_name']; ?></option>
                    <?php } ?>
                    <option value="None" <?php echo ($school_seq=="None") ? "selected": ""; ?>>None</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}명</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col/>
                      <col width="10%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="15%"/>
                      <col width="10%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">구분</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">학교</th>
                        <th class="text-center">학년</th>
                        <th class="text-center">반</th>
                        <th class="text-center">회원구분</th>
                        <th class="text-center">글쓴이</th>
                        <th class="text-center">날짜</th>
                        <th class="text-center">상태</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($qnaList) > 0 ){ ?>
                      {qnaList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{qna_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{qna_category}</td>
                        <td class="text-center">{qna_title}</td>
                        <td class="text-center">{school_name}</td>
                        <td class="text-center">{school_year}</td>
                        <td class="text-center">{school_class}</td>
                        <td class="text-center">{user_level}</td>
                        <td class="text-center"><a href="javascript:goView('{qna_seq}')">{user_name}({user_id})</a></td>
                        <td class="text-center">{qna_reg_datetime}</td>
                        <td class="text-center"><a href="javascript:goView('{qna_seq}')">{comment_yn}</a></td>
                      </tr>
                      {/qnaList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="11">게시글이 없습니다.</td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </form>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-left">
                {paging}
                {no}
                {/paging}
              </ul>
              <span class="float-right">
                <button type="button" class="btn btn-block btn-default" onclick="deleteQna()">선택삭제</button>
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
<script>
$(function(){
  $('.select2').select2();
  $('.select2').css("float","right");
    $('#allCheck').on("click",function(){
      allCheckClick();
    });
});

function goView($qna_seq)
{
  location.href = "/admin/etcAdm/qnaView/"+$qna_seq+"{param}";
}

function allCheckClick()
{
  if($('#allCheck').is(":checked") == true ){
    $('input[name="chk[]"]').prop("checked",true);
  }else{
    $('input[name="chk[]"]').prop("checked",false);
  }
}

function deleteQna()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("삭제할 문의를 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/etcAdm/deleteQna",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      alert("삭제되었습니다.");
      location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function deleteNotice()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("삭제할 공지사항을 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/etcAdm/deleteNotice",
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
  function goModify($seq)
  {
      location.href="/admin/etcAdm/noticeModify/"+$seq+"{param}";
  }

  function writeNotice()
  {
    location.href="/admin/etcAdm/noticeWrite/{param}";
  }
</script>
