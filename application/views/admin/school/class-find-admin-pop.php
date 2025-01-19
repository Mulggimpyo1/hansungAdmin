
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>학급관리자 검색</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <form id="userFindForm" onsubmit="return false;">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
    <input type="hidden" id="school_seq" name="school_seq" value="{school_seq}"/>
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
                <col width="30%"/>
              </colgroup>
              <tbody>
                  <th class="text-left align-middle"><input type="text" class="form-control col-sm-2 float-left" name="srcN" id="srcN"/></th>
                  <td class="text-left align-middle">
                    <button type="button" class="btn btn-sm btn-default float-left col-sm-2" onclick="findUser()">검색</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <table class="table table-hover">
              <colgroup>
                <col/>
                <col width="30%"/>
              </colgroup>
              <tbody id="user_body">
                {classAdminData}
                <tr>
                  <th class="text-left align-middle">{user_name}({user_id})</th>
                  <td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left col-sm-2" onclick="choiceUser('{user_id}')">선택</button></td>
                </tr>
                {/classAdminData}
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
