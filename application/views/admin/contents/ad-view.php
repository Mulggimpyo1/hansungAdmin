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
<!-- Content Wrapper. Contains page content -->
<input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
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
        <div class="col-2">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <div class="container" style="padding:10px 10px 10px 10px; min-height:300px;">
                <div class="challenge_wrap" style="width:100%;overflow:hidden;">
                  <div class="challenge_detail">
                    <div class="challenge_img">
                      <div class="swiper-container">
                        <div class="swiper-wrapper">
                          <?php for($i=0; $i<count($adData['img']); $i++){ ?>
                          <div class="swiper-slide">
                            <div class="img" ><img src="/upload/ad/<?php echo $adData['img'][$i] ?>" alt=""></div>
                          </div>
                          <?php } ?>
                        </div>
                         <div class="swiper-pagination"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="text" class="form-control" value="<?php echo $adData['adv_title']; ?>" readonly/>
                <textarea class="form-control" readonly><?php echo $adData['adv_content']; ?></textarea>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>

        <div class="col-8">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table">
                  <colgroup>
                    <col width="50%"/>
                    <col width="50%"/>
                  </colgroup>
                  <tbody>
                    <tr>
                      <td class="text-left align-middle">
                        <canvas id="lineChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                      </td>
                      <td class="text-left align-middle">
                        <table class="table">
                          <colgroup>
                            <col width="50%"/>
                            <col width="50%"/>
                          </colgroup>
                          <tbody>
                            <tr>
                              <th class="text-center align-middle">TOTAL</th>
                              <th class="text-right align-middle"><?php echo number_format($viewTotal); ?>/<?php echo number_format($adData['adv_total_view']) ?></th>
                            </tr>
                            <tr>
                              <th class="text-center align-middle">노출</th>
                              <th class="text-right align-middle"><?php echo number_format($viewTotal); ?></th>
                            </tr>
                            <tr>
                              <th class="text-center align-middle">링크방문</th>
                              <th class="text-right align-middle"><?php echo number_format($linkTotal); ?></th>
                            </tr>
                            <tr>
                              <th class="text-center align-middle">좋아요</th>
                              <th class="text-right align-middle"><?php echo number_format($likeTotal); ?></th>
                            </tr>
                            <tr>
                              <th class="text-center align-middle">댓글</th>
                              <th class="text-right align-middle"><?php echo number_format($commentTotal); ?></th>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td class="text-left align-middle">
                        <table class="table">
                          <colgroup>
                            <col width="40%"/>
                            <col width="20%"/>
                            <col width="20%"/>
                            <col width="20%"/>
                          </colgroup>
                          <tbody>
                            <tr>
                              <th class="text-center align-middle">일시</th>
                              <th class="text-right align-middle">좋아요</th>
                              <th class="text-right align-middle">노출</th>
                              <th class="text-right align-middle">방문</th>
                            </tr>
                            <?php for($i=0; $i<count($allViewData); $i++){ ?>
                            <tr>
                              <th class="text-center align-middle"><?php echo $allViewData[$i]['reg_date']; ?></th>
                              <th class="text-right align-middle"><?php echo number_format($allViewData[$i]['like_total']); ?></th>
                              <th class="text-right align-middle"><?php echo number_format($allViewData[$i]['view_total']); ?></th>
                              <th class="text-right align-middle"><?php echo number_format($allViewData[$i]['link_total']); ?></th>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </td>
                      <td class="text-left">
                        <div class="card card-primary card-outline card-outline-tabs">
                          <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">지역별</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">학교별</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">성별</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">나이별</a>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                              <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <table class="table">
                                  <colgroup>
                                    <col width="10%"/>
                                    <col/>
                                    <col width="30%"/>
                                  </colgroup>
                                  <tbody>
                                    <?php for($i=0; $i<count($locationViewData); $i++){ ?>
                                    <tr>
                                      <th class="text-center align-middle"><?php echo ($i+1); ?>.</th>
                                      <th class="text-center align-middle"><?php echo $locationViewData[$i]['location']; ?></th>
                                      <th class="text-right align-middle"><?php echo number_format($locationViewData[$i]['view_total']); ?></th>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <table class="table">
                                  <colgroup>
                                    <col width="10%"/>
                                    <col/>
                                    <col width="30%"/>
                                  </colgroup>
                                  <tbody>
                                    <?php for($i=0; $i<count($schoolViewData); $i++){ ?>
                                    <tr>
                                      <th class="text-center align-middle"><?php echo ($i+1); ?>.</th>
                                      <th class="text-center align-middle"><?php echo $schoolViewData[$i]['school_name']; ?></th>
                                      <th class="text-right align-middle"><?php echo number_format($schoolViewData[$i]['view_total']); ?></th>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <table class="table">
                                  <colgroup>
                                    <col width="10%"/>
                                    <col/>
                                    <col width="30%"/>
                                  </colgroup>
                                  <tbody>
                                    <?php for($i=0; $i<count($genderViewData); $i++){ ?>
                                    <tr>
                                      <th class="text-center align-middle"><?php echo ($i+1); ?>.</th>
                                      <th class="text-center align-middle"><?php echo $genderViewData[$i]['gender']=="M"?"남자":"여자"; ?></th>
                                      <th class="text-right align-middle"><?php echo number_format($genderViewData[$i]['view_total']); ?></th>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                <table class="table">
                                  <colgroup>
                                    <col width="10%"/>
                                    <col/>
                                    <col width="30%"/>
                                  </colgroup>
                                  <tbody>
                                    <?php for($i=0; $i<count($ageViewData); $i++){ ?>
                                    <tr>
                                      <th class="text-center align-middle"><?php echo ($i+1); ?>.</th>
                                      <th class="text-center align-middle"><?php echo $ageViewData[$i]['age']; ?>살</th>
                                      <th class="text-right align-middle"><?php echo number_format($ageViewData[$i]['view_total']); ?></th>
                                    </tr>
                                    <?php } ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <!-- /.card -->
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              <!-- /.card -->
              <button type="button" class="btn btn-primary float-right mr-4 mb-4" onclick="goList()">목록</button>
            </div>
          </div>
        </div>

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<script src="/js/swiper-bundle.min.js"></script>
<script src="/js/jquery.slider.min.js"></script>
<!-- ChartJS -->
<script src="/js/Chart.min.js"></script>

<link rel="stylesheet" type="text/css" href="/css/swiper-bundle.min.css">

<script>
$(function(){
  loadData();
  new Swiper('.challenge_img .swiper-container', {
    slidesPerView: 1,
    observer: true,
    observeParents: true,
    pagination: {
      el: ".swiper-pagination",
    },
  });



});

function goList()
{
  location.href = "/admin/contentAdm/adList{param}";
}

function loadData()
{
  var csrf_name = $('#csrf').attr("name");
  var csrf_val = $('#csrf').val();

  var formData = {
    "adv_seq" : "{adv_seq}"
  };

  formData[csrf_name] = csrf_val;

  $.ajax({
    type: "POST",
    url : "/admin/contentAdm/getAdViewGraph",
    data: formData,
    dataType:"json",
    success : function(data, status, xhr) {
        var xArray = data.data.label;

        var yArray = data.data.data;

        var lineChartCanvas = $('#lineChart').get(0).getContext('2d');
        var myLineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: {
                // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                labels: xArray,

                datasets: [
                    {
                        label: "노출",
                        lineTension: 0.1,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 1,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 1,
                        pointBorderWidth: 1,
                        // data: [0, 10000, 5000, 15000, 10000, 20000, 15000, 0, null, 30000, 25000, 30000],
                        data: yArray,
                        fill: false
                    }
                ]
            },
            options: {
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart
                                .datasets[tooltipItem.datasetIndex]
                                .label || '';
                            return '노출' + ': ' + tooltipItem.yLabel;
                        }
                    }
                }
            }
        });

    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(jqXHR.responseText);
    }
  });
}


</script>
