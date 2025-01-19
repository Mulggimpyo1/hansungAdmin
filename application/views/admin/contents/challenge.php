<style>
.jstree i{
  color : green;
}
.item{
  padding: .5em;
}
.jstree-node{
  font-size:20px;
}
.jstree-default a {
    white-space:normal !important; height: 30px;
}
.jstree-anchor {
    height: 30px !important;
}
.jstree-default li > ins {
    vertical-align:top;
}
.jstree-leaf {
    height: 30px;
}
.jstree-leaf a{
  height: 30px !important;
}

.challenge_wrap .challenge_category{max-width:700px;padding:0 25px 25px}
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
        <div class="col-3">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <div class="container" style="padding:10px 10px 10px 10px; min-height:300px;">
                <div class="float-left" id="challenge_tree">
                </div>
                <div class="float-right">
                  <button class="btn btn-block btn-default float-left mr-3 mb-2" style="clear:both;float:left;" id="save_btn">저장</button>
                  <button class="btn btn-block btn-default float-left mr-3 mb-2" style="clear:both;float:left;" id="d1_add_btn">대메뉴 추가</button>
                  <button class="btn btn-block btn-default float-left mr-3 mb-2" style="clear:both;float:left;" id="d2_add_btn">소메뉴 추가</button>
                  <button class="btn btn-block btn-default float-left mr-3 mb-2" style="clear:both;float:left;" id="modi_btn">수정</button>
                  <button class="btn btn-block btn-default float-left mr-3 mb-2" style="clear:both;float:left;" id="del_btn">삭제</button>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>

        <div class="col-9">
          <form id="challengeForm">
            <input type="hidden" name="challenge_seq" id="challenge_seq"/>
            <input type="hidden" name="depth" id="depth"/>
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" id="depth1_table" style="display:none;">
                <table class="table">
                  <colgroup>
                    <col width="10%"/>
                    <col/>
                  </colgroup>
                  <tbody>
                    <tr>
                      <th class="text-left align-middle">챌린지명</th>
                      <td class="text-left align-middle">
                        <input type="text" class="form-control col-sm-2 float-left" id="challenge_title" name="challenge_title" onkeyup="changeTitle()"/>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">썸네일</th>
                      <td class="text-left align-middle">
                        <input type="file" class="form-control col-sm-2" name="challenge_thumb" id="challenge_thumb">
                        <small id="challenge_thumb_text"></small>
                        <input type="hidden" class="form-control col-sm-2" name="challenge_thumb_org" id="challenge_thumb_org">
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">아이콘</th>
                      <td class="text-left align-middle">
                        <input type="file" class="form-control col-sm-2" name="challenge_icon" id="challenge_icon">
                        <small id="challenge_icon_text"></small>
                        <input type="hidden" class="form-control col-sm-2" name="challenge_icon_org" id="challenge_icon_org">
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">미리보기</th>
                      <td class="text-left align-middle">
                        <div class="challenge_wrap">
	                       <div class="challenge_category" style="padding-left:0px;">
                            <ul style="padding-left:0px;">
                    					<li>
                    						<a href="#">
                    							<img src="/images/challenge/challenge_menu1.jpg" class="thumb" id="preview_img" alt="">
                    							<strong><span id="preview_text">줍깅(플로깅)</span><br>챌린지</strong>
                    						</a>
                    					</li>
                    				</ul>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle" colspan="2"><button type="button" class="btn btn-primary float-left mr-3 mb-2" style="clear:both;float:left;" onclick="saveChallenge()" >저장</button></th>
                  </tbody>
                </table>
              <!-- /.card -->
            </div>

            <div class="card-body table-responsive p-0" id="depth2_table" style="display:none;">
                <table class="table">
                  <colgroup>
                    <col width="10%"/>
                    <col/>
                  </colgroup>
                  <tbody>
                    <tr>
                      <th class="text-left align-middle">챌린지명</th>
                      <td class="text-left align-middle">
                        <h1 id="parent_title"></h1>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">하위 챌린지명</th>
                      <td class="text-left align-middle">
                        <input type="text" class="form-control col-sm-2 float-left" id="challenge_title_2" name="challenge_title_2"/>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">게시물당 절감 탄소량</th>
                      <td class="text-left align-middle">
                        <input type="text" class="form-control col-sm-1 float-left" id="challenge_carbon_point" name="challenge_carbon_point"/>
                        <span class="float-left ml-3 mt-2">Kg</span>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">작성제한일</th>
                      <td class="text-left align-middle">
                        <input type="text" class="form-control col-sm-1 float-left" id="limit_day" name="limit_day" value="0"/>
                        <span class="float-left ml-3 mt-2">일</span>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">필수동의텍스트</th>
                      <td class="text-left align-middle">
                        <input type="text" class="form-control col-sm-4 float-left" id="agree_text" name="agree_text"/>
                      </td>
                    </tr>
                    <tr>
                      <th class="text-left align-middle">정보</th>
                      <td class="text-left align-middle">
                        size 300px x 300px
                      </td>
                    </tr>
                    <?php for($i=1;$i<=10;$i++){ ?>
                    <tr>
                      <th class="text-left align-middle"><?php echo $i; ?></th>
                      <td class="text-left align-middle">
                          <input type="file" id="image<?php echo $i; ?>" name="image<?php echo $i; ?>" class="form-control col-sm-2"/>
                          <small id="image<?php echo $i; ?>_text"></small>
                          <input type="hidden" id="image<?php echo $i; ?>_org" name="image<?php echo $i; ?>_org"/>
                          <button type="button" class="btn btn-sm btn-danger" id="image<?php echo $i; ?>_del" style="display:none;" onclick="delImg('<?php echo $i ?>')">삭제</button>
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
                                  <?php for($i=1; $i<=10; $i++){ ?>
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
                      <th class="text-left align-middle" colspan="2"><button type="button" class="btn btn-primary float-left mr-3 mb-2" style="clear:both;float:left;" onclick="saveChallenge()" >저장</button></th>
                  </tbody>
                </table>
              <!-- /.card -->
            </div>


          </div>
          </form>
        </div>

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<script src="https://kit.fontawesome.com/ab06f23d17.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
<script src="/js/swiper-bundle.min.js"></script>
<script src="/js/jquery.slider.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/swiper-bundle.min.css">
<script>
var total_count = 0;
var first_data = [];
var del_seq = [];

var fileDOM = document.querySelector('#challenge_thumb');
var preview = document.querySelector('#preview_img');



function changeTitle()
{
  var txt = $('#challenge_title').val();
  $('#preview_text').text(txt);
}

function treeLoad($data)
{
  $('#challenge_tree').jstree({
    'core' : {
    'data' : $data,
    "check_callback" : true
  },
  "plugins" : ["dnd","types"],
  "types" : {
    "#" : {
      "max_depth" : 2,
      "valid_children" : ["root"]
    },
    "root" : {
      "icon":"fa-solid fa-leaf",
      "valid_children" : ["default","file"]
    },
    "default" : {
      "valid_children" : ["default","file"]
    },
    "file" : {
      "icon":"fa-solid fa-bolt",
      "valid_children" : []
    }
  }
  })
  .bind('loaded.jstree', function(evt, data) {
    //로딩
    $('#challenge_tree').jstree("open_all");
    //$('#challenge_tree').jstree(true).select_node($data[0].id);
    if("<?php echo $this->input->get("id") ?>"!=""){
      $('#challenge_tree').jstree(true).select_node('<?php echo $this->input->get("id") ?>');
    }else{
      $('#challenge_tree').jstree(true).select_node('c1');
    }


  })
  .bind('move_node.jstree', function(evt,data){
    //이동
    var org_parent = data.old_parent;
    var new_parent = data.parent;

    if(org_parent != '#' && new_parent == '#'){
      alert('1차 카테고리로 이동할 수 없습니다.');
      $('#challenge_tree').jstree(true).refresh(true);
    }
    //console.log($('#tree').jstree(true).get_json('#',{flat:true}));

    $('#challenge_tree').jstree(true).open_node(new_parent);
    return true;
  })
  .bind('rename_node.jstree',function(evt,data){
    //수정
  })
  .bind('create_node.jstree',function(evt,data){
    //생성
  })
}

$(function(){
  new Swiper('.challenge_img .swiper-container', {
    slidesPerView: 1,
    observer: true,
    observeParents: true,
    pagination: {
      el: ".swiper-pagination",
    },
  });

  changeTitle();

  fileDOM.addEventListener('change', () => {
    const imageSrc = URL.createObjectURL(fileDOM.files[0]);
    preview.src = imageSrc;
  });

  /* 미리보기 세팅 */
  for(var i=1; i<=10; i++){
    var imgDom = document.querySelector('#image'+i);
    imgDom.addEventListener('change', (o) => {
      var num = o.target.id.substr(5,o.target.id.length-1);
      var src = URL.createObjectURL(document.querySelector('#image'+num).files[0]);
      var previewImg = document.querySelector('#preview_img'+num+' img');
      previewImg.src = src;
    });
  }

  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {};

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url: "/admin/contentAdm/loadCategory",
    data: data,
    dataType:"json",
  }).done(function(o) {
    if(o.length>0){
      var obj = JSON.parse(JSON.stringify(o));

      const maxObjArr = obj.reduce( (prev, value) => {
        return Number(prev.id.substr(1)) >= Number(value.id.substr(1)) ? prev : value
      });

      total_count = Number(maxObjArr.id.substr(1));

    }else{
      total_count = 0;
    }

    treeLoad(o);




  });


});

$('#d1_add_btn').on("click",function(){
  var id = 'c'+(total_count+1);
  total_count++;
  var new_node = { "id" : id, "parent" : "#", "type" : "root", "icon":"fa-solid fa-leaf" };
  $('#challenge_tree').jstree(true).create_node('#',new_node,"last");
  $('#challenge_tree').jstree('edit',id);
  console.log($('#challenge_tree').jstree(true).get_json('#',{flat:true}));

});

$('#d2_add_btn').on("click",function(){
  var node = $('#challenge_tree').jstree('get_selected',true);
  if(node.length == 0 || node[0].parent != '#'){
    alert("대메뉴를 선택해 주세요.");
    return;
  }

  var new_id = 'c'+(total_count+1);
  total_count++;
  var new_node = { "id" : new_id, "parent" : node[0].id, type:"file","icon":"fa-solid fa-bolt" };
  $('#challenge_tree').jstree(true).create_node(node[0].id,new_node,"last");
  $('#challenge_tree').jstree('edit',new_id);

});

$('#modi_btn').on("click",function(){
  var node = $('#challenge_tree').jstree('get_selected',true);
  $('#challenge_tree').jstree('edit',node[0].id);

});

$('#del_btn').on("click",function(){
  var node = $('#challenge_tree').jstree('get_selected',true);
  if(node[0].parent == "#"){
    if(!confirm("하위카테고리도 삭제됩니다. 삭제하시겠습니까?")){
      return;
    }
  }

  if(node[0].data){
    del_seq.push(node[0].data.challenge_seq);
  }



  $('#challenge_tree').jstree(true).delete_node(node[0].id);
  saveCategory($('#challenge_tree').jstree(true).get_json('#', {flat:true}));
});

//노드선택
$('#challenge_tree').bind('select_node.jstree', function(evt, data,x ) {
  var _id = data.node.id;
  choice_id = _id;
  loadChallengeNode(_id);
});


$('#save_btn').on("click",function(){
  saveCategory($('#challenge_tree').jstree(true).get_json('#', {flat:true}));

  //console.log( $('#challenge_tree').jstree(true).get_json('#', {flat:true}));
});
var choice_id = "";

//load 내용
function loadChallengeNode($id)
{
  $('#depth1_table').hide();
  $('#depth2_table').hide();
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {
    "id" : $id
  };

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url: "/admin/contentAdm/loadChallengeNode",
    data: data,
    dataType:"json",
  }).done(function(o) {

      if(o.result == "success"){
        $('#challenge_seq').val(o.data.challenge_seq);
        $('#depth').val(o.data.challenge_depth);
        if(o.data.challenge_depth == 1){
          //cate 1
          var challenge_title = o.data.challenge_title;
          var challenge_thumb = o.data.challenge_thumb;
          var challenge_icon = o.data.challenge_icon;
          if(challenge_thumb != "" && challenge_thumb != null){
            $('#challenge_thumb_org').val(challenge_thumb);
            $('#preview_img').attr("src","/upload/challenge/"+challenge_thumb);
            $('#challenge_thumb_text').text(challenge_thumb);
          }else{
            $('#preview_img').attr("src","/images/temp/main_content.png");
            $('#challenge_thumb_text').text("");
          }
          if(challenge_icon != "" && challenge_icon != null){
            $('#challenge_icon_org').val(challenge_icon);
            $('#challenge_icon_text').text(challenge_icon);
          }else{
            $('#challenge_icon_text').text("");
          }
          $('#challenge_title').val(challenge_title);
          $('#preview_text').text(challenge_title);
          $('#depth1_table').show();

        }else{
          //cate 2
          var parent_title = o.data.parent_title;
          var challenge_title = o.data.challenge_title;
          var challenge_carbon_point = o.data.challenge_carbon_point;
          var agree_text = o.data.agree_text;
          var limit_day = o.data.limit_day;
          for(var i = 1; i<=10; i++){

            if( o.data['image'+i] != "" && o.data['image'+i] != null){
              $('#image'+i+'_org').val(o.data['image'+i]);
              $('#image'+i+'_text').text(o.data['image'+i]);
              $('#preview_img'+i+' img').attr("src","/upload/challenge/"+o.data['image'+i]);
              $('#image'+i+'_del').show();
            }else{
              $('#preview_img'+i+' img').attr("src","/images/temp/main_content.png");
              $('#image'+i+'_text').text("");
              $('#image'+i+'_del').hide();
            }
          }

          $('#challenge_title_2').val(challenge_title);
          $('#parent_title').text(parent_title);
          $('#challenge_carbon_point').val(challenge_carbon_point);
          $('#agree_text').val(agree_text);
          $('#limit_day').val(limit_day);

          $('#depth2_table').show();
        }
      }
  });
}

function delImg($i)
{
  $('#image'+$i+'_del').hide();
  $('#image'+$i+'_org').val("");
  $('#image'+$i+'_text').text("");
  alert("삭제되었습니다.\n저장을 누르셔야 적용됩니다.");
}

function saveCategory($json)
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var data = {
    "cate" : $json,
    "del"  : del_seq
  };

  data[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url: "/admin/contentAdm/saveCategory",
    data: data,
    dataType:"json",
  }).done(function(o) {
    if(o.result=="success"){
      alert("저장되었습니다.");
    }else{
      alert("챌린지 제목은 최대 20자입니다");
    }

      location.reload();
  });
}

function saveChallenge()
{
  var depth = $('#depth').val();
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var form = $('#challengeForm')[0];
  var formData = new FormData($('#challengeForm')[0]);


  if(depth == 1){
    var challenge_thumb = $('#challenge_thumb').val();
    var challenge_thumb_org = $('#challenge_thumb_org').val();
    if(challenge_thumb==""&&challenge_thumb_org==""){
      alert("썸네일을 작성해주세요.");
      return false;
    }

    var challenge_icon = $('#challenge_icon').val();
    var challenge_icon_org = $('#challenge_icon_org').val();
    if(challenge_icon==""&&challenge_icon_org==""){
      alert("아이콘을 작성해주세요.");
      return false;
    }

    try{
      formData.append("challenge_thumb",$("#challenge_thumb")[0].files[0]);
      formData.append("challenge_icon",$("#challenge_icon")[0].files[0]);
    }catch(e){
      console.log(e);
    }

  }else{
    var challenge_title = $('#challenge_title_2').val();
    var agree_text = $('#agree_text').val();
    if(challenge_title == ""){
      alert("하위 챌린지명을 입력해주세요.");
      return false;
    }
    if(agree_text == ""){
      alert("필수동의 텍스트를 작성해주세요.");
      return false;
    }
    try{
      for(var i = 1; i<=10; i++){
        formData.append("image"+i,$("#image"+i)[0].files[0]);
      }

    }catch(e){
      console.log(e);
    }
  }

  formData.append(csrf_name,csrf_val);

  $.ajax({
    type: "POST",
    url : "/admin/contentAdm/saveChallengeProc",
    data: formData,
    dataType:"json",
    processData: false,
    contentType: false,
    success : function(data, status, xhr) {
      if(data.result=="success"){
        alert("저장되었습니다.");
        location.href="/admin/contentAdm/challenge?id="+choice_id;
      }else{
        alert("챌린지 제목은 최대 20자입니다");
      }

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}


</script>
