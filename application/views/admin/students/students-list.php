<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="float-left">{title}</h1>

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
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <input type="hidden" id="user_status" name="user_status" value=""/>
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcType" id="srcType">
                    <option value="all" <?php echo ($srcType=="all") ? "selected": ""; ?>>전체</option>
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>회원명</option>
                    <option value="id" <?php echo ($srcType=="id") ? "selected": ""; ?>>회원아이디</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="status" id="status">
                    <option value="all" <?php echo ($status=="all") ? "selected": ""; ?>>전체</option>
                    <option value="C" <?php echo ($status=="C") ? "selected": ""; ?>>승인</option>
                    <option value="R" <?php echo ($status=="R") ? "selected": ""; ?>>대기</option>
                    <option value="L" <?php echo ($status=="L") ? "selected": ""; ?>>탈퇴</option>
                  </select>
                  <?php if($this->session->userdata("admin_type")=="A"){ ?>
                  <select class="form-control select2 float-right" id="academy_select" style="width:400px" onchange="academiSelect()">
                    <option>학원선택</option>
                    <?php for($i=0;$i<count($this->CONFIG_DATA['academy_list']);$i++){ ?>
                    <option value="<?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_seq']; ?>" <?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_seq']==$this->session->userdata("academy_seq")?"selected":"" ?>><?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_name']; ?></option>
                    <?php } ?>
                  </select>
                  <?php } ?>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {total_user}명</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <?php if($this->session->userdata("admin_type")=="A"){ ?>
                      <col width="9%"/>
                      <?php } ?>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <?php if($this->session->userdata("admin_type")=="A"){ ?>
                        <th class="text-center">학원이름</th>
                        <?php } ?>
                        <th class="text-center">회원아이디</th>
                        <th class="text-center">회원이름</th>
                        <th class="text-center">학생연락처</th>
                        <th class="text-center">부모연락처</th>
                        <th class="text-center">학교</th>
                        <th class="text-center">학년</th>
                        <th class="text-center">반</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">상태</th>
                        <th class="text-center">관리</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($studentList) > 0 ){ ?>
                      {studentList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{user_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <?php if($this->session->userdata("admin_type")=="A"){ ?>
                        <td class="text-center align-middle">{academy_name}</td>
                        <?php } ?>
                        <td class="text-center align-middle">{user_id}</td>
                        <td class="text-center align-middle">{user_name}</td>
                        <td class="text-center align-middle">{phone}</td>
                        <td class="text-center align-middle">{parent_phone}</td>
                        <td class="text-center align-middle">{school_name}</td>
                        <td class="text-center align-middle">{school_year}</td>
                        <td class="text-center align-middle">{class_name}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                        <td class="text-center align-middle">{status}</td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-block btn-warning" onclick="goModify('{user_seq}')">수정</button></td>
                      </tr>
                      {/studentList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="10">회원이 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeStudent()">회원등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="studentExcelDown()">엑셀다운로드</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceStateChange('C')">선택승인</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceStateChange('R')">선택대기</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceStateChange('L')">선택탈퇴</button>
              </span>
              <?php if($this->session->userdata("admin_type")=="A"){ ?>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="studentExcelWrite()">엑셀등록</button>
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
<form id="excel_down_form" method="POST" action="/admin/academiAdm/studentDownLoad">
  <input type="hidden" name="srcN_excel" id="srcN_excel"/>
  <input type="hidden" name="srcType_excel" id="srcType_excel"/>
  <input type="hidden" name="status_excel" id="status_excel"/>
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
</form>
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

function choiceStateChange($str)
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("선택변경 회원을 선택해주세요.");
    return;
  }

  $('#user_status').val($str);

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();


  data[csrf_name] = csrf_val;


  if(confirm("상태를 변경하시겠습니까?")){
    $.ajax({
      type: "POST",
      url : "/admin/academiAdm/updateUserStatus",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result=="success"){
          alert("회원 상태가 변경되었습니다.");
        }else{
          alert("학원의 사용인원이 초과 되었습니다.");
        }

        location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }


}

  function goModify($seq)
  {
      location.href="/admin/academiAdm/studentModify/"+$seq+"?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
  }

  function writeStudent()
  {
    location.href="/admin/academiAdm/studentWrite?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
  }

  function studentExcelWrite()
  {
    window.open("/admin/home/studentExcel","popup_window","left=50 , top=50, width=985, height=500, scrollbars=auto");
  }

  function studentExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcType_excel').val($('#srcType').val());
    $('#status_excel').val($('#status').val());

    $('#excel_down_form').submit();
  }
</script>
