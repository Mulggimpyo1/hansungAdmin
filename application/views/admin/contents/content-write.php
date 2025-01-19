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
            <form role="form" id="contentWriteForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" name="content_type" value="<?php echo $this->session->userdata("admin_type"); ?>" />
              <input type="hidden" name="academy_seq" value="<?php echo $this->session->userdata("academy_seq"); ?>" />

              <div class="card-body">
                <h4 style="color:#007bff;">콘텐츠 정보</h4>
                <table class="table table-bordered" id="write_table">
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <tbody>
                    <tr>
                      <th>콘텐츠 제목</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="content_title" name="content_title" placeholder="콘텐츠 제목" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 설명</th>
                      <td colspan="3">
                        <textarea rows="3" class="form-control col-sm-6 float-left" id="content_discription" name="content_discription" placeholder="콘텐츠 설명"></textarea>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 카테고리</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_category" id="content_category">
                          <option value="">카테고리선택</option>
                          <option value="T">원서음원</option>
                          <option value="D">드라마,영화(영어)</option>
                          <option value="K">음악(Song,Pop,Musical etc)</option>
                          <option value="L">듣기평가</option>
                          <option value="N">뉴스,다큐(영어)</option>
                          <option value="H">한글음원</option>
                          <option value="X">기타</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 코드</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-2 float-left" id="content_code" name="content_code" placeholder="콘텐츠 코드" value="" />
                        <?php if($this->session->userdata("admin_type")=="C"){ ?>
                        <div class="input-group">
                          <small style="color:red">* 콘텐츠 코드는 학원에서 관리를 위해 부여하는 코드입니다. (영문, 숫자 가능)</small>
                        </div>
                        <div class="input-group">
                          <small style="color:red">* 콘텐츠 코드 만들기 예시) <?php echo $this->session->userdata("academy_seq"); ?>001 => 학원고유값(<?php echo $this->session->userdata("academy_seq"); ?>)+숫자(001)</small>
                        </div>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 AR LEVEL</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-3 float-left" id="content_ar_level" name="content_ar_level" placeholder="AR LEVEL" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 이미지</th>
                      <td colspan="3">
                        <input type="file" class="form-control col-sm-6 float-left" id="content_image" name="content_image" onchange="checkImageSize()"/>
                        <div class="input-group">
                          <small style="color:red">* 최대 업로드 이미지 사이즈 : 10MB</small>
                        </div>
                        <div class="input-group">
                          <small style="color:red">* 권장 이미지 사이즈 : 가로 253px * 세로290px</small>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>트랙 타입</th>
                      <td colspan="3">
                        <label style="margin-left:5px; margin-top:5px;">
                          <input type="radio" name="track_type" value="S" checked/> 싱글트랙
                        </label>
                        <label style="margin-left:5px; margin-top:5px;">
                          <input type="radio" name="track_type" value="M"/> 멀티트랙
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 파일</th>
                      <td colspan="3">
                        <input type="file" class="form-control col-sm-6 float-left files" onchange="checkFilesize(this)"/>
                        <div class="float-left" style="margin-top:3px; margin-left:5px; display:none;" id="add_btn">
                          <button type="button" class="btn btn-sm btn-success" onclick="addFileInput()">추가</button>
                        </div>
                        <div class="input-group">
                          <small style="color:red">* 최대 업로드 파일 사이즈 : 50MB</small>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 공개유무</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_public_yn" id="content_public_yn">
                            <option value="">공개유무</option>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                        <div class="input-group">
                          <small style="color:red">* 콘텐츠를 내 학원 학생에게 노출할 것인지 결정</small>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 공유유무</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_sharing_yn" id="content_sharing_yn">
                            <option value="">공유유무</option>
                            <option value="Y">Y</option>
                            <option value="N">N</option>
                        </select>
                        <div class="input-group">
                          <small style="color:red">* 콘텐츠를 내 학원 외에 다른 곳과 공유할 것인지 결정</small>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="goList()">목록</button>
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="writeProc()">등록</button>
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
var maxFileInput = 25;
var fileInputCnt = 1;
  $(function(){
    $("input[name='track_type']").on("change",function(){
      var val = $(this).val();
      if(val == "M"){
        $('#add_btn').show();
      }else{
        $('#add_btn').hide();
        $('.add_files').remove();
      }
    });

    $("#content_code").keyup(function(event){
      if (!(event.keyCode >=37 && event.keyCode<=40)) {
        var inputVal = $(this).val();
        $(this).val(inputVal.replace(/[^a-z0-9]/gi,''));
      }
    });
  });

  function addFileInput()
  {
    fileInputCnt++;
    if(fileInputCnt >= maxFileInput){
      alert("최대 25개까지 업로드 가능합니다.");
      fileInputCnt = maxFileInput;
      return;
    }

    var html = "";

    html += '<tr class="add_files" id="fileInput'+fileInputCnt+'">';
    html += '<th>추가 파일</th>';
    html += '<td colspan="3">';
    html += '<input type="file" class="form-control col-sm-6 float-left files" onchange="checkFilesize(this)"/>';
    html += '<div class="float-left" style="margin-top:3px; margin-left:5px;" id="add_btn">';
    html += '<button type="button" class="btn btn-sm btn-default" onclick="deleteFileInput(\''+fileInputCnt+'\')">삭제</button>';
    html += '</div>';
    html += '<div class="input-group">';
    html += '<small style="color:red">* 최대 업로드 파일 사이즈 : 50MB</small>';
    html += '</div>';
    html += '</td>';
    html += '</tr>';

    $('#write_table tr').eq(-3).after(html);
  }

  function deleteFileInput($cnt)
  {
    $('#fileInput'+$cnt).remove();
  }

  function showLoadingBar() {
      var maskHeight = $(document).height();
      var maskWidth = window.document.body.clientWidth;

      var mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
      var loadingImg = '';

      loadingImg += "<div id='loadingImg' style='position:absolute; left:50%; top:40%; display:none; z-index:10000;'>";
      loadingImg += "    <img src='/assets/admin_resources/dist/img/loading.gif'/>";
      loadingImg += "</div>";

      $('body').append(mask).append(loadingImg);

      $('#mask').css({
          'width' : maskWidth
          , 'height': maskHeight
          , 'opacity' : '0.3'
      });

      $('#mask').show();
      $('#loadingImg').show();
  }

  function hideLoadingBar()
  {
    $('#mask, #loadingImg').hide();
    $('#mask, #loadingImg').remove();
  }

  function checkFilesize(obj)
  {

    var files = $(obj)[0].files[0];
    var size = Math.floor(files.size);

    if(fileCheck(50,size)){

    }else{
      alert("최대업로드 크기를 초과했습니다.");
      $(obj).val("");
    }


  }

  function checkImageSize()
  {
    var files = $("#content_image")[0].files[0];
    var size = Math.floor(files.size);

    if(fileCheck(10,size)){
      $('#content_image_size').val(size);
    }else{
      alert("최대업로드 크기를 초과했습니다.");
      $('#content_image').val("");
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

  function getByteSize(size){
    var byteUnits = ["KB", "MB", "GB", "TB"];
    for (let i = 0; i < byteUnits.length; i++) {
      size = Math.floor(size / 1024);

      if (size < 1024) return size.toFixed(1) + byteUnits[i];
    }
  }

  function goList(){
    location.href="/admin/contentAdm/contentList";
  }

  function writeProc(){

    var content_title = $('#content_title').val();
    var content_category = $('#content_category').val();
    var content_public_yn = $('#content_public_yn').val();
    var content_sharing_yn = $('#content_sharing_yn').val();
    var content_time_hour = $('#content_time_hour').val();
    var content_time_min = $('#content_time_min').val();
    var content_time_sec = $('#content_time_sec').val();
    var content_code = $('#content_code').val();

    if(content_title==""){
      alert("콘텐츠 제목을 입력해주세요");
      return;
    }

    if(content_category==""){
      alert("콘텐츠 카테고리를 입력해주세요");
      return;
    }

    if(content_code == ""){
      alert("콘텐츠 코드를 입력해주세요.");
      return;
    }

    if(content_public_yn==""){
      alert("콘텐츠 공개유무를 선택해주세요");
      return;
    }

    if(content_public_yn==""){
      alert("콘텐츠 공유 유무를 선택해주세요");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#contentWriteForm')[0];
    var formData = new FormData($('#contentWriteForm')[0]);
    try{
      formData.append("content_image",$("#content_image")[0].files[0]);
      var fileInput = $('.files');
      // fileInput 개수를 구한다.
      for (var i = 0; i < fileInput.length; i++) {
      	if (fileInput[i].files.length > 0) {
      		for (var j = 0; j < fileInput[i].files.length; j++) {
      			console.log(" fileInput["+i+"].files["+j+"] :::"+ fileInput[i].files[j]);

      			// formData에 'file'이라는 키값으로 fileInput 값을 append 시킨다.
      			formData.append('file[]', $('.files')[i].files[j]);
      		}
      	}
      }
    }catch(e){
      console.log(e);
    }

    formData.append(csrf_name,csrf_val);

    showLoadingBar();
    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/writeContentProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        hideLoadingBar();

        if( data.result == "success" ){
          alert("등록 되었습니다.");
          location.href = "/admin/contentAdm/contentList";
        } else if(data.result == "failed") {
          if(data.msg=="size over"){
            alert("할당된 디스크 용량이 초과 되었습니다.");

          }

          if(data.msg=="content_code_duplicate"){
            alert("콘텐츠코드가 이미 존재합니다");
            $('#content_code').focus();
          }
        }

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }
</script>
