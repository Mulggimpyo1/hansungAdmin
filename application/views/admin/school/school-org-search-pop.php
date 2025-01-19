
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>기관명</h1>
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
              <tbody id="search">
                <tr>
                  <th class="text-left align-middle" colspan="2">
                    <select type="text" class="form-control col-sm-2 float-left" name="school_classification" id="school_classification">
                      <option value="">선택</option>
                      <option value="ELE">초등학교</option>
                      <option value="MID">중학교</option>
                      <option value="HIG">고등학교</option>
                      <option value="ETC">기타</option>
                    </select>
                  </th>
                </tr>
                <tr>
                  <th class="text-left align-middle"><input type="text" class="form-control col-sm-2 float-left" name="school_name" id="school_name" onkeyup="if (window.event.keyCode == 13) {search()}"/></th>
                  <td class="text-left align-middle">
                    <button type="button" class="btn btn-sm btn-default float-left col-sm-2" onclick="search()">검색</button>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>
            <!-- /.card-body -->

          <div class="card">
            <!-- /.card-header -->
            <table class="table table-hover">
              <colgroup>
                <col/>
                <col width="30%"/>
              </colgroup>
              <tbody id="school_body">
                <tr>
                  <th class="text-center align-middle" colspan="2">검색해주세요</th>
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

var school_arr = window.opener.school_arr;

function search()
{
  var school_classification = $('#school_classification').val();
  var school_name = $('#school_name').val();

  if(school_classification == ""){
    alert("기관구분을 선택해주세요");
    return;
  }

  if(school_name == ""){
    alert("기관명을 입력해주세요");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {
    "school_classification" : school_classification,
    "school_name"           : school_name
  };

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/schoolAdm/schoolOrgSearchProc",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      if(data.result == "success"){
        var html = "";
        if(data.data.length>0){
          for(var i = 0; i <data.data.length; i++){
            var arr = data.data[i].addr_1.split(" ");
            html += '<tr>';
            html += '<th class="text-left align-middle">'+data.data[i].school_name+' ('+arr[0]+')</th>';
            html += '<td class="text-left align-middle">';
            var school_chk = false;
            for(var j=0; j<school_arr.length; j++){
              if(school_arr[j].school_seq==data.data[i].school_seq){
                school_chk = true;
              }
            }

            if(school_chk){
              html += '<button type="button" id="add_'+data.data[i].school_seq+'" class="btn btn-sm btn-primary float-left col-sm-2" style="display:none;" onclick="choiceSchool(this)" data-school_seq="'+data.data[i].school_seq+'" data-school_name="'+data.data[i].school_name+'">선택</button>';
              html += '<button type="button" id="del_'+data.data[i].school_seq+'" class="btn btn-sm btn-warning float-left col-sm-2" data-school_seq="'+data.data[i].school_seq+'" data-school_name="'+data.data[i].school_name+'">선택됨</button>';
            }else{
              html += '<button type="button" id="add_'+data.data[i].school_seq+'" class="btn btn-sm btn-primary float-left col-sm-2" onclick="choiceSchool(this)" data-school_seq="'+data.data[i].school_seq+'" data-school_name="'+data.data[i].school_name+'">선택</button>';
              html += '<button type="button" id="del_'+data.data[i].school_seq+'" class="btn btn-sm btn-warning float-left col-sm-2" style="display:none;" data-school_seq="'+data.data[i].school_seq+'" data-school_name="'+data.data[i].school_name+'">선택됨</button>';
            }




            html += '</td>';
            html += '</tr>';
          }
        }
        $('#school_body').html(html);

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });


}

function choiceSchool(obj)
{
  var school_name = $(obj).data("school_name");
  var school_seq = $(obj).data("school_seq");

  var data = {
    "school_name" : school_name,
    "school_seq" : school_seq
  };

  var parentArr = window.opener.school_arr;
  school_arr = parentArr;


  var duplicate = parentArr.find(e => e.school_seq === school_seq);
  if(duplicate != undefined){
    alert("이미 추가된 학교입니다.");
  }else{
    $(obj).hide();
    $('#add_'+school_seq).hide();
    $('#del_'+school_seq).show();
    window.opener.choiceSchool(data);
  }



  //
  //window.close();
}

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
