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
              <input type="hidden" id="yn" name="yn" value=""/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcType" id="srcType">
                    <option value="all" <?php echo ($srcType=="all") ? "selected": ""; ?>>전체</option>
                    <option value="title" <?php echo ($srcType=="title") ? "selected": ""; ?>>제목</option>
                    <option value="code" <?php echo ($srcType=="code") ? "selected": ""; ?>>콘텐츠 코드</option>
                  </select>
                  <select class="form-control col-2 float-right" style="margin:5px 5px 5px 5px;" name="category" id="category">
                    <option value="all" <?php echo ($category=="all") ? "selected": ""; ?>>카테고리</option>
                    <option value="T" <?php echo ($category=="T") ? "selected": ""; ?>>원서음원</option>
                    <option value="D" <?php echo ($category=="D") ? "selected": ""; ?>>드라마,영화(영어)</option>
                    <option value="K" <?php echo ($category=="K") ? "selected": ""; ?>>음악(Song,Pop,Musical etc)</option>
                    <option value="L" <?php echo ($category=="L") ? "selected": ""; ?>>듣기평가</option>
                    <option value="N" <?php echo ($category=="N") ? "selected": ""; ?>>뉴스,다큐(영어)</option>
                    <option value="H" <?php echo ($category=="H") ? "selected": ""; ?>>한글음원</option>
                    <option value="X" <?php echo ($category=="X") ? "selected": ""; ?>>기타</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}개</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">등록학원</th>
                        <th class="text-center">콘텐츠코드</th>
                        <th class="text-center">카테고리</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">콘텐츠 용량</th>
                        <th class="text-center">공개</th>
                        <th class="text-center">공유</th>
                        <th class="text-center">트랙</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">관리</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($contentList) > 0 ){ ?>
                      <?php for($i=0; $i<count($contentList); $i++){ ?>
                        <td class="text-center align-middle">
                          <?php
                          if($this->session->userdata("admin_type")=="C"){
                            if($contentList[$i]['academy_seq']==$this->session->userdata("academy_seq")){
                           ?>
                          <input type="checkbox" name="chk[]" value="<?php echo $contentList[$i]['content_code'] ?>">
                          <?php
                            }
                          }else if($this->session->userdata("admin_type")=="A"){ ?>
                            <input type="checkbox" name="chk[]" value="<?php echo $contentList[$i]['content_code'] ?>">
                          <?php
                          }
                          ?>
                        </td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['count'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['academy_name'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_code']; ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_category']; ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_title'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_file_size'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_public_yn'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['content_sharing_yn'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['track_no'] ?></td>
                        <td class="text-center align-middle"><?php echo $contentList[$i]['reg_date'] ?></td>
                        <td class="text-center align-middle">
                          <?php
                            if($this->session->userdata("admin_type")=="C"){
                              if($contentList[$i]['academy_seq']==$this->session->userdata("academy_seq")){
                          ?>
                          <span class="float-right">
                            <button type="button" class="btn btn-block btn-default" style="margin-left:5px;" onclick="deleteContent('<?php echo $contentList[$i]['content_code'] ?>')">삭제</button>
                          </span>
                          <span class="float-right">
                            <button type="button" class="btn btn-block btn-primary" onclick="goModify('<?php echo $contentList[$i]['content_code'] ?>')">수정</button>
                          </span>
                          <?php
                              }else{
                                echo '<tr>';
                              }
                            }else{
                          ?>
                          <span class="float-right">
                            <button type="button" class="btn btn-block btn-default" style="margin-left:5px;" onclick="deleteContent('<?php echo $contentList[$i]['content_code'] ?>')">삭제</button>
                          </span>
                          <span class="float-right">
                            <button type="button" class="btn btn-block btn-primary" onclick="goModify('<?php echo $contentList[$i]['content_code'] ?>')">수정</button>
                          </span>
                        <?php } ?>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="11">콘텐츠가 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeContent()">콘텐츠 등록</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="contentExcelDown()">엑셀다운로드</button>
              </span>
              <?php if($this->session->userdata("admin_type")=="A"){ ?>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-warning" onclick="contentExcelWrite()">엑셀등록</button>
              </span>
              <?php } ?>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="deleteChoiceContent()">선택삭제</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceShare('N')">선택공유취소</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="choiceShare('Y')">선택공유</button>
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
<form id="excel_down_form" method="POST" action="/admin/contentAdm/contentDownLoad">
  <input type="hidden" name="srcN_excel" id="srcN_excel"/>
  <input type="hidden" name="srcType_excel" id="srcType_excel"/>
  <input type="hidden" name="category_excel" id="category_excel"/>
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
</form>
<script>

  $(function(){
      $('#allCheck').on("click",function(){
        allCheckClick();
      });
  });

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
      alert("공유변경 콘텐츠를 선택해주세요.");
      return;
    }

    $('#yn').val($str);

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#content_form').serialize();

    data[csrf_name] = csrf_val;

    console.log(data);




    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/updateShare",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        console.log(data);
        alert("공유설정이 변경되었습니다.");
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
      alert("삭제할 콘텐츠를 선택해주세요.");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#content_form').serialize();

    data[csrf_name] = csrf_val;

    if(confirm("숙제배정이 되어있다면 숙제 데이터도 삭제됩니다.\n삭제하시겠습니까?")){

      $.ajax({
        type: "POST",
        url : "/admin/contentAdm/deleteChoiceContent",
        data: data,
        dataType:"json",
        success : function(data, status, xhr) {

          alert("콘텐츠가 삭제 되었습니다.");
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }
  }

  function goModify($seq)
  {
      location.href="/admin/contentAdm/contentModify/"+$seq;
  }

  function writeContent()
  {
    location.href="/admin/contentAdm/contentWrite";
  }

  function deleteContent($content_code)
  {
    if(confirm("숙제배정이 되어있다면 숙제 데이터도 삭제됩니다.\n삭제하시겠습니까?")){
      location.href="/admin/contentAdm/deleteContent/"+$content_code
    }

  }

  function contentExcelWrite()
  {
      window.open("/admin/home/contentExcel","popup_window","left=50 , top=50, width=985, height=500, scrollbars=auto");
  }

  function contentExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcType_excel').val($('#srcType').val());
    $('#category_excel').val($('#category').val());

    $('#excel_down_form').submit();
  }
</script>
