<style>
.keyword {padding:5px;border:1px solid #ddd;}
.keywords {padding-left:20px;padding-top:20px;float:left;}
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
            <li class="breadcrumb-item"><a href="/admin">Home</a></li>
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
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcType" id="srcType">
                    <option value="all" <?php echo ($srcType=="all") ? "selected": ""; ?>>전체</option>
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>학원명</option>
                    <option value="id" <?php echo ($srcType=="id") ? "selected": ""; ?>>학원아이디</option>
                  </select>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="15%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">번호</th>
                        <th class="text-center">학원명</th>
                        <th class="text-center">학원아이디</th>
                        <th class="text-center">할당량</th>
                        <th class="text-center">사용량</th>
                        <th class="text-center">할당인원</th>
                        <th class="text-center">사용인원</th>
                        <th class="text-center">계약일</th>
                        <th class="text-center">만료일</th>
                        <th class="text-center">상태</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($boardList) > 0 ){ ?>
                      {boardList}
                      <tr style="cursor:pointer">
                        <td class="text-center">{count}</td>
                        <td class="text-center">{academy_name}</td>
                        <td class="text-center">{academy_id}</td>
                        <td class="text-center">{contract_disk_str}</td>
                        <td>
                          <div class="progress grogress-sm">
                            <div class="progress-bar bg-{use_per_class}" role="grogressbar" aria-valuenow="{use_per}" aria-valuemin="0" aria-valuemax="100" style="width: {use_per}%"></div>
                          </div>
                          <small>{disk_size} ({use_per}%)</small>
                        </td>
                        <td class="text-center">{students_total}</td>
                        <td>
                          <div class="progress grogress-sm">
                            <div class="progress-bar bg-{user_per_class}" role="grogressbar" aria-valuenow="{user_per}" aria-valuemin="0" aria-valuemax="100" style="width: {user_per}%"></div>
                          </div>
                          <small>{use_students_total}명 ({user_per}%)</small>
                        </td>
                        <td class="text-center">{contract_date}</td>
                        <td class="text-center">{expiration_date}</td>
                        <td class="text-center">{status}</td>
                      </tr>
                      {/boardList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="10">등록된 가맹점이 없습니다.</td>
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
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="useageExcelDown()">엑셀다운로드</button>
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
<form id="excel_down_form" method="POST" action="/admin/useageDownLoad">
  <input type="hidden" name="srcN_excel" id="srcN_excel"/>
  <input type="hidden" name="srcType_excel" id="srcType_excel"/>
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
</form>
<script>
function useageExcelDown()
{
  $('#srcN_excel').val($('#srcN').val());
  $('#srcType_excel').val($('#srcType').val());
  $('#excel_down_form').submit();
}

  $(function(){
    $('.select2').select2();
  });

  function searchCourseContents()
  {
    var srcN = $('#srcN').val();
    var srcType = $('#srcType').val();

    if(srcN == ""){
      alert("검색어를 입력해 주세요.");
      return;
    }

    location.href = "/admin/useAgeList?srcN="+srcN+"&srcType="+srcType;
  }
</script>
