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
            <form role="form" id="boardWriteForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" id="edu_seq" name="edu_seq" value="{edu_seq}"/>
              <div class="card-body">
                <div class="form-group">
                  <label for="title">구분</label>
                  <select type="text" class="form-control col-sm-2" name="edu_type" id="edu_type">
                    <option value="">선택</option>
                    <option value="news" <?php echo $eduData['edu_type']=="news"?"selected":""; ?>>뉴스</option>
                    <option value="movie" <?php echo $eduData['edu_type']=="movie"?"selected":""; ?>>영상</option>
                    <option value="webtoon" <?php echo $eduData['edu_type']=="webtoon"?"selected":""; ?>>웹툰</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="title">제목</label>
                  <input type="text" class="form-control" name="edu_title" id="edu_title" placeholder="제목을 작성해주세요" value="<?php echo $eduData['edu_title']; ?>">
                </div>
                <div class="form-group">
                  <label style="margin-left:5px; margin-top:5px;">
                    <input type="radio" name="edu_display_yn" value="Y" <?php echo $eduData['edu_display_yn']=="Y"?"checked":""; ?>/> 노출
                  </label>
                  <label style="margin-left:5px; margin-top:5px;">
                    <input type="radio" name="edu_display_yn" value="N" <?php echo $eduData['edu_display_yn']=="N"?"checked":""; ?>/> 비노출
                  </label>
                </div>
                <div class="form-group">
                  <label for="title">썸네일</label>
                  <?php if(!empty($eduData['edu_thumb'])){ ?>
                    <img src="/upload/board/<?php echo $eduData['edu_thumb']; ?>" width="100"/>
                  <?php } ?>
                  <input type="file" class="form-control col-sm-2" name="edu_thumb" id="edu_thumb">
                  <input type="hidden" name="edu_thumb_org" value="<?php echo $eduData['edu_thumb']; ?>"/>
                </div>
                <div class="form-group">
                  <label for="board_title">내용</label>
                  <textarea class="form-control" name="edu_contents" id="ir1" style="display:none;"><?php echo $eduData['edu_contents']; ?></textarea>
                  <script type="text/javascript" src="/assets/admin_resources/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
                  <script type="text/javascript">
					        var oEditors = [];
					        nhn.husky.EZCreator.createInIFrame({
					            oAppRef: oEditors,
					            elPlaceHolder: "ir1",
					            sSkinURI: "/assets/admin_resources/editor/SmartEditor2Skin.html",
					            fCreator: "createSEditor2"
					        });
					        function submitContents(elClickedObj) {

					            // 에디터의 내용이 textarea에 적용됩니다.
					            oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
					            // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

					            try {
					                modifyProc();
					            } catch(e) {
                        console.log(e);
                      }
					         }
					        </script>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" onclick="goList()">목록</button>
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="submitContents()">수정</button>
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="loadEduTemp()">불러오기</button>
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="tempSave()">임시저장</button>
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
    location.href="/admin/contentAdm/eduList{param}";
  }

  function loadEduTemp()
  {
    window.open("/admin/contentAdm/eduTempListPop","eduTempListPop","width=470, height=500");
  }

  function setTempData($data)
  {
    var edu_title = $data['edu_title'];
    var edu_display_yn = $data['edu_display_yn'];
    var edu_contents = $data['edu_contents'];
    var edu_type = $data['edu_type'];

    $('#edu_title').val(edu_title);
    if(edu_display_yn=="Y"){
      $("input[name='edu_display_yn'][value='Y']").prop("checked", true);
    }else{
      $("input[name='edu_display_yn'][value='N']").prop("checked", true);
    }

    $('#edu_type').val(edu_type);


    oEditors.getById["ir1"].exec("SET_IR", [""]); //내용초기화

    oEditors.getById["ir1"].exec("PASTE_HTML", [edu_contents]);

  }

  function tempSave()
  {
    // 에디터의 내용이 textarea에 적용됩니다.
    oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
    // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.

    try {
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var form = $('#boardWriteForm')[0];
      var formData = new FormData($('#boardWriteForm')[0]);
      try{
        formData.append("edu_thumb",$("#edu_thumb")[0].files[0]);
      }catch(e){
        console.log(e);
      }

      var contents = $('#ir1').val();

      formData.append("ir1",contents);
      formData.append(csrf_name,csrf_val);


      $.ajax({
        type: "POST",
        url : "/admin/contentAdm/eduTempWriteProc",
        data: formData,
        dataType:"json",
        processData: false,
        contentType: false,
        success : function(data, status, xhr) {
          console.log(data);
          if( data.result == "success" ){
            alert("임시저장 되었습니다.");
          } else {
            alert("오류발생!!");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    } catch(e) {
      console.log(e);
    }


  }

  function modifyProc(){

    var edu_type = $('#edu_type').val();
    var edu_title = $('#edu_title').val();
    var edu_contents = $('#ir1').val();
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    if( edu_title == "" ){
        alert("제목을 작성 해 주세요.");
        return;
    }
    if( edu_type == "" ){
        alert("구분을 선택해주세요.");
        return;
    }

    if( edu_contents == "" ){
        alert("내용을 작성 해 주세요.");
        return;
    }

    var form = $('#boardWriteForm')[0];
    var formData = new FormData($('#boardWriteForm')[0]);
    try{
      formData.append("edu_thumb",$("#edu_thumb")[0].files[0]);
    }catch(e){
      console.log(e);
    }

    formData.append("ir1",edu_contents);
    formData.append(csrf_name,csrf_val);


    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/eduModifyProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        if( data.result == "success" ){
          alert("수정 되었습니다.");
          location.href = "/admin/contentAdm/eduList{param}";
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
