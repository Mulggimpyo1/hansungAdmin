<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{title}</h1>
          <small style="color:red">※ 공유음원으로 숙제 배정 시 게시자의 상황에 의해 재생이 안될 수 있음</small>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <form id="allocationForm">
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
                    <th class="text-left align-middle">제목</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-6 float-left" style="margin-left:5px;margin-right:5px;" name="homework_title" id="homework_title"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">마감일</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left date" id="final_date" name="final_date" readonly/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle" colspan="2"><button type="button" class="btn btn-block btn-default float-left col-sm-1" onclick="studentPop()">인원 검색</button></th>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

          <div class="card" style="height: 300px; overflow-y: scroll;">
            <!-- /.card-header -->
            <table class="table table-hover" style="white-space:nowrap; border-collapse:collapse;">
              <colgroup>
                <col width="9%"/>
                <col width="9%"/>
                <col width="9%"/>
                <col width="9%"/>
                <col width="9%"/>
              </colgroup>
              <thead>
                <tr>
                  <th class="text-center">아이디</th>
                  <th class="text-center">이름</th>
                  <th class="text-center">학교</th>
                  <th class="text-center">학년</th>
                  <th class="text-center">삭제</th>
                </tr>
              </thead>
              <tbody id="userList">
              </tbody>
            </table>
          </div>

          <div class="card">
            <!-- /.card-header -->
              <table class="table table-hover">
                <colgroup>
                  <col width="5%"/>
                  <col/>
                </colgroup>
                <tbody>
                  <tr>
                    <th class="text-left align-middle" colspan="2"><button type="button" class="btn btn-block btn-default float-left col-sm-1" onclick="contentPop()">콘텐츠 검색</button></th>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->

            <div class="card" style="height: 300px; overflow-y: scroll;">
              <!-- /.card-header -->
              <table class="table table-hover" style="white-space:nowrap; border-collapse:collapse;">
                <colgroup>
                  <col width="9%"/>
                  <col width="5%"/>
                  <col width="9%"/>
                  <col width="9%"/>
                  <col width="5%"/>
                </colgroup>
                <thead>
                  <tr>
                    <th class="text-center">음원제목</th>
                    <th class="text-center">음원코드</th>
                    <th class="text-center">트랙번호</th>
                    <th class="text-center">음원카테고리</th>
                    <th class="text-center">삭제</th>
                  </tr>
                </thead>
                <tbody id="contentList">

                </tbody>
              </table>
            </div>

            <div class="card-footer clearfix">
              <span class="float-right" style="margin-left:5px;">
                <button type="button" class="btn btn-block btn-default" onclick="goList()">목록</button>
              </span>
              <span class="float-right">
                <button type="button" class="btn btn-block btn-success" onclick="allocationProc()">등록</button>
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
  </form>

</div>
<!-- /.content-wrapper -->
<script>
var contentArr = [];
var studentArr = [];
  $(function(){
      $('#user_all_check_box').on("click",function(){
        alluserCheckClick();
      });

      $('#content_all_check_box').on("click",function(){
        allcontentCheckClick();
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

  function goList()
  {
      location.href="/admin/academiAdm/homeworkList";
  }

  function alluserCheckClick()
  {
    if($('#user_all_check_box').is(":checked") == true ){
      $('input[name="user_seq[]"]').prop("checked",true);
    }else{
      $('input[name="user_seq[]"]').prop("checked",false);
    }
  }

  function allcontentCheckClick()
  {
    if($('#content_all_check_box').is(":checked") == true ){
      $('input[name="content_seq[]"]').prop("checked",true);
    }else{
      $('input[name="content_seq[]"]').prop("checked",false);
    }
  }

  function userListLoad()
  {
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#allocationForm').serialize();

    data[csrf_name] = csrf_val;


    $.ajax({
      type: "POST",
      url : "/admin/academiAdm/allocationUserList",
      data: data,
      dataType:"json",
      success : function(data, status, xhr) {
        var html = "";
        if(data.data.length>0){

          for(var i=0; i<data.data.length; i++){
            html += '<tr>';
            html += '<td class="text-center align-middle"><input type="checkbox" name="user_seq[]" value="'+data.data[i].user_seq+'"/></td>';
            html += '<td class="text-center align-middle">'+data.data[i].user_id+'</td>';
            html += '<td class="text-center align-middle">'+data.data[i].user_name+'</td>';
            html += '<td class="text-center align-middle">'+data.data[i].school_name+'</td>';
            html += '<td class="text-center align-middle">'+data.data[i].school_year+'</td>';
            html += '</tr>';
          }

        }else{
          html += '<tr><td colspan="5">검색된 회원이 없습니다.</td></tr>';
        }

        $('#userList').html(html);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function allocationProc()
  {
    var userBool = false;
    var contentBool = false;

    var homework_title = $('#homework_title').val();
    var final_date = $('#final_date').val();

    if(homework_title == ""){
      alert("제목을 입력해 주세요.");
      return;
    }

    if(studentArr.length <= 0){
      alert("배정할 학생을 선택해 주세요.");
      return;
    }

    if(contentArr.length <= 0){
      alert("배정할 음원을 선택해 주세요.");
      return;
    }

    if(final_date == ""){
      alert("마감일을 지정해 주세요.");
      return;
    }

    if(confirm("숙제를 배정 하시겠습니까?")){
      var csrf_name = $('#csrf').attr("name");
      var csrf_val = $('#csrf').val();

      var data = $('#allocationForm').serializeArray();

      data[csrf_name] = csrf_val;

      for(var i=0; i<contentArr.length; i++){
        data.push({"name":"content_seq[]","value":contentArr[i]});
      }
      for(var i=0; i<studentArr.length; i++){
        data.push({"name":"user_seq[]","value":studentArr[i]});
      }


      $.ajax({
        type: "POST",
        url : "/admin/academiAdm/allocationProc",
        data: data,
        dataType:"json",
        traditional : true,
        success : function(data, status, xhr) {
          console.log(data);
          if(data.result == "success"){
            alert("숙제배정이 완료 되었습니다.");
            location.href = "/admin/academiAdm/homeworkList";
          }else{
            alert("등록되지 않았습니다.");
            return;
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR.responseText);
        }
      });
    }


  }

  function addContentList($arr)
  {
    for(var i=0; i<$arr.length; i++){
      contentArr.push($arr[i]);
    }

    var set = new Set(contentArr);

    contentArr = [...set];

    addContent();


  }

  function addContent()
  {
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#allocationForm').serializeArray();

    data[csrf_name] = csrf_val;

    for(var i=0; i<contentArr.length; i++){
      data.push({"name":"content_seq[]","value":contentArr[i]});
    }


    $.ajax({
      type: "POST",
      url : "/admin/academiAdm/addContentList",
      data: data,
      dataType:"json",
      traditional : true,
      success : function(data, status, xhr) {
        console.log(data);
        var html = "";

        for(var i=0; i<data.data.length; i++){
          html += '<tr>';
          html += '<td class="text-center align-middle">'+data.data[i].content_title+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].content_code+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].track_no+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].content_category+'</td>';
          html += '<td class="text-center align-middle"><button type="button" class="btn btn-sm btn-warning" onclick="deleteContent(\''+data.data[i].content_seq+'\')">삭제</button></td>';
          html += '</tr>';
        }

          $('#contentList').html(html);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function deleteContent($content_seq)
  {
    var filtered = contentArr.filter((element)=>element !== $content_seq);
    contentArr = filtered;
    addContent();
  }

  function contentPop()
  {
    window.open("/admin/academiAdm/contentListPop","contentPop","width=800, height=700");
  }

  function addStudentList($arr)
  {
    console.log($arr);
    for(var i=0; i<$arr.length; i++){
      studentArr.push($arr[i]);
    }

    var set = new Set(studentArr);

    studentArr = [...set];

    addStudent();


  }

  function addStudent()
  {
    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var data = $('#allocationForm').serializeArray();

    data[csrf_name] = csrf_val;

    for(var i=0; i<studentArr.length; i++){
      data.push({"name":"student_seq[]","value":studentArr[i]});
    }


    $.ajax({
      type: "POST",
      url : "/admin/academiAdm/addStudentList",
      data: data,
      dataType:"json",
      traditional : true,
      success : function(data, status, xhr) {
        console.log(data);
        var html = "";

        for(var i=0; i<data.data.length; i++){
          html += '<tr>';
          html += '<td class="text-center align-middle">'+data.data[i].user_id+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].user_name+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].school_name+'</td>';
          html += '<td class="text-center align-middle">'+data.data[i].school_year+'</td>';
          html += '<td class="text-center align-middle"><button type="button" class="btn btn-sm btn-warning" onclick="deleteStudent(\''+data.data[i].user_seq+'\')">삭제</button></td>';
          html += '</tr>';
        }

          $('#userList').html(html);

      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });
  }

  function deleteStudent($user_seq)
  {
    var filtered = studentArr.filter((element)=>element !== $user_seq);
    studentArr = filtered;
    addStudent();
  }

  function studentPop()
  {
    window.open("/admin/academiAdm/studentListPop","contentPop","width=800, height=700");
  }
</script>
