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
                  <select class="form-control col-1 float-right" style="margin:5px 5px 5px 5px;" name="status" id="status">
                    <option value="all" <?php echo ($status=="all") ? "selected": ""; ?>>상태</option>
                    <option value="ready" <?php echo ($status=="ready") ? "selected": ""; ?>>광고대기</option>
                    <option value="Y" <?php echo ($status=="Y") ? "selected": ""; ?>>광고중</option>
                    <option value="N" <?php echo ($status=="N") ? "selected": ""; ?>>광고종료</option>
                  </select>
                  <input type="text" class="form-control col-1 float-right date" style="margin:5px 5px 5px 5px;" name="adv_end_date" id="adv_end_date" value="<?php echo $adv_end_date!="all"?$adv_end_date:""; ?>"/>
                  <span class="float-right mr-1 ml-1 mt-2">~</span>
                  <input type="text" class="form-control col-1 float-right date" style="margin:5px 5px 5px 5px;" name="adv_start_date" id="adv_start_date" value="<?php echo $adv_start_date!="all"?$adv_start_date:""; ?>"/>
                  <span style="float:left; margin:15px 5px 5px 15px; font-weight:bold">총 {list_total}명</span>
                </div>
                  <table class="table table-hover">
                    <colgroup>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col/>
                      <col width="8%"/>
                      <col width="10%"/>
                      <col width="5%"/>
                      <col width="10%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                      <col width="5%"/>
                    </colgroup>
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" id="allCheck"></th>
                        <th class="text-center">#</th>
                        <th class="text-center">상태</th>
                        <th class="text-center">미리보기</th>
                        <th class="text-center">광고명</th>
                        <th class="text-center">광고주</th>
                        <th class="text-center">광고기간</th>
                        <th class="text-center">등록일</th>
                        <th class="text-center">노출 수</th>
                        <th class="text-center">미리보기</th>
                        <th class="text-center">인사이트</th>
                        <th class="text-center">수정</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if( count($adList) > 0 ){ ?>
                      {adList}
                      <tr>
                        <td class="text-center align-middle"><input type="checkbox" name="chk[]" value="{adv_seq}"></td>
                        <td class="text-center align-middle">{count}</td>
                        <td class="text-center align-middle">{status}</td>
                        <td class="text-center align-middle">{thumb}</td>
                        <td class="text-center align-middle">{adv_title}</td>
                        <td class="text-center align-middle">{adv_comp_name}</td>
                        <td class="text-center align-middle">{adv_start_date} ~ {adv_end_date}</td>
                        <td class="text-center align-middle">{reg_date}</td>
                        <td class="text-center align-middle">{adv_view}/{adv_total_view}건</td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-default"  onclick="viewAdFeed('{adv_seq}')">미리보기</button></td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-default" onclick="goView('{adv_seq}')">확인</button></td>
                        <td class="text-center align-middle"><button type="button" class="btn btn-default" onclick="goModify('{adv_seq}')">수정</button></td>
                      </tr>
                      {/adList}
                      <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="10">광고가 없습니다.</td>
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
              <span class="float-right">
                <button type="button" class="btn btn-block btn-primary" onclick="writeAd()">등록</button>
              </span>
              <span class="float-right mr-2">
                <button type="button" class="btn btn-block btn-default" onclick="deleteAd()">선택삭제</button>
              </span>
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
function viewAdFeed($adv_seq)
{
  window.open("/feed/adView/"+$adv_seq, "Feed", "width=400,height=667");
}

$(function(){
    $('.select2').select2();
    $('#allCheck').on("click",function(){
      allCheckClick();
    });

    $.datepicker.regional['ko'] = {
        closeText: '닫기',
        prevText: '이전달',
        nextText: '다음달',
        currentText: 'X',
        monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
        '7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
        monthNamesShort: ['1월','2월','3월','4월','5월','6월',
        '7월','8월','9월','10월','11월','12월'],
        dayNames: ['일','월','화','수','목','금','토'],
        dayNamesShort: ['일','월','화','수','목','금','토'],
        dayNamesMin: ['일','월','화','수','목','금','토'],
        weekHeader: 'Wk',
        dateFormat: 'yy-mm-dd',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: ''};
       $.datepicker.setDefaults($.datepicker.regional['ko']);

    $('.date').datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      yearRange: 'c-99:c+99',
      minDate: '',
      maxDate: ''
   });
});

function goView($ad_seq)
{
  location.href = "/admin/contentAdm/adView/"+$ad_seq+"{param}";
}

function goModify($ad_seq)
{
  location.href = "/admin/contentAdm/adModify/"+$ad_seq+"{param}";
}

function allCheckClick()
{
  if($('#allCheck').is(":checked") == true ){
    $('input[name="chk[]"]').prop("checked",true);
  }else{
    $('input[name="chk[]"]').prop("checked",false);
  }
}

function deleteAd()
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
    url : "/admin/contentAdm/adDelete",
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

  function writeAd()
  {
    location.href="/admin/contentAdm/adWrite{param}";
  }
</script>
