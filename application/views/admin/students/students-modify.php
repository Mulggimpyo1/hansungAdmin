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
            <form role="form" id="studentModifyForm" enctype="multipart/form-data">
              <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
              <input type="hidden" name="user_seq" value="{user_seq}"/>

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
                        <input type="text" class="form-control col-sm-6 float-left" id="user_name" name="user_name" placeholder="회원명" value="<?php echo $userData['user_name']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>회원 아이디</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="user_id" name="user_id" placeholder="회원 아이디" value="<?php echo $userData['user_id']; ?>" disabled />
                      </td>
                    </tr>
                    <tr>
                      <th>회원 비밀번호</th>
                      <td colspan="3">
                        <input type="password" class="form-control col-sm-6 float-left" id="user_password" name="user_password" placeholder="회원 비밀번호" value="" />
                        <input type="hidden" name="user_password_org" value="<?php echo $userData['user_password']; ?>"/>
                      </td>
                    </tr>
                    <tr>
                      <th>학원</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="academy_seq" id="academy_seq">
                          <?php if($this->session->userdata("admin_type")=="A"){ ?>
                            <option value="">학원선택</option>
                            <?php for($i=0; $i<count($academiList); $i++){ ?>
                            <option value="<?php echo $academiList[$i]['academy_seq']; ?>" <?php echo $userData['academy_seq']==$academiList[$i]['academy_seq'] ? "selected":"" ?>><?php echo $academiList[$i]['academy_name']; ?></option>
                            <?php } ?>
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
                        <input type="text" class="form-control col-sm-6 float-left" id="email" name="email" placeholder="이메일" value="<?php echo $userData['email']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>성별</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="gender" id="gender">
                            <option value="M" <?php echo $userData['gender']=="M" ? "selected":"" ?>>남자</option>
                            <option value="F" <?php echo $userData['gender']=="F" ? "selected":"" ?>>여자</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>학생 연락처</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="phone" name="phone" placeholder="학생 연락처" value="<?php echo $userData['phone']; ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                      </td>
                    </tr>
                    <tr>
                      <th>부모 연락처</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="parent_phone" name="parent_phone" placeholder="부모 연락처" value="<?php echo $userData['parent_phone']; ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
                      </td>
                    </tr>
                    <tr>
                      <th>학교명</th>
                      <td colspan="3">
                        <input type="text" class="form-control col-sm-6 float-left" id="school_name" name="school_name" placeholder="학교명" value="<?php echo $userData['school_name']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>학년</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="school_year" id="school_year">
                          <option value="0" <?php echo $userData['school_year']=="0" ? "selected":"" ?>>유치</option>
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
                              <option value="<?php echo $i; ?>" <?php echo $userData['school_year']==$i ? "selected":"" ?>><?php echo $grade_name; ?></option>
                            <?php } ?>
                            <option value="13" <?php echo $userData['school_year']=="13" ? "selected":"" ?>>일반</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th>반 배정</th>
                      <td colspan="3">
                        <select class="form-control col-sm-4 float-left" name="academy_class_seq" id="academy_class_seq">
                          <?php if($this->session->userdata("admin_type")=="A"){ ?>
                            <option value="">반 선택</option>
                            <?php for($i=0; $i<count($academiClassList); $i++){ ?>
                            <option value="<?php echo $academiClassList[$i]['academy_class_seq']; ?>" <?php echo $userData['academy_class_seq']==$academiClassList[$i]['academy_class_seq'] ? "selected":"" ?>><?php echo $academiClassList[$i]['class_name']; ?></option>
                            <?php } ?>
                          <?php
                            }else{
                              for($i=0; $i<count($academiClassList); $i++){
                                if($academiClassList[$i]['academy_seq']==$this->session->userdata("academy_seq")){
                          ?>
                          <option value="<?php echo $academiClassList[$i]['academy_class_seq'] ?>" <?php echo $userData['academy_class_seq']==$academiClassList[$i]['academy_class_seq'] ? "selected":"" ?>><?php echo $academiClassList[$i]['class_name'] ?></option>
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
                            <option value="C" <?php echo $userData['status']=="C" ? "selected":"" ?>>승인</option>
                            <option value="R" <?php echo $userData['status']=="R" ? "selected":"" ?>>대기</option>
                            <option value="L" <?php echo $userData['status']=="L" ? "selected":"" ?>>탈퇴</option>
                        </select>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-default float-right" style="margin-right:10px;" onclick="goList()">목록</button>
                <!--<button type="button" class="btn btn-warning float-right" style="margin-right:10px;" onclick="deleteUser()">삭제</button>-->
                <button type="button" class="btn btn-primary float-right" style="margin-right:10px;" onclick="modifyProc()">수정</button>
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

  function modifyProc()
  {

    if(checkInput()){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var form = $('#studentModifyForm')[0];
      var formData = new FormData($('#studentModifyForm')[0]);


      $.ajax({
        type: "POST",
        url : "/admin/academiAdm/studentModifyProc",
        data: formData,
        dataType:"json",
        processData: false,
        contentType: false,
        success : function(data, status, xhr) {
          if( data.result == "success" ){
            alert("수정 되었습니다.");
            <?php if($mode == "delete"){ ?>
              location.href = "/admin/academiAdm/deleteStudentList";
            <?php }else{ ?>
              location.href = "/admin/academiAdm/studentList?num={num}&srcN={srcN}&srcType={srcType}&status={status}";
            <?php } ?>

          }else{
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

  function deleteUser()
  {
    if(confirm("삭제하시겠습니까?")){
      location.href="/admin/academiAdm/studentDelete/"+{user_seq}
    }
  }
</script>
