<div class="fixed-top text-center" style="background-color:#fff;border-bottom:1px solid #f0f0f0;">
  <h3><?php echo $client_name; ?></h3>
</div>
<div class="text-center" style="margin-top:60px;">
  <select id="year" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" onchange="changeYear();">
    <?php for($i=2016; $i<=date("Y"); $i++){ ?>
    <option value="<?php echo $i ?>" <?php echo $i == $year ? "selected" : "" ?>><?php echo $i."년"; ?></option>
    <?php } ?>
  </select>
  <select id="month" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" onchange="changeMonth();">
    <?php for($i=1; $i<=12; $i++){ ?>
      <?php

      if($i < 10){
        $_month = "0".$i;
      }else{
        $_month = $i;
      }
       ?>
    <option value="<?php echo $_month ?>" <?php echo $_month == $month ? "selected":""; ?>><?php echo $_month."월"; ?></option>
    <?php } ?>
  </select>
</div>
<div class="text-center">

    <span class="btn btn-<?php echo $status=="all" ?"":"outline-"; ?>dark btn-sm" onclick="changeStatus('all')">전체</span>
    <span class="btn btn-<?php echo $status=="R" ?"":"outline-"; ?>secondary btn-sm" onclick="changeStatus('R')">작업대기</span>
    <span class="btn btn-<?php echo $status=="P" ?"":"outline-"; ?>primary btn-sm" onclick="changeStatus('P')">작업중</span>
    <span class="btn btn-<?php echo $status=="C" ?"":"outline-"; ?>danger btn-sm" onclick="changeStatus('C')">작업완료</span>
    <span class="btn btn-<?php echo $status=="Q" ?"":"outline-"; ?>warning btn-sm" onclick="changeStatus('Q')">납품완료</span>



</div>
<?php for($i=0; $i<count($partnerList); $i++){ ?>
<div class="card" style="margin:15px;">
  <h5 class="card-header"><?php echo $partnerList[$i]['product_name'] ?></h5>
  <div class="card-body">
    <h5 class="cart-title" style="color:red;">작업내용: <?php echo $partnerList[$i]['content'] ?></h5>
    <h5 class="card-title">정매: <?php echo number_format($partnerList[$i]['amount']) ?><br>작업수량:
      <?php
        $real_amount = 0;

        if($partnerList[$i]['work_amount2'] > 2){
          $real_amount = number_format($partnerList[$i]['work_amount'])." x ".$partnerList[$i]['work_amount2'];
        }else{
          $real_amount = number_format($partnerList[$i]['work_amount']);
        }
        echo $real_amount;
      ?>
    </h5>
    <p class="card-text" style="clear:both;"></p>
    <p class="card-text">등록일 : <?php echo $partnerList[$i]['reg_date']; ?></p>
    <?php if($partnerList[$i]['status']=="R"){ ?>
      <span class="btn btn-secondary">작업대기</span>
    <?php }else if($partnerList[$i]['status']=="P"){ ?>
      <span class="btn btn-primary">작업중</span>
    <?php }else if($partnerList[$i]['status']=="C"){ ?>
      <span class="btn btn-danger">작업완료</span>
    <?php }else if($partnerList[$i]['status']=="Q"){ ?>
      <span class="btn btn-warning">납품완료</span>
    <?php } ?>
  </div>
  <div class="card-footer text-muted">
    수정일 : <?php echo $partnerList[$i]['mod_date']; ?>
  </div>
</div>
<?php } ?>

<script>
var status = "{status}";
var year = "{year}";
var month = "{month}";

function changeYear()
{
  var r_year = $('#year').val();

  location.href = "/partner/list?year="+r_year+"&month={month}&status={status}";
}

function changeMonth()
{
  var r_month = $('#month').val();

  location.href = "/partner/list?year={year}&month="+r_month+"&status={status}";
}

function changeStatus($status)
{
  location.href = "/partner/list?year={year}&month=&status="+$status+"";
}
</script>
