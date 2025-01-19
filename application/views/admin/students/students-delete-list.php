<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="float-left">{title}</h1>
          <?php if($this->session->userdata("admin_type")=="A"){ ?>
          <select class="select2 float-left" id="academy_select" style="width:400px" onchange="academiSelect()">
            <option>학원선택</option>
            <?php for($i=0;$i<count($this->CONFIG_DATA['academy_list']);$i++){ ?>
            <option value="<?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_seq']; ?>" <?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_seq']==$this->session->userdata("academy_seq")?"selected":"" ?>><?php echo $this->CONFIG_DATA['academy_list'][$i]['academy_name']; ?></option>
            <?php } ?>
          </select>
          <?php } ?>
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
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>회원명</option>
                    <option value="id" <?php echo ($srcType=="id") ? "selected": ""; ?>>회원아이디</option>
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
                    </colgroup>
                    <thead>
                      <tr>
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
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($studentList) > 0 ){ ?>
                      {studentList}
                      <tr onclick="goModify('{user_seq}')" style="cursor:pointer">
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
      location.href="/admin/academiAdm/studentModify/"+$seq+"?mode=delete";
  }

</script>
