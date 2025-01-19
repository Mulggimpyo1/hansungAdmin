<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rank extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		/**
		* 언어셋 설정
		*/
		$this->load->config('gettext');
		$this->load->helper('gettext');
		$this->load->model("member_model");
		$this->load->model("board_model");
		$this->load->model("rank_model");
		$this->load->model("content_model");
		$this->load->helper("string");
		$charset = array(
			$this->getChar()
		);

		$this->load->library(
            'gettext',
            array(
                'gettext_text_domain' => 'default',
                'gettext_locale' => $charset,
                'gettext_locale_dir' => 'language/locales'
            )
        );

		$this->loginCheck();
	}

	public function index()
	{

	}

  public function achieve()
  {
    $sub = "rank";

		$depth1 = "ranking";
		$depth2 = "achieve";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$user_total_point = $this->member_model->getUserTotalPoint($user_seq);
		$user_quiz_point = $this->member_model->getUserPoint($user_seq,'Q');
		$user_challenge_point = $this->member_model->getUserPoint($user_seq,'C');
		$user_contents_point = $this->member_model->getUserPoint($user_seq,'B');

		$point_level = 0;
		$point_per = 0;
		$start_num = 0;
		$end_num = 0;

		if($user_total_point<1000){
			$point_level = 1;
			if($user_total_point==0){
				$point_per = 0;
			}else{
				$point_per = ($user_total_point / 1000) * 100;
			}
			$start_num = 0;
			$end_num = 1000;
		}else if($user_total_point>999 && $user_total_point<3000){
			$point_level = 2;
			$point_per = (($user_total_point-1000) / (3000-1000)) * 100;
			$start_num = 1000;
			$end_num = 3000;
		}else if($user_total_point>2999 && $user_total_point<6000){
			$point_level = 3;
			$point_per = (($user_total_point-3000) / (6000-3000)) * 100;
			$start_num = 3000;
			$end_num = 6000;
		}else if($user_total_point>5999 && $user_total_point<12000){
			$point_level = 4;
			$point_per = (($user_total_point-6000) / (12000-6000)) * 100;
			$start_num = 6000;
			$end_num = 12000;
		}else if($user_total_point>=12000){
			$point_level = 5;
			$point_per = 100;
			$start_num = 12000;
			$end_num = 12000;
		}

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"user_total_point"	=>	$user_total_point,
			"user_quiz_point"	=>	$user_quiz_point,
			"user_challenge_point"	=>	$user_challenge_point,
			"user_contents_point"	=>	$user_contents_point,
			"point_level"	=>	$point_level,
			"point_per"	=>	$point_per,
			"start_num"	=>	$start_num,
			"end_num"	=>	$end_num
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('rank/achieve',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function carbonTreeLoad()
	{
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$carbonData = $this->rank_model->getUserCarbonData($user_seq);

		$carbon_point = floor($carbonData['carbon']);
		$tree_num = ($carbon_point/9)<=0?0:floor($carbon_point/9);

		$data = array(
			"carbon_point"	=>	$carbon_point,
			"tree_num"	=>	$tree_num
		);

		echo '{"result":"success","data":'.json_encode($data).'}';
		exit;
	}

  public function ranking()
  {
    $sub = "rank";

    $depth1 = "ranking";
    $depth2 = "ranking";


    $this->CONFIG_DATA["depth1"] = $depth1;
    $this->CONFIG_DATA["depth2"] = $depth2;

    $data = array(
      "depth1"	=>	$depth1,
      "depth2"	=>	$depth2,
    );


    $this->CONFIG_DATA["sub"] = $sub;
    $this->parser->parse('include/head',$this->CONFIG_DATA);
    $this->parser->parse('include/aside',$this->CONFIG_DATA);
    $this->parser->parse('rank/ranking',$data);
    $this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function soloRank()
	{
		$search_year = $this->input->post("search_year");
		$search_month = $this->input->post("search_month");
		$my_group = $this->input->post("my_group");

		$school_seq = $this->CONFIG_DATA['userData']['school_seq'];

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$where = " AND year = '{$search_year}' AND month = '{$search_month}'";
		if(!empty($my_group)){
			$where .= " AND school_seq = '{$school_seq}'";
		}

		$result = $this->rank_model->getSoloRank($where,$user_seq);

		$result['userData'] = $this->CONFIG_DATA['userData'];

		echo '{"result":"success","data":'.json_encode($result).'}';
		exit;
	}

  public function rankClass()
  {
    $sub = "rank";

    $depth1 = "ranking";
    $depth2 = "rankClass";


    $this->CONFIG_DATA["depth1"] = $depth1;
    $this->CONFIG_DATA["depth2"] = $depth2;

    $data = array(
      "depth1"	=>	$depth1,
      "depth2"	=>	$depth2,
    );


    $this->CONFIG_DATA["sub"] = $sub;
    $this->parser->parse('include/head',$this->CONFIG_DATA);
    $this->parser->parse('include/aside',$this->CONFIG_DATA);
    $this->parser->parse('rank/rank-class',$data);
    $this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function classRank()
	{
		$search_year = $this->input->post("search_year");
		$search_month = $this->input->post("search_month");
		$my_group = $this->input->post("my_group");

		$school_seq = $this->CONFIG_DATA['userData']['school_seq'];

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$where = " AND year = '{$search_year}' AND month = '{$search_month}'";
		if(!empty($my_group)){
			$where .= " AND school_seq = '{$school_seq}'";
		}

		$result = $this->rank_model->getClassRank($where,$user_seq);
		$result['userData'] = $this->CONFIG_DATA['userData'];

		echo '{"result":"success","data":'.json_encode($result).'}';
		exit;
	}

  public function rankSchool()
  {
    $sub = "rank";

    $depth1 = "ranking";
    $depth2 = "rankSchool";


    $this->CONFIG_DATA["depth1"] = $depth1;
    $this->CONFIG_DATA["depth2"] = $depth2;

    $data = array(
      "depth1"	=>	$depth1,
      "depth2"	=>	$depth2,
    );


    $this->CONFIG_DATA["sub"] = $sub;
    $this->parser->parse('include/head',$this->CONFIG_DATA);
    $this->parser->parse('include/aside',$this->CONFIG_DATA);
    $this->parser->parse('rank/rank-school',$data);
    $this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function schoolRank()
	{
		$search_year = $this->input->post("search_year");
		$search_month = $this->input->post("search_month");


		$school_seq = $this->CONFIG_DATA['userData']['school_seq'];

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$where = " AND year = '{$search_year}' AND month = '{$search_month}'";

		$result = $this->rank_model->getSchoolRank($where,$user_seq);
		$result['userData'] = $this->CONFIG_DATA['userData'];

		echo '{"result":"success","data":'.json_encode($result).'}';
		exit;
	}

	public function monthCarbonLoad()
	{
		$challengeArr = $this->content_model->getChallengeDepth1();
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$monthArr = array();
		$year = date("Y");
		for($i=0; $i<date("n"); $i++){
			$month = sprintf('%02d',($i+1));

			$carbon_data = $this->rank_model->getTotalChallengeMonthData($year,$month);
			$user_carbon_data = $this->rank_model->getUserChallengeMonthData($year,$month,$user_seq);
			$challengeData = array();
			$userData = array();
			$user_total = 0;
			for($q=0; $q<count($user_carbon_data); $q++){
				$user_total += $user_carbon_data[$q]['total_carbon'];
			}

			for($j=0; $j<count($challengeArr); $j++){
				$challengeData[$j]['challenge_title'] = $challengeArr[$j]['challenge_title'];
				$userData[$j]['challenge_title'] = $challengeArr[$j]['challenge_title'];
				$challengeData[$j]['carbon_total'] = 0;
				$userData[$j]['carbon_total'] = 0;
				$userData[$j]['user_total'] = 0;

				if(count($carbon_data)>0){
					for($t=0; $t<count($carbon_data); $t++){
						if($carbon_data[$t]['challenge_title']==$challengeArr[$j]['challenge_title']){
							$challengeData[$j]['carbon_total'] = $carbon_data[$t]['total_carbon'];
						}
					}
				}

				if(count($user_carbon_data)>0){
					for($t=0; $t<count($user_carbon_data); $t++){
						if($user_carbon_data[$t]['challenge_title']==$challengeArr[$j]['challenge_title']){
							$userData[$j]['carbon_total'] = $user_carbon_data[$t]['total_carbon'];
							//$user_total += $user_carbon_data[$t]['total_carbon'];
						}
					}
				}

				if($userData[$j]['carbon_total'] > 0){
					$userData[$j]['per'] = number_format(($userData[$j]['carbon_total'] / $user_total) * 100);
				}else{
					$userData[$j]['per'] = 0;
				}

			}

			$monthArr[$i] = array(
				"month"	=>	$month,
				"challenge_data"	=>	$challengeData,
				"userData"	=>	$userData,
				"user_total"	=>	$user_total
			);
		}

		$returnArr = array(
			"monthData"	=>	$monthArr,
			"challenge"	=>	$challengeArr
		);

		echo json_encode($returnArr);
		exit;

	}

}
