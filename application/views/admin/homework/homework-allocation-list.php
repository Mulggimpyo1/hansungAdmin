<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?php echo $memberData['user_name']; ?> {title}</h1>
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
                    <option value="name" <?php echo ($srcType=="name") ? "selected": ""; ?>>컨텐츠 제목</option>
                    <option value="code" <?php echo ($srcType=="code") ? "selected": ""; ?>>컨텐츠 코드</option>
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
                  </colgroup>
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">컨텐츠 이름</th>
                      <th class="text-center">컨텐츠 타입</th>
                      <th class="text-center">컨텐츠 코드</th>
                      <th class="text-center">등록일</th>
                      <th class="text-center">관리</th>
                    </tr>
                  </thead>
                    <tbody>
                      <?php if( count($homeworkList) > 0 ){ ?>
                      <?php for($i=0; $i<count($homeworkList); $i++){ ?>
                      <tr>
                        <td class="text-center align-middle"><?php echo $homeworkList[$i]['count']; ?></td>
                        <td class="text-center align-middle"><?php echo $homeworkList[$i]['content_title']; ?></td>
                        <td class="text-center align-middle"><?php echo $homeworkList[$i]['content_category']; ?></td>
                        <td class="text-center align-middle"><?php echo $homeworkList[$i]['content_code']; ?></td>
                        <td class="text-center align-middle"><?php echo $homeworkList[$i]['reg_date']; ?></td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-success btn-sm" onclick="unAllocation('<?php echo $homeworkList[$i]['content_seq']; ?>')">배정해제</button>
                        </td>
                      </tr>
                      <?php } ?>
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
                <button type="button" class="btn btn-block btn-default" onclick="goList()">뒤로가기</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-success" onclick="contentListPop()">음원검색</button>
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
  function unAllocation($seq)
  {
      if(confirm("숙제배정을 해제하시겠습니까?")){

      }
  }

  function contentListPop()
  {
    var user_seq = "<?php echo $memberData['user_seq']; ?>";

    window.open("/admin/academiAdm/contentListPop/"+user_seq,"popup_window","left=50 , top=50, width=985, height=800, scrollbars=auto");
  }

  function goList()
  {
    location.href = "/admin/academiAdm/homeworkList";
  }

</script>
