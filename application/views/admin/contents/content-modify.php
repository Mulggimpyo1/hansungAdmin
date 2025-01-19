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
            <form role="form" id="contentModifyForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" name="content_type" value="<?php echo $contentData['content_type']; ?>" />
              <input type="hidden" name="academy_seq" value="<?php echo $contentData['academy_seq']; ?>" />
              <input type="hidden" name="content_code" value="{content_code}"/>
              <input type="hidden" name="delete_content_name" id="delete_content_name" value=""/>

              <div class="card-body">
                <h4 style="color:#007bff;">콘텐츠 정보 <!--<small><span style="color:red">*콘텐츠를 수정하면 숙제배정된 콘텐츠가 초기화됩니다</span></small>--></h4>
                <table class="table table-bordered" id="write_table">
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <tbody>
                    <tr>
                      <th>콘텐츠 제목</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="content_title" name="content_title" placeholder="콘텐츠 제목" value="<?php echo $contentData['content_title']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 설명</th>
                      <td colspan="3">
                        <textarea rows="3" class="form-control col-sm-6 float-left" id="content_discription" name="content_discription" placeholder="콘텐츠 설명"><?php echo $contentData['content_discription']; ?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 카테고리</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_category" id="content_category">
                          <option value="">카테고리선택</option>
                          <option value="T" <?php echo $contentData['content_category']=="T"?"selected":"" ?>>원서음원</option>
                          <option value="D" <?php echo $contentData['content_category']=="D"?"selected":"" ?>>드라마,영화(영어)</option>
                          <option value="K" <?php echo $contentData['content_category']=="K"?"selected":"" ?>>음악(Song,Pop,Musical etc)</option>
                          <option value="L" <?php echo $contentData['content_category']=="L"?"selected":"" ?>>듣기평가</option>
                          <option value="N" <?php echo $contentData['content_category']=="N"?"selected":"" ?>>뉴스,다큐(영어)</option>
                          <option value="H" <?php echo $contentData['content_category']=="H"?"selected":"" ?>>한글음원</option>
                          <option value="X" <?php echo $contentData['content_category']=="X"?"selected":"" ?>>기타</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 코드</th>
                      <td colspan="3">
                        <?php echo $contentData['content_code']; ?>
                        <input type="hidden" class="form-control col-sm-6 float-left" id="content_code" name="content_code" placeholder="콘텐츠 코드" value="<?php echo $contentData['content_code']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 AR LEVEL</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-3 float-left" id="content_ar_level" name="content_ar_level" placeholder="AR LEVEL (0.0~6.0)" value="<?php echo $contentData['content_ar_level']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 이미지</th>
                      <td colspan="3">
                        <?php if(!empty($contentData['content_image'])){ ?>
                          <?php if($contentData['content_type']=="C"){ ?>
                            <img src="/upload/academy/<?php echo $contentData['academy_seq'] ?>/content/image/<?php echo $contentData['content_image']; ?>" width="100"/>
                          <?php }else{ ?>
                            <img src="/upload/audio/image/<?php echo $contentData['content_image']; ?>" width="100"/>
                          <?php } ?>
                        <?php } ?>
                        <input type="file" class="form-control col-sm-6 float-left" id="content_image" name="content_image" onchange="checkImageSize()"/>
                        <input type="hidden" name="content_image_org" value="<?php echo $contentData['content_image']; ?>"/>
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
                          <input type="radio" name="track_type" value="S" <?php echo $contentData['track_type'] == "S" ? "checked":"" ?>/> 싱글트랙
                        </label>
                        <label style="margin-left:5px; margin-top:5px;">
                          <input type="radio" name="track_type" value="M" <?php echo $contentData['track_type'] == "M" ? "checked":"" ?>/> 멀티트랙
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 파일</th>
                      <td colspan="3">
                        <input type="file" class="form-control col-sm-6 float-left files" onchange="checkFilesize(this)"/>
                        <input type="hidden" name="modify_idx[]" value=""/>
                        <div class="float-left" style="margin-top:3px; margin-left:5px; <?php echo $contentData['track_type'] == "M" ? "":"display:none" ?>" id="add_btn">
                          <button type="button" class="btn btn-sm btn-success" onclick="addFileInput()">추가</button>
                        </div>
                        <div class="input-group">
                          <?php echo $contentData['file'][0]; ?>
                          <input type="hidden" name="file_org[]" value="<?php echo $contentData['file'][0]; ?>"/>
                        </div>
                        <div class="input-group">
                          <small style="color:red">* 최대 업로드 파일 사이즈 : 50MB</small>
                        </div>
                      </td>
                    </tr>
                    <?php if($contentData['track_type']=="M"){
                      if(count($contentData['file'])>1){
                        for($i=1; $i<count($contentData['file']); $i++){
                    ?>
                    <tr class="add_files" id="fileInput<?php echo $i+1; ?>">
                      <th>추가 파일</th>
                      <td colspan="3">
                        <input type="file" class="form-control col-sm-6 float-left files" onchange="checkFilesize(this)"/>
                        <input type="hidden" name="modify_idx[]" value=""/>
                        <div class="float-left" style="margin-top:3px; margin-left:5px;" id="add_btn">
                          <button type="button" class="btn btn-sm btn-default" data-content_name="<?php echo $contentData['file'][$i]; ?>" onclick="deleteFileInput('<?php echo $i+1 ?>')">삭제</button>
                        </div>
                        <div class="input-group">
                          <?php echo $contentData['file'][$i]; ?>
                          <input type="hidden" name="file_org[]" value="<?php echo $contentData['file'][$i]; ?>"/>
                        </div>
                        <div class="input-group">
                          <small style="color:red">* 최대 업로드 파일 사이즈 : 50MB</small>
                        </div>
                      </td>
                    </tr>
                    <?php
                      }
                    }
                  }
                    ?>
                    <tr>
                      <th>콘텐츠 공개유무</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_public_yn" id="content_public_yn">
                            <option value="">공개유무</option>
                            <option value="Y" <?php echo $contentData['content_public_yn']=="Y"?"selected":"" ?>>Y</option>
                            <option value="N" <?php echo $contentData['content_public_yn']=="N"?"selected":"" ?>>N</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>콘텐츠 공유유무</th>
                      <td colspan="3">
                        <select class="form-control col-sm-2 float-left" name="content_sharing_yn" id="content_sharing_yn">
                            <option value="">공유유무</option>
                            <option value="Y" <?php echo $contentData['content_sharing_yn']=="Y"?"selected":"" ?>>Y</option>
                            <option value="N" <?php echo $contentData['content_sharing_yn']=="N"?"selected":"" ?>>N</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="goList()">목록</button>
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
var maxFileInput = 25;
var fileInputCnt = <?php echo count($contentData['file']) ?>;
var deleteArr = [];
  $(function(){
    $("input[name='track_type']").on("change",function(){
      var val = $(this).val();
      if(val == "M"){

        $('#add_btn').show();
        $('.add_files').show();
      }else{
        $('#add_btn').hide();
        $('.add_files').hide();
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
    if($('#fileInput'+$cnt+" button").data("content_name")!=""){
      deleteArr.push($('#fileInput'+$cnt+" button").data("content_name"));
    }
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

    $(obj).siblings("input").val("Y");


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

  function modifyProc(){

    var content_title = $('#content_title').val();
    var content_category = $('#content_category').val();
    var content_public_yn = $('#content_public_yn').val();
    var content_sharing_yn = $('#content_sharing_yn').val();

    if(content_title==""){
      alert("콘텐츠 제목을 입력해주세요");
      return;
    }

    if(content_category==""){
      alert("콘텐츠 카테고리를 입력해주세요");
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

    $('#delete_content_name').val(deleteArr.join(','));

    if($('input[name="track_type"]:checked').val()=="S"){


      $('.add_files button').each(function(){
        if($(this).data("content_name")!=""){
          deleteArr.push($(this).data("content_name"));
        }
        $('.add_files').remove();
      });


    }


    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#contentModifyForm')[0];
    var formData = new FormData($('#contentModifyForm')[0]);
    try{
      formData.append("content_image",$("#content_image")[0].files[0]);
      var fileInput = $('.files');
      // fileInput 개수를 구한다.
      for (var i = 0; i < fileInput.length; i++) {
        console.log("file index : "+i);
      	if (fileInput[i].files.length > 0) {
      		for (var j = 0; j < fileInput[i].files.length; j++) {
      			//console.log(" fileInput["+i+"].files["+j+"] :::"+ fileInput[i].files[j]);

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
      url : "/admin/contentAdm/modifyContentProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        hideLoadingBar();
        if( data.result == "success" ){
          alert("수정 되었습니다.");
          location.href = "/admin/contentAdm/contentList";
        } else {
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        hideLoadingBar();
        console.log(jqXHR.responseText);
      }
    });

  }
</script>
