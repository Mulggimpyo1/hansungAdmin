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
            <form id="board_form">
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">숙제배정명</th>
                        <th class="text-center">배정인원 수</th>
                        <th class="text-center">배정음원 수</th>
                        <th class="text-center">마감일</th>
                        <th class="text-center">관리</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($homeworkList) > 0 ){ ?>
                      {homeworkList}
                      <tr>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{homework_title}</td>
                        <td class="text-center align-middle">{total_user}</td>
                        <td class="text-center align-middle">{total_content}</td>
                        <td class="text-center align-middle">{final_date}</td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-warning btn-sm" onclick="goModify({homework_seq})">수정</button>
                          <button type="button" class="btn btn-default btn-sm" onclick="goDelete({homework_seq})">삭제</button>
                        </td>
                      </tr>
                      {/homeworkList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="6">숙제배정이 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeAllocation()">숙제배정등록</button>
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
  function goModify($seq)
  {
      location.href="/admin/academiAdm/homeworkModify/"+$seq;
  }

  function goDelete($seq)
  {
    if(confirm("삭제하시면 숙제내역이 전체 삭제됩니다.\n정말 삭제하시겠습니까?")){
      location.href="/admin/academiAdm/homeworkDelete/"+$seq;
    }
  }

  function writeAllocation()
  {
    location.href="/admin/academiAdm/homeworkWrite";
  }

</script>
