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
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
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
                        <th class="text-center">#</th>
                        <th class="text-center">학원아이디</th>
                        <th class="text-center">학원이름</th>
                        <th class="text-center">원장이름</th>
                        <th class="text-center">학원연락처</th>
                        <th class="text-center">사업자번호</th>
                        <th class="text-center">월정금액</th>
                        <th class="text-center">사용인원</th>
                        <th class="text-center">할당용량</th>
                        <th class="text-center">사용용량</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">상태</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($boardList) > 0 ){ ?>
                      {boardList}
                      <tr onclick="goModify('{academy_seq}')" style="cursor:pointer">
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{academy_id}</td>
                        <td class="text-center align-middle">{academy_name}</td>
                        <td class="text-center align-middle">{academy_owner_name}</td>
                        <td class="text-center align-middle">{tel}</td>
                        <td class="text-center align-middle">{business_no}</td>
                        <td class="text-center align-middle">{month_payment}</td>
                        <td class="text-center align-middle">{students_total}</td>
                        <td class="text-center align-middle">{contract_disk}</td>
                        <td class="text-center align-middle">{disk_size}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                        <td class="text-center align-middle">{status}</td>
                      </tr>
                      {/boardList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="12">게시글이 없습니다.</td>
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
<!-- /.content-wrapper -->
<script>
  function goModify($seq)
  {
      location.href="/admin/academiModify/"+$seq+"?mode=delete";
  }

</script>
