<style>
table td {
  font-size: 0.9rem!important;
}
</style>

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
                <div class="form-group"<?php if($this->CONFIG_DATA['device']=="mobile"){  ?>style="width:1100px;"<?php }?>>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {total_client_db}건</span>
                </div>
                  <table class="table table-hover" <?php if($this->CONFIG_DATA['device']=="mobile"){  ?>style="width:1100px;"<?php }?>>
                    <thead>
                      <colgroup>
                        <col />
                        <col width="10%"/>
                        <col width="10%"/>
                        <col width="30%"/>
                        <col width="10%"/>
                      </colgroup>
                      <tr>
                        <th class="text-center">업체명</th>
                        <th class="text-center">이메일</th>
                        <th class="text-center">전화번호</th>
                        <th class="text-center">제안내용</th>
                        <th class="text-center">등록일</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($clientDbList) > 0 ){ ?>
                      {clientDbList}
                      <tr>
                        <td class="text-center align-middle">{c_name}</td>
                        <td class="text-center align-middle">{c_email}</td>
                        <td class="text-center align-middle">{c_phone}</td>
                        <td class="text-center align-middle">{c_text}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                      </tr>
                      {/clientDbList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="5">협력제안 내용이 없습니다.</td>
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


  function goModify($work_idx)
  {
    location.href="/admin/home/workModify/"+$work_idx+"?num={num}&srcN={srcN}&srcType={srcType}&status={status}&f_year={f_year}&f_month={f_month}";
  }
</script>
