<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{title}</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <form id="schoolForm">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <table class="table table-hover">
                <colgroup>
                  <col width="5%"/>
                  <col/>
                </colgroup>
                <tbody>
                  <tr>
                    <th class="text-left align-middle">기관명</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left select2" name="school_seq" id="school_seq">
                        <option value="">선택</option>
                        {schoolList}
                        <option value="{school_seq}">{school_name}</option>
                        {/schoolList}
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">학년선택</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left" name="school_year" id="school_year">
                        <option value="">선택</option>
                        <?php for($i=0; $i<6; $i++){ ?>
                        <option value="<?php echo ($i+1); ?>"><?php echo ($i+1)."학년"; ?></option>
                        <?php } ?>
                      </select>
                      <input type="checkbox" class="float-left" name="no_choice" id="no_choice" onclick="noChoice()" value="Y" style="margin-top:12px;margin-left:5px; margin-right:5px;"/>
                      <label for="no_choice" style="margin-top:6px;">선택하지않음</label>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">학급명</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left" name="school_class" id="school_class">
                        <option value="">선택</option>
                        <?php for($i=0; $i<20; $i++){ ?>
                        <option value="<?php echo ($i+1)."반"; ?>"><?php echo ($i+1)."반"; ?></option>
                        <?php } ?>
                      </select>
                      <input type="text" class="form-control col-sm-2 float-left" id="self_input" name="self_input" style="display:none;"/>
                      <input type="checkbox" class="float-left" name="self_write" id="self_write" onclick="selfWrite()" value="Y" style="margin-top:12px;margin-left:5px; margin-right:5px;"/>
                      <label for="self_write" style="margin-top:6px;">직접입력</label>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">학급관리자</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="class_admin_id" name="class_admin_id" readonly/>
                      <button type="button" class="btn btn-block btn-default float-left col-sm-1" id="admin_search_btn" style="margin-left:5px;" onclick="adminFind()">검색</button>
                      <button type="button" class="btn btn-block btn-warning float-left col-sm-1" id="remove_admin_btn" style="margin-top:0px;margin-left:5px;display:none;" onclick="removeAdmin()">해제</button>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">로고</th>
                    <td class="text-left align-middle">
                      <input type="file" class="form-control col-sm-3 float-left" id="class_image" name="class_image"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

            <!-- /.card-header -->
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-left align-middle">
                      <button type="button" class="btn btn-primary float-left mr-3" onclick="writeSchool()">등록</button>
                      <button type="button" class="btn btn-default float-left" onclick="goList()">목록</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </form>

</div>
<!-- /.content-wrapper -->

<script>
  $(function(){
    $('.select2').select2();
  })

  function goList()
  {
      location.href="/admin/schoolAdm/classList{param}";
  }

  function adminFind()
  {
    var school_seq = $('#school_seq').val();
    if(school_seq == ""){
      alert("기관을 선택해주세요");
      return
    }

    window.open("/admin/schoolAdm/classFindAdminPop/"+school_seq,"findAdminPop","width=470, height=500");
  }

  function classAdminChoice($user_id)
  {
    $('#class_admin_id').val($user_id);
    $('#admin_search_btn').hide();
    $('#remove_admin_btn').show();
  }

  function removeAdmin()
  {
    $('#class_admin_id').val("");
    $('#admin_search_btn').show();
    $('#remove_admin_btn').hide();
  }

  function writeSchool()
  {
    var school_seq = $('#school_seq').val();
    var class_name = $('#school_class').val();

    var self_write = $('#self_write').is(":checked");
    if(self_write){
      class_name = $('#self_input').val();
    }


    if(school_seq == ""){
      alert("기관을 선택해주세요.");
      $('#school_seq').focus();
      return;
    }

    if(class_name == ""){
      alert("학급명을 입력해주세요");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#schoolForm')[0];
    var formData = new FormData($('#schoolForm')[0]);
    try{
      formData.append("class_image",$("#class_image")[0].files[0]);
    }catch(e){
      console.log(e);
    }

    formData.append(csrf_name,csrf_val);

    $.ajax({
      type: "POST",
      url : "/admin/schoolAdm/classWriteProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {

        if( data.result == "success" ){
          alert("등록 되었습니다.");
          location.href = "/admin/schoolAdm/classList{param}";
        } else {
          alert("이미 등록된 학급입니다");
        }


      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  function selfWrite()
  {
    var self_write = $('#self_write').is(":checked");
    if(self_write){
      $('#school_class').hide();
      $('#self_input').show();
    }else{
      $('#school_class').show();
      $('#self_input').hide();
    }
  }

  function noChoice()
  {
    var noChoice = $('#no_choice').is(":checked");
    if(noChoice){
      $('#school_year').hide();
    }else{
      $('#school_year').show();
    }
  }

</script>
