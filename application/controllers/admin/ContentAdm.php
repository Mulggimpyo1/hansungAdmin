<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContentAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("board_model");
		$this->load->model("member_model");
    $this->load->model("content_model");
		$this->load->model("school_model");
		$this->load->model("config_model");
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
			$this->eduList();
		}

	}

  //교육정보 리스트
	public function eduList()
	{
		$depth1 = "admin";
		$depth2 = "eduList";
		$title = "교육정보 리스트";
		$sub_title = "교육정보 리스트";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$category = $this->input->get('category');
		$page_size = $this->input->get('page_size');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$category = $category=="" ? "all" : $category;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&category={$category}&page_size={$page_size}";


		$where = "";

		if(!empty($srcN)){
			$srcN = addslashes($srcN);
			$where .= "AND edu_title LIKE '%{$srcN}%'";
		}

		if($category != 'all'){
			$where .= "AND edu_type = '{$category}'";
		}

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getEduTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&category={$category}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$eduList = $this->content_model->getEduList($whereData);

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
		$eduList = $this->add_counting($eduList,$list_total,$num);

		$params = "&srcN={$srcN}&category={$category}";

		$paging = $this->make_paging2("/admin/contentAdm/eduList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($eduList); $i++)
		{
			$eduList[$i]['edu_reg_datetime'] = date("Y-m-d",strtotime($eduList[$i]['edu_reg_datetime']));

			switch($eduList[$i]['edu_display_yn']){
				case "Y":
				$eduList[$i]['edu_display_yn'] = "공개";
				break;
				case "N":
				$eduList[$i]['edu_display_yn'] = "비공개";
				break;
			}

			switch($eduList[$i]['edu_type']){
				case "news":
				$eduList[$i]['edu_type'] = "뉴스";
				break;
				case "movie":
				$eduList[$i]['edu_type'] = "영상";
				break;
				case "webtoon":
				$eduList[$i]['edu_type'] = "웹툰";
				break;
			}
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"eduList"	=>	$eduList,
			"paging"		=>	$paging,
			"category"		=>	$category,
			"srcN"			=>	$srcN,
			"list_total"	=>	$list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/edu-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//상태변경
	public function updateEduDisplay()
	{
		$edu_display_yn = $this->input->post("edu_display_yn");
		$chk = $this->input->post("chk");

		for($i=0; $i<count($chk); $i++){
			$this->content_model->updateEduDisplay($chk[$i],$edu_display_yn);
		}

		echo '{"result":"success"}';
		exit;
	}

	//교육정보 작성
	public function eduWrite()
	{
		$depth1 = "order";
		$depth2 = "eduList";
		$title = "교육정보등록";
		$sub_title = "교육정보등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$category = $this->input->get('category');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&category={$category}&page_size={$page_size}";

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/edu-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//교육자료 작성
	public function eduWriteProc()
	{
		$edu_type = $this->input->post("edu_type");
		$edu_title = $this->input->post("edu_title");
		$edu_display_yn = $this->input->post("edu_display_yn");
		$edu_contents = $this->input->post("ir1");
		$edu_thumb = $_FILES['edu_thumb']['name'];

		$edu_thumb = $_FILES['edu_thumb']['name'];
		$edu_thumb = empty($edu_thumb) ? "" : $edu_thumb;

		if(!empty($edu_thumb)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/board/";

			$file_name = $edu_type."_thumb_".date("Ymdhis")."_".$edu_thumb;

			@unlink($upload_path.$file_name);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["edu_thumb"]["tmp_name"],$upload_path.$file_name);

			$edu_thumb = $file_name;
		}

		$data = array(
			"edu_type" => $edu_type,
			"edu_title" => $edu_title,
			"edu_display_yn" => $edu_display_yn,
			"edu_contents" => $edu_contents,
			"edu_thumb" => $edu_thumb,
			"edu_reg_datetime"	=> date("Y-m-d H:i:s"),
			"edu_writer_id"	=>	$this->session->userdata("admin_id"),
		);

		$result = $this->content_model->insertEdu($data);

		echo '{"result":"success"}';
		exit;
	}

	//교육정보 수정
	public function eduModify($edu_seq)
	{
		$depth1 = "order";
		$depth2 = "eduList";
		$title = "교육정보수정";
		$sub_title = "교육정보수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$category = $this->input->get('category');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&category={$category}&page_size={$page_size}";

		$eduData = $this->content_model->getEduData($edu_seq);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"eduData"	=>	$eduData,
			"edu_seq"	=>	$edu_seq,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/edu-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//교육자료 수정
	public function eduModifyProc()
	{
		$edu_seq = $this->input->post("edu_seq");
		$edu_type = $this->input->post("edu_type");
		$edu_title = $this->input->post("edu_title");
		$edu_display_yn = $this->input->post("edu_display_yn");
		$edu_contents = $this->input->post("ir1");

		$edu_thumb = $_FILES['edu_thumb']['name'];
		$edu_thumb = empty($edu_thumb) ? "" : $edu_thumb;
		$edu_thumb_org = $this->input->post("edu_thumb_org");

		if(!empty($edu_thumb)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/board/";

			$file_name = $edu_type."_thumb_".date("Ymdhis")."_".$edu_thumb;

			@unlink($upload_path.$edu_thumb_org);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["edu_thumb"]["tmp_name"],$upload_path.$file_name);

			$edu_thumb = $file_name;
		}else{
			$edu_thumb = $edu_thumb_org;
		}

		$data = array(
			"edu_type" => $edu_type,
			"edu_title" => $edu_title,
			"edu_display_yn" => $edu_display_yn,
			"edu_contents" => $edu_contents,
			"edu_thumb" => $edu_thumb,
			"edu_mod_datetime"	=> date("Y-m-d H:i:s")
		);

		$result = $this->content_model->updateEdu($data,$edu_seq);

		echo '{"result":"success"}';
		exit;
	}

	public function eduTempWriteProc()
	{
		$edu_type = $this->input->post("edu_type");
		$edu_title = $this->input->post("edu_title");
		$edu_display_yn = $this->input->post("edu_display_yn");
		$edu_contents = $this->input->post("ir1");

		$data = array(
			"edu_type" => $edu_type,
			"edu_title" => $edu_title,
			"edu_display_yn" => $edu_display_yn,
			"edu_contents" => $edu_contents,
			"edu_reg_datetime"	=> date("Y-m-d H:i:s")
		);

		$this->content_model->insertEduTemp($data);

		echo '{"result":"success"}';
		exit;
	}

	//임시저장 팝업
	public function eduTempListPop()
	{
		$depth1 = "admin";
		$depth2 = "eduList";
		$title = "임시저장";
		$sub_title = "임시저장";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$eduTempList = $this->content_model->getEduTempList();

		for($i=0; $i<count($eduTempList); $i++){
			$eduTempList[$i]['edu_title'] = $this->short_text($eduTempList[$i]['edu_title'], 10,'...');
			$eduTempList[$i]['edu_reg_datetime'] = date("Y-m-d",strtotime($eduTempList[$i]['edu_reg_datetime']));
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"eduTempList"	=>	$eduTempList
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/contents/edu-temp-list-pop",$content_data);
	}

	//교육정보 삭제하기
	public function deleteEdu()
	{
		$chk = $this->input->post("chk");
		for($i=0; $i<count($chk); $i++){
			$this->content_model->deleteEdu($chk[$i]);
		}


		echo '{"result":"success"}';
		exit;
	}

	//임시저장불러오기
	public function eduTempLoad()
	{
		$edu_seq = $this->input->post("edu_seq");
		$eduData = $this->content_model->getEduTemp($edu_seq);

		echo '{"result":"success","data":'.json_encode($eduData).'}';
		exit;
	}

	//임시저장삭제하기
	public function deleteEduTemp()
	{
		$edu_seq = $this->input->post("edu_seq");
		$this->content_model->deleteEduTemp($edu_seq);

		echo '{"result":"success"}';
		exit;
	}

	//퀴즈 리스트
	public function quizList()
	{
		$depth1 = "admin";
		$depth2 = "quizList";
		$title = "퀴즈 리스트";
		$sub_title = "퀴즈 리스트";



		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$page_size = $this->input->get("page_size");

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&page_size={$page_size}";


		$where = "";

		/*

		if(!empty($srcN)){
			$srcN = addslashes($srcN);
			if($srcType=="title"){
				$where .= "AND content.content_title LIKE '%{$srcN}%'";
			}else if($srcType=="code"){
				$where .= "AND content.content_code LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (content.content_title LIKE '%{$srcN}%' OR content.content_code LIKE '%{$srcN}%')";
			}
		}

		if($category != 'all'){
			$where .= "AND content.content_category = '{$category}'";
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$search_where = "1=1 ";
			if(!empty($srcN)){
				$srcN = addslashes($srcN);
				if($srcType=="title"){
					$search_where .= "AND content.content_title LIKE '%{$srcN}%'";
				}else if($srcType=="code"){
					$search_where .= "AND content.content_code LIKE '%{$srcN}%'";
				}else{
					$search_where .= "AND (content.content_title LIKE '%{$srcN}%' OR content.content_code LIKE '%{$srcN}%')";
				}
			}

			if($category != 'all'){
				$search_where .= "AND content.content_category = '{$category}'";
			}

			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND content.content_sharing_yn = 'Y' OR ({$search_where} AND content.academy_seq = '{$academy_seq}' AND content.content_type = 'C')";


		}
		*/

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getQuizTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$quizList = $this->content_model->getQuizList($whereData);

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
		$quizList = $this->add_counting($quizList,$list_total,$num);

		$params = "&page_size={$page_size}";

		$paging = $this->make_paging2("/admin/contentAdm/quizList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($quizList); $i++)
		{
			$quizList[$i]['reg_date'] = date("Y-m-d",strtotime($quizList[$i]['reg_date']));
			$quizList[$i]['quiz_title'] = stripslashes($quizList[$i]['quiz_title']);
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"quizList"	=>	$quizList,
			"paging"		=>	$paging,
			"srcN"			=>	$srcN,
			"list_total"	=>	$list_total,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/quiz-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//퀴즈 작성
	public function quizWrite()
	{
		$depth1 = "order";
		$depth2 = "quizList";
		$title = "퀴즈컨텐츠 등록";
		$sub_title = "퀴즈컨텐츠 등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&page_size={$page_size}";

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/quiz-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//퀴즈등록
	public function quizWriteProc()
	{

		$quiz_title = $this->input->post("quiz_title");
		$quiz_view_datetime = $this->input->post("quiz_view_datetime");
		$quiz_view_hour = $this->input->post("quiz_view_hour");
		$quiz_view_min = $this->input->post("quiz_view_min");
		$status = $this->input->post("status");

		$quiz_title = addslashes($quiz_title);

		$status = empty($status)?"N":$status;

		$quiz_view_datetime = $quiz_view_datetime." ".$quiz_view_hour.":".$quiz_view_min.":"."00";

		$quizArr = array();

		for($i=0; $i<10; $i++){
			$type = $this->input->post("quiz_".($i+1)."_type");
			if($type=="type1"){
				$type = "t1";
			}else{
				$type = "t2";
			}

			$question = $this->input->post("quiz_".($i+1)."_".$type."_q");
			$answer = $this->input->post("quiz_".($i+1)."_".$type."_a");
			$discription = $this->input->post("quiz_".($i+1)."_".$type."_discription");

			$quizArr[$i]['type'] = $type;
			$quizArr[$i]['q'] = addslashes($question);
			$quizArr[$i]['a'] = addslashes($answer);
			$quizArr[$i]['d'] = addslashes($discription);
			if($type=="t1"){
				$quizArr[$i]['n1'] = $this->input->post("quiz_".($i+1)."_".$type."_n1");
				$quizArr[$i]['n2'] = $this->input->post("quiz_".($i+1)."_".$type."_n2");
				$quizArr[$i]['ex'] = array();
				$quizArr[$i]['ex'][0] = $answer;
				$quizArr[$i]['ex'][1] = $this->input->post("quiz_".($i+1)."_".$type."_n1");
				$quizArr[$i]['ex'][2] = $this->input->post("quiz_".($i+1)."_".$type."_n2");
				shuffle($quizArr[$i]['ex']);
			}
		}

		$quiz_contents = serialize($quizArr);

		$data = array(
			"quiz_title"	=> $quiz_title,
			"quiz_total"	=>	10,
			"quiz_contents"	=>	$quiz_contents,
			"quiz_view_datetime"	=>	$quiz_view_datetime,
			"status"	=>	$status,
			"reg_date"	=>	date("Y-m-d H:i:s")
		);

		$result = $this->content_model->insertQuiz($data);

		echo '{"result":"success"}';
		exit;
	}

	//퀴즈 수정
	public function quizModify($quiz_seq)
	{
		$depth1 = "order";
		$depth2 = "quizList";
		$title = "퀴즈컨텐츠 수정";
		$sub_title = "퀴즈컨텐츠 수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&page_size={$page_size}";

		$quizData = $this->content_model->getQuizData($quiz_seq);

		$quiz = unserialize($quizData['quiz_contents']);

		for($i=0; $i<count($quiz); $i++){
			$quiz[$i]['q'] = stripslashes($quiz[$i]['q']);
			$quiz[$i]['a'] = stripslashes($quiz[$i]['a']);
			$quiz[$i]['d'] = stripslashes($quiz[$i]['d']);
			if(!empty($quiz[$i]['ex'])){
				foreach($quiz[$i]['ex'] as $key => $value){
					$quiz[$i]['ex'][$key] = stripslashes($value);
				}
			}
			if(empty($quiz[$i]['n1'])){
				$quiz[$i]['n1'] = "";
			}else{
				$quiz[$i]['n1'] = stripslashes($quiz[$i]['n1']);
			}
			if(empty($quiz[$i]['n2'])){
				$quiz[$i]['n2'] = "";
			}else{
				$quiz[$i]['n2'] = stripslashes($quiz[$i]['n2']);
			}
		}

		$quiz_view_datetime = date("Y-m-d",strtotime($quizData['quiz_view_datetime']));;
		$quiz_view_hour = date("H",strtotime($quizData['quiz_view_datetime']));
		$quiz_view_min = date("i",strtotime($quizData['quiz_view_datetime']));

		$quizData['quiz_title'] = stripslashes($quizData['quiz_title']);
		$quizData['quiz_view_datetime'] = $quiz_view_datetime;
		$quizData['quiz_view_hour'] = $quiz_view_hour;
		$quizData['quiz_view_min'] = $quiz_view_min;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"param"	=>	$param,
			"quizData"	=>	$quizData,
			"quiz"	=>	$quiz
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/quiz-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//퀴즈수정
	public function quizModifyProc()
	{
		$quiz_seq = $this->input->post("quiz_seq");
		$quiz_title = $this->input->post("quiz_title");
		$quiz_view_datetime = $this->input->post("quiz_view_datetime");
		$quiz_view_hour = $this->input->post("quiz_view_hour");
		$quiz_view_min = $this->input->post("quiz_view_min");
		$status = $this->input->post("status");

		$quiz_title = addslashes($quiz_title);

		$status = empty($status)?"N":$status;

		$quiz_view_datetime = $quiz_view_datetime." ".$quiz_view_hour.":".$quiz_view_min.":"."00";

		$quizArr = array();

		for($i=0; $i<10; $i++){
			$type = $this->input->post("quiz_".($i+1)."_type");
			if($type=="type1"){
				$type = "t1";
			}else{
				$type = "t2";
			}

			$question = $this->input->post("quiz_".($i+1)."_".$type."_q");
			$answer = $this->input->post("quiz_".($i+1)."_".$type."_a");
			$discription = $this->input->post("quiz_".($i+1)."_".$type."_discription");

			$quizArr[$i]['type'] = $type;
			$quizArr[$i]['q'] = addslashes($question);
			$quizArr[$i]['a'] = addslashes($answer);
			$quizArr[$i]['d'] = addslashes($discription);
			if($type=="t1"){
				$quizArr[$i]['n1'] = $this->input->post("quiz_".($i+1)."_".$type."_n1");
				$quizArr[$i]['n2'] = $this->input->post("quiz_".($i+1)."_".$type."_n2");
				$quizArr[$i]['ex'] = array();
				$quizArr[$i]['ex'][0] = $answer;
				$quizArr[$i]['ex'][1] = $this->input->post("quiz_".($i+1)."_".$type."_n1");
				$quizArr[$i]['ex'][2] = $this->input->post("quiz_".($i+1)."_".$type."_n2");
				shuffle($quizArr[$i]['ex']);
			}
		}

		$quiz_contents = serialize($quizArr);

		$data = array(
			"quiz_title"	=> $quiz_title,
			"quiz_total"	=>	10,
			"quiz_contents"	=>	$quiz_contents,
			"quiz_view_datetime"	=>	$quiz_view_datetime,
			"status"	=>	$status,
			"update_time"	=>	date("Y-m-d H:i:s")
		);

		$result = $this->content_model->updateQuiz($quiz_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

	//퀴즈 상태변경
	public function quizChangeStatus()
	{
		$status = $this->input->post("status");
		$quiz_seq = $this->input->post("quiz_seq");

		if($status=="N"){
			$quizViewCount = $this->content_model->getQuizViewCount();
			if($quizViewCount<=1){
				echo '{"result":"failed","msg":"퀴즈는 최소1개 노출해야합니다."}';
				exit;
			}
		}else{
			$this->content_model->updateQuizStatus($quiz_seq);

			$arr = array(
	      "send_id" =>  '',
	      "alarm_target"  =>  "all",
	      "alarm_type"  =>  "quiz",
	      "quiz_seq"  =>  $quiz_seq,
	      "to_id" =>  '',
	      "title" =>  "새로운 퀴즈가 등록됐습니다",
	      "link"  =>  "https://app.netzeroschool.kr/content/quiz/".$quiz_seq,
	      "reg_date"  =>  date("Y-m-d H:i:s"),
	    );
			$this->addAlarm($arr);


			echo '{"result":"success"}';
			exit;
		}
	}

	//퀴즈삭제
	public function deleteQuiz()
	{
		$quiz_seq = $this->input->post("quiz_seq");
		$this->content_model->deleteQuiz($quiz_seq);
		echo '{"result":"success"}';
		exit;
	}

	//챌린지 리스트
	public function challengeList()
	{
		$depth1 = "order";
		$depth2 = "challengeList";
		$title = "챌린지리스트";
		$sub_title = "챌린지리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcClass = $this->input->get('srcClass');
		$srcYear = $this->input->get('srcYear');
		$challenge_parent_seq = $this->input->get('challenge_parent_seq');
		$challenge_seq = $this->input->get('challenge_seq');
		$page_size = $this->input->get('page_size');


		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcClass = empty($srcClass) ? "all" : $srcClass;

		$srcYear = empty($srcYear) ? "all" : $srcYear;

		$challenge_parent_seq = empty($challenge_parent_seq) ? "all" : $challenge_parent_seq;

		$challenge_seq = empty($challenge_seq) ? "all" : $challenge_seq;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&srcClass={$srcClass}&srcYear={$srcYear}&challenge_parent_seq={$challenge_parent_seq}&challenge_seq={$challenge_seq}&page_size={$page_size}";

		$where = "";


		if(!empty($srcN)){
			$where .= "AND (users.user_name LIKE '%{$srcN}%' OR users.user_id LIKE '%{$srcN}%')";
		}

		if($srcYear != 'all'){
			if($srcYear!="None"){
				$where .= "AND users.school_year = '{$srcYear}'";
			}else{
				$where .= "AND users.school_year = ''";
			}

		}

		if($srcClass != 'all'){
			$where .= "AND users.school_class = '{$srcClass}'";
		}

		if($challenge_parent_seq != 'all'){
			$where .= "AND feed.feed_parent_challenge_seq = '{$challenge_parent_seq}'";
		}

		if($challenge_seq != 'all'){
			$where .= "AND feed.feed_challenge_seq = '{$challenge_seq}'";
		}

		//기관관리자 접근
		if($this->session->userdata("admin_level")==1){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND users.school_seq = '{$admin_school_seq}'";
		}
		//학급관리자 접근
		if($this->session->userdata("admin_level")==2){
			$admin_school_year = $this->session->userdata("school_year");
			$admin_school_class = $this->session->userdata("school_class");
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND users.school_seq = '{$admin_school_seq}' AND users.school_year = '{$admin_school_year}' AND users.school_class = '{$admin_school_class}'";
		}


		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getChallengeListTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&srcClass={$srcClass}&srcYear={$srcYear}&challenge_parent_seq={$challenge_parent_seq}&challenge_seq={$challenge_seq}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$challengeList = $this->content_model->getChallengeList($whereData);

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
		$challengeList = $this->add_counting($challengeList,$list_total,$num);

		$paging = $this->make_paging2("/admin/contentAdm/challengeList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($challengeList); $i++)
		{
			//$challengeList[$i]['reg_date'] = date("Y-m-d",strtotime($challengeList[$i]['reg_date']));

			if(empty($challengeList[$i]['school_year'])){
				$challengeList[$i]['school_year'] = "-";
			}
			if(empty($challengeList[$i]['school_class'])){
				$challengeList[$i]['school_class'] = "-";
			}
		}

		$where = "";

		//기관관리자 접근
		if($this->session->userdata("admin_level")==2){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= "AND school.school_seq = '{$admin_school_seq}'";
		}

		//기관리스트
		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	""
		);

		$classList = $this->school_model->getClassGroupList();

		$challengeDepth1 = $this->content_model->getChallengeDepth1();

		$challenge_depth1 = $challenge_parent_seq == "all" ? "":$challenge_parent_seq;

		if(!empty($challenge_depth1)){
			$challengeDepth2 = $this->content_model->getChallengeDepth2($challenge_parent_seq);
		}else{
			$challengeDepth2 = array();
		}


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"challengeList"	=>	$challengeList,
			"classList"		=>	$classList,
			"paging"		=>	$paging,
			"srcN"			=>	$srcN,
			"srcClass"		=>	$srcClass,
			"srcYear"		=>	$srcYear,
			"page_size"		=>	$page_size,
			"challengeDepth1"	=>	$challengeDepth1,
			"challenge_parent_seq"	=>	$challenge_parent_seq,
			"challenge_seq"	=>	$challenge_seq,
			"challengeDepth2"	=>	$challengeDepth2,
			"num"				=>	$num,
      "list_total"  =>  $list_total,
			"param"	=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/challenge-list",$content_data);
		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//챌린지 뎁스2 로드
	public function loadDepth2()
	{
		$parent_challenge_seq = $this->input->post("parent_challenge_seq");

		$challenge_data = $this->content_model->getChallengeDepth2($parent_challenge_seq);

		echo '{"result":"success","data":'.json_encode($challenge_data).'}';
		exit;
	}

	//챌린지 관리
	public function challenge()
	{
		$depth1 = "admin";
		$depth2 = "challenge";
		$title = "챌린지 관리";
		$sub_title = "챌린지관리";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/challenge",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//챌린지 로드
	public function loadCategory()
	{
		/*
		$arr = array();
		{ "id" : "ajson1", "parent" : "#","type":"root", "text" : "재활용챌린지" },
		$arr[0] = array(
			"id"	=>	"d1_1",
			"parent"	=>	"#",
			"type"		=>	"root",
			"text"		=>	"재활용 챌린지"
		);
		*/

		$arr = $this->content_model->getChallengeCategory();

		$returnArr = array();

		for($i=0; $i<count($arr); $i++){
			$returnArr[$i]['id'] = $arr[$i]['challenge_cate_id'];
			$returnArr[$i]['parent'] = $arr[$i]['challenge_depth'] == 1 ? "#" : $arr[$i]['challenge_parent_cate_id'];
			$returnArr[$i]['type'] = $arr[$i]['challenge_depth'] == 1 ? "root" : "file";
			$returnArr[$i]['text'] = $arr[$i]['challenge_title'];

			$returnArr[$i]['data'] = array(
				"challenge_seq"	=>	$arr[$i]['challenge_seq']
			);
		}

		echo json_encode($returnArr);
		exit;
	}

	//챌린지 카테고리 저장
	public function saveCategory()
	{

		$cate_arr = $this->input->post("cate");
		$del_arr = $this->input->post("del");

		$d1_depth = 0;
		$d2_depth = 0;
		$d1_arr = array();

		for($i=0; $i<count($cate_arr); $i++){
			if($cate_arr[$i]['parent'] == '#'){
				$d1_depth++;
				$d2_depth = 0;
				$parent_id = $cate_arr[$i]['id'];
				$cate_arr[$i]['data']['sort_num'] = $d1_depth;
				$cate_arr[$i]['data']['challenge_parent_cate_id'] = "";
			}else{
				if($cate_arr[$i]['parent'] == $parent_id){
					$d2_depth++;
					$cate_arr[$i]['data']['sort_num'] = $d2_depth;
					$cate_arr[$i]['data']['challenge_parent_cate_id'] = $parent_id;
				}
			}

			$cate_arr[$i]['data']['challenge_title'] = $cate_arr[$i]['text'];
			if(mb_strlen($cate_arr[$i]['text'],"utf-8")>20){
				echo '{"result":"failed"}';
				exit;
			}


			$cate_arr[$i]['data']['challenge_cate_id'] = $cate_arr[$i]['id'];
			$cate_arr[$i]['data']['challenge_depth'] = $cate_arr[$i]['data']['sort_num'];

			$challenge_title = $cate_arr[$i]['data']['challenge_title'];
			$challenge_cate_id = $cate_arr[$i]['data']['challenge_cate_id'];
			if($cate_arr[$i]['parent']=="#"){
				$challenge_depth = 1;
			}else{
				$challenge_depth = 2;
			}

			$challenge_parent_cate_id = $cate_arr[$i]['data']['challenge_parent_cate_id'];
			$sort_num = $cate_arr[$i]['data']['sort_num'];

			$data = array(
				"challenge_title"	=>	$challenge_title,
				"challenge_cate_id"	=>	$challenge_cate_id,
				"challenge_depth"	=>	$challenge_depth,
				"challenge_parent_cate_id"	=>	$challenge_parent_cate_id,
				"sort_num"	=>	$sort_num,
			);

			if(empty($cate_arr[$i]['data']['challenge_seq'])){
				//insert

				$reg_date = date("Y-m-d H:i:s");
				$data['reg_date'] = $reg_date;

				$result = $this->content_model->insertChallenge($data);

			}else{
				//update
				$update_time = date("Y-m-d H:i:s");
				$data['update_time'] = $update_time;
				$challenge_seq = $cate_arr[$i]['data']['challenge_seq'];

				$result = $this->content_model->updateChallenge($challenge_seq,$data);

			}

		}

		for($i=0; $i<count($del_arr); $i++){
			$this->content_model->deleteChallenge($del_arr[$i]);
		}

		echo '{"result":"success"}';
		exit;
	}

	//챌린지 노드 로드
	public function loadChallengeNode()
	{
		$challenge_id = $this->input->post('id');

		$challengeNode = $this->content_model->getChallengeNode($challenge_id);

		$returnArr = array();

		if(is_array($challengeNode)){
			if($challengeNode['challenge_depth']==2){
				$parentNode = $this->content_model->getChallengeNode($challengeNode['challenge_parent_cate_id']);
				$challengeNode['parent_title'] = $parentNode['challenge_title'];
			}
			$returnArr = $challengeNode;

			echo '{"result":"success","data":'.json_encode($returnArr).'}';
			exit;
		}else{
			echo '{"result":"failed"}';
			exit;
		}
	}

	//챌린지 저장
	public function saveChallengeProc()
	{
		$challenge_title = $this->input->post("challenge_title");
		$challenge_title_2 = $this->input->post("challenge_title_2");
		$depth = $this->input->post("depth");
		$challenge_seq = $this->input->post("challenge_seq");
		$challenge_carbon_point = $this->input->post("challenge_carbon_point");



		if($depth == "1"){
			if(mb_strlen($challenge_title)>20){
				echo '{"result":"failed"}';
				exit;
			}

			$challenge_thumb = $_FILES['challenge_thumb']['name'];
			$challenge_thumb_org = $this->input->post("challenge_thumb_org");
			if(!empty($challenge_thumb)){
				$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/challenge/";

				$file_name = "challenge_d1_".$challenge_seq."_thumb_".date("Ymdhis")."_".$challenge_thumb;

				//@unlink($upload_path.$challenge_thumb_org);

				if( !is_dir($upload_path) ){
					mkdir($upload_path,0777,true);
				}

				move_uploaded_file($_FILES["challenge_thumb"]["tmp_name"],$upload_path.$file_name);

				$challenge_thumb = $file_name;
			}else{
				$challenge_thumb = $challenge_thumb_org;
			}

			$challenge_icon = $_FILES['challenge_icon']['name'];
			$challenge_icon_org = $this->input->post("challenge_icon_org");
			if(!empty($challenge_icon)){
				$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/challenge/";

				$file_name = "challenge_d1_".$challenge_seq."_icon_".date("Ymdhis")."_".$challenge_icon;

				//@unlink($upload_path.$challenge_icon_org);

				if( !is_dir($upload_path) ){
					mkdir($upload_path,0777,true);
				}

				move_uploaded_file($_FILES["challenge_icon"]["tmp_name"],$upload_path.$file_name);

				$challenge_icon = $file_name;
			}else{
				$challenge_icon = $challenge_icon_org;
			}

			$data = array(
				"challenge_title"	=>	$challenge_title,
				"challenge_thumb"	=>	$challenge_thumb,
				"challenge_icon"	=>	$challenge_icon
			);

		}else{
			$limit_day = $this->input->post("limit_day");
			$agree_text = $this->input->post("agree_text");
			if(mb_strlen($challenge_title_2)>20){
				echo '{"result":"failed"}';
				exit;
			}
			$data = array(
				"challenge_title"	=>	$challenge_title_2,
				"challenge_carbon_point"	=>	$challenge_carbon_point,
				"limit_day"	=>	$limit_day,
				"agree_text"	=>	$agree_text
			);

			for($i=1; $i<=10; $i++){
				$img = $_FILES['image'.$i]['name'];
				$img_org = $this->input->post("image".$i."_org");

				if(!empty($img)){
					$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/challenge/";

					$file_name = "challenge_d2_".$challenge_seq."_thumb_".date("Ymdhis")."_".$img;

					//@unlink($upload_path.$img_org);

					if( !is_dir($upload_path) ){
						mkdir($upload_path,0777,true);
					}

					move_uploaded_file($_FILES['image'.$i]["tmp_name"],$upload_path.$file_name);

					$img = $file_name;
				}else{
					$img = $img_org;
				}

				$data['image'.$i] = $img;

			}


		}

		$result = $this->content_model->updateChallenge($challenge_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

	//피드관리
	public function feedAdmList()
	{
		$depth1 = "admin";
		$depth2 = "feedAdmList";
		$title = "피드관리";
		$sub_title = "피드관리";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$user_level = $this->input->get('user_level');
		$school_year = $this->input->get('school_year');
		$school_seq = $this->input->get('school_seq');
		$challenge_cate_id = $this->input->get('challenge_cate_id');
		$status = $this->input->get('status');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$user_level = $user_level == "" ? "all" : $user_level;
		$school_year = empty($school_year) ? "all" : $school_year;
		$school_seq = empty($school_seq) ? "all" : $school_seq;
		$status = empty($status) ? "all" : $status;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&user_level={$user_level}&school_year={$school_year}&status={$status}&school_seq={$school_seq}&school_seq={$school_seq}&page_size={$page_size}";

		for($i=0; $i<count($challenge_cate_id); $i++){
			$param .= "&challenge_cate_id[]=".$challenge_cate_id[$i];
		}

		$where = "";

		if(!empty($srcN)){
			$srcN = addslashes($srcN);
			$where .= "AND (users.user_name LIKE '%{$srcN}%' OR users.user_id LIKE '%{$srcN}%')";
		}

		if($user_level != 'all'){
			$where .= "AND users.user_level = '{$user_level}'";
		}

		if($school_year != 'all'){
			$where .= "AND users.school_year = '{$school_year}'";
		}

		if($school_seq != 'all'){
			$where .= "AND users.school_seq = '{$school_seq}'";
		}

		if($status != 'all'){
			if($status == 'F'){
				$where .= "AND report.feed_seq is NOT NULL";
			}else{
				$where .= "AND feed.status = '{$status}'";
			}

		}

		if(!empty($challenge_cate_id)){
			$cate_where = "(";
			for($i=0; $i<count($challenge_cate_id); $i++){
				$cate = $challenge_cate_id[$i];
				if($i<count($challenge_cate_id)-1){
					$cate_where .= " challenge.challenge_cate_id='{$cate}' OR challenge.challenge_parent_cate_id = '{$cate}' OR";
				}else{
					$cate_where .= " challenge.challenge_cate_id='{$cate}' OR challenge.challenge_parent_cate_id = '{$cate}'";
				}

			}
			$cate_where .= ")";
			$where .= "AND ".$cate_where;

		}

		//기관관리자 접근
		if($this->session->userdata("admin_level")==1){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND users.school_seq = '{$admin_school_seq}'";
		}
		//학급관리자 접근
		if($this->session->userdata("admin_level")==2){
			$admin_school_year = $this->session->userdata("school_year");
			$admin_school_class = $this->session->userdata("school_class");
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= " AND users.school_seq = '{$admin_school_seq}' AND users.school_year = '{$admin_school_year}' AND users.school_class = '{$admin_school_class}'";
		}



		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getFeedTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&user_level={$user_level}&school_year={$school_year}&status={$status}&school_seq={$school_seq}&school_seq={$school_seq}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$feedList = $this->content_model->getFeedList($whereData);

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
		$feedList = $this->add_counting($feedList,$list_total,$num);

		$paging = $this->make_paging2("/admin/contentAdm/feedAdmList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($feedList); $i++)
		{
			$feedList[$i]['reg_date'] = date("Y-m-d",strtotime($feedList[$i]['reg_date']));

			switch($feedList[$i]['status']){
				case "Y":
				$feedList[$i]['status_txt'] = "공개";
				break;
				case "N":
				$feedList[$i]['status_txt'] = "비공개";
				break;
				case "D":
				$feedList[$i]['status_txt'] = "관리자삭제";
				break;
			}

			$feedList[$i]['feed_img'] = explode("|",$feedList[$i]['feed_photo']);

			$feedList[$i]['like_total'] = number_format($feedList[$i]['like_total']);
			$feedList[$i]['comment_total'] = number_format($feedList[$i]['comment_total']);
			$feedList[$i]['report_total'] = number_format($feedList[$i]['report_total']);

		}

		$challengeList = $this->content_model->getChallengeDepth1();
		$schoolList = $this->school_model->getAllSchool();

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"feedList"	=>	$feedList,
			"paging"		=>	$paging,
			"srcN"			=>	$srcN,
			"status"		=>	$status,
			"school_seq"	=>	$school_seq,
			"school_year"	=>	$school_year,
			"challenge_cate_id"	=>	$challenge_cate_id,
			"user_level"	=>	$user_level,
			"schoolList"	=>	$schoolList,
			"challengeList"	=>	$challengeList,
			"list_total"	=>	$list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/feed-adm-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//선택피드 삭제
	public function deleteChoiceFeed()
	{
		$chk = $this->input->post("chk");

		for($i=0; $i<count($chk); $i++){
			$result = $this->content_model->amdinDeleteFeed($chk[$i],"관리자 삭제");

			$arr = array(
				"send_id"	=>	'admin',
				"alarm_target"	=>	"user",
				"alarm_type"	=>	"delete",
				"to_id"	=>	$result['user_id'],
				"feed_seq"	=>	$chk[$i],
				"title"	=>	"관리자에 의해 피드가 삭제 되었습니다.",
				"link"	=>	"/main",
			);

			$this->addAlarm($arr);
		}

		echo '{"result":"success"}';
		exit;
	}

	//피드 복구
	public function feedStatusChange()
	{
		$feed_seq = $this->input->post("feed_seq");

		$this->content_model->updateStatusFeed($feed_seq);

		echo '{"result":"success"}';
		exit;
	}

	//신고내역 팝업
	public function feedReportPop($feed_seq)
	{
		$depth1 = "admin";
		$depth2 = "feedList";
		$title = "신고내역";
		$sub_title = "신고내역";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$reportList = $this->content_model->getReportList($feed_seq);

		for($i=0; $i<count($reportList); $i++){
			$reportList[$i]['reg_date'] = date("Y-m-d",strtotime($reportList[$i]['reg_date']));
			$reportList[$i]['feed_report_category'] = explode("|",$reportList[$i]['feed_report_category']);
			$report_category = "";
			for($j=0; $j<count($reportList[$i]['feed_report_category']); $j++){
				$str = $reportList[$i]['feed_report_category'][$j];
				switch($str){
					case "A":
					$report_category .= "부적절한 사진,욕설";
					break;
					case "B":
					$report_category .= "챌린지와 관계없음";
					break;
					case "C":
					$report_category .= "수칙 미준수";
					break;
					case "D":
					$report_category .= "기타";
					break;
				}
				if($j < count($reportList[$i]['feed_report_category'])-1){
					$report_category .= " / ";
				}
			}

			$reportList[$i]['feed_report_category'] = $report_category;

		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"reportList"	=>	$reportList,
			"feed_seq"	=>	$feed_seq
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/contents/feed-report-pop",$content_data);
	}

	public function deleteFeed()
	{
		$feed_seq = $this->input->post('feed_seq');
		$del_txt = $this->input->post('del_txt');

		$result = $this->content_model->amdinDeleteFeed($feed_seq,$del_txt);
		$arr = array(
			"send_id"	=>	'admin',
			"alarm_target"	=>	"user",
			"alarm_type"	=>	"delete",
			"to_id"	=>	$result['user_id'],
			"feed_seq" =>	$feed_seq,
			"title"	=>	"관리자에 의해 [".$del_txt."] 이유로 피드가 삭제 되었습니다.",
			"link"	=>	"/main",
		);

		$this->addAlarm($arr);

		echo '{"result":"success"}';
		exit;
	}

	//광고관리
	public function adList()
	{
		$depth1 = "admin";
		$depth2 = "adList";
		$title = "광고 리스트";
		$sub_title = "광고 리스트";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$adv_start_date = $this->input->get('adv_start_date');
		$adv_end_date = $this->input->get('adv_end_date');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$adv_start_date = $adv_start_date=="" ? "all" : $adv_start_date;
		$adv_end_date = $adv_end_date=="" ? "all" : $adv_end_date;
		$status = $status=="" ? "all" : $status;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";


		$where = "";

		if(!empty($srcN)){
			$srcN = addslashes($srcN);
			$where .= "AND (ad.adv_title LIKE '%{$srcN}%' OR ad.adv_comp_name LIKE '%{$srcN}%')";
		}

		if($adv_start_date != 'all'){
			if($adv_end_date != 'all'){
				$where .= "AND ((ad.adv_start_date <= '{$adv_start_date}' AND (ad.adv_end_date >= '{$adv_start_date}' OR ad.adv_end_date is NULL)) OR (ad.adv_start_date <= '{$adv_end_date}' AND (ad.adv_end_date >= '{$adv_end_date}' OR ad.adv_end_date is NULL)))";
			}else{
				$where .= "AND (ad.adv_end_date >= '{$adv_start_date}' OR ad.adv_end_date is NULL)";
			}
		}else{
			if($adv_end_date != 'all'){
				$where .= "AND ad.adv_start_date <= '{$adv_end_date}'";
			}
		}



		if($status != 'all'){
			if($status == "ready"){
				$where .= "AND ad.status = 'N' AND ad.adv_start_date > DATE_FORMAT(NOW(),'%Y-%m-%d')";
			}else if($status == "N"){
				$where .= "AND ad.status = 'N' AND ad.adv_end_date < DATE_FORMAT(NOW(),'%Y-%m-%d')";
			}else{
				$where .= "AND ad.status = '{$status}'";
			}

		}

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getAdTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$adList = $this->content_model->getAdList($whereData);

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
		$adList = $this->add_counting($adList,$list_total,$num);

		$params = "&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";

		$paging = $this->make_paging2("/admin/contentAdm/adList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($adList); $i++)
		{
			$adList[$i]['reg_date'] = date("Y-m-d",strtotime($adList[$i]['reg_date']));

			$adList[$i]['adv_total_view'] = number_format($adList[$i]['adv_total_view']);
			$adList[$i]['adv_view'] = number_format($adList[$i]['adv_view']);

			if(!empty($adList[$i]['adv_image1'])){
				$adList[$i]['thumb'] = "<img src='/upload/ad/".$adList[$i]['adv_image1']."' width='100'/>";
			}else{
				$adList[$i]['thumb'] = "-";
			}

			if($adList[$i]['status'] == "N" && $adList[$i]['adv_start_date'] > date("Y-m-d")){
				$adList[$i]['status'] = "광고대기중";
			}else if($adList[$i]['status'] == "N" && $adList[$i]['adv_end_date'] < date("Y-m-d")){
				$adList[$i]['status'] = "광고종료";
			}else if($adList[$i]['status'] == "Y"){
				$adList[$i]['status'] = "광고중";
				$adList[$i]['adv_end_date'] = "ing";
			}


		}

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	"",
			"limit"			=>	""
		);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"adList"	=>	$adList,
			"paging"		=>	$paging,
			"srcN"			=>	$srcN,
			"adv_start_date"	=>	$adv_start_date,
			"adv_end_date"	=>	$adv_end_date,
			"status"	=>	$status,
			"list_total"	=>	$list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/ad-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//광고 작성
	public function adWrite()
	{
		$depth1 = "order";
		$depth2 = "adList";
		$title = "광고등록";
		$sub_title = "광고등록";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$adv_start_date = $this->input->get('adv_start_date');
		$adv_end_date = $this->input->get('adv_end_date');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$adv_start_date = $adv_start_date=="" ? "all" : $adv_start_date;
		$adv_end_date = $adv_end_date=="" ? "all" : $adv_end_date;
		$status = $status=="" ? "all" : $status;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";

		$locationData = $this->config_model->getConfig('location');

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"locationData"	=>	$locationData,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/ad-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//광고등록
	public function adWriteProc()
	{


		$adv_title = $this->input->post("adv_title");
		$adv_comp_name = $this->input->post("adv_comp_name");

		$adv_location = $this->input->post("adv_location");
		$range_1 = $this->input->post("range_1");
		$range_arr = explode(";",$range_1);
		$age_start_average = $range_arr[0];
		$age_end_average = $range_arr[1];

		$adv_total_view = $this->input->post("adv_total_view");
		$adv_day_view = $this->input->post("adv_day_view");
		$adv_start_date = $this->input->post("adv_start_date");
		$adv_link_name = $this->input->post("adv_link_name");
		$adv_link = $this->input->post("adv_link");
		$adv_content = $this->input->post("adv_content");
		$memo = $this->input->post("memo");

		$adv_gender = $this->input->post("adv_gender");

		$schoolArr = json_decode($_POST['schoolArr'],true);

		$school_seq = "";
		$schoolSeqArr = array();

		if(count($schoolArr)>0){
			for($i=0; $i<count($schoolArr); $i++){
				$schoolSeqArr[$i] = $schoolArr[$i]['school_seq'];
			}
			$school_seq = implode(",",$schoolSeqArr);
		}

		$self_write = $this->input->post("self_write");
		if(!empty($self_write)){
			$school_seq = "";
		}

		if(!empty($adv_gender)){
			$adv_gender = implode("|",$adv_gender);
		}else{
			$adv_gender = "";
		}

		$adv_image1 = $_FILES['adv_image1']['name'];
		$adv_image2 = $_FILES['adv_image2']['name'];
		$adv_image3 = $_FILES['adv_image3']['name'];
		$adv_image4 = $_FILES['adv_image4']['name'];
		$adv_image5 = $_FILES['adv_image5']['name'];

		$adv_image1 = empty($adv_image1) ? "" : $adv_image1;
		$adv_image2 = empty($adv_image2) ? "" : $adv_image2;
		$adv_image3 = empty($adv_image3) ? "" : $adv_image3;
		$adv_image4 = empty($adv_image4) ? "" : $adv_image4;
		$adv_image5 = empty($adv_image5) ? "" : $adv_image5;

		$adv_profile = $_FILES['adv_profile']['name'];

		$adv_profile = empty($adv_profile) ? "" : $adv_profile;

		if(!empty($adv_profile)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."profile_".$adv_profile;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_profile"]["tmp_name"],$upload_path.$file_name);

			$adv_profile = $file_name;
		}

		if(!empty($adv_image1)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image1_".$adv_image1;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_image1"]["tmp_name"],$upload_path.$file_name);

			$adv_image1 = $file_name;
		}

		if(!empty($adv_image2)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image2_".$adv_image2;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_image2"]["tmp_name"],$upload_path.$file_name);

			$adv_image2 = $file_name;
		}

		if(!empty($adv_image3)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image3_".$adv_image3;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_image3"]["tmp_name"],$upload_path.$file_name);

			$adv_image3 = $file_name;
		}

		if(!empty($adv_image4)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image4_".$adv_image4;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_image4"]["tmp_name"],$upload_path.$file_name);

			$adv_image4 = $file_name;
		}

		if(!empty($adv_image5)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image5_".$adv_image5;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["adv_image5"]["tmp_name"],$upload_path.$file_name);

			$adv_image5 = $file_name;
		}

		$now_date = date("Y-m-d");

		if($adv_start_date <= $now_date){
			$status = "Y";
		}else{
			$status = "N";
		}

		$data = array(
			"adv_title"	=>	$adv_title,
			"adv_comp_name"	=>	$adv_comp_name,
			"adv_profile"	=>	$adv_profile,
			"adv_location"	=>	$adv_location,
			"school_seq"	=>	$school_seq,
			"age_start_average"	=>	$age_start_average,
			"age_end_average"	=>	$age_end_average,
			"adv_total_view"	=>	$adv_total_view,
			"adv_day_view"	=>	$adv_day_view,
			"adv_start_date"	=>	$adv_start_date,
			"adv_link_name"	=>	$adv_link_name,
			"adv_link"	=>	$adv_link,
			"adv_content"	=>	$adv_content,
			"memo"	=>	$memo,
			"adv_image1"	=>	$adv_image1,
			"adv_image2"	=>	$adv_image2,
			"adv_image3"	=>	$adv_image3,
			"adv_image4"	=>	$adv_image4,
			"adv_image5"	=>	$adv_image5,
			"adv_gender"	=>	$adv_gender,
			"status"	=>	$status,
			"reg_date"	=>	date("Y-m-d H:i:s")
		);

		$result = $this->content_model->insertAd($data);

		echo '{"result":"success"}';
		exit;
	}

	//광고 수정
	public function adModify($adv_seq)
	{
		$depth1 = "order";
		$depth2 = "adList";
		$title = "광고수정";
		$sub_title = "광고수정";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$adv_start_date = $this->input->get('adv_start_date');
		$adv_end_date = $this->input->get('adv_end_date');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$locationData = $this->config_model->getConfig('location');

		$adData = $this->content_model->getAdData($adv_seq);

		if(!empty($adData['school_seq'])){
			$schoolName = $this->school_model->getSchool($adData['school_seq']);
			$schoolName = $schoolName['school_name'];
			$adData['school_name'] = $schoolName;
		}else{
			$adData['school_name'] = "";
		}


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"locationData"	=>	$locationData,
			"adData"	=>	$adData,
			"adv_seq"	=>	$adv_seq,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/ad-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function adSchoolLoad()
	{
		$adv_seq = $this->input->post("adv_seq");
		$adv_school = $this->content_model->getAdSchool($adv_seq);
		$schoolArr = array();
		if(!empty($adv_school)){
			$adv_arr = explode(",",$adv_school);

			for($i=0; $i<count($adv_arr); $i++){
				$schoolData = $this->school_model->getSchool($adv_arr[$i]);
				$school_name = $schoolData['school_name'];
				$schoolArr[$i]['school_name'] = $school_name;
				$schoolArr[$i]['school_seq'] = $adv_arr[$i];
			}
		}

		echo json_encode($schoolArr);
		exit;

	}

	//광고수정
	public function adModifyProc()
	{
		$adv_seq = $this->input->post("adv_seq");

		$adv_title = $this->input->post("adv_title");
		$adv_comp_name = $this->input->post("adv_comp_name");
		$adv_location = $this->input->post("adv_location");
		$school_seq = $this->input->post("school_seq");
		$range_1 = $this->input->post("range_1");
		$range_arr = explode(";",$range_1);
		$age_start_average = $range_arr[0];
		$age_end_average = $range_arr[1];

		$adv_total_view = $this->input->post("adv_total_view");
		$adv_day_view = $this->input->post("adv_day_view");
		$adv_start_date = $this->input->post("adv_start_date");
		$adv_link_name = $this->input->post("adv_link_name");
		$adv_link = $this->input->post("adv_link");
		$adv_content = $this->input->post("adv_content");
		$memo = $this->input->post("memo");

		$adv_profile_org = $this->input->post("adv_profile_org");

		$adv_gender = $this->input->post("adv_gender");

		$schoolArr = json_decode($_POST['schoolArr'],true);

		$school_seq = "";
		$schoolSeqArr = array();

		if(count($schoolArr)>0){
			for($i=0; $i<count($schoolArr); $i++){
				$schoolSeqArr[$i] = $schoolArr[$i]['school_seq'];
			}
			$school_seq = implode(",",$schoolSeqArr);
		}

		$self_write = $this->input->post("self_write");
		if(!empty($self_write)){
			$school_seq = "";
		}

		$adv_image1_org = $this->input->post("adv_image1_org");
		$adv_image2_org = $this->input->post("adv_image2_org");
		$adv_image3_org = $this->input->post("adv_image3_org");
		$adv_image4_org = $this->input->post("adv_image4_org");
		$adv_image5_org = $this->input->post("adv_image5_org");


		if(!empty($adv_gender)){
			$adv_gender = implode("|",$adv_gender);
		}else{
			$adv_gender = "";
		}

		$adv_image1 = $_FILES['adv_image1']['name'];
		$adv_image2 = $_FILES['adv_image2']['name'];
		$adv_image3 = $_FILES['adv_image3']['name'];
		$adv_image4 = $_FILES['adv_image4']['name'];
		$adv_image5 = $_FILES['adv_image5']['name'];

		$adv_profile = $_FILES['adv_profile']['name'];

		$adv_image1 = empty($adv_image1) ? "" : $adv_image1;
		$adv_image2 = empty($adv_image2) ? "" : $adv_image2;
		$adv_image3 = empty($adv_image3) ? "" : $adv_image3;
		$adv_image4 = empty($adv_image4) ? "" : $adv_image4;
		$adv_image5 = empty($adv_image5) ? "" : $adv_image5;

		$adv_image1_org = empty($adv_image1_org) ? "" : $adv_image1_org;
		$adv_image2_org = empty($adv_image2_org) ? "" : $adv_image2_org;
		$adv_image3_org = empty($adv_image3_org) ? "" : $adv_image3_org;
		$adv_image4_org = empty($adv_image4_org) ? "" : $adv_image4_org;
		$adv_image5_org = empty($adv_image5_org) ? "" : $adv_image5_org;

		$adv_profile_org = empty($adv_profile_org) ? "" : $adv_profile_org;

		if(!empty($adv_profile)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."profile_".$adv_profile;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_profile_org);

			move_uploaded_file($_FILES["adv_profile"]["tmp_name"],$upload_path.$file_name);

			$adv_profile = $file_name;
		}else{
			$adv_profile = $adv_profile_org;
		}

		if(!empty($adv_image1)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image1_".$adv_image1;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_image1_org);

			move_uploaded_file($_FILES["adv_image1"]["tmp_name"],$upload_path.$file_name);

			$adv_image1 = $file_name;
		}else{
			$adv_image1 = $adv_image1_org;
		}

		if(!empty($adv_image2)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image2_".$adv_image2;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_image2_org);

			move_uploaded_file($_FILES["adv_image2"]["tmp_name"],$upload_path.$file_name);

			$adv_image2 = $file_name;
		}else{
			$adv_image2 = $adv_image2_org;
		}

		if(!empty($adv_image3)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image3_".$adv_image3;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_image3_org);

			move_uploaded_file($_FILES["adv_image3"]["tmp_name"],$upload_path.$file_name);

			$adv_image3 = $file_name;
		}else{
			$adv_image3 = $adv_image3_org;
		}

		if(!empty($adv_image4)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image4_".$adv_image4;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_image4_org);


			move_uploaded_file($_FILES["adv_image4"]["tmp_name"],$upload_path.$file_name);

			$adv_image4 = $file_name;
		}else{
			$adv_image4 = $adv_image4_org;
		}

		if(!empty($adv_image5)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/ad/";

			$file_name = "ad_".date("Ymdhis")."_"."image5_".$adv_image5;

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			@unlink($upload_path.$adv_image5_org);

			move_uploaded_file($_FILES["adv_image5"]["tmp_name"],$upload_path.$file_name);

			$adv_image5 = $file_name;
		}else{
			$adv_image5 = $adv_image5_org;
		}

		$now_date = date("Y-m-d");

		if($adv_start_date <= $now_date){
			$status = "Y";
		}else{
			$status = "N";
		}

		$data = array(
			"adv_title"	=>	$adv_title,
			"adv_comp_name"	=>	$adv_comp_name,
			"adv_profile"	=>	$adv_profile,
			"adv_location"	=>	$adv_location,
			"school_seq"	=>	$school_seq,
			"age_start_average"	=>	$age_start_average,
			"age_end_average"	=>	$age_end_average,
			"adv_total_view"	=>	$adv_total_view,
			"adv_day_view"	=>	$adv_day_view,
			"adv_start_date"	=>	$adv_start_date,
			"adv_link_name"	=>	$adv_link_name,
			"adv_link"	=>	$adv_link,
			"adv_content"	=>	$adv_content,
			"memo"	=>	$memo,
			"adv_image1"	=>	$adv_image1,
			"adv_image2"	=>	$adv_image2,
			"adv_image3"	=>	$adv_image3,
			"adv_image4"	=>	$adv_image4,
			"adv_image5"	=>	$adv_image5,
			"adv_gender"	=>	$adv_gender,
			"status"	=>	$status,
			"update_time"	=>	date("Y-m-d H:i:s")
		);

		$result = $this->content_model->updateAd($adv_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

	//광고 삭제
	public function adDelete($adv_seq="")
	{
		if(empty($adv_seq)){
			//선택삭제
			$chk = $this->input->post("chk");
			for($i=0; $i<count($chk); $i++){
				$this->content_model->deleteAd($chk[$i]);
			}
		}else{
			//개별삭제
			$this->content_model->deleteAd($adv_seq);
		}

		echo '{"result":"success"}';
		exit;
	}

	//광고 인사이트
	public function adView($adv_seq)
	{
		$depth1 = "order";
		$depth2 = "adList";
		$title = "광고Insight";
		$sub_title = "광고Insight";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$adv_start_date = $this->input->get('adv_start_date');
		$adv_end_date = $this->input->get('adv_end_date');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$adv_start_date = $adv_start_date=="" ? "all" : $adv_start_date;
		$adv_end_date = $adv_end_date=="" ? "all" : $adv_end_date;
		$status = $status=="" ? "all" : $status;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&adv_start_date={$adv_start_date}&adv_end_date={$adv_end_date}&status={$status}&page_size={$page_size}";

		$adData = $this->content_model->getAdData($adv_seq);

		$imgArr = array();

		for($i=0; $i<5; $i++){
			if(!empty($adData['adv_image'.($i+1)])){
				array_push($imgArr,$adData['adv_image'.($i+1)]);
			}
		}

		$adData['img'] = $imgArr;

		//노출통계
		$viewTotal = $this->content_model->getAdViewTotal($adv_seq);
		//링크방문 통계
		$linkTotal = $this->content_model->getAdLinkTotal($adv_seq);
		//좋아요 통계
		$likeTotal = $this->content_model->getAdLikeTotal($adv_seq);
		//댓글 통계
		$commentTotal = $this->content_model->getAdCommentTotal($adv_seq);

		//일별 노출수 통계
		$allViewData = $this->content_model->getAdAllViewData($adv_seq);

		//지역별 노출수
		$locationViewData = $this->content_model->getAdLocationViewData($adv_seq);

		//학교별 노출수
		$schoolViewData = $this->content_model->getAdSchoolViewData($adv_seq);

		//성별 노출수
		$genderViewData = $this->content_model->getAdGenderViewData($adv_seq);

		//나이별 노출 수
		$ageViewData = $this->content_model->getAdAgeViewData($adv_seq);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"adData"	=>	$adData,
			"viewTotal"	=>	$viewTotal,
			"linkTotal"	=>	$linkTotal,
			"likeTotal"	=>	$likeTotal,
			"commentTotal"	=>	$commentTotal,
			"allViewData"	=>	$allViewData,
			"locationViewData"	=>	$locationViewData,
			"schoolViewData"	=>	$schoolViewData,
			"genderViewData" => $genderViewData,
			"ageViewData"	=>	$ageViewData,
			"adv_seq"	=>	$adv_seq,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/ad-view",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function getAdViewGraph()
	{
		$adv_seq = $this->input->post("adv_seq");

		$allViewData = $this->content_model->getAdAllViewData($adv_seq);

		$labelArr = array();
		$dataArr = array();

		for($i=0; $i<count($allViewData); $i++){
			$labelArr[$i] = $allViewData[$i]['reg_date'];
			$dataArr[$i] = $allViewData[$i]['view_total'];
		}

		$returnData = array(
			"label"	=>	$labelArr,
			"data"	=>	$dataArr
		);

		echo '{"result":"result","data":'.json_encode($returnData).'}';
		exit;
	}



	//도서 리스트
	public function bookList()
	{
		$depth1 = "admin";
		$depth2 = "bookList";
		$title = "도서 리스트";
		$sub_title = "도서 리스트";



		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$category = $this->input->get('category');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";
		$category = $category ?? "all";


		$where = "";

		/*

		if(!empty($srcN)){
			$srcN = addslashes($srcN);
			if($srcType=="title"){
				$where .= "AND content.content_title LIKE '%{$srcN}%'";
			}else if($srcType=="code"){
				$where .= "AND content.content_code LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (content.content_title LIKE '%{$srcN}%' OR content.content_code LIKE '%{$srcN}%')";
			}
		}

		if($category != 'all'){
			$where .= "AND content.content_category = '{$category}'";
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$search_where = "1=1 ";
			if(!empty($srcN)){
				$srcN = addslashes($srcN);
				if($srcType=="title"){
					$search_where .= "AND content.content_title LIKE '%{$srcN}%'";
				}else if($srcType=="code"){
					$search_where .= "AND content.content_code LIKE '%{$srcN}%'";
				}else{
					$search_where .= "AND (content.content_title LIKE '%{$srcN}%' OR content.content_code LIKE '%{$srcN}%')";
				}
			}

			if($category != 'all'){
				$search_where .= "AND content.content_category = '{$category}'";
			}

			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND content.content_sharing_yn = 'Y' OR ({$search_where} AND content.academy_seq = '{$academy_seq}' AND content.content_type = 'C')";


		}
		*/

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->content_model->getBookTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$bookList = $this->content_model->getBookList($whereData);

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
		$bookList = $this->add_counting($bookList,$list_total,$num);

		$params = "&srcType={$srcType}&category={$category}";

		$paging = $this->make_paging2("/admin/contentAdm/bookList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($bookList); $i++)
		{
			$bookList[$i]['book_reg_datetime'] = date("Y-m-d",strtotime($bookList[$i]['book_reg_datetime']));
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"bookList"	=>	$bookList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"category"			=>	$category,
			"list_total"	=>	$list_total
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/contents/book-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
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
