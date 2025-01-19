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
              <input type="hidden" name="school_status" id="school_status"/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcType" id="srcType">
                    <option value="all" <?php echo ($srcType=="all") ? "selected": ""; ?>>전체</option>
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>기관명</option>
                    <option value="a_name" <?php echo ($srcType=="a_name") ? "selected": ""; ?>>관리자명</option>
                    <option value="a_id" <?php echo ($srcType=="a_id") ? "selected": ""; ?>>관리자 계정</option>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="status" id="status">
                    <option value="all" <?php echo ($status=="all") ? "selected": ""; ?>>전체</option>
                    <option value="Y" <?php echo ($status=="Y") ? "selected": ""; ?>>승인</option>
                    <option value="N" <?php echo ($status=="N") ? "selected": ""; ?>>미승인</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}개</span>
                </div>
                <div class="card-body table-responsive p-0">
                  <div class="form-group">
                      <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="page_size" id="page_size" onchange="this.form.submit();">
                      <option value="20" <?php echo ($page_size=="20") ? "selected": ""; ?>>20개</option>
                      <option value="50" <?php echo ($page_size=="50") ? "selected": ""; ?>>50개</option>
                      <option value="100" <?php echo ($page_size=="100") ? "selected": ""; ?>>100개</option>
                    </select>
                  </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">관리코드</th>
                        <th class="text-center">구분</th>
                        <th class="text-center">기관명</th>
                        <th class="text-center">관리자</th>
                        <th class="text-center">학급</th>
                        <th class="text-center">학생</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">상태</th>
                        <th class="text-center">관리자계정</th>
                        <th class="text-center">수정</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($schoolList) > 0 ){ ?>
                      {schoolList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{school_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{school_no}</td>
                        <td class="text-center align-middle">{contract_type}</td>
                        <td class="text-center align-middle">{school_name}</td>
                        <td class="text-center align-middle">{admin_name}</td>
                        <td class="text-center align-middle">{total_class}</td>
                        <td class="text-center align-middle">{total_user}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                        <td class="text-center align-middle">{status}</td>
                        <td class="text-center align-middle">{admin_id}</td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-block btn-warning" onclick="goModify('{school_seq}')">수정</button></td>
                      </tr>
                      {/schoolList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="11">기관이 없습니다.</td>
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
              <?php if($this->session->userdata("admin_type")=="A"){ ?>
              <span class="float-right">
                <button type="button" class="btn btn-block btn-success" onclick="writeSchool()">기관등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="schoolExcelDown()">엑셀다운로드</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceStateChange('Y')">선택승인</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceStateChange('N')">선택미승인</button>
              </span>

              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="schoolExcelWrite()">엑셀등록</button>
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
<form id="excel_down_form" method="POST" action="/admin/schoolAdm/schoolDownLoad">
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

function writeSchool()
{
  location.href = "/admin/schoolAdm/schoolWrite?num={num}&srcN={srcN}&srcType={srcType}&status={status}&page_size={page_size}";
}

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
    alert("선택변경 기관을 선택해주세요.");
    return;
  }

  $('#school_status').val($str);

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();


  data[csrf_name] = csrf_val;


  if(confirm("상태를 변경하시겠습니까?")){
    $.ajax({
      type: "POST",
      url : "/admin/schoolAdm/updateSchoolStatus",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result=="success"){
          alert("기관 상태가 변경되었습니다.");
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
      location.href="/admin/schoolAdm/schoolModify/"+$seq+"?num={num}&srcN={srcN}&srcType={srcType}&status={status}&page_size={page_size}";
  }

  function schoolExcelWrite()
  {
    window.open("/admin/schoolAdm/schoolExcel","popup_window","left=50 , top=50, width=985, height=500, scrollbars=auto");
  }

  function schoolExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcType_excel').val($('#srcType').val());
    $('#status_excel').val($('#status').val());

    $('#excel_down_form').submit();
  }
</script>
