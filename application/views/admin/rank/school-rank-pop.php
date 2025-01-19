
<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>랭킹상세</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <form id="contractForm" onsubmit="return false;">
    <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <table class="table table-hover">
              <colgroup>
                <col width="50%"/>
                <col width="50%"/>
              </colgroup>
              <tbody id="contract_body">
                <tr>
                  <th class="text-center align-middle" rowspan="3">
                    <?php if(empty($rankData['logo_image'])){ ?>
                    <img src="/images/common/user.png" width="100"/>
                  <?php }else{ ?>
                    <img src="/upload/school/<?php echo $rankData['logo_image'] ?>" width="100"/>
                  <?php } ?>
                  </th>
                  <td class="text-left align-middle">기관명 : <?php echo $rankData['school_name']; ?></td>
                </tr>
                <tr>
                  <td class="text-left align-middle">학급 수 : <?php echo $rankData['total_class']; ?></td>
                </tr>
                <tr>
                  <td class="text-left align-middle">학생 수 : <?php echo $rankData['total_user']; ?></td>
                </tr>
                <tr>
                  <th class="text-left align-middle" colspan="2">
                    <?php
                    $yearMonth = "";
                    if($year!="all"){
                      $yearMonth .= $year."년 ";
                    }
                    if($month!="all"){
                      $yearMonth .= $month."월 ";
                    }

                    if($year=="all" && $month=="all"){
                      $yearMonth = "전체";
                    }
                    echo "기간 : ".$yearMonth;
                    ?>
                  </th>
                </tr>
              </tbody>
            </table>
            </div>
            <!-- /.card-body -->
            <div class="card">
              <!-- /.card-header -->
              <table class="table table-hover">
                <colgroup>
                  <col width="30%"/>
                  <col width="80%"/>
                </colgroup>
                <tbody id="contract_body">
                  <tr>
                    <th class="text-left align-middle">총 탄소 절감량</th>
                    <th class="text-left align-middle"><?php echo $rankData['carbon_point']."kg"; ?></th>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">1인 평균</th>
                    <th class="text-left align-middle"><?php echo $rankData['point_average']."kg"; ?></th>
                  </tr>
                  <tr>
                    <th class="text-left align-middle">피드 업로드 수</th>
                    <th class="text-left align-middle"><?php echo $rankData['total_feed']."건"; ?></th>
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
<script>

</script>
