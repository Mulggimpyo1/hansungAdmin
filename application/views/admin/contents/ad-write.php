<style>
.select2 {
  float:left!important;
}
.challenge_wrap .challenge_category{max-width:560px;padding:0 25px 25px}
.challenge_wrap .challenge_category li{margin-top:20px;list-style: none;}
.challenge_wrap .challenge_category li a{display:block;overflow:hidden;position:relative;border-radius:5px;box-shadow:0 0 10px rgba(0,0,0,0.15)}
.challenge_wrap .challenge_category li .thumb{height:125px}
.challenge_wrap .challenge_category li strong{position:absolute;right:15px;bottom:8px;font-size:18px;color:#000;line-height:22px;text-align:right;font-family:'Pretendard', 'Malgun Gothic', '맑은고딕', sans-serif;}
.challenge_wrap .list_challenge{margin-top:10px;padding-bottom:25px}
.challenge_wrap .list_challenge ul{border-top:1px solid #a0a0a0}
.challenge_wrap .list_challenge li{border-bottom:1px solid #a0a0a0}
.challenge_wrap .list_challenge li a{display:block;padding:25px;font-size:16px;color:#000;line-height:20px;}
.challenge_wrap .challenge_detail{margin-top:10px;padding-bottom:25px}
.challenge_wrap .challenge_detail .challenge_img{position:relative;padding-bottom:25px}
.challenge_wrap .challenge_detail .challenge_img .img img{width:100%}
.challenge_wrap .challenge_detail .swiper-pagination{bottom:0}
.challenge_wrap .challenge_detail .swiper-pagination-bullet{width:6px;height:6px;border:1px solid #0054a7;background:none;opacity:1}
.challenge_wrap .challenge_detail .swiper-pagination-bullet-active{background:#0054a7}
.challenge_wrap .challenge_detail .btn_challenge{display:block;height:33px;max-width:285px;margin:35px auto 0;border-radius:10px;background:#0054a7;font-size:14px;color:#fff;line-height:34px;text-align:center}
</style>
<!-- Ion Slider -->
<link rel="stylesheet" href="/css/ion.rangeSlider.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="/css/icheck-bootstrap.min.css">
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
  <form id="adForm">
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
                    <th class="text-left align-middle">광고명</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_title" name="adv_title"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">광고주</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_comp_name" name="adv_comp_name"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">광고주 프로필사진</th>
                    <td class="text-left align-middle">
                        <input type="file" id="adv_profile" name="adv_profile" class="form-control col-sm-2"/>
                        <small id="adv_profile_text"></small>
                        <input type="hidden" id="adv_profile_org" name="adv_profile_org"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle" style="background-color:#e9ecef" colspan="2">광고대상</th>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">지역</th>
                    <td class="text-left align-middle">
                      <select type="text" class="form-control col-sm-2 select2 float-left" name="adv_location" id="adv_location">
                        <option value="">전체</option>
                        {locationData}
                        <option value="{value}">{value}</option>
                        {/locationData}
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">기관</th>
                    <td class="text-left align-middle">
                      <button type="button" class="btn btn-block btn-default float-left col-sm-1" id="school_search_btn" style="margin-left:5px;" onclick="schoolFind()">검색</button>
                      <input type="checkbox" class="float-left" name="self_write" id="self_write" onclick="selfWrite()" value="Y" style="margin-top:12px;margin-left:5px; margin-right:5px;"/>
                      <label for="self_write" style="margin-top:6px;">전체</label>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">기관선택</th>
                    <td class="text-left align-middle" id='school_wrap'>

                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">나이</th>
                    <td class="text-left align-middle">
                      <div class="col-sm-2">
                        <input id="range_1" type="text" name="range_1" value="">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">성별</th>
                    <td class="text-left align-middle">
                      <div class="icheck-primary d-inline">
                        <input type="checkbox" id="adv_gender1" name="adv_gender[]" value="M">
                        <label for="adv_gender1">
                          남자
                        </label>
                      </div>
                      <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" id="adv_gender2" name="adv_gender[]" value="W">
                        <label for="adv_gender2">
                          여자
                        </label>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle" style="background-color:#e9ecef; height:50px" colspan="2"></th>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">총 노출횟수</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_total_view" name="adv_total_view"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">1일 최대 노출</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_day_view" name="adv_day_view"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">광고시작일</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left date" id="adv_start_date" name="adv_start_date" readonly/>
                    </td>
                  </tr>
                  <?php for($i=1;$i<=5;$i++){ ?>
                  <tr>
                    <th class="text-left align-middle">사진<?php echo $i; ?></th>
                    <td class="text-left align-middle">
                        <input type="file" id="adv_image<?php echo $i; ?>" name="adv_image<?php echo $i; ?>" class="form-control col-sm-2"/>
                        <small id="adv_image<?php echo $i; ?>_text"></small>
                        <input type="hidden" id="adv_image<?php echo $i; ?>_org" name="adv_image<?php echo $i; ?>_org"/>
                    </td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <th class="text-left align-middle">미리보기</th>
                    <td class="text-left align-middle">
                      <div class="challenge_wrap" style="width:300px;overflow:hidden;">
                        <div class="challenge_detail">
                          <div class="challenge_img">
                            <div class="swiper-container">
                              <div class="swiper-wrapper">
                                <?php for($i=1; $i<=5; $i++){ ?>
                                <div class="swiper-slide">
                                  <div class="img" id="preview_img<?php echo $i; ?>"><img src="/images/temp/main_content.png" alt=""></div>
                                </div>
                                <?php } ?>
                              </div>
                               <div class="swiper-pagination"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">링크명</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_link_name" name="adv_link_name"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">링크</th>
                    <td class="text-left align-middle">
                      <input type="text" class="form-control col-sm-2 float-left" id="adv_link" name="adv_link"/>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">내용</th>
                    <td class="text-left align-middle">
                      <textarea class="form-control col-sm-3 float-left" id="adv_content" name="adv_content"></textarea>
                    </td>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">메모</th>
                    <td class="text-left align-middle">
                      <textarea class="form-control col-sm-3 float-left" id="memo" name="memo"></textarea>
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
                      <button type="button" class="btn btn-primary float-left mr-3" onclick="writeAd()">등록</button>
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

<!-- Ion Slider -->
<script src="/js/ion.rangeSlider.min.js"></script>
<script src="/js/swiper-bundle.min.js"></script>
<script src="/js/jquery.slider.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/swiper-bundle.min.css">
<script>
var school_arr = [];
  $(function(){
    /* ION SLIDER */
    $('#range_1').ionRangeSlider({
      min     : 3,
      max     : 100,
      from    : 3,
      to      : 100,
      type    : 'double',
      step    : 1,
      prefix  : '나이 ',
      postfix : ' 살',
      prettify: false,
      hasGrid : true
    });

    new Swiper('.challenge_img .swiper-container', {
      slidesPerView: 1,
      observer: true,
      observeParents: true,
      pagination: {
        el: ".swiper-pagination",
      },
    });

    /* 미리보기 세팅 */
    for(var i=1; i<=5; i++){
      var imgDom = document.querySelector('#adv_image'+i);
      imgDom.addEventListener('change', (o) => {
        var num = o.target.id.substr(9,o.target.id.length-1);
        var src = URL.createObjectURL(document.querySelector('#adv_image'+num).files[0]);
        var previewImg = document.querySelector('#preview_img'+num+' img');
        previewImg.src = src;
      });
    }

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

  function schoolFind()
  {
    window.open("/admin/schoolAdm/schoolOrgSearchPop","contractPop","width=470, height=500");
  }

  function choiceSchool(data)
  {
    var school_name = data.school_name;
    var school_seq = data.school_seq;

    school_arr.push(data);

    addSchool();

    /*
    $('#school_name').val(school_name);
    $('#school_seq').val(school_seq);
    */
  }

  function goList()
  {
      location.href="/admin/contentAdm/adList{param}";
  }

  function writeAd()
  {
    var adv_title = $('#adv_title').val();
    var adv_comp_name = $('#adv_comp_name').val();
    var adv_total_view = $('#adv_total_view').val();
    var adv_day_view = $('#adv_day_view').val();
    var adv_start_date = $('#adv_start_date').val();
    var adv_end_date = $('#adv_end_date').val();

    var adv_image1 = $('#adv_image1').val();
    var adv_content = $('#adv_content').val();

    var adv_profile = $('#adv_profile').val();


    if(adv_title == ""){
      alert("제목을 입력해주세요.");
      return;
    }
    if(adv_comp_name == ""){
      alert("광고주를 입력해주세요.");
      return;
    }
    if(adv_profile == ""){
      alert("광고주 프로필사진을 등록해주세요.");
      return;
    }
    if(adv_total_view == ""){
      alert("총 노출횟수를 입력해주세요.");
      return;
    }
    if(adv_day_view == ""){
      alert("1일 최대노출을 입력해주세요.");
      return;
    }
    if(adv_start_date == ""){
      alert("광고시작일을 입력해주세요.");
      return;
    }

    if(adv_image1 == ""){
      alert("이미지는 최소 1개이상 올려야 합니다.");
      return;
    }
    if(adv_content == ""){
      alert("내용을 입력해주세요.");
      return;
    }

    var csrf_name = $('#csrf').attr("name");
    var csrf_val = $('#csrf').val();

    var form = $('#adForm')[0];
    var formData = new FormData($('#adForm')[0]);
    try{
      for(var i = 1; i<=5; i++){
        formData.append("adv_image"+i,$("#adv_image"+i)[0].files[0]);
      }
      formData.append("adv_profile",$("#adv_profile")[0].files[0]);
    }catch(e){
      console.log(e);
    }

    formData.append("schoolArr",JSON.stringify(school_arr));

    formData.append(csrf_name,csrf_val);

    loadView('Y');

    $.ajax({
      type: "POST",
      url : "/admin/contentAdm/adWriteProc",
      data: formData,
      dataType:"json",
      processData: false,
      contentType: false,
      success : function(data, status, xhr) {
        loadView('N');
        if( data.result == "success" ){
          alert("등록 되었습니다.");
          location.href = "/admin/contentAdm/adList{param}";
        } else {
          alert("오류발생!!");
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR.responseText);
      }
    });

  }

  function addSchool()
  {
    var html = '';
    for(var i=0; i<school_arr.length; i++){
      html += '<small style="float:left;margin-left:5px;" id="school_'+school_arr[i].school_seq+'"><a href="javascript:deleteSchool(\''+school_arr[i].school_seq+'\')">'+school_arr[i].school_name+' x</a></small>';
    }
    $('#school_wrap').html(html);
  }

  function deleteSchool($school_seq)
  {
    school_arr.forEach((item, index)=> {
  		if(item.school_seq == $school_seq) {
  		    school_arr.splice(index, 1);
        }
		});

    addSchool();
  }

  function selfWrite()
  {
    var self_write = $('#self_write').is(":checked");
    if(self_write){
      $('#school_search_btn').hide();
    }else{
      $('#school_search_btn').show();
    }
  }
</script>
