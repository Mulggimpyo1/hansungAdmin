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
  <form id="schoolForm">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <table class="table table-hover">
                <colgroup>
                  <col width="5%"/>
                  <col/>
                </colgroup>
                <tbody>
                  <tr>
                    <th class="text-left align-middle">계약구분</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left" name="contract_type" id="contract_type">
                        <option value="">선택</option>
                        {contractData}
                        <option value="{value}">{value}</option>
                        {/contractData}
                      </select>
                      <span class="float-left"><a href="javascript:contractPop()"><i class="fas fa-cog"></i></a></span>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">관리코드</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="school_no" name="school_no" readonly value="{school_no}"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">기관명</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="school_name" name="school_name" readonly/>
                      <button type="button" class="btn btn-block btn-default float-left col-sm-1" id="school_search_btn" style="margin-left:5px;" onclick="schoolFind()">검색</button>
                      <input type="checkbox" class="float-left" name="self_write" id="self_write" onclick="selfWrite()" value="Y" style="margin-top:12px;margin-left:5px; margin-right:5px;"/>
                      <label for="self_write" style="margin-top:6px;">직접입력</label>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">기관구분</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left" name="school_classification" id="school_classification">
                        <option value="">선택</option>
                        <option value="ELE">초등학교</option>
                        <option value="MID">중학교</option>
                        <option value="HIG">고등학교</option>
                        <option value="ETC">기타</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle" rowspan="3">주소</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-1 float-left" id="zipcode" name="zipcode" onclick="findAddress()"/>
                      <button type="button" class="btn btn-block btn-default float-left col-sm-1" style="margin-left:5px;" onclick="findAddress()">주소검색</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-3 float-left" id="addr_1" name="addr_1"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-3 float-left" id="addr_2" name="addr_2"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">위도</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-3 float-left" id="lat" name="lat"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">경도</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-3 float-left" id="lng" name="lng"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">지역</th>
                    <td class="text-left align-middle">
                      <select class="form-control col-1 float-left" style="margin:5px 5px 5px 5px;" name="location" id="location">
                        <option value="">지역</option>
                        <?php for($i=0; $i<count($locationData); $i++){ ?>
                        <option value="<?php echo ($locationData[$i]['value']); ?>"><?php echo $locationData[$i]['value']; ?></option>
                        <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">연락처</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="tel" name="tel"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">승인유무</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 float-left" name="status" id="status">
                        <option value="Y">승인</option>
                        <option value="N">미승인</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">계약기간</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left date" id="contract_start_date" name="contract_start_date" readonly/> <span class="float-left mr-3 ml-3">~</span> <input type="text" class="form-control col-sm-2 float-left date" id="contract_end_date" name="contract_end_date" readonly/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">도서 제공여부</th>
                    <td class="text-left align-middle">
                      <input type="radio" class="float-left mr-1" name="book_yn" id="book_y" checked value="Y" style="margin-top:5px;">
                      <label for="book_y" class="float-left mr-2">열람가능</label>
                      <input type="radio" class="float-left mr-1" name="book_yn" id="book_n" value="N" style="margin-top:5px;">
                      <label for="book_n" class="float-left">불가능</label>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">메모</th>
                    <td class="text-left align-middle">
                      <textarea class="form-control col-sm-3 float-left" id="memo" name="memo"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">로고</th>
                    <td class="text-left align-middle">
                      <input type="file" class="form-control col-sm-3 float-left" id="logo_image" name="logo_image"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">이메일</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="email" name="email"/>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

            <!-- /.card-header -->
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-left align-middle">
                      <button type="button" class="btn btn-primary float-left mr-3" onclick="writeSchool()">등록</button>
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

<script>
  $(function(){

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

  function goList()
  {
      location.href="/admin/schoolAdm/schoolList{param}";
  }

  function contractPop()
  {
    window.open("/admin/schoolAdm/contractPop","contractPop","width=470, height=430");
  }

  function schoolFind()
  {
    window.open("/admin/schoolAdm/schoolSearchPop","contractPop","width=470, height=500");
  }

  function refreshContract(data)
  {
    if(data.length>0){
      var html = '<option value="">선택</option>';
      for(var i = 0; i < data.length; i++){
        html += '<option value="'+data[i].value+'">'+data[i].value+'</option>';
      }

      $('#contract_type').html(html);
    }
  }

  function choiceSchool(data)
  {
    var school_name = data.school_name;
    var zipcode = data.zipcode;
    var addr_1 = data.addr_1;
    var addr_2 = data.addr_2;
    var tel = data.tel;
    var email = data.email;
    var school_classification = data.school_classification;
    var lat = data.lat;
    var lng = data.lng;

    $('#school_name').val(school_name);
    $('#zipcode').val(zipcode);
    $('#addr_1').val(addr_1);
    $('#addr_2').val(addr_2);
    $('#tel').val(tel);
    $('#email').val(email);
    $('#school_classification').val(school_classification).prop("selected",true);
    $('#lat').val(lat);
    $('#lng').val(lng);
  }

  function writeSchool()
  {
    var contract_type = $('#contract_type').val();
    var school_name = $('#school_name').val();
    var school_no = $('#school_no').val();
    var zipcode = $('#zipcode').val();
    var addr_1 = $('#addr_1').val();
    var addr_2 = $('#addr_2').val();
    var tel = $('#tel').val();
    var status = $('#status').val();
    var contract_start_date = $('#contract_start_date').val();
    var contract_end_date = $('#contract_end_date').val();
    var memo = $('#memo').val();
    var email = $('#email').val();
    var school_classification = $('#school_classification').val();
    var _location = $('#location').val();
    var lat = $('#lat').val();
    var lng = $('#lng').val();

    if(contract_type == ""){
      alert("계약구분을 선택해주세요.");
      $('#contract_type').focus();
      return;
    }

    if(school_name == ""){
      alert("기관명을 입력해주세요");
      return;
    }

    if(school_classification == ""){
      alert("기관구분을 선택해주세요");
      return;
    }

    if(zipcode == "" || addr_1 == "" || addr_2 == ""){
      alert("주소를 입력해주세요");
      return;
    }

    if(lat == ""){
      alert("위도를 입력해주세요");
      return;
    }

    if(lng == ""){
      alert("경도를 입력해주세요");
      return;
    }

    if(_location == ""){
      alert("지역을 입력해주세요");
      return;
    }

    if(contract_start_date == ""){
      alert("계약기간을 선택해주세요");
      return;
    }

    if(contract_end_date == ""){
      alert("계약기간을 선택해주세요");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#schoolForm')[0];
    var formData = new FormData($('#schoolForm')[0]);
    try{
      formData.append("logo_image",$("#logo_image")[0].files[0]);
    }catch(e){
      console.log(e);
    }

    formData.append(csrf_name,csrf_val);

    $.ajax({
      type: "POST",
      url : "/admin/schoolAdm/schoolWriteProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {

        if( data.result == "success" ){
          alert("등록 되었습니다.");
          location.href = "/admin/schoolAdm/schoolList";
        } else {
          alert("오류발생!!");
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
