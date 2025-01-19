
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>계약구분</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <form id="contractForm" onsubmit="return false;">
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
                <col width="30%"/>
              </colgroup>
              <tbody id="contract_body">
                {contractData}
                <tr>
                  <th class="text-left align-middle">{value}</th>
                  <td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left col-sm-2" onclick="deleteContract('{seq}')">삭제</button></td>
                </tr>
                {/contractData}
              </tbody>
            </table>
            <table class="table table-hover">
              <colgroup>
                <col/>
                <col width="30%"/>
              </colgroup>
              <tbody>
                  <th class="text-left align-middle"><input type="text" class="form-control col-sm-2 float-left" name="contract_name" id="contract_name"/></th>
                  <td class="text-left align-middle">
                    <button type="button" class="btn btn-sm btn-default float-left col-sm-2" onclick="contractAdd()">저장</button>
                  </td>
                </tr>
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


function contractAdd()
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var contract_name = $('#contract_name').val();

  if(contract_name == ""){
    alert("계약구분을 입력해주세요.");
    return;
  }

  var data = $('#contractForm').serialize();

  data[csrf_name] = csrf_val;


  $.ajax({
    type: "POST",
    url : "/admin/schoolAdm/contractAdd",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      if(data.result == "success"){
        var html = "";
        if(data.data.length>0){
          for(var i = 0; i <data.data.length; i++){
            html += '<tr>';
            html += '<th class="text-left align-middle">'+data.data[i].value+'</th>';
            html += '<td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left col-sm-2" onclick="deleteContract(\''+data.data[i].seq+'\')">삭제</button></td>';
            html += '</tr>';
          }
        }
        console.log(html);
        window.opener.refreshContract(data.data);
        $('#contract_body').html(html);
        $('#contract_name').val("");

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function deleteContract($seq)
{
  if(confirm("삭제하시겠습니까?\n등록된 기관의 계약구분도 사라집니다.")){
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = {"seq" : $seq};

    data[csrf_name] = csrf_val;


    $.ajax({
      type: "POST",
      url : "/admin/schoolAdm/contractDelete",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        if(data.result == "success"){
          var html = "";
          if(data.data.length>0){
            for(var i = 0; i <data.data.length; i++){
              html += '<tr>';
              html += '<th class="text-left align-middle">'+data.data[i].value+'</th>';
              html += '<td class="text-left align-middle"><button type="button" class="btn btn-sm btn-warning float-left col-sm-2" onclick="deleteContract(\''+data.data[i].seq+'\')">삭제</button></td>';
              html += '</tr>';
            }
          }

          window.opener.refreshContract(data.data);
          $('#contract_body').html(html);
          $('#contract_name').val("");

        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }
}

  function closePop()
  {
    window.close();
  }

</script>
