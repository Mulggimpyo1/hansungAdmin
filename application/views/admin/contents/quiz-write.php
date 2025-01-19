<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
  .toggle.ios .toggle-handle { border-radius: 20rem; }
</style>
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
  <form id="quizForm">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <table class="table">
                <colgroup>
                  <col width="5%"/>
                  <col/>
                </colgroup>
                <tbody>
                  <tr>
                    <th class="text-left align-middle">제목</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="quiz_title" name="quiz_title"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">노출설정</th>
                    <td class="text-left align-middle">
                      <input type="checkbox" name="status" id="status" data-style="ios" data-toggle="toggle" data-onstyle="danger" data-offstyle="warning" value="Y">
                    </td>
                  </tr>
                  <tr id="view_wrap">
                    <th class="text-left align-middle">노출예약</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left date mr-1" id="quiz_view_datetime" name="quiz_view_datetime" readonly/>
                      <select type="text" class="form-control col-sm-1 float-left mr-1" name="quiz_view_hour" id="quiz_view_hour">
                        <option value="">시간</option>
                        <?php for($i=0; $i<24; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?>시</option>
                        <?php } ?>
                      </select>
                      <select type="text" class="form-control col-sm-1 float-left mr-1" name="quiz_view_min" id="quiz_view_min">
                        <option value="">분</option>
                        <option value="00">00분</option>
                        <option value="30">30분</option>
                      </select>
                    </td>
                  </tr>
                  <?php for($i=1; $i<=10; $i++){ ?>
                  <tr>
                    <th class="text-center align-middle" rowspan="2" style="background-color:#fefefe;">Q<?php echo $i; ?></th>
                    <td class="text-left align-middle">
                      <input type="radio" class="float-left mr-1" name="quiz_<?php echo $i; ?>_type" id="quiz_<?php echo $i; ?>_type1" checked value="type1" style="margin-top:5px;" onchange="typeChange('<?php echo $i; ?>','1')">
                      <label for="quiz_<?php echo $i; ?>_type1" class="float-left mr-2">객관식 문제</label>
                      <input type="radio" class="float-left mr-1" name="quiz_<?php echo $i; ?>_type" id="quiz_<?php echo $i; ?>_type2" value="type2" style="margin-top:5px;" onchange="typeChange('<?php echo $i; ?>','2')">
                      <label for="quiz_<?php echo $i; ?>_type2" class="float-left">OX퀴즈</label>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <table class="table" id="quiz_<?php echo $i; ?>_type1_table" style="border-top:0px">
                        <tbody>
                          <tr class="type1">
                            <td class="text-left align-middle" style="border-top:0px;">
                              <label>문제</label>
                              <textarea class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t1_q" name="quiz_<?php echo $i; ?>_t1_q"></textarea>
                            </td>
                          </tr>
                          <tr class="type1">
                            <td class="text-left align-middle">
                              <label>정답문항</label>
                              <input type="text" class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t1_a" name="quiz_<?php echo $i; ?>_t1_a"/>
                            </td>
                          </tr>
                          <tr class="type1">
                            <td class="text-left align-middle">
                              <label>오답문항</label>
                              <input type="text" class="form-control col-sm-3 mb-2" id="quiz_<?php echo $i; ?>_t1_n1" name="quiz_<?php echo $i; ?>_t1_n1"/>
                              <input type="text" class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t1_n2" name="quiz_<?php echo $i; ?>_t1_n2"/>
                            </td>
                          </tr>
                          <tr class="type1">
                            <td class="text-left align-middle">
                              <label>정답 해설</label>
                              <textarea class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t1_discription" name="quiz_<?php echo $i; ?>_t1_discription"></textarea>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table" id="quiz_<?php echo $i; ?>_type2_table" style="display:none;">
                        <tbody>
                          <tr>
                            <td class="text-left align-middle" style="border-top:0px;">
                              <label>문제</label>
                              <textarea class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t2_q" name="quiz_<?php echo $i; ?>_t2_q"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left align-middle">
                              <input type="radio" class="float-left mr-1" name="quiz_<?php echo $i; ?>_t2_a" id="quiz_<?php echo $i; ?>_t2_a1" value="O" style="margin-top:5px;" checked>
                              <label for="quiz_<?php echo $i; ?>_t2_a1" class="float-left mr-2">O</label>
                              <input type="radio" class="float-left mr-1" name="quiz_<?php echo $i; ?>_t2_a" id="quiz_<?php echo $i; ?>_t2_a2" value="X" style="margin-top:5px;">
                              <label for="quiz_<?php echo $i; ?>_t2_a2" class="float-left">X</label>
                            </td>
                          </tr>
                          <tr>
                            <td class="text-left align-middle">
                              <label>정답 해설</label>
                              <textarea class="form-control col-sm-3" id="quiz_<?php echo $i; ?>_t2_discription" name="quiz_<?php echo $i; ?>_t2_discription"></textarea>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                <?php } ?>

                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

            <!-- /.card-header -->
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-left align-middle">
                      <button type="button" class="btn btn-primary float-left mr-3" onclick="writeQuiz()">등록</button>
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
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script>

  $(function(){
    $('#status').bootstrapToggle();
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

     $('#status').on("change",function(){
       if($(this).is(":checked")){
         $('#view_wrap').hide();
       }else{
         $('#view_wrap').show();
       }
     });

     if($('#status').is(":checked")){
       $('#view_wrap').hide();
     }else{
       $('#view_wrap').show();
     }
  });

  function typeChange($quiz_num,$type)
  {
    $('#quiz_'+$quiz_num+'_type1_table').hide();
    $('#quiz_'+$quiz_num+'_type2_table').hide();

    $('#quiz_'+$quiz_num+'_type'+$type+'_table').show();
  }

  function goList()
  {
      location.href="/admin/contentAdm/quizList{param}";
  }

  function writeQuiz()
  {
    var quiz_title = $('#quiz_title').val();
    if(quiz_title == ""){

      alert("퀴즈 제목을 작성해주세요.");
      setTimeout(function(){
        $('#quiz_title').focus();
      },0);

      return;
    }

    for(var i = 1; i <= 10; i++){
      var type = $("input[name='quiz_"+i+"_type']:checked").val();
      var question = "";
      var answer = "";
      var discription = "";
      var type_short = "";
      if(type == "type1"){
        type_short = "t1";
      }else{
        type_short = "t2";
      }

      if(type == "type1"){
        question = $('#quiz_'+i+'_t1_q').val();
        answer = $('#quiz_'+i+'_t1_a').val();
        var n1 = $('#quiz_'+i+'_t1_n1').val();
        var n2 = $('#quiz_'+i+'_t1_n2').val();
        discription = $('#quiz_'+i+'_t1_discription').val();

      }else{
        question = $('#quiz_'+i+'_t2_q').val();
        answer = $('#quiz_'+i+'_t2_a').val();
        discription = $('#quiz_'+i+'_t2_discription').val();
      }



      if(question == ""){
        alert("문제를 작성해주세요.");
        $('#quiz_'+i+'_'+type_short+'_q').focus();
        return;
      }

      if(answer == ""){
        alert("정답을 작성해주세요.");
        setTimeout(function(){
          $('#quiz_'+i+'_'+type_short+'_a').focus();
        },0);
        return;
      }

      if(type == "type1" && n1 == ""){
        alert("오답문항을 작성해주세요.");
        setTimeout(function(){
          $('#quiz_'+i+'_'+type_short+'_n1').focus();
        },0);
        return;
      }
      if(type == "type1" && n2 == ""){
        alert("오답문항을 작성해주세요.");
        setTimeout(function(){
          $('#quiz_'+i+'_'+type_short+'_n2').focus();
        },0);
        return;
      }


      if(discription == ""){
        alert("정답해설을 작성해주세요.");
        $('#quiz_'+i+'_'+type_short+'_discription').focus();
        return;
      }
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var formData = $('#quizForm').serialize();

    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/quizWriteProc",
      data: formData,
      dataType:"json",
      success : function(data, status, xhr) {
          if(data.result=="success"){
            alert("등록되었습니다.");
            location.href = "/admin/contentAdm/quizList{param}";
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
      $('#school_name').attr("readonly",false);
      $('#school_search_btn').hide();
    }else{
      $('#school_name').attr("readonly",true);
      $('#school_search_btn').show();
    }
  }

  function findAddress()
  {
        new daum.Postcode({
            oncomplete: function(data) {

                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }

                } else {
                    document.getElementById("addr_1").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('zipcode').value = data.zonecode;
                document.getElementById("addr_1").value = addr+extraAddr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("addr_2").focus();
            }
        }).open();
    }
</script>
