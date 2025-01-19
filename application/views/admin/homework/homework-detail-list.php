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
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>콘텐츠 제목</option>
                    <option value="code" <?php echo ($srcType=="code") ? "selected": ""; ?>>콘텐츠 코드</option>
                  </select>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="15%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="20%"/>
                      <col width="10%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">번호</th>
                        <th class="text-center">콘텐츠 코드</th>
                        <th class="text-center">콘텐츠 제목</th>
                        <th class="text-center">트랙</th>
                        <th class="text-center">음원길이</th>
                        <th class="text-center">진행률</th>
                        <th class="text-center">마감일</th>
                        <th class="text-center">상태</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($homeworkList) > 0 ){ ?>
                      {homeworkList}
                      <tr style="cursor:pointer">
                        <td class="text-center">{count}</td>
                        <td class="text-center">{content_code}</td>
                        <td class="text-center">{content_title}</td>
                        <td class="text-center">{track_no}</td>
                        <td class="text-center">{content_time_str}</td>
                        <td>
                          <div class="progress grogress-sm">
                            <div class="progress-bar bg-{color_class}" role="grogressbar" aria-valuenow="{user_per}" aria-valuemin="0" aria-valuemax="100" style="width: {user_per}%"></div>
                          </div>
                          <small>{update_time_str} ({user_per}%)</small>
                        </td>
                        <td class="text-center">{final_date}</td>
                        <td class="text-center">{status}</td>
                      </tr>
                      {/homeworkList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="6">숙제가 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-default" onclick="goList()">뒤로가기</button>
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

  $(function(){
    $('.select2').select2();
  });

  function goList()
  {
    location.href = "/admin/academiAdm/homeworkCurrentList";
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
