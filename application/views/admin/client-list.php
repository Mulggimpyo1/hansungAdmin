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
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>업체명</option>
                    <option value="id" <?php echo ($srcType=="id") ? "selected": ""; ?>>사업자번호</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {total_client}개</span>
                </div>
                  <table class="table table-hover" <?php if($this->CONFIG_DATA['device']=="mobile"){  ?>style="width:800px;"<?php }?>>
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col/>
                      <col width="10%" <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> class=" d-none d-sm-block"<?php }?>/>
                      <col width="15%"/>
                      <col width="10%" <?php if($this->CONFIG_DATA['device']=="mobile"){  ?> class=" d-none d-sm-block"<?php }?>/>
                      <col width="10%"/>
                      <col/>
                      <col width="10%" <?php if($this->CONFIG_DATA['device']=="mobile"){  ?> class=" d-none d-sm-block"<?php }?>/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">업체명</th>
                        <th class="text-center <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">사업자번호</th>
                        <th class="text-center">전화번호</th>
                        <th class="text-center <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">팩스번호</th>
                        <th class="text-center">담당자</th>
                        <th class="text-center">담당자연락처</th>
                        <th class="text-center  <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">등록일</th>
                        <th class="text-center">관리</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($clientList) > 0 ){ ?>
                      {clientList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{client_idx}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{client_name}</td>
                        <td class="text-center align-middle   <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">{business_no}</td>
                        <td class="text-center align-middle"><a href="tel://{phone}">{phone}</a></td>
                        <td class="text-center align-middle  <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">{fax}</td>
                        <td class="text-center align-middle">{manager_name}</td>
                        <td class="text-center align-middle"><a href="tel://{manager_phone}">{manager_phone}</a></td>
                        <td class="text-center align-middle  <?php if($this->CONFIG_DATA['device']=="mobile"){ ?> d-none d-sm-block<?php }?>">{wdate}</td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-block btn-warning" onclick="goModify('{client_idx}')">수정</button></td>
                      </tr>
                      {/clientList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="10">업체가 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeClient()">업체등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="choiceStateDelete()">선택삭제</button>
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
<form id="excel_down_form" method="POST" action="/admin/home/clientDownLoad">
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

function choiceStateDelete()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("삭제할 업체를 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();


  data[csrf_name] = csrf_val;


  if(confirm("정말 삭제하시겠습니까?")){
    $.ajax({
      type: "POST",
      url : "/admin/home/deleteClients",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result=="success"){
          alert("업체가 삭제 되었습니다.");
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
      location.href="/admin/home/clientModify/"+$seq+"?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
  }

  function writeClient()
  {
    location.href="/admin/home/clientWrite?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
  }

  function clientExcelWrite()
  {
    window.open("/admin/home/clientExcel","popup_window","left=50 , top=50, width=985, height=500, scrollbars=auto");
  }

  function clientExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcType_excel').val($('#srcType').val());
    $('#status_excel').val($('#status').val());

    $('#excel_down_form').submit();
  }
</script>
