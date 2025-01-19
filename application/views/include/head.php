<!DOCTYPE html>
<html lang="ko">
<head>
  <title>저탄소스쿨</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
  <meta name="format-detection" content="telephone=no, address=no, email=no">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="/css/swiper-bundle.min.css">
  <!--<link rel="stylesheet" type="text/css" href="/css/ui.css?version=<?php echo date("YmdHis");?>">-->
  <link rel="stylesheet" type="text/css" href="/css/ui.css">
  <script src="/js/jquery-3.6.0.min.js"></script>
  <script src="/js/jquery.slider.min.js"></script>
  <script src="/js/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!--<script src="/js/ui.js?version=<?php echo date("YmdHis");?>"></script>-->
  <script src="/js/ui.js"></script>
  <meta property="og:url" content="<?php echo $og_url; ?>">
  <meta property="og:title" content="<?php echo $og_title; ?>">
  <meta property="og:type" content="website">
  <meta property="og:image" content="<?php echo $og_image; ?>">
  <meta property="og:description" content="<?php echo $og_desc; ?>">
</head>
<body>
  <input type="hidden" id="csrf" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>"/>
<?php if($is_main=="true"){ ?><div id="wrap"><?php } ?>
