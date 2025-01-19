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
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="status" id="status">
                    <option value="all" <?php echo ($status=="all") ? "selected": ""; ?>>전체</option>
                    <option value="Y" <?php echo ($status=="Y") ? "selected": ""; ?>>승인</option>
                    <option value="N" <?php echo ($status=="N") ? "selected": ""; ?>>미승인</option>
                  </select>
                  <?php if($this->session->userdata("admin_level")<=1){ ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="s_class" id="s_class">
                    <option value="all" <?php echo ($s_class=="all") ? "selected": ""; ?>>전체</option>
                    <option value="1" <?php echo ($s_class=="1") ? "selected": ""; ?>>1학년</option>
                    <option value="2" <?php echo ($s_class=="2") ? "selected": ""; ?>>2학년</option>
                    <option value="3" <?php echo ($s_class=="3") ? "selected": ""; ?>>3학년</option>
                    <option value="4" <?php echo ($s_class=="4") ? "selected": ""; ?>>4학년</option>
                    <option value="5" <?php echo ($s_class=="5") ? "selected": ""; ?>>5학년</option>
                    <option value="6" <?php echo ($s_class=="6") ? "selected": ""; ?>>6학년</option>
                  </select>
                  <?php }else{ ?>
                    <input type="hidden" name="s_class" id="s_class" value="<?php echo $this->session->userdata("school_year"); ?>"/>
                  <?php } ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcType" id="srcType">
                    <option value="all" <?php echo ($srcType=="all") ? "selected": ""; ?>>전체</option>
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>기관명</option>
                    <option value="a_name" <?php echo ($srcType=="a_name") ? "selected": ""; ?>>학급 관리자명</option>
                    <option value="a_id" <?php echo ($srcType=="a_id") ? "selected": ""; ?>>학급 관리자 계정</option>
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
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <?php if($this->session->userdata("admin_level")<2){ ?>
                      <col width="9%"/>
                      <?php } ?>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">구분</th>
                        <th class="text-center">기관명</th>
                        <th class="text-center">학년</th>
                        <th class="text-center">반</th>
                        <th class="text-center">인원</th>
                        <th class="text-center">상태</th>
                        <th class="text-center">학급관리자</th>
                        <th class="text-center">관리자계정</th>
                        <?php if($this->session->userdata("admin_level")<2){ ?>
                        <th class="text-center">수정</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($classList) > 0 ){ ?>
                      {classList}
                      <tr>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{contract_type}</td>
                        <td class="text-center align-middle">{school_name}</td>
                        <td class="text-center align-middle">{school_year}</td>
                        <td class="text-center align-middle">{school_class}</td>
                        <td class="text-center align-middle">{total_user}명</td>
                        <td class="text-center align-middle">{status}</td>
                        <td class="text-center align-middle">{class_admin_name}</td>
                        <td class="text-center align-middle">{admin_id}</td>
                      <?php if($this->session->userdata("admin_level")<2){ ?>
                        <td class="text-center align-middle"><button type="button" class="btn btn-block btn-warning" onclick="goModify('{school_class_seq}')">수정</button></td>
                        <?php } ?>
                      </tr>
                      {/classList}
                      <?php } else { ?>
                      <tr>
                        <?php if($this->session->userdata("admin_level")<2){ ?>
                        <td class="text-center" colspan="9">학급이 없습니다.</td>
                        <?php } ?>
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
              <?php if($this->session->userdata("admin_level")<2){ ?>
              <span class="float-right">
                <button type="button" class="btn btn-block btn-success" onclick="writeSchoolClass()">학급등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="schoolClassExcelDown()">엑셀다운로드</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="schoolClassExcelWrite()">엑셀등록</button>
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
<form id="excel_down_form" method="POST" action="/admin/schoolAdm/classDownLoad">
  <input type="hidden" name="srcN_excel" id="srcN_excel"/>
  <input type="hidden" name="srcType_excel" id="srcType_excel"/>
  <input type="hidden" name="status_excel" id="status_excel"/>
  <input type="hidden" name="s_class_excel" id="s_class_excel"/>
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
</form>
<script>

  function goModify($seq)
  {
      location.href="/admin/schoolAdm/classModify/"+$seq+"{param}";
  }

  function writeSchoolClass()
  {
    location.href="/admin/schoolAdm/classWrite{param}";
  }

  function schoolClassExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcType_excel').val($('#srcType').val());
    $('#status_excel').val($('#status').val());
    $('#s_class_excel').val($('#s_class').val());

    $('#excel_down_form').submit();
  }

  function schoolClassExcelWrite()
  {
    window.open("/admin/schoolAdm/schoolClassExcel","popup_window","left=50 , top=50, width=985, height=500, scrollbars=auto");
  }
</script>
