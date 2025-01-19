
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>인원검색</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <form id="allocationForm" onsubmit="return false;">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <table class="table table-hover">
              <colgroup>
                <col width="15%"/>
                <col/>
              </colgroup>
              <tbody>
                <tr>
                  <th class="text-left align-middle">반 선택</th>
                  <td class="text-left align-middle">
                    <select class="form-control col-sm-6 float-left" name="academy_class" id="academy_class" onchange="studentListLoad()">
                        <option value="">반 선택</option>
                        {academy_class}
                        <option value="{academy_class_seq}">{class_name}</option>
                        {/academy_class}
                    </select>
                  </td>
                </tr>
                <tr>
                  <th class="text-left align-middle">인원 검색</th>
                  <td class="text-left align-middle">
                    <select class="form-control col-sm-2 float-left" name="user_search_type" id="user_search_type">
                        <option value="">전체</option>
                        <option value="name">이름</option>
                        <option value="id">아이디</option>
                    </select>
                    <input type="text" class="form-control col-sm-6 float-left" style="margin-left:5px;margin-right:5px;" name="user_search_text" id="user_search_text"  onkeyup="if (window.event.keyCode == 13) {studentListLoad();}"/>
                    <button type="button" class="btn btn-block btn-default float-left col-sm-2" onclick="studentListLoad()">검색</button>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>
            <!-- /.card-body -->

            <div class="card" style="height: 300px; overflow-y: scroll;">
              <!-- /.card-header -->
              <table class="table table-hover" style="white-space:nowrap; border-collapse:collapse;">
                <colgroup>
                  <col width="5%"/>
                  <col width="9%"/>
                  <col width="9%"/>
                  <col width="9%"/>
                  <col width="9%"/>
                </colgroup>
                <thead>
                  <tr>
                    <th class="text-center"><input type="checkbox" id="student_all_check_box"/></th>
                    <th class="text-center">아이디</th>
                    <th class="text-center">이름</th>
                    <th class="text-center">학교</th>
                    <th class="text-center">학년</th>
                  </tr>
                </thead>
                <tbody id="userList">
                </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
              <span class="float-right">
                <button type="button" class="btn btn-block btn-default" onclick="closePop()">닫기</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-success" onclick="checkAllocation()">선택학생 배정</button>
              </span>
            </div>
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

    $('#student_all_check_box').on("click",function(){
      allcontentCheckClick();
    });

    studentListLoad();

});
function allcontentCheckClick()
{
  if($('#student_all_check_box').is(":checked") == true ){
    $('input[name="user_seq[]"]').prop("checked",true);
  }else{
    $('input[name="user_seq[]"]').prop("checked",false);
  }
}

function checkAllocation()
{
  var student_seq = [];

  $('input[name="user_seq[]"]:checked').each(function(){
    student_seq.push($(this).val());
  });

  window.opener.addStudentList(student_seq);
}

function studentListLoad()
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#allocationForm').serialize();

  data[csrf_name] = csrf_val;


  $.ajax({
    type: "POST",
    url : "/admin/academiAdm/allocationUserList",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      var html = "";
      if(data.data.length>0){

        for(var i=0; i<data.data.length; i++){
          html += '<tr>';
          html += '<td class="text-center align-middle"><input type="checkbox" name="user_seq[]" value="'+data.data[i].user_seq+'"/></td>';
          html += '<td class="text-center align-middle">'+data.data[i].user_id+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].user_name+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].school_name+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].school_year+'</td>';
          html += '</tr>';
        }

      }else{
        html += '<tr><td colspan="5">검색된 회원이 없습니다.</td></tr>';
      }

      $('#userList').html(html);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

  function closePop()
  {
    window.close();
  }

</script>
