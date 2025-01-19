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
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item">{sub_title}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <form id="search_form">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <select class="form-control col-1 float-right select2" style="margin:5px 5px 5px 5px;" name="location" id="location">
                    <option value="all" <?php echo ($location=="all") ? "selected": ""; ?>>지역</option>
                    <?php for($i=0; $i<count($locationData); $i++){ ?>
                    <option value="<?php echo $locationData[$i]['value']; ?>" <?php echo ($locationData[$i]['value']==$location) ? "selected": ""; ?>><?php echo $locationData[$i]['value']; ?></option>
                    <?php } ?>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="month" id="month">
                    <option value="all" <?php echo ($month=="all") ? "selected": ""; ?>>월</option>
                    <?php for($i=0; $i<12; $i++){ ?>
                    <option value="<?php echo sprintf('%02d',($i+1)); ?>" <?php echo ($month==($i+1)) ? "selected": ""; ?>><?php echo ($i+1)."월" ?></option>
                    <?php } ?>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="year" id="year">
                    <option value="all" <?php echo ($year=="all") ? "selected": ""; ?>>년</option>
                    <option value="2022" <?php echo ($year=="2022") ? "selected": ""; ?>>2022년</option>
                    <option value="2023" <?php echo ($year=="2023") ? "selected": ""; ?>>2023년</option>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}명</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="15%"/>
                      <col width="15%"/>
                      <col width="10%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center">순위</th>
                        <th class="text-center">지역</th>
                        <th class="text-center">기관 명</th>
                        <th class="text-center">기관 총 탄소 절감량</th>
                        <th class="text-center">인당 평균 탄소 절감량</th>
                        <th class="text-center">상세</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($rankList) > 0 ){ ?>
                      {rankList}
                      <tr>
                        <td class="text-center align-middle">{rank}</td>
                        <td class="text-center align-middle">{location}</td>
                        <td class="text-center">{school_name}</td>
                        <td class="text-center">{carbon_point}kg</td>
                        <td class="text-center">{point_average}kg</td>
                        <td class="text-center"><button type="button" class="btn btn-default" onclick="rankPop('{school_seq}')">상세</button></td>
                      </tr>
                      {/rankList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="6">랭킹이 없습니다.</td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
            </form>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              <ul class="pagination pagination-sm m-0 float-left">
                {paging}
                {no}
                {/paging}
              </ul>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
$(function(){
  $('.select2').select2();
  $('.select2').css("float","right");
    $('#allCheck').on("click",function(){
      allCheckClick();
    });
});

function goView($qna_seq)
{
  location.href = "/admin/etcAdm/qnaView/"+$qna_seq+"{param}";
}

function allCheckClick()
{
  if($('#allCheck').is(":checked") == true ){
    $('input[name="chk[]"]').prop("checked",true);
  }else{
    $('input[name="chk[]"]').prop("checked",false);
  }
}

function rankPop($school_seq)
{
  window.open("/admin/rankAdm/schoolRankPop/"+$school_seq+"?year={year}&month={month}","rankpop","width=470, height=500");
}

function deleteQna()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("삭제할 문의를 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/etcAdm/deleteQna",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      alert("삭제되었습니다.");
      location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function deleteNotice()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("삭제할 공지사항을 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/etcAdm/deleteNotice",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      alert("삭제 되었습니다.");
      location.reload();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}
  function goModify($seq)
  {
      location.href="/admin/etcAdm/noticeModify/"+$seq+"{param}";
  }

  function writeNotice()
  {
    location.href="/admin/etcAdm/noticeWrite/{param}";
  }
</script>
