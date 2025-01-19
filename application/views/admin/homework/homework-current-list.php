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
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>회원이름</option>
                    <option value="id" <?php echo ($srcType=="id") ? "selected": ""; ?>>회원아이디</option>
                  </select>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="30%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">번호</th>
                        <th class="text-center">회원아이디</th>
                        <th class="text-center">회원이름</th>
                        <th class="text-center">배정숙제</th>
                        <th class="text-center">진행사항</th>
                        <th class="text-center">상세보기</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($homeworkList) > 0 ){ ?>
                      {homeworkList}
                      <tr style="cursor:pointer">
                        <td class="text-center">{count}</td>
                        <td class="text-center">{user_id}</td>
                        <td class="text-center">{user_name}</td>
                        <td class="text-center">{cnt}</td>
                        <td>
                          <div class="progress grogress-sm">
                            <div class="progress-bar bg-blue" role="grogressbar" aria-valuenow="{user_per}" aria-valuemin="0" aria-valuemax="100" style="width: {user_per}%"></div>
                          </div>
                          <small>{complete_cnt}건 ({user_per}%)</small>
                        </td>
                        <td class="text-center"><button type="button" class="btn btn-default" onclick="viewDetail('{user_seq}')">보기</button></td>
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
    $('.select2').select2();
  });

  function viewDetail($user_seq)
  {
    location.href = "/admin/academiAdm/homeworkDetail/"+$user_seq;
  }

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
