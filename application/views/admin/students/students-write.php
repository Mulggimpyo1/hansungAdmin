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
            <li class="breadcrumb-item"><a href="/admin/main">Home</a></li>
            <li class="breadcrumb-item active">{sub_title}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <!-- form start -->
            <form role="form" id="studentWriteForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>

              <div class="card-body">
                <h4 style="color:#007bff;">회원 정보</h4>
                <table class="table table-bordered">
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <colgroup width="15%" />
                  <colgroup width="35%" />
                  <tbody>
                    <tr>
                      <th>회원명</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="user_name" name="user_name" placeholder="회원명" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>회원 아이디</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="user_id" name="user_id" placeholder="회원 아이디" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>회원 비밀번호</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="user_password" name="user_password" placeholder="회원 비밀번호" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>학원</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="academy_seq" id="academy_seq">
                          <?php if($this->session->userdata("admin_type")=="A"){ ?>
                            <option value="">학원선택</option>
                            {academiList}
                            <option value="{academy_seq}">{academy_name}</option>
                            {/academiList}
                          <?php
                            }else{
                              for($i=0; $i<count($academiList); $i++){
                                if($academiList[$i]['academy_seq']==$this->session->userdata("academy_seq")){
                          ?>
                          <option value="<?php echo $academiList[$i]['academy_seq'] ?>"><?php echo $academiList[$i]['academy_name'] ?></option>
                          <?php
                                }
                              }
                            } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>이메일</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="email" name="email" placeholder="이메일" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>성별</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="gender" id="gender">
                            <option value="M">남자</option>
                            <option value="F">여자</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>학생 연락처</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="phone" name="phone" placeholder="학생 연락처" value=""  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                      </td>
                    </tr>
                    <tr>
                      <th>부모 연락처</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="parent_phone" name="parent_phone" placeholder="부모 연락처" value=""  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                      </td>
                    </tr>
                    <tr>
                      <th>학교명</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="school_name" name="school_name" placeholder="학교명" value="" />
                      </td>
                    </tr>
                    <tr>
                      <th>학년</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="school_year" id="school_year">
                          <option value="0">유치</option>
                            <?php for($i=1; $i<=12; $i++){
                              $grade_name = "";
                              switch($i){
                                case 1:
                                case 2:
                                case 3:
                                case 4:
                                case 5:
                                case 6:
                                $grade_name = "초등 ".$i."학년";
                                break;
                                case 7:
                                case 8:
                                case 9:
                                $grade_name = "중등 ".($i-6)."학년";
                                break;
                                case 10:
                                case 11:
                                case 12:
                                $grade_name = "고등 ".($i-9)."학년";
                                break;
                              }
                            ?>
                              <option value="<?php echo $i; ?>"><?php echo $grade_name; ?></option>
                            <?php } ?>
                            <option value="13">일반</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>반 배정</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="academy_class_seq" id="academy_class_seq">

                            <option value="">반 선택</option>
                          <?php if($this->session->userdata("admin_type")=="A"){ ?>
                            {academiClassList}
                            <option value="{academy_class_seq}">{class_name}</option>
                            {/academiClassList}
                          <?php
                            }else{
                              for($i=0; $i<count($academiClassList); $i++){
                                if($academiClassList[$i]['academy_seq']==$this->session->userdata("academy_seq")){
                          ?>
                          <option value="<?php echo $academiClassList[$i]['academy_class_seq'] ?>"><?php echo $academiClassList[$i]['class_name'] ?></option>
                          <?php
                                }
                              }
                            } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>상태</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="status" id="status">
                            <option value="C">승인</option>
                            <option value="R">대기</option>
                            <option value="L">탈퇴</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="goList()">목록</button>
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="writeProc()">등록</button>
              </div>
            </form>
          </div>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>


  function goList(){
    location.href="/admin/academiAdm/studentList?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
  }

  function checkInput()
  {
    var user_name = $('#user_name').val();
    var user_id = $('#user_id').val();
    var user_password = $('#user_password').val();
    var academy_seq = $('#academy_seq').val();
    var email = $('#email').val();
    var gender = $('#gender').val();
    var phone = $('#phone').val();
    var parent_phone = $('#parent_phone').val();
    var school_name = $('#school_name').val();
    var school_year = $('#school_year').val();
    var academy_class_seq = $('#academy_class_seq').val();

    if( user_name == "" ){
      alert("회원명을 입력해주세요");
      return false;
    }

    if( user_id == "" ){
      alert("아이디를 입력해주세요");
      return false;
    }

    var idReg = /[a-z0-9]{5,19}$/g;

    if(!idReg.test($('#user_id').val())){
      alert("아이디는 소문자 영문/숫자로 이루어진 5~20자이어야 합니다.");
      return;
    }

    if( user_password == "" ){
      alert("비밀번호를 입력해주세요");
      return false;
    }

    if( academy_seq == "" ){
      alert("학원을 선택해주세요");
      return false;
    }

    if( academy_class_seq == "" ){
      alert("반을 선택해주세요");
      return false;
    }

    return true;

  }

  function writeProc()
  {

    if(checkInput()){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var form = $('#studentWriteForm')[0];
      var formData = new FormData($('#studentWriteForm')[0]);


      $.ajax({
        type: "POST",
        url : "/admin/academiAdm/studentWriteProc",
        data: formData,
        dataType:"json",
        processData: false,
        contentType: false,
        success : function(data, status, xhr) {
          if( data.result == "success" ){
            alert("등록 되었습니다.");
            location.href = "/admin/academiAdm/studentList?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
          } else {
            if(data.msg == "duplicate id"){
              alert("이미 가입된 아이디가 있습니다.");
            }

            if(data.msg == "student over"){
              alert("학원 승인사용인원을 초과하였습니다.");
            }

          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }


  }
</script>
