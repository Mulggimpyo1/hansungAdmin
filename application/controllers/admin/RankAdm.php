<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RankAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("member_model");
    $this->load->model("content_model");
		$this->load->model("school_model");
		$this->load->model("config_model");
		$this->load->model("rank_model");
		$uri = explode("/",uri_string());
		// login Check
    if( !$this->session->userdata("admin_id") ){
      if( $uri[count($uri)-1] != "login" && $uri[count($uri)-1] != "login_proc" ){
        //$this->msg("로그인 해주시기 바랍니다.");
        $this->goURL(base_url("admin/login"));
        exit;
      }
		}


	}

	public function index()
	{
		//login page redirect
		if( !$this->session->userdata("admin_id") ){
			$this->goURL("/admin");
		}else{
			$this->rankList();
		}

	}

  //개인랭크 리스트
	public function rankList()
	{
		$depth1 = "admin";
		$depth2 = "rankList";
		$title = "개인랭크 리스트";
		$sub_title = "개인랭크 리스트";

		$num = $this->input->get('num');
    $srcN = $this->input->get('srcN');
    $year = $this->input->get('year');
    $month = $this->input->get('month');
    $school_seq = $this->input->get('school_seq');
    $school_year = $this->input->get('school_year');
    $school_class = $this->input->get('school_class');

		$page_size = $this->input->get('page_size');


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

    $year = empty($year) ? "all" : $year;

    $month = empty($month) ? "all" : $month;

    $school_seq = empty($school_seq) ? "all" : $school_seq;

    $school_year = empty($school_year) ? "all" : $school_year;

    $school_class = empty($school_class) ? "all" : $school_class;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&year={$year}&month={$month}&school_seq={$school_seq}&school_year={$school_year}&school_class={$school_class}&page_size={$page_size}";


		$where = "";

		if(!empty($srcN)){
			$where .= " AND (users.user_id LIKE '%{$srcN}%' OR users.user_name LIKE '%{$srcN}%')";
		}

		if($year != "all"){
			$where .= " AND hist.point_year = '{$year}'";
		}

		if($month != "all"){
			$where .= " AND hist.point_month = '{$month}'";
		}

		if($school_seq != "all"){
			$where .= " AND hist.school_seq = '{$school_seq}'";
		}

		if($school_year != "all"){
			$where .= " AND users.school_year = '{$school_year}'";
		}

		if($school_class != "all"){
			$where .= " AND users.school_class = '{$school_class}'";
		}

		//기관관리자 접근
		if($this->session->userdata("admin_level")==1){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND hist.school_seq = '{$admin_school_seq}'";
		}
		//학급관리자 접근
		if($this->session->userdata("admin_level")==2){
			$admin_school_year = $this->session->userdata("school_year");
			$admin_school_class = $this->session->userdata("school_class");
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND hist.school_seq = '{$admin_school_seq}' AND users.school_year = '{$admin_school_year}' AND users.school_class = '{$admin_school_class}'";
		}

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->rank_model->getRankTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&year={$year}&month={$month}&school_seq={$school_seq}&school_year={$school_year}&school_class={$school_class}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$rankList = $this->rank_model->getRankList($whereData);

		//넘버링
		$current_page = ceil ( ($num + 1) / $page_size );

		$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
		$end_page = $start_page + $page_list_size - 1;

		if ($total_page < $end_page)
		{
				$end_page = $total_page;
		}

		$prev_list = ($num-$page_size > 0 ) ? $num-$page_size:0;
		$next_list = ($num+$page_size < ($total_page-1)*$page_size) ? $num+$page_size:($total_page-1)*$page_size;
		//넘버링 끝
		$rankList = $this->add_counting($rankList,$list_total,$num);

		$params = "&year={$year}&month={$month}&school_seq={$school_seq}&school_year={$school_year}&school_class={$school_class}&page_size={$page_size}";

		$paging = $this->make_paging2("/admin/rankAdm/rankList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	"",
			"limit"			=>	""
		);

		$schoolList = $this->school_model->getSchoolList($whereData);

		$classList = $this->school_model->getClassGroupList();


		//customSetting
		for($i = 0; $i < count($rankList); $i++)
		{
			$rankList[$i]['rank'] = ($i+1) + $num;
			$rankList[$i]['carbon_point'] = number_format($rankList[$i]['carbon_point'],2);
			$rankList[$i]['school_name'] = empty($rankList[$i]['school_name']) ? "일반" : $rankList[$i]['school_name'];
			$rankList[$i]['school_year'] = empty($rankList[$i]['school_year']) ? "-" : $rankList[$i]['school_year']."학년";
			$rankList[$i]['school_class'] = empty($rankList[$i]['school_class']) ? "-" : $rankList[$i]['school_class'];
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"rankList"	=>	$rankList,
			"schoolList"	=>	$schoolList,
			"classList"	=>	$classList,
			"year"	=>	$year,
			"month"	=>	$month,
			"school_seq"	=>	$school_seq,
			"school_year"	=>	$school_year,
			"school_class"	=>	$school_class,
			"paging"		=>	$paging,
			"list_total"	=>	$list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/rank/rank-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//개인랭크 팝업
	public function rankPop($user_seq)
	{
		$depth1 = "admin";
		$depth2 = "rankList";
		$title = "개인랭크 상세";
		$sub_title = "개인랭크 상세";

    $year = $this->input->get('year');
    $month = $this->input->get('month');


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $year = empty($year) ? "all" : $year;

    $month = empty($month) ? "all" : $month;



		$where = "";

		if($year != "all"){
			$where .= " AND hist.point_year = '{$year}'";
		}

		if($month != "all"){
			$where .= " AND hist.point_month = '{$month}'";
		}

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);

		$userData = $this->rank_model->getUserDetail($user_seq,$where);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"userData"	=>	$userData,
			"year"	=>	$year,
			"month"	=>	$month
		);


		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/rank/rank-pop",$content_data);
	}

	//기관랭크 리스트
	public function schoolRankList()
	{
		$depth1 = "admin";
		$depth2 = "schoolRankList";
		$title = "기관랭크 리스트";
		$sub_title = "기관랭크 리스트";

		$num = $this->input->get('num');
    $srcN = $this->input->get('srcN');
    $year = $this->input->get('year');
    $month = $this->input->get('month');
		$location = $this->input->get('location');

		$page_size = $this->input->get('page_size');


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

    $year = empty($year) ? "all" : $year;

    $month = empty($month) ? "all" : $month;

		$location = empty($location) ? "all" : $location;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&year={$year}&month={$month}&location={$location}&page_size={$page_size}";


		$where = "";

		if(!empty($srcN)){
			$where .= " AND (school.school_name LIKE '%{$srcN}%')";
		}

		if($year != "all"){
			$where .= " AND hist.point_year = '{$year}'";
		}

		if($month != "all"){
			$where .= " AND hist.point_month = '{$month}'";
		}

		if($location != "all"){
			$where .= " AND school.location = '{$location}'";
		}

		//기관관리자 접근
		/*
		if($this->session->userdata("admin_level")==1){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND hist.school_seq = '{$admin_school_seq}'";
		}
		*/

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->rank_model->getSchoolRankTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&year={$year}&month={$month}&location={$location}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$rankList = $this->rank_model->getSchoolRankList($whereData);

		//넘버링
		$current_page = ceil ( ($num + 1) / $page_size );

		$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
		$end_page = $start_page + $page_list_size - 1;

		if ($total_page < $end_page)
		{
				$end_page = $total_page;
		}

		$prev_list = ($num-$page_size > 0 ) ? $num-$page_size:0;
		$next_list = ($num+$page_size < ($total_page-1)*$page_size) ? $num+$page_size:($total_page-1)*$page_size;
		//넘버링 끝
		$rankList = $this->add_counting($rankList,$list_total,$num);

		$params = "&year={$year}&month={$month}&location={$location}&page_size={$page_size}";

		$paging = $this->make_paging2("/admin/rankAdm/schoolRankList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$locationData = $this->config_model->getConfig('location');


		//customSetting
		for($i = 0; $i < count($rankList); $i++)
		{
			$rankList[$i]['rank'] = ($i+1) + $num;
			$pointSumArr = $this->rank_model->getSchoolRankAverage($rankList[$i]['school_seq']);
			$average = 0;
			$point = 0;
			for($j=0; $j<count($pointSumArr); $j++){
				$point += $pointSumArr[$j]['point_sum'];
			}
			$average = number_format($point / count($pointSumArr),2);
			$rankList[$i]['point_average'] = $average;
			$rankList[$i]['carbon_point'] = number_format($rankList[$i]['carbon_point'],2);
			$rankList[$i]['school_name'] = empty($rankList[$i]['school_name']) ? "일반" : $rankList[$i]['school_name'];
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"rankList"	=>	$rankList,
			"locationData"	=>	$locationData,
			"location"	=>	$location,
			"year"	=>	$year,
			"month"	=>	$month,
			"paging"		=>	$paging,
			"list_total"	=>	$list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/rank/school-rank-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//기관랭크 상세 팝업
	public function schoolRankPop($school_seq)
	{
		$depth1 = "admin";
		$depth2 = "schoolRankPop";
		$title = "기관랭크 상세";
		$sub_title = "기관랭크 상세";

    $year = $this->input->get('year');
    $month = $this->input->get('month');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$year = empty($year) ? "all" : $year;

    $month = empty($month) ? "all" : $month;

		$where = "";

		if($year != "all"){
			$where .= " AND hist.point_year = '{$year}'";
		}

		if($month != "all"){
			$where .= " AND hist.point_month = '{$month}'";
		}

		$rankData = $this->rank_model->getSchoolRankDetail($where,$school_seq);

		$pointSumArr = $this->rank_model->getSchoolRankAverage($school_seq);
		$average = 0;
		$point = 0;
		for($j=0; $j<count($pointSumArr); $j++){
			$point += $pointSumArr[$j]['point_sum'];
		}
		$average = number_format($point / count($pointSumArr),2);

		$rankData['point_average'] = $average;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"rankData"	=>	$rankData,
			"year"	=>	$year,
			"month"	=>	$month
		);


		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/rank/school-rank-pop",$content_data);
	}

	/**
	*============================== end =====================================*
	*/

	//make paging2
	public function make_paging2($url,$start_page,$end_page,$page_size,$num,$srcN="",$total_page,$params="")
	{
	    $pageArr[]['no'] = '<li><a class="page-link" href="'.$url.'?num=0&srcN='.$srcN.$params.'"><</a></li>';
		if( $end_page <= 0 )
        {
            $pageArr[]['no'] = '<li class="page-item"><a class="page-link" href="#">1</a></li>';
        }

        for( $i = $start_page; $i <= $end_page; $i++ )
        {
          $page = ( $i - 1 ) * $page_size;
          if( $num != $page )
          {
	    			$pageArr[$i]['no'] = '<li class="page-item"><a class="page-link" href="'.$url.'?num='.$page.'&srcN='.$srcN.$params.'">'.$i.'</a></li>';
          }
          else
          {
            $pageArr[$i]['no'] = '<li ><a class="page-link" href="#" style="background:#efefef">'.$i.'</a></li>';
          }
        }

        if($total_page> $end_page)
            $pageArr[]['no'] = '<li><a class="page-link" href="'.$url.'?num='.((($end_page*10)-10)+10).'&srcN='.$srcN.$params.'">></a></li>';
        else
            $pageArr[]['no'] = '<li><a class="page-link" href="#">></a></li>';

        return $pageArr;
	}

	//make paging
	public function make_paging($bd_name,$start_page,$end_page,$page_size,$num,$srcN="")
  {

    if( $end_page <= 0 )
    {
        $pageArr[0]['no'] = '<li class="page-item"><a class="page-link" href="#">1</a></li>';
    }

    for( $i = $start_page; $i <= $end_page; $i++ )
    {
      $page = ( $i - 1 ) * $page_size;
      if( $num != $page )
      {
				$pageArr[$i]['no'] = '<li class="page-item"><a class="page-link" href="/admin/board/'.$bd_name.'?num='.$page.'&srcN='.$srcN.'">'.$i.'</a></li>';
      }
      else
      {
        $pageArr[$i]['no'] = '<li><a class="page-link" href="#">'.$i.'</a></li>';
      }
    }

    return $pageArr;
  }

	//board add counting
	public function add_counting($arr,$total,$num)
  {
    $i = $total-$num;
    $returnArr = $arr;

    for( $v = 1; $v <= count($returnArr); $v++ )
    {
      //$returnArr[$v-1]['bd_name'] = $bd_name;
      $returnArr[$v-1]['count'] = $i;
      $i--;
    }

    return $returnArr;

  }

}
