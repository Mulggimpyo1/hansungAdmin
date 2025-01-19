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
            <form id="content_form">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" id="edu_display_yn" name="edu_display_yn" value=""/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="category" id="category">
                    <option value="all" <?php echo ($category=="all") ? "selected": ""; ?>>구분</option>
                    <option value="news" <?php echo ($category=="news") ? "selected": ""; ?>>뉴스기사</option>
                    <option value="movie" <?php echo ($category=="movie") ? "selected": ""; ?>>영상</option>
                    <option value="webtoon" <?php echo ($category=="webtoon") ? "selected": ""; ?>>웹툰</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}개</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">게시물</th>
                        <th class="text-center">구분</th>
                        <th class="text-center">조회수</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">상태</th>
                        <th class="text-center">수정</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($eduList) > 0 ){ ?>
                      <?php for($i=0; $i<count($eduList); $i++){ ?>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="<?php echo $eduList[$i]['edu_seq'] ?>"></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['count'] ?></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['edu_title'] ?></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['edu_type'] ?></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['edu_read_cnt']; ?></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['edu_reg_datetime']; ?></td>
                        <td class="text-center align-middle"><?php echo $eduList[$i]['edu_display_yn'] ?></td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-block btn-primary" onclick="goModify('<?php echo $eduList[$i]['edu_seq'] ?>')">수정</button>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="8">교육정보가 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeEdu()">등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="deleteChoiceContent()">선택삭제</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceShare('N')">선택공개취소</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceShare('Y')">선택공개</button>
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
      $('#allCheck').on("click",function(){
        allCheckClick();
      });
  });

  function goModify($edu_seq)
  {
    location.href = "/admin/contentAdm/eduModify/"+$edu_seq+"{param}";
  }

  function allCheckClick()
  {
    if($('#allCheck').is(":checked") == true ){
      $('input[name="chk[]"]').prop("checked",true);
    }else{
      $('input[name="chk[]"]').prop("checked",false);
    }
  }

  function choiceShare($str)
  {
    var chkBool = false;
    $('input[name="chk[]"]').each(function(){
      if($(this).is(":checked")){
        chkBool = true;
        return;
      }
    });


    if(chkBool == false){
      alert("상태변경 교육정보를 선택해주세요.");
      return;
    }

    $('#edu_display_yn').val($str);

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#content_form').serialize();

    data[csrf_name] = csrf_val;

    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/updateEduDisplay",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        alert("상태가 변경되었습니다.");
        location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function deleteChoiceContent()
  {
    var chkBool = false;
    $('input[name="chk[]"]').each(function(){
      if($(this).is(":checked")){
        chkBool = true;
        return;
      }
    });


    if(chkBool == false){
      alert("삭제할 교육정보를 선택해주세요.");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#content_form').serialize();

    data[csrf_name] = csrf_val;

    if(confirm("삭제하시겠습니까?")){

      $.ajax({
        type: "POST",
        url : "/admin/contentAdm/deleteEdu",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {

          alert("교육정보가 삭제 되었습니다.");
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function writeEdu()
  {
    location.href="/admin/contentAdm/eduWrite{param}";
  }

</script>
