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
            <form role="form" id="bannerWriteForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <div class="card-body">
                <div class="form-group">
                  <label for="title">제목</label>
                  <input type="text" class="form-control" name="banner_title" id="banner_title" placeholder="Enter Title" value="">
                </div>
                <div class="form-group">
                  <label for="title">링크</label>
                  <input type="text" class="form-control" name="banner_url" id="banner_url" placeholder="http://" value="">
                </div>
                <div class="form-group">
                  <label for="title">링크타겟</label>
                  <select name="banner_target" id="banner_target" class="form-control col-sm-12 float-left" >
                      <option value="_self">현재창</option>
                      <option value="_blank">새창</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="title">순서</label>
                  <input type="text" class="form-control" name="sort_num" id="sort_num" value="<?php echo $sort_num; ?>">
                </div>
                <div class="form-group">
                  <label style="margin-left:5px; margin-top:5px;">
                    <input type="radio" name="display_yn" value="Y" checked/> 노출
                  </label>
                  <label style="margin-left:5px; margin-top:5px;">
                    <input type="radio" name="display_yn" value="N"/> 비노출
                  </label>
                </div>
                <div class="form-group">
                  <label for="title">배너</label>
                  <div class="input-group">
                      <input type="file" class="form-control" id="banner_image" name="banner_image" onchange="fileSizeCheck()">
                  </div>
                  <div class="input-group" style="margin-top:10px">
                    <small style="color:red">* 최대 업로드 이미지 사이즈 : 10MB</small>
                  </div>
                  <div class="input-group">
                    <small style="color:red">* 권장 이미지 사이즈 : 가로 400px * 세로266px</small>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" onclick="goList()">목록</button>
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="writeProc()">올리기</button>
              </div>
            </form>
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
  function goList(){
    location.href="/admin/mainBannerList";
  }

  function writeProc(){

    var title = $('#banner_title').val();
    var banner_url = $('#banner_url').val();
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();
    var banner_image = $('#banner_image').val();

    if( title == "" ){
        alert("제목을 작성 해 주세요.");
        return;
    }
    if( banner_url == "" ){
        alert("링크를 작성 해 주세요.");
        return;
    }
    if( banner_image == ""){
      alert("배너를 등록 해 주세요.");
      return;
    }


    var form = $('#bannerWriteForm')[0];
    var formData = new FormData($('#bannerWriteForm')[0]);
    try{
      formData.append("banner_image",$("#banner_image")[0].files[0]);
    }catch(e){
      console.log(e);
    }

    formData.append(csrf_name,csrf_val);


    $.ajax({
      type: "POST",
      url : "/admin/home/mainBannerWriteProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        if( data.result == "success" ){
          alert("작성 되었습니다.");
          location.href = "/admin/mainBannerList";
        } else {
          alert("오류발생!!");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  function fileSizeCheck()
  {

    var files = $("#banner_image")[0].files[0];
    var size = Math.floor(files.size);

    if(fileCheck(10,size)){

    }else{
      alert("최대업로드 크기를 초과했습니다.");
      $('#banner_image').val("");
    }


  }

  function fileCheck(maxSize,fileSize)
  {
    maxSize = 1024 ** 2 * maxSize;

    if(maxSize > fileSize){
      return true;
    }else{
      return false;
    }
  }
</script>
