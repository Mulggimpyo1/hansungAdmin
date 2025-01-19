
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>임시저장글</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <form id="eduTempForm" onsubmit="return false;">
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
                <col/>
                <col width="20%"/>
                <col width="30%"/>
              </colgroup>
              <tbody id="user_body">
                {eduTempList}
                <tr>
                  <th class="text-left align-middle">{edu_title}</th>
                  <td class="text-left align-middle"><small>{edu_reg_datetime}</small></td>
                  <td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left mr-1" onclick="choiceEdu('{edu_seq}')">선택</button><button type="button" class="btn btn-sm btn-default float-left" onclick="deleteEdu('{edu_seq}')">삭제</button></td>
                </tr>
                {/eduTempList}
              </tbody>
            </table>

            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
              <span class="float-right">
                <button type="button" class="btn btn-sm btn-default" onclick="closePop()">닫기</button>
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

function choiceEdu($edu_seq)
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {
    "edu_seq" : $edu_seq
  };

  data[csrf_name] = csrf_val;


  $.ajax({
    type: "POST",
    url : "/admin/contentAdm/eduTempLoad",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      if(data.result == "success"){
        window.opener.setTempData(data.data);
        window.close();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function deleteEdu($edu_seq)
{
  if(confirm("삭제하시겠습니까?")){
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = {
      "edu_seq" : $edu_seq
    };

    data[csrf_name] = csrf_val;


    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/deleteEduTemp",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result == "success"){
          alert("삭제되었습니다.");
          location.reload();
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }
}

function findUser()
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var srcN = $('#srcN').val();

  var data = $('#userFindForm').serialize();

  data[csrf_name] = csrf_val;


  $.ajax({
    type: "POST",
    url : "/admin/schoolAdm/findUserName",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      if(data.result == "success"){
        var html = "";
        if(data.data.length>0){
          for(var i = 0; i <data.data.length; i++){
            html += '<tr>';
            html += '<th class="text-left align-middle">'+data.data[i].user_name+'('+data.data[i].user_id+')</th>';
            html += '<td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left col-sm-2" onclick="choiceUser(\''+data.data[i].user_id+'\')">선택</button></td>';
            html += '</tr>';
          }
        }

        $('#user_body').html(html);

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function choiceUser($user_id)
{
  window.opener.classAdminChoice($user_id);
  window.close();
}


  function closePop()
  {
    window.close();
  }

</script>
