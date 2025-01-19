<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Player extends MY_Controller {

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
		$this->load->model("academi_model");
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

		$this->skin = "basic";
		$this->CONFIG_DATA["skin"]	=	$this->skin;

		$this->theme_url = $this->device.'/'.$this->skin;

		if(!empty($this->session->userdata("user_id"))){
			$adminNoticeNew = $this->board_model->getAdminNoticeNew();
			$academiNoticeNew = $this->board_model->getAcademiNoticeNew();

			$this->CONFIG_DATA['web_new'] = $adminNoticeNew;
			$this->CONFIG_DATA['app_new'] = $academiNoticeNew;
		}

		if(empty($this->session->userdata("user_id"))){
			$this->goURL("/");
		}
	}

	public function homeworkList()
	{
		$this->duplicateLoginCheck();

		$sub = "homework";

		$depth1 = "list";
		$depth2 = "list";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $num = $this->input->get('num');
    $srcN = $this->input->get('srcN');
    $srcType = $this->input->get('srcType');

		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('player/homework-list',$this->CONFIG_DATA);
	}

  public function homeworkAjax()
  {
		$loginCheck = $this->duplicateLoginCheckAjax();

    $num = $this->input->post("num");

    $where = "";

    $page_size = 10;
    $page_list_size = 10;
    $whereData = array(
      "where"			=>	$where,
      "user_id"			=>	$this->session->userdata("user_id"),
      "limit"       =>  ""
    );

    $list_total = $this->academi_model->getUserHomeworkTotalCount($whereData);

    if( $list_total <= 0 )
    {
      $list_total = 0;
    }

    $total_page = ceil( $list_total / $page_size );




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

    $whereData = array(
      "where" =>  $where,
      "user_id" =>  $this->session->userdata("user_id"),
      "limit"   =>  "LIMIT ".($num*$page_size).",".$page_size
    );

    $homeworkData = $this->academi_model->getHomeworkData($whereData);

    if(count($homeworkData)>0){
      for($i=0; $i<count($homeworkData); $i++){
        //$homeworkData[$i]['content_time'] = $this->getTimeFromSeconds($homeworkData[$i]['content_time']);
				if($homeworkData[$i]['content_type'] == "C"){
					$content_url = "/upload/academy/".$homeworkData[$i]["content_academy_seq"]."/content/".$homeworkData[$i]['content_file'];
				}else{
					$content_url = "/upload/audio/".$homeworkData[$i]['content_file'];
				}
				if(empty($homeworkData[$i]['content_total_time'])){
					$homeworkData[$i]['content_total_time'] = $this->getAudioTime($content_url);
				}
				$homeworkData[$i]['content_total_time'] = $this->getTimeFromSeconds($homeworkData[$i]['content_total_time']);

      }
    }





    $data = array(
      "homeworkData"  =>  $homeworkData,
      "total_page"  =>  $total_page,
      "next_list"   =>  $next_list,
      "academy_seq" =>  $this->session->userdata("academy_seq"),
			"loginCheck"	=>	$loginCheck
    );

    echo json_encode($data);
  }

  public function audioList()
	{
		$this->duplicateLoginCheck();

		$sub = "audio";

		$depth1 = "list";
		$depth2 = "list";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $num = $this->input->get('num');
    $srcN = $this->input->get('srcN');
    $srcType = $this->input->get('srcType');

		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('player/audio-list',$this->CONFIG_DATA);
	}

  public function audio_player($content_code)
  {
		$this->duplicateLoginCheck();

		$sub = "audio";

		$depth1 = "player";
		$depth2 = "player";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $audioDataMulti = $this->content_model->getAudio($content_code);

		$audioData = $audioDataMulti[0];

		$user_id = $this->session->userdata("user_id");

		$userData = $this->member_model->getUser($user_id);

		$addPlayList = $this->content_model->addPlayList($audioData,$userData);

    $content_type = $audioData['content_type'];
		if($content_type == "C"){
			$img_url = "/upload/academy/".$audioData["academy_seq"]."/content/image/";
			$content_url = "/upload/academy/".$audioData["academy_seq"]."/content/";
		}else{
			$img_url = "/upload/audio/image/";
			$content_url = "/upload/audio/";
		}
		if(empty($audioData['content_image'])){
			$audioData['content_image'] = "/images/temp/img_sound.gif";
		}else{
			$audioData['content_image'] = $img_url.$audioData['content_image'];
		}
		$audioData['content_url'] = $content_url.$audioData['content_file'];

		$str_rr = explode(":", $this->getTimeFromSeconds($audioData['content_time']));
    array_shift($str_rr);
    $audioData['content_time_str'] = implode(":",$str_rr);

		if($audioData['track_type']=="M"){
			for($i=0; $i<count($audioDataMulti); $i++){
				if($audioDataMulti[$i]['content_type'] == "C"){
					$img_url = "/upload/academy/".$audioDataMulti[$i]["academy_seq"]."/content/image/";
					$content_url = "/upload/academy/".$audioDataMulti[$i]["academy_seq"]."/content/";
				}else{
					$img_url = "/upload/audio/image/";
					$content_url = "/upload/audio/";
				}
				if(empty($audioDataMulti[$i]['content_image'])){
					$audioDataMulti[$i]['content_image'] = "/images/temp/img_sound.gif";
				}else{
					$audioDataMulti[$i]['content_image'] = $img_url.$audioDataMulti[$i]['content_image'];
				}
				$audioDataMulti[$i]['content_url'] = $content_url.$audioDataMulti[$i]['content_file'];

				$audioDataMulti[$i]['content_time'] = $this->getTimeFromSeconds($audioDataMulti[$i]['content_time']);
			}
		}


    $data = array(
      "audioData" =>  $audioData,
			"audioDataMulti"	=>	$audioDataMulti
    );

		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('player/audio-player',$data);

  }

	public function trackLoad()
	{

		$content_code = $this->input->post("content_code");
		$track_no = $this->input->post("track_no");

		$audioData = $this->content_model->getContentTrackData($content_code,$track_no);

		if($audioData['content_type'] == "C"){
			$img_url = "/upload/academy/".$audioData["academy_seq"]."/content/image/";
			$content_url = "/upload/academy/".$audioData["academy_seq"]."/content/";
		}else{
			$img_url = "/upload/audio/image/";
			$content_url = "/upload/audio/";
		}
		if(empty($audioData['content_image'])){
			$audioData['content_image'] = "/images/temp/img_sound.gif";
		}else{
			$audioData['content_image'] = $img_url.$audioData['content_image'];
		}
		$audioData['content_url'] = $content_url.$audioData['content_file'];

		$user_id = $this->session->userdata("user_id");

		$userData = $this->member_model->getUser($user_id);

		$addPlayList = $this->content_model->addPlayList($audioData,$userData);

		$mode = $this->input->post("mode");

		if($mode == "homework"){
			$homework_seq = $this->academi_model->getHomeworkSeq($user_id,$content_code,$track_no);

			$homeworkData = $this->academi_model->getHomeworkSeqData($homework_seq);
			if(empty($homeworkData['start_time'])){
	      //숙제 시작업데이트
	      $this->academi_model->updateHomework($homework_seq);
	    }

			$audioData['homework_seq'] = $homework_seq;
			$audioData['update_time'] = $homeworkData['update_time'];

		}

		echo json_encode($audioData);
		exit;
	}

  public function homework_player($homework_seq)
  {
		$this->duplicateLoginCheck();

		$sub = "homework";

		$depth1 = "player";
		$depth2 = "player";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $homeworkData = $this->academi_model->getHomeworkSeqData($homework_seq);

    $content_code = $homeworkData['content_code'];
		$track_no = $homeworkData['track_no'];

    $audioDataMulti = $this->content_model->getHomeworkAudio($content_code,$homeworkData['user_id']);
		//$audioData = $audioDataMulti[$track_no-1];

		for($i=0; $i<count($audioDataMulti); $i++){
			if($audioDataMulti[$i]['track_no'] == $track_no){
				$audioData = $audioDataMulti[$i];
			}
		}


		$user_id = $this->session->userdata("user_id");
		$userData = $this->member_model->getUser($user_id);

		$addPlayList = $this->content_model->addPlayList($audioData,$userData);

    $content_type = $audioData['content_type'];
		if($content_type == "C"){
			$img_url = "/upload/academy/".$audioData["academy_seq"]."/content/image/";
			$content_url = "/upload/academy/".$audioData["academy_seq"]."/content/";
		}else{
			$img_url = "/upload/audio/image/";
			$content_url = "/upload/audio/";
		}
		if(empty($audioData['content_image'])){
			$audioData['content_image'] = "/images/temp/img_sound.gif";
		}else{
			$audioData['content_image'] = $img_url.$audioData['content_image'];
		}
		$audioData['content_url'] = $content_url.$audioData['content_file'];

    $str_rr = explode(":", $this->getTimeFromSeconds($audioData['content_time']));
    array_shift($str_rr);
    $audioData['content_time_str'] = implode(":",$str_rr);

    if(empty($homeworkData['update_time'])){
      $homeworkData['update_time'] = "0";
      $homeworkData['update_time_str'] = "00:00";
    }else{
      $str_rb = explode(":", $this->getTimeFromSeconds($homeworkData['update_time']));
      array_shift($str_rb);
      $homeworkData['update_time_str'] = implode(":",$str_rb);;
    }

		if($audioData['track_type']=="M"){
			for($i=0; $i<count($audioDataMulti); $i++){
				if($audioDataMulti[$i]['content_type'] == "C"){
					$img_url = "/upload/academy/".$audioDataMulti[$i]["academy_seq"]."/content/image/";
					$content_url = "/upload/academy/".$audioDataMulti[$i]["academy_seq"]."/content/";
				}else{
					$img_url = "/upload/audio/image/";
					$content_url = "/upload/audio/";
				}
				if(empty($audioDataMulti[$i]['content_image'])){
					$audioDataMulti[$i]['content_image'] = "/images/temp/img_sound.gif";
				}else{
					$audioDataMulti[$i]['content_image'] = $img_url.$audioDataMulti[$i]['content_image'];
				}
				$audioDataMulti[$i]['content_url'] = $content_url.$audioDataMulti[$i]['content_file'];

				$audioDataMulti[$i]['content_time'] = $this->getTimeFromSeconds($audioDataMulti[$i]['content_time']);
			}
		}


    $data = array(
      "audioData" =>  $audioData,
      "homeworkData"  =>  $homeworkData,
			"audioDataMulti"	=>	$audioDataMulti
    );

    if(empty($homeworkData['start_time'])){
      //숙제 시작업데이트
      $this->academi_model->updateHomework($homework_seq);
    }


		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('player/homework-player',$data);

  }

  public function updateHomework()
  {
    $homework_seq = $this->input->post("homework_seq");
    $update_time = $this->input->post("update_time");
    $end_yn = $this->input->post("end_yn");

    $data = array(
      "homework_seq"  =>  $homework_seq,
      "update_time"   =>  $update_time,
      "end_yn"        =>  $end_yn
    );

    $result = $this->academi_model->updateHomeworkTime($data);

    echo '{"result":"success"}';
    exit;
  }

  public function audioAjax()
  {
		$loginCheck = $this->duplicateLoginCheckAjax();

    $num = $this->input->post("num");
    $src_category = $this->input->post("src_category");
    $src_ar = $this->input->post("src_ar");
    $src_text = $this->input->post("src_text");

    $where = "";

    if(!empty($src_category)){
      $where .= "AND content_category = '{$src_category}'";
    }
    if(!empty($src_ar))
    {
      switch($src_ar){
        case "0.7":
        $where .= "AND content_ar_level BETWEEN 0.5 AND 0.7";
        break;
        case "1.1":
        $where .= "AND content_ar_level BETWEEN 0.8 AND 1.1";
        break;
        case "1.5":
        $where .= "AND content_ar_level BETWEEN 1.2 AND 1.5";
        break;
        case "1.8":
        $where .= "AND content_ar_level BETWEEN 1.6 AND 1.8";
        break;
        case "2.3":
        $where .= "AND content_ar_level BETWEEN 1.9 AND 2.3";
        break;
        case "2.5":
        $where .= "AND content_ar_level BETWEEN 2.4 AND 2.5";
        break;
        case "2.9":
        $where .= "AND content_ar_level BETWEEN 2.6 AND 2.9";
        break;
        case "3.2":
        $where .= "AND content_ar_level BETWEEN 3.0 AND 3.2";
        break;
        case "3.6":
        $where .= "AND content_ar_level BETWEEN 3.3 AND 3.6";
        break;
        case "4.0":
        $where .= "AND content_ar_level BETWEEN 3.7 AND 4.0";
        break;
        case "4.4":
        $where .= "AND content_ar_level BETWEEN 4.1 AND 4.4";
        break;
        case "4.7":
        $where .= "AND content_ar_level BETWEEN 4.5 AND 4.7";
        break;
        case "5.4":
        $where .= "AND content_ar_level BETWEEN 4.8 AND 5.4";
        break;
        case "6.4":
        $where .= "AND content_ar_level BETWEEN 5.5 AND 6.4";
        break;
        case "over":
        $where .= "AND content_ar_level >= 6.5";
        break;
        case "none":
        $where .= "AND content_ar_level is NULL";
        break;
      }
    }

    if(!empty($src_text)){
			$src_text = addslashes($src_text);
      $where .= "AND (content_title LIKE '%{$src_text}%' OR content_code LIKE '%{$src_text}%')";
    }

    $page_size = 10;
    $page_list_size = 5;
    $whereData = array(
      "where"			=>	$where,
      "limit"       =>  ""
    );

    $list_total = $this->academi_model->getUserAudioTotalCount($whereData);

    if( $list_total <= 0 )
    {
      $list_total = 0;
    }

    $total_page = ceil( $list_total / $page_size );


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



    $whereData = array(
      "where" =>  $where,
      "limit"   =>  "LIMIT ".($num*$page_size).",".$page_size
    );

    $audioData = $this->academi_model->getAudioData($whereData);

    if(count($audioData)>0){
      for($i=0; $i<count($audioData); $i++){
        $audioData[$i]['content_time'] = $this->getTimeFromSeconds($audioData[$i]['content_total_time']);
				if($audioData[$i]['content_type'] == "C"){
					$content_url = "/upload/academy/".$audioData[$i]["academy_seq"]."/content/".$audioData[$i]['content_file'];
				}else{
					$content_url = "/upload/audio/".$audioData[$i]['content_file'];
				}

				if(empty($audioData[$i]['content_ar_level'])){
					$audioData[$i]['content_ar_level'] = "none";
				}else{
					$audioData[$i]['content_ar_level'] = number_format($audioData[$i]['content_ar_level'],1);
				}

      }
    }

    $data = array(
      "audioData"  =>  $audioData,
      "total_page"  =>  $total_page,
      "next_list"   =>  $next_list,
      "academy_seq" =>  $this->session->userdata("academy_seq"),
			"loginCheck"	=>	$loginCheck
    );

    echo json_encode($data);

  }

	public function saveTime()
	{
		$loginCheck = $this->duplicateLoginCheckAjax();
		if($loginCheck=="Y"){
			echo '{"result":"failed","msg":"duplicateLogin"}';
			exit;
		}

		$content_category = $this->input->post("content_category");
		$save_time = $this->input->post("save_time");
		$reg_date = date("Y-m-d");
		$user_id = $this->session->userdata("user_id");

		$play_time = $this->input->post("play_time");
		$total_time = $this->input->post("total_time");

		if($play_time<=$total_time){		

			if(!empty($user_id)){
				$data = array(
					"content_category"	=>	$content_category,
					"save_time"					=>	$save_time,
					"reg_date"					=>	$reg_date,
					"user_id"						=>	$user_id
				);

				$this->academi_model->saveTime($data);

				echo '{"result":"success"}';
			}
		}else{
			echo '{"result":"failed","msg":"over time"}';
		}
		exit;
	}

	public function main()
	{
		$this->duplicateLoginCheck();

		$sub = "main";

		$depth1 = "main";
		$depth2 = "main";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$where = "AND display_yn = 'Y'";
		$sort = "ORDER BY sort_num ASC";
		$limit = "";

		$bannerData = array(
			"where"	=>	$where,
			"sort"	=>	$sort,
			"limit"	=>	$limit
		);

		$mainBanner = $this->board_model->getMainBannerList($bannerData);
		$homeworkData = $this->academi_model->getHomeworkData($this->session->userdata("user_id"),"limit 6");

		for($i=0; $i<count($homeworkData); $i++){
			$content_type = $homeworkData[$i]['content_type'];
			if($content_type == "C"){
				$img_url = "/upload/academy/".$homeworkData[$i]['academy_seq']."/content/image/";
				$content_url = "/upload/academy/".$homeworkData[$i]['academy_seq']."/content/";
			}else{
				$img_url = "/upload/audio/image/";
				$content_url = "/upload/audio/";
			}
			if(empty($homeworkData[$i]['content_image'])){
				$homeworkData[$i]['content_image'] = "/images/temp/img_sound.gif";
			}else{
				$homeworkData[$i]['content_image'] = $img_url.$homeworkData[$i]['content_image'];
			}
			$homeworkData[$i]['content_url'] = $content_url;
		}

		$contentData = $this->content_model->getAllContent("limit 6");

		for($i=0; $i<count($contentData); $i++){
			$content_type = $contentData[$i]['content_type'];
			if($content_type == "C"){
				$img_url = "/upload/academy/".$contentData[$i]['academy_seq']."/content/image/";
				$content_url = "/upload/academy/".$contentData[$i]['academy_seq']."/content/";
			}else{
				$img_url = "/upload/audio/image/";
				$content_url = "/upload/audio/";
			}
			if(empty($contentData[$i]['content_image'])){
				$contentData[$i]['content_image'] = "/images/temp/img_sound.gif";
			}else{
				$contentData[$i]['content_image'] = $img_url.$contentData[$i]['content_image'];
			}
			$contentData[$i]['content_url'] = $content_url;
		}

		$infoData = $this->academi_model->getMainInfoData();



		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"mainBanner"	=>	$mainBanner,
			"homeworkData"	=>	$homeworkData,
			"contentData"		=>	$contentData,
			"infoData"			=>	$infoData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/header',$this->CONFIG_DATA);
		$this->parser->parse('main',$data);
	}

	public function unload_test()
	{
		$last_time = $this->input->post('last_time');
		$unload_date = date("Y-m-d H:i:s");

		$data = array(
			"last_time"	=>	$last_time,
			"unload_date"	=>	$unload_date
		);

		$this->study_model->insertUnload($data);
	}

	public function audio_play()
	{
		$this->duplicateLoginCheck();

		$sub = "audio_player";
		$data = array(
			"sub"	=>	$sub
		);

		$depth1 = "audio";
		$depth2 = "audio";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$this->parser->parse('/audio_player',$this->CONFIG_DATA);

	}

	public function terms()
	{
		$sub = "terms";
		$data = array(
			"char"	=>	$this->getChar(),
			"sub"	=>	$sub
		);

		$depth1 = "terms";
		$depth2 = "terms";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		$this->CONFIG_DATA["sub"] = "terms";
		$this->CONFIG_DATA["lang"] = $this->getChar();

		$this->parser->parse($this->theme_url.'/inc/sub_head',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_top',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/terms',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_footer',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_scripts',$this->CONFIG_DATA);
	}

	public function privacy()
	{
		$sub = "privacy";
		$data = array(
			"char"	=>	$this->getChar(),
			"sub"	=>	$sub
		);

		$depth1 = "privacy";
		$depth2 = "privacy";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		$this->CONFIG_DATA["sub"] = "privacy";
		$this->CONFIG_DATA["lang"] = $this->getChar();

		$this->parser->parse($this->theme_url.'/inc/sub_head',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_top',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/privacy',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_footer',$this->CONFIG_DATA);
		$this->parser->parse($this->theme_url.'/inc/sub_scripts',$this->CONFIG_DATA);
	}

}
