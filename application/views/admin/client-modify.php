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
  <form id="clientForm">
    <input type="hidden" id="client_idx" name="client_idx" value="{client_idx}" />
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
              <table class="table table-hover">
                <colgroup>
                  <col/>
                </colgroup>
                <tbody>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="client_name" name="client_name" value="<?php echo $clientData['client_name'] ?>" placeholder="업체명"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="business_no" name="business_no" value="<?php echo $clientData['business_no'] ?>" placeholder="사업자번호"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="owner_name" name="owner_name" value="<?php echo $clientData['owner_name'] ?>" placeholder="대표자"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="business_1" name="business_1" value="<?php echo $clientData['business_1'] ?>" placeholder="업태"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="business_2" name="business_2" value="<?php echo $clientData['business_2'] ?>" placeholder="종목"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="phone" name="phone" value="<?php echo $clientData['phone'] ?>" placeholder="전화번호"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="fax" name="fax" value="<?php echo $clientData['fax'] ?>" placeholder="팩스"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="manager_name" name="manager_name" value="<?php echo $clientData['manager_name'] ?>" placeholder="담당자"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="manager_phone" name="manager_phone" value="<?php echo $clientData['manager_phone'] ?>" placeholder="담당자연락처"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="email" name="email" value="<?php echo $clientData['email'] ?>" placeholder="이메일"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="c_id" name="c_id" value="<?php echo $clientData['c_id'] ?>" placeholder="아이디"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="email" name="c_pw" value="<?php echo $clientData['c_pw'] ?>" placeholder="비밀번호"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-3 float-left" id="zipcode" name="zipcode" value="<?php echo $clientData['zipcode'] ?>" onclick="findAddress()" placeholder="우편번호" />
                      <button type="button" class="btn btn-block btn-default float-left col-sm-1" style="margin-left:5px;" onclick="findAddress()">주소검색</button>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="addr_1" name="addr_1" value="<?php echo $clientData['addr_1'] ?>" placeholder="주소"/>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-md-12 float-left" id="addr_2" name="addr_2" value="<?php echo $clientData['addr_2'] ?>" placeholder="상세주소"/>
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
                      <button type="button" class="btn btn-primary float-left mr-3" onclick="modifyClient()">수정</button>
                      <button type="button" class="btn btn-warning float-left mr-3" onclick="deleteClient()">삭제</button>
                      <button type="button" class="btn btn-default float-left mr-3" onclick="goList()">목록</button>
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

  });

  function modifyClient()
  {
    var client_name = $('#client_name').val();
    var business_no = $('#business_no').val();
    var owner_name = $('#owner_name').val();
    var business_1 = $('#business_1').val();
    var business_2 = $('#business_2').val();
    var phone = $('#phone').val();
    var fax = $('#fax').val();
    var bank = $('#bank').val();
    var manager_name = $('#manager_name').val();
    var manager_phone = $('#manager_phone').val();
    var zipcode = $('#zipcode').val();
    var addr_1 = $('#addr_1').val();
    var addr_2 = $('#addr_2').val();
    var c_id = $('#c_id').val();
    var c_pw = $('#c_pw').val();

    if( client_name == ''){
      alert("업체명을 작성해주세요.");
      return;
    }

    if( business_no == ''){
      alert("사업자등록번호를 작성해주세요.");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#clientForm')[0];
    var formData = new FormData($('#clientForm')[0]);

    $.ajax({
      type: "POST",
      url : "/admin/home/clientModifyProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {

        if( data.result == "success" ){
          alert("수정 되었습니다.");
          location.href = "/admin/home/clientList?srcType={srcType}&srcN={srcN}&num={num}&param={param}";
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  function deleteClient()
  {
      if(confirm("정말 삭제하시겠습니까?")){
        var csrf_name = $('#csrf').attr("name");
        var csrf_val = $('#csrf').val();

        var form = $('#clientForm')[0];
        var formData = new FormData($('#clientForm')[0]);

        $.ajax({
          type: "POST",
          url : "/admin/home/clientDeleteProc",
          data: formData,
          dataType:"json",
          processData: false,
          contentType: false,
          success : function(data, status, xhr) {

            if( data.result == "success" ){
              alert("삭제 되었습니다.");
              location.href = "/admin/home/clientList?srcType={srcType}&srcN={srcN}&num={num}&param={param}";
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
          }
        });
      }


  }

  function goList(){
    location.href = "/admin/home/clientList?srcType={srcType}&srcN={srcN}&num={num}&param={param}";
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
