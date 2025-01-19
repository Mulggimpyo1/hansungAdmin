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
            <li class="breadcrumb-item"><a href="/admin/main">Home</a></li>
            <li class="breadcrumb-item active">{sub_title}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <!-- form start -->
            <form role="form" id="academiClassModifyForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" name="academy_class_seq" value="{academy_class_seq}" />

              <div class="card-body">
                <table class="table table-bordered">
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <tbody>
                    <tr>
                      <th>반 이름</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="class_name" name="class_name" placeholder="반 이름" value="<?php echo $academyClassData['class_name']; ?>" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="goList()">목록</button>
                <button type="button" class="btn btn-warning float-right" style="margin-right:10px;" onclick="deleteProc()">삭제</button>
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="modifyProc()">수정</button>
              </div>
            </form>
          </div>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
$('#class_name').keydown(function() {
  if (event.keyCode === 13) {
    event.preventDefault();
  };
});

  function goList(){
    location.href="/admin/academiAdm/academiClassList";
  }

  function deleteProc(){
    if(confirm("정말 삭제하시겠습니까?")){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var form = $('#academiClassModifyForm')[0];
      var formData = new FormData($('#academiClassModifyForm')[0]);


      $.ajax({
        type: "POST",
        url : "/admin/academiAdm/academiClassDeleteProc",
        data: formData,
        dataType:"json",
        processData: false,
        contentType: false,
        success : function(data, status, xhr) {
          if( data.result == "success" ){
            alert("삭제 되었습니다.");
            location.href = "/admin/academiAdm/academiClassList";
          } else {
            alert("해당 반에 인원이 있습니다. 인원을 먼저 이동 후 삭제 해 주세요.");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }


  }

  function modifyProc(){

    if($('#class_name').val()==""){
      alert("반 이름을 입력해 주세요.");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#academiClassModifyForm')[0];
    var formData = new FormData($('#academiClassModifyForm')[0]);


    $.ajax({
      type: "POST",
      url : "/admin/academiAdm/academiClassModifyProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        if( data.result == "success" ){
          alert("수정 되었습니다.");
          location.href = "/admin/academiAdm/academiClassList";
        } else {
          alert("오류발생!!");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }
</script>
