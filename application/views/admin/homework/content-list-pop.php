
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>음원검색</h1>
          <small style="color:red">※ 공유음원으로 숙제 배정 시 게시자의 상황에 의해 재생이 안될 수 있음</small>
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
                    <th class="text-left align-middle">음원카테고리</th>
                    <td class="text-left align-middle">
                      <select class="form-control col-sm-6 float-left" name="content_category" id="content_category" onchange="contentListLoad()">
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
                    <th class="text-left align-middle">음원 검색</th>
                    <td class="text-left align-middle">
                      <select class="form-control col-sm-2 float-left" name="content_search_type" id="content_search_type">
                          <option value="">전체</option>
                          <option value="title">음원제목</option>
                          <option value="code">음원코드</option>
                      </select>
                      <input type="text" class="form-control col-sm-6 float-left" style="margin-left:5px;margin-right:5px;" name="content_search_text" id="content_search_text" onkeyup="if (window.event.keyCode == 13) {contentListLoad();}"/>
                      <button type="button" class="btn btn-block btn-default float-left col-sm-2" onclick="contentListLoad()">검색</button>
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
                    <th class="text-center"><input type="checkbox" id="content_all_check_box"/></th>
                    <th class="text-center">음원제목</th>
                    <th class="text-center">음원코드</th>
                    <th class="text-center">트랙번호</th>
                    <th class="text-center">음원카테고리</th>
                  </tr>
                </thead>
                <tbody id="contentList">

                </tbody>
              </table>
            </div>
            <div class="card-footer clearfix">
              <span class="float-right">
                <button type="button" class="btn btn-block btn-default" onclick="closePop()">닫기</button>
              </span>
              <span class="float-right" style="margin-right:5px;">
                <button type="button" class="btn btn-block btn-success" onclick="checkAllocation()">선택음원 배정</button>
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

    $('#content_all_check_box').on("click",function(){
      allcontentCheckClick();
    });

    contentListLoad();

});
function allcontentCheckClick()
{
  if($('#content_all_check_box').is(":checked") == true ){
    $('input[name="content_seq[]"]').prop("checked",true);
  }else{
    $('input[name="content_seq[]"]').prop("checked",false);
  }
}

function checkAllocation()
{
  var content_seq = [];

  $('input[name="content_seq[]"]:checked').each(function(){
    content_seq.push($(this).val());
  });

  window.opener.addContentList(content_seq);
}

function contentListLoad()
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#allocationForm').serialize();

  data[csrf_name] = csrf_val;


  $.ajax({
    type: "POST",
    url : "/admin/academiAdm/allocationContentList",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      var html = "";
      if(data.data.length>0){
        for(var i=0; i<data.data.length; i++){
          html += '<tr>';
          html += '<td class="text-center align-middle"><input type="checkbox" name="content_seq[]" value="'+data.data[i].content_seq+'"/></td>';
          html += '<td class="text-center align-middle">'+data.data[i].content_title+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].content_code+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].track_no+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].content_category+'</td>';
          html += '</tr>';
        }

      }else{
        html += '<tr><td colspan="4">검색된 컨텐츠가 없습니다.</td></tr>';
      }

      $('#contentList').html(html);
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
