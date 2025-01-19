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
                    <option value="title" <?php echo ($srcType=="name") ? "selected": ""; ?>>제목</option>
                  </select>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col />
                      <col />
                      <col width="10%"/>
                      <col width="10%"/>
                      <col width="10%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">이미지</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">노출</th>
                        <th class="text-center">순서</th>
                        <th class="text-center">작성일</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($boardList) > 0 ){ ?>
                      {boardList}
                      <tr>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle" onclick="goModify('{banner_id}')" style="cursor:pointer"><img src="/upload/banner/{image}" height="80"></td>
                        <td class="text-center align-middle">{banner_title}</td>
                        <td class="text-center align-middle">{display_yn}</td>
                        <td class="text-center align-middle">
                          <input type="text" size="2" id="sort_{banner_id}" name="sort[]" value="{sort_num}"/>
                          <input type="hidden" name="banner_id[]" value="{banner_id}"/>
                        </td>
                        <td class="text-center align-middle">{reg_time}</td>
                      </tr>
                      {/boardList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="7">게시글이 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeBanner()">배너 등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="saveSort()">순서저장</button>
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
      location.href="/admin/modifyBanner/"+$seq;
  }

  function writeBanner()
  {
    location.href="/admin/writeBanner";
  }

  function saveSort()
  {
    if(confirm("순서를 저장하시겠습니까?")){
      var formData = $('#banner_form').serialize();

      $.ajax({
        type: "POST",
        url : "/admin/home/mainBannerSortProc",
        data: formData,
        dataType:"json",
        success : function(data, status, xhr) {
          alert("저장 되었습니다.");
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }

  }
</script>
