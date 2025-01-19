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
                <?php if($this->session->userdata("admin_level")==0){ ?>
                <div class="form-group">
                  <button type="button" class="btn btn-default float-right" style="margin:5px 5px 5px 5px;" id="delBtn" onclick="deleteNotice()">삭제</button>
                  <button type="button" class="btn btn-default float-right" style="margin:5px 5px 5px 5px;" id="readBtn" onclick="choiceReadChange()">변경</button>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="notice_read_type" id="notice_read_type">
                    <option value="">공개변경</option>
                    <option value="0">전체공개</option>
                    <option value="1">기관관리자이상</option>
                    <option value="2">학급관리자이상</option>
                  </select>
                </div>
              <?php } ?>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">읽기권한</th>
                        <th class="text-center">조회</th>
                        <th class="text-center">날짜</th>
                        <?php if($this->session->userdata("admin_level")==0){ ?>
                        <th class="text-center">수정</th>
                        <?php }else{ ?>
                          <th class="text-center">보기</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($noticeList) > 0 ){ ?>
                      {noticeList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{notice_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{notice_title}</td>
                        <td class="text-center">{notice_read_type}</td>
                        <td class="text-center">{notice_read_cnt}</td>
                        <td class="text-center">{notice_reg_datetime}</td>
                        <?php if($this->session->userdata("admin_level")==0){ ?>
                        <td class="text-center"><button type="button" class="btn btn-block btn-warning" onclick="goModify('{notice_seq}')">수정</button></td>
                        <?php }else{ ?>
                        <td class="text-center"><button type="button" class="btn btn-block btn-warning" onclick="goView('{notice_seq}')">보기</button></td>
                        <?php } ?>
                      </tr>
                      {/noticeList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="7">게시글이 없습니다.</td>
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
              <?php if($this->session->userdata("admin_level")==0){ ?>
              <span class="float-right">
                <button type="button" class="btn btn-block btn-success" onclick="writeNotice()">글쓰기</button>
              </span>
              <?php } ?>
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
    $('#allCheck').on("click",function(){
      allCheckClick();
    });
});

function allCheckClick()
{
  if($('#allCheck').is(":checked") == true ){
    $('input[name="chk[]"]').prop("checked",true);
  }else{
    $('input[name="chk[]"]').prop("checked",false);
  }
}

function choiceReadChange()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("공개변경 교육정보를 선택해주세요.");
    return;
  }

  var notice_read_type = $('#notice_read_type').val();
  if(notice_read_type == ""){
    alert("변경할 공개상태를 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/etcAdm/updateNoticeDisplay",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      alert("상태가 변경되었습니다.");
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

  function goView($seq)
  {
      location.href="/admin/etcAdm/noticeView/"+$seq+"{param}";
  }

  function writeNotice()
  {
    location.href="/admin/etcAdm/noticeWrite/{param}";
  }
</script>
