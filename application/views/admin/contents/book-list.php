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
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}개</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="30%"/>
                      <col width="5%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">도서명</th>
                        <th class="text-center">열람 수</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">수정</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($bookList) > 0 ){ ?>
                      <?php for($i=0; $i<count($bookList); $i++){ ?>
                        <td class="text-center align-middle"><?php echo $bookList[$i]['count'] ?></td>
                        <td class="text-center align-middle"><?php echo $bookList[$i]['book_title'] ?></td>
                        <td class="text-center align-middle"><?php echo $bookList[$i]['book_read_cnt'] ?></td>
                        <td class="text-center align-middle"><?php echo $bookList[$i]['book_reg_datetime']; ?></td>
                        <td class="text-center align-middle">
                          <span class="float-right">
                            <button type="button" class="btn btn-block btn-primary" onclick="goModify('<?php echo $bookList[$i]['book_seq'] ?>')">수정</button>
                          </span>
                        </td>
                      </tr>
                      <?php } ?>
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="6">도서가 없습니다.</td>
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
                <button type="button" class="btn btn-block btn-success" onclick="writeBook()">등록</button>
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
