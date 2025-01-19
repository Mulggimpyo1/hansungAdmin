<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="float-left">{title}</h1>

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
              <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <div class="card-body table-responsive p-0">
                <div class="form-group">
                  <button type="button" class="btn btn-primary float-right" style="margin:5px 5px 5px 5px;" id="srcBtn" onclick="search(this)">검색</button>
                  <input type="text" class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcN" id="srcN" value="<?php echo $this->input->get('srcN'); ?>"/>
                  <?php if($this->session->userdata("admin_level")<=1){ ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcClass" id="srcClass">
                    <option value="all" <?php echo ($srcClass=="all") ? "selected": ""; ?>>전체</option>
                    <?php for($i=0; $i<count($classList); $i++){ ?>
                    <option value="<?php echo $classList[$i]['school_class']; ?>" <?php echo ($classList[$i]['school_class']==$srcClass) ? "selected": ""; ?>><?php echo $classList[$i]['school_class']; ?></option>
                    <?php } ?>
                  </select>
                  <?php }else{ ?>
                    <input type="hidden" name="srcClass" id="srcClass" value="<?php echo $this->session->userdata("school_class"); ?>"/>
                  <?php } ?>
                  <?php if($this->session->userdata("admin_level")<=1){ ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="srcYear" id="srcYear">
                    <option value="all" <?php echo ($srcYear=="all") ? "selected": ""; ?>>전체</option>
                    <?php for($i=0; $i<6; $i++){ ?>
                    <option value="<?php echo ($i+1); ?>" <?php echo ($srcYear==($i+1)) ? "selected": ""; ?>><?php echo ($i+1)."학년" ?></option>
                    <?php } ?>
                    <option value="None" <?php echo ($srcYear=="None") ? "selected": ""; ?>>None</option>
                  </select>
                <?php }else{ ?>
                  <input type="hidden" name="srcYear" id="srcYear" value="<?php echo $this->session->userdata("school_year"); ?>"/>
                <?php } ?>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="challenge_seq" id="challenge_seq">
                    <option value="all" <?php echo ($challenge_parent_seq=="all") ? "selected": ""; ?>>구분</option>
                    <?php for($i=0; $i<count($challengeDepth2); $i++){ ?>
                    <option value="<?php echo $challengeDepth2[$i]['challenge_seq']; ?>" <?php echo ($challengeDepth2[$i]['challenge_seq']==$challenge_seq) ? "selected": ""; ?>><?php echo $challengeDepth2[$i]['challenge_title']; ?></option>
                    <?php } ?>
                  </select>
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="challenge_parent_seq" id="challenge_parent_seq" onchange="loadDepth2()">
                    <option value="all" <?php echo ($challenge_parent_seq=="all") ? "selected": ""; ?>>챌린지</option>
                    <?php for($i=0; $i<count($challengeDepth1); $i++){ ?>
                    <option value="<?php echo $challengeDepth1[$i]['challenge_seq']; ?>" <?php echo ($challengeDepth1[$i]['challenge_seq']==$challenge_parent_seq) ? "selected": ""; ?>><?php echo $challengeDepth1[$i]['challenge_title']; ?></option>
                    <?php } ?>
                  </select>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}명</span>
                </div>
                <div class="card-body table-responsive p-0">
                  <div class="form-group">
                      <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="page_size" id="page_size" onchange="this.form.submit();">
                      <option value="20" <?php echo ($page_size=="20") ? "selected": ""; ?>>20개</option>
                      <option value="50" <?php echo ($page_size=="50") ? "selected": ""; ?>>50개</option>
                      <option value="100" <?php echo ($page_size=="100") ? "selected": ""; ?>>100개</option>
                    </select>
                  </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                      <col width="9%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">기관명</th>
                        <th class="text-center">학년</th>
                        <th class="text-center">반</th>
                        <th class="text-center">이름(아이디)</th>
                        <th class="text-center">챌린지</th>
                        <th class="text-center">구분</th>
                        <th class="text-center">절감탄소량</th>
                        <th class="text-center">일자</th>
                        <th class="text-center">상세보기</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($challengeList) > 0 ){ ?>
                      {challengeList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{user_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{school_name}</td>
                        <td class="text-center align-middle">{school_year}학년</td>
                        <td class="text-center align-middle">{school_class}</td>
                        <td class="text-center align-middle">{user_name}({user_id})</td>
                        <td class="text-center align-middle">{parent_title}</td>
                        <td class="text-center align-middle">{challenge_title}</td>
                        <td class="text-center align-middle">{challenge_carbon_point}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-block btn-warning" onclick="viewFeed('{feed_seq}')">상세</button></td>
                      </tr>
                      {/challengeList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="11">피드가 없습니다.</td>
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
<form id="excel_down_form" method="POST" action="/admin/memberAdm/memberDownLoad">
  <input type="hidden" name="srcN_excel" id="srcN_excel"/>
  <input type="hidden" name="srcLevel_excel" id="srcLevel_excel"/>
  <input type="hidden" name="srcClass_excel" id="srcClass_excel"/>
  <input type="hidden" name="srcSchool_excel" id="srcSchool_excel"/>
  <input type="hidden" name="srcYear_excel" id="srcYear_excel"/>
  <input type="hidden" name="srcStatus_excel" id="srcStatus_excel"/>
  <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
</form>
<script>
$(function(){
    $('#allCheck').on("click",function(){
      allCheckClick();
    });
});

function allCheckClick()
{
  if($('#allCheck').is(":checked") == true ){
    $('input[name="chk[]"]').prop("checked",true);
  }else{
    $('input[name="chk[]"]').prop("checked",false);
  }
}

function deleteUser()
{
  var chkBool = false;
  $('input[name="chk[]"]').each(function(){
    if($(this).is(":checked")){
      chkBool = true;
      return;
    }
  });


  if(chkBool == false){
    alert("선택삭제 회원을 선택해주세요.");
    return;
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = $('#search_form').serialize();


  data[csrf_name] = csrf_val;


  if(confirm("선택한회원을 삭제하시겠습니까?")){
    $.ajax({
      type: "POST",
      url : "/admin/memberAdm/deleteUsers",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {

        if(data.result=="success"){
          alert("회원이 삭제 되었습니다.");
          location.reload();
        }



      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }
}

function loadDepth2()
{
  var parent_challenge_seq = $('#challenge_parent_seq').val();
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();
  var data = {
    "parent_challenge_seq"  : parent_challenge_seq
  };
  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/contentAdm/loadDepth2",
    data: data,
    dataType:"json",
    success : function(data, status, xhr) {
      var html = "<option value='all'>구분</option>";
      for(var i = 0; i <data.data.length; i++){
        html += "<option value='"+data.data[i].challenge_seq+"'>"+data.data[i].challenge_title+"</option>";
      }
      $('#challenge_seq').html(html);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}

function viewFeed($feed_seq)
{
  window.open("/feed/feedView/"+$feed_seq, "Feed", "width=400,height=667");
}

  function goModify($seq)
  {
      location.href="/admin/memberAdm/memberModify/"+$seq+"{param}";
  }

  function memberExcelDown()
  {
    $('#srcN_excel').val($('#srcN').val());
    $('#srcLevel_excel').val($('#srcLevel').val());
    $('#srcClass_excel').val($('#srcClass').val());
    $('#srcSchool_excel').val($('#srcSchool').val());
    $('#srcYear_excel').val($('#srcYear').val());
    $('#srcStatus_excel').val($('#srcStatus').val());

    $('#excel_down_form').submit();
  }
</script>
