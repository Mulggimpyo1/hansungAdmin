<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcademiAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("board_model");
		$this->load->model("member_model");
		$this->load->model("academi_model");
		$this->load->model("adm_model");
		$this->load->library('excel');

		$this->CONFIG_DATA['academy_list'] = $this->academi_model->getAcademiList(array("where"=>"","limit"=>""));
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
			$this->academiInfo();
		}

	}

	public function academiInfo()
	{
		$depth1 = "admin";
		$depth2 = "academiInfo";
		$title = "이용안내";
		$sub_title = "이용안내";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$where = "";
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}else{
			$where = "AND info_type = 'A'";
		}

		$infoData = $this->academi_model->getInfoData($where);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"infoData"	=>	$infoData
		);



		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/info/academi-info",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function infoWriteProc()
	{
		$info_seq = $this->input->post("info_seq");
		$info_type = $this->input->post("info_type");
		$info_manual = $this->input->post("info_manual");
		$info_movie = $this->input->post("info_movie");
		$info_blog = $this->input->post("info_blog");
		$manual_target = $this->input->post("manual_target");
		$movie_target = $this->input->post("movie_target");
		$blog_target = $this->input->post("blog_target");

		$data = array(
			"info_seq"	=>	$info_seq,
			"info_type"	=>	$info_type,
			"info_manual"	=>	$info_manual,
			"info_movie"	=>	$info_movie,
			"info_blog"	=>	$info_blog,
			"manual_target"	=>	$manual_target,
			"movie_target"	=>	$movie_target,
			"blog_target"	=>	$blog_target,
		);

		$result = $this->adm_model->writeInfo($data);

		echo '{"result":"success"}';
		exit;
	}



  //회원리스트
	public function studentList()
	{
		$depth1 = "admin";
		$depth2 = "studentList";
		$title = "회원리스트";
		$sub_title = "회원리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$status = $status ?? "all";

		$where = "";

		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%'";
			}
		}

		if($status != 'all'){
			$where .= "AND user.status = '{$status}'";
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND user.academy_seq = '{$academy_seq}'";
		}

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getStudentTotalCount($whereData);

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

		$studentList = $this->academi_model->getStudentList($whereData);

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
		$studentList = $this->add_counting($studentList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/studentList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($studentList); $i++)
		{
			$studentList[$i]['reg_date'] = date("Y-m-d",strtotime($studentList[$i]['reg_date']));

      switch($studentList[$i]['status']){
        case "C":
        $studentList[$i]['status'] = "승인";
        break;

        case "R":
        $studentList[$i]['status'] = "대기";
        break;

        case "L":
        $studentList[$i]['status'] = "탈퇴";
        break;

        case "D":
        $studentList[$i]['status'] = "삭제";
        break;
      }

			switch($studentList[$i]['school_year']){
				case 0:
				$studentList[$i]['school_year'] = "유치";
				break;
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				$studentList[$i]['school_year'] = "초등 ".$studentList[$i]['school_year']."학년";
				break;
				case 7:
				case 8:
				case 9:
				$studentList[$i]['school_year'] = "중등 ".($studentList[$i]['school_year']-6)."학년";
				break;
				case 10:
				case 11:
				case 12:
				$studentList[$i]['school_year'] = "고등 ".($studentList[$i]['school_year']-9)."학년";
				break;
				case 13:
				$studentList[$i]['school_year'] = "일반";
				break;
			}
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"studentList"	=>	$studentList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"status"		=>	$status,
			"num"				=>	$num,
			"total_user"	=>	number_format($list_total)
		);




		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/students/students-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//회원리스트
	public function deleteStudentList()
	{
		$depth1 = "admin";
		$depth2 = "deleteStudentList";
		$title = "탈퇴 회원리스트";
		$sub_title = "탈퇴 회원리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$where = "";

		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%'";
			}
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND user.academy_seq = '{$academy_seq}'";
		}

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getDeleteStudentTotalCount($whereData);

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

		$studentList = $this->academi_model->getDeleteStudentList($whereData);

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
		$studentList = $this->add_counting($studentList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/deleteStudentList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($studentList); $i++)
		{
			$studentList[$i]['reg_date'] = date("Y-m-d",strtotime($studentList[$i]['reg_date']));

      switch($studentList[$i]['status']){
        case "C":
        $studentList[$i]['status'] = "승인";
        break;

        case "R":
        $studentList[$i]['status'] = "대기";
        break;

        case "L":
        $studentList[$i]['status'] = "탈퇴";
        break;

        case "D":
        $studentList[$i]['status'] = "삭제";
        break;
      }

			switch($studentList[$i]['school_year']){
				case 0:
				$studentList[$i]['school_year'] = "유치";
				break;
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				$studentList[$i]['school_year'] = "초등 ".$studentList[$i]['school_year']."학년";
				break;
				case 7:
				case 8:
				case 9:
				$studentList[$i]['school_year'] = "중등 ".($studentList[$i]['school_year']-6)."학년";
				break;
				case 10:
				case 11:
				case 12:
				$studentList[$i]['school_year'] = "고등 ".($studentList[$i]['school_year']-9)."학년";
				break;
				case 13:
				$studentList[$i]['school_year'] = "일반";
				break;
			}
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"studentList"	=>	$studentList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN
		);




		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/students/students-delete-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

  public function studentWrite()
	{
		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$status = $status ?? "all";

		$param = "num=".$num."&srcN=".$srcN."&srcType=".$srcType."&status=".$status;

		//반이 있는지 확인
		$academy_seq = $this->session->userdata("academy_seq");
		$where = empty($academy_seq) ? "" : "AND academy_seq = '{$academy_seq}'";
		$data = array(
			"where"	=>	$where
		);

		$isClass = $this->academi_model->getAcademiClassTotalCount($data);

		if($isClass <= 0){
			$this->msg("반이 등록되지 않았습니다.");
			$this->goURL("/admin/academiAdm/academiClassList");
			exit;
		}

		$depth1 = "admin";
		$depth2 = "studentList";
		$title = "회원등록";
		$sub_title = "이용안내";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

    $data = array(
			"where"	=>	"",
			"limit"	=>	""
		);
		$academiList = $this->academi_model->getAcademiList($data);

		$data = array(
			"where"	=>	"",
			"limit"	=>	""
		);
		$academiClassList = $this->academi_model->getAcademiClassList($data);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
      "academiList" =>  $academiList,
      "academiClassList"  =>  $academiClassList,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"status"		=>	$status,
			"num"				=>	$num,
			"param"			=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/students/students-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function studentWriteProc()
	{
		$user_name = $this->input->post("user_name");
    $user_id = $this->input->post("user_id");
    $user_password = $this->input->post("user_password");
    $academy_seq = $this->input->post("academy_seq");
    $email = $this->input->post("email");
    $gender = $this->input->post("gender");
    $phone = $this->input->post("phone");
    $parent_phone = $this->input->post("parent_phone");
    $school_name = $this->input->post("school_name");
    $school_year = $this->input->post("school_year");
    $academy_class_seq = $this->input->post("academy_class_seq");
		$status = $this->input->post("status");
		$reg_date = date("Y-m-d H:i:s");

		$user_id = strtolower($user_id);


		$duplicateId = $this->academi_model->getDuplicateUserId($user_id);

		if($duplicateId>0){
			echo '{"result":"failed","msg":"duplicate id"}';
			exit;
		}

		//승인인원체크
		if($status == "C"){
			$student_total = $this->academi_model->getStudentTotal($academy_seq);
			$current_total = $this->academi_model->getCurrentStudent($academy_seq);
			if($student_total<=$current_total){
				echo '{"result":"failed","msg":"student over"}';
				exit;
			}
		}



		$data = array(
			"user_name"	=>	$user_name,
			"user_id"	=>	$user_id,
			"user_password"	=>	$this->encrypt("password",$user_password),
			"academy_seq"	=>	$academy_seq,
			"email"	=>	$email,
			"gender"	=>	$gender,
			"phone"	=>	str_replace(",","",$phone),
			"parent_phone"	=>	str_replace(",","",$parent_phone),
			"school_name"	=>	$school_name,
			"school_year"	=>	$school_year,
			"academy_class_seq"	=>	$academy_class_seq,
			"status"		=>	$status,
			"reg_date"	=>	$reg_date,
		);

		$result = $this->academi_model->insertUser($data);

		echo '{"result":"success"}';
		exit;
	}

	public function studentModify($user_seq)
	{
		$depth1 = "admin";
		$depth2 = "studentList";
		$title = "회원수정";
		$sub_title = "회원수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$mode = $this->input->get("mode") ?? "";

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$status = $status ?? "all";

    $data = array(
			"where"	=>	"",
			"limit"	=>	""
		);
		$academiList = $this->academi_model->getAcademiList($data);

		$data = array(
			"where"	=>	"",
			"limit"	=>	""
		);
		$academiClassList = $this->academi_model->getAcademiClassList($data);

		$userData = $this->member_model->getStudent($user_seq);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
      "academiList" =>  $academiList,
      "academiClassList"  =>  $academiClassList,
			"userData"	=>	$userData,
			"user_seq"	=>	$user_seq,
			"mode"	=>	$mode,
			"num"	=>	$num,
			"srcN"	=>	$srcN,
			"srcType"	=>	$srcType,
			"status"	=>	$status,
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/students/students-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function studentModifyProc()
	{
		$user_seq = $this->input->post("user_seq");
		$user_name = $this->input->post("user_name");
    $user_password = $this->input->post("user_password");
		$user_password_org = $this->input->post("user_password_org");
    $academy_seq = $this->input->post("academy_seq");
    $email = $this->input->post("email");
    $gender = $this->input->post("gender");
    $phone = $this->input->post("phone");
    $parent_phone = $this->input->post("parent_phone");
    $school_name = $this->input->post("school_name");
    $school_year = $this->input->post("school_year");
    $academy_class_seq = $this->input->post("academy_class_seq");
		$status = $this->input->post("status");
		$reg_date = date("Y-m-d H:i:s");

		//승인인원체크
		if($status == "C"){
			$student_total = $this->academi_model->getStudentTotal($academy_seq);
			$current_total = $this->academi_model->getCurrentStudent($academy_seq);
			if($student_total <= $current_total){
				echo '{"result":"failed","msg":"student over"}';
				exit;
			}
		}

		if(empty($user_password)){
			$user_password = $this->decrypt("password",$user_password_org);
		}

		$data = array(
			"user_name"	=>	$user_name,
			"user_password"	=>	$this->encrypt("password",$user_password),
			"academy_seq"	=>	$academy_seq,
			"email"	=>	$email,
			"gender"	=>	$gender,
			"phone"	=>	str_replace(",","",$phone),
			"parent_phone"	=>	str_replace(",","",$parent_phone),
			"school_name"	=>	$school_name,
			"school_year"	=>	$school_year,
			"academy_class_seq"	=>	$academy_class_seq,
			"status"		=>	$status,
			"update_time"	=>	$reg_date,
		);

		$result = $this->academi_model->updateUser($user_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

	public function studentDelete($user_seq)
	{
		$this->academi_model->deleteUser($user_seq);
		$this->msg("삭제되었습니다.");
		$this->goURL("/admin/academiAdm/studentList");
		exit;
	}

  //반매칭 리스트
	public function academiClassList()
	{
		$depth1 = "admin";
		$depth2 = "academiClassList";
		$title = "반 관리";
		$sub_title = "반 관리";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$where = "";

		if(!empty($srcN)){
			$where .= "AND class_name LIKE '%{$srcN}%'";
		}
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getAcademiClassTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	" ORDER BY reg_date DESC",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$classList = $this->academi_model->getAcademiClassList($whereData);

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
		$classList = $this->add_counting($classList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/academiClassList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($classList); $i++)
		{
			$classList[$i]['reg_date'] = date("Y-m-d",strtotime($classList[$i]['reg_date']));
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"classList"	=>	$classList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN
		);




		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/academi/academi-class-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

  public function academiClassWrite()
	{
		$depth1 = "admin";
		$depth2 = "academiClassList";
		$title = "반 등록";
		$sub_title = "반 등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/academi/academi-class-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function academiClassWriteProc()
	{
		$academy_seq = $this->session->userdata("academy_seq");
		$class_name = $this->input->post("class_name");
		$reg_date = date("Y-m-d H:i:s");

		$data = array(
			"academy_seq"	=>	$academy_seq,
			"class_name"	=>	$class_name,
			"reg_date"		=>	$reg_date
		);

		$result = $this->academi_model->insertAcademyClass($data);

		echo '{"result":"success"}';
		exit;
	}

	public function academiClassModify($academy_class_seq)
	{
		$depth1 = "admin";
		$depth2 = "academiClassList";
		$title = "반 등록";
		$sub_title = "반 등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$academyClassData = $this->academi_model->getAcademiClass($academy_class_seq);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"academyClassData"	=>	$academyClassData,
			"academy_class_seq"	=>	$academy_class_seq
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/academi/academi-class-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function academiClassModifyProc()
	{
		$academy_class_seq = $this->input->post("academy_class_seq");
		$class_name = $this->input->post("class_name");

		$data = array(
			"class_name"	=>	$class_name
		);

		$result = $this->academi_model->updateAcademyClass($academy_class_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

	public function academiClassDeleteProc()
	{
		$academy_class_seq = $this->input->post("academy_class_seq");
		$class_name = $this->input->post("class_name");

		$data = array(
			"class_name"	=>	$class_name
		);

		$result = $this->academi_model->deleteAcademyClass($academy_class_seq,$data);

		if($result['result']=="success"){
			echo '{"result":"success"}';
			exit;
		}else{
			echo '{"result":"failed"}';
			exit;
		}


	}


  //숙재배정 리스트
	public function homeworkList()
	{
		$depth1 = "admin";
		$depth2 = "homeworkList";
		$title = "숙제배정";
		$sub_title = "숙제배정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$where = "";
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getHomeworkTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	"ORDER BY reg_date DESC",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$homeworkList = $this->academi_model->getHomeworkList($whereData);

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
		$homeworkList = $this->add_counting($homeworkList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/homeworkList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($homeworkList); $i++)
		{
			$homeworkList[$i]['reg_date'] = date("Y-m-d",strtotime($homeworkList[$i]['reg_date']));
			$homeworkList[$i]['final_date'] = date("Y-m-d",strtotime($homeworkList[$i]['final_date']));
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"homeworkList"	=>	$homeworkList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/homework/homework-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//숙재배정 등록
	public function homeworkWrite()
	{
		$depth1 = "admin";
		$depth2 = "homeworkList";
		$title = "숙제배정 등록";
		$sub_title = "숙제배정 등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$where = "";
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$whereData = array(
			"where"	=>	$where,
			"limit"	=>	""
		);

		$academy_class = $this->academi_model->getAcademiClassList($whereData);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"academy_class"	=>	$academy_class
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/homework/homework-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function allocationUserList()
	{
		$academy_class = $this->input->post("academy_class");
		$user_search_type = $this->input->post("user_search_type");
		$user_search_text = $this->input->post("user_search_text");

		$where = " AND status = 'C'";
		if(!empty($academy_class)){
			$where .= " AND academy_class_seq = '{$academy_class}'";
		}

		if(!empty($user_search_type)){
			if(!empty($user_search_text)){
				if($user_search_type == "name"){
					$where .= " AND user_name LIKE '%{$user_search_text}%'";
				}else if($user_search_type == "id"){
					$where .= " AND user_id LIKE '%{$user_search_text}%'";
				}
			}
		}else{
			if(!empty($user_search_text)){
					$where .= " AND (user_name LIKE '%{$user_search_text}%' OR user_id LIKE '%{$user_search_text}%')";
			}
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$returnData = $this->academi_model->getSearchUserList($where);

		if(count($returnData)>0){
			for($i=0; $i<count($returnData); $i++){
				switch($returnData[$i]['school_year']){
					case 0:
					$returnData[$i]['school_year'] = "유치";
					break;
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
					case 6:
					$returnData[$i]['school_year'] = "초등 ".$returnData[$i]['school_year']."학년";
					break;
					case 7:
					case 8:
					case 9:
					$returnData[$i]['school_year'] = "중등 ".($returnData[$i]['school_year']-6)."학년";
					break;
					case 10:
					case 11:
					case 12:
					$returnData[$i]['school_year'] = "고등 ".($returnData[$i]['school_year']-9)."학년";
					break;
					case 13:
					$returnData[$i]['school_year'] = "일반";
					break;
				}
			}
		}

		echo '{"result" : "success" , "data" : '.json_encode($returnData).'}';
		exit;
	}

	public function allocationContentList()
	{
		$content_category = $this->input->post("content_category");
		$content_search_type = $this->input->post("content_search_type");
		$content_search_text = $this->input->post("content_search_text");

		$where = "AND content_sharing_yn = 'Y'";
		if(!empty($content_category)){
			$where .= " AND content_category = '{$content_category}'";
		}

		if(!empty($content_search_type)){
			if(!empty($content_search_text)){
				if($content_search_type == "title"){
					$where .= " AND content_title LIKE '%{$content_search_text}%'";
				}else if($content_search_type == "code"){
					$where .= " AND content_code LIKE '%{$content_search_text}%'";
				}
			}
		}else{
			if(!empty($content_search_text)){
					$where .= " AND (content_title LIKE '%{$content_search_text}%' OR content_code LIKE '%{$content_search_text}%')";
			}
		}

		$returnData = $this->academi_model->getSearchContentList($where);

		if(count($returnData)>0){
			for($i=0; $i<count($returnData); $i++){
				switch($returnData[$i]['content_category']){
					case "M":
					$returnData[$i]['content_category'] = "리딩터치 메인북(정독)";
					break;
					case "S":
					$returnData[$i]['content_category'] = "리딩터치 스페셜북(다독)";
					break;
					case "T":
					$returnData[$i]['content_category'] = "원서,스토리";
					break;
					case "D":
					$returnData[$i]['content_category'] = "드라마,영화";
					break;
					case "K":
					$returnData[$i]['content_category'] = "음악(Song,Pop,Musical etc)";
					break;
					case "N":
					$returnData[$i]['content_category'] = "뉴스,다큐";
					break;
					case "X":
					$returnData[$i]['content_category'] = "기타";
					break;
				}
			}
		}

		echo '{"result" : "success" , "data" : '.json_encode($returnData).'}';
		exit;
	}

	public function allocationProc()
	{
		$academy_class = $this->input->post("academy_class");
		$user_seq_arr = $this->input->post("user_seq");
		$content_seq_arr = $this->input->post("content_seq");
		$homework_title = $this->input->post("homework_title");
		$final_date = $this->input->post("final_date");

		$data = array(
			"academy_class"	=>	$academy_class,
			"userData"	=>	$user_seq_arr,
			"contentData"	=>	$content_seq_arr,
			"homework_title"	=>	$homework_title,
			"final_date"			=>	$final_date
		);

		$result = $this->academi_model->insertAllocation($data);

		if($result){
			echo '{"result":"success"}';
			exit;
		}else{
			echo '{"result":"failed"}';
			exit;
		}
	}

	public function addContentList()
	{

		$content_seq_arr = $this->input->post("content_seq");

		$result = $this->academi_model->getContentArray($content_seq_arr);

		for($i=0; $i<count($result); $i++){
			switch($result[$i]['content_category']){
				case "T":
				$result[$i]['content_category'] = "원서음원";
				break;
				case "D":
				$result[$i]['content_category'] = "드라마,영화(영어)";
				break;
				case "K":
				$result[$i]['content_category'] = "음악(Song,Pop,Musical etc)";
				break;
				case "L":
				$result[$i]['content_category'] = "듣기평가";
				break;
				case "N":
				$result[$i]['content_category'] = "뉴스,다큐(영어)";
				break;
				case "H":
				$result[$i]['content_category'] = "한글음원";
				break;
				case "X":
				$result[$i]['content_category'] = "기타";
				break;
			}
		}

		$returnArr = array(
			"data"	=>	$result
		);

		echo json_encode($returnArr);
		exit;
	}

	public function addStudentList()
	{

		$student_seq = $this->input->post("student_seq");

		$result = $this->academi_model->getStudentArray($student_seq);

		for($i=0; $i<count($result); $i++){
			switch($result[$i]['school_year']){
				case 0:
				$result[$i]['school_year'] = "유치";
				break;
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				$result[$i]['school_year'] = "초등 ".$result[$i]['school_year']."학년";
				break;
				case 7:
				case 8:
				case 9:
				$result[$i]['school_year'] = "중등 ".($result[$i]['school_year']-6)."학년";
				break;
				case 10:
				case 11:
				case 12:
				$result[$i]['school_year'] = "고등 ".($result[$i]['school_year']-9)."학년";
				break;
				case 13:
				$result[$i]['school_year'] = "일반";
				break;

			}
		}

		$returnArr = array(
			"data"	=>	$result
		);

		echo json_encode($returnArr);
		exit;
	}

	public function firstContentList($homework_seq)
	{
		$content_arr = $this->academi_model->getFirstContentArray($homework_seq);

		$content_seq_arr = explode(",",$content_arr);

		$returnArr = array(
			"data"	=>	$content_seq_arr
		);

		echo json_encode($returnArr);
		exit;
	}

	public function firstStudentList($homework_seq)
	{
		$user_arr = $this->academi_model->getFirstStudentArray($homework_seq);

		$user_seq_arr = explode(",",$user_arr);

		$returnArr = array(
			"data"	=>	$user_seq_arr
		);

		echo json_encode($returnArr);
		exit;
	}

	//숙재배정 수정
	public function homeworkModify($allocation_seq)
	{
		$depth1 = "admin";
		$depth2 = "homeworkList";
		$title = "숙제배정 수정";
		$sub_title = "숙제배정 수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$where = "";

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$whereData = array(
			"where"	=>	$where,
			"limit"	=>	""
		);

		$academy_class = $this->academi_model->getAcademiClassList($whereData);

		$allocationData = $this->academi_model->getAllocationData($allocation_seq);

		for($i=0; $i<count($allocationData['userData']); $i++){
			switch($allocationData['userData'][$i]['school_year']){
				case 0:
				$allocationData['userData'][$i]['school_year'] = "유치";
				break;
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				$allocationData['userData'][$i]['school_year'] = "초등 ".$allocationData['userData'][$i]['school_year']."학년";
				break;
				case 7:
				case 8:
				case 9:
				$allocationData['userData'][$i]['school_year'] = "중등 ".($allocationData['userData'][$i]['school_year']-6)."학년";
				break;
				case 10:
				case 11:
				case 12:
				$allocationData['userData'][$i]['school_year'] = "고등 ".($allocationData['userData'][$i]['school_year']-9)."학년";
				break;
				case 13:
				$allocationData['userData'][$i]['school_year'] = "일반";
				break;
			}
		}

		for($i=0; $i<count($allocationData['contentData']); $i++){
			switch($allocationData['contentData'][$i]['content_category']){
				case "M":
				$allocationData['contentData'][$i]['content_category'] = "리딩터치 메인북(정독)";
				break;
				case "S":
				$allocationData['contentData'][$i]['content_category'] = "리딩터치 스페셜북(다독)";
				break;
				case "T":
				$allocationData['contentData'][$i]['content_category'] = "원서,스토리";
				break;
				case "D":
				$allocationData['contentData'][$i]['content_category'] = "드라마,영화";
				break;
				case "K":
				$allocationData['contentData'][$i]['content_category'] = "음악(Song,Pop,Musical etc)";
				break;
				case "N":
				$allocationData['contentData'][$i]['content_category'] = "뉴스,다큐";
				break;
				case "X":
				$allocationData['contentData'][$i]['content_category'] = "기타";
				break;
			}
		}


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"academy_class"	=>	$academy_class,
			"allocationData"	=>	$allocationData,
			"homework_seq"	=>	$allocation_seq
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/homework/homework-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function allocationModifyProc()
	{
		$homework_seq = $this->input->post("homework_seq");
		$academy_class = $this->input->post("academy_class");
		$user_seq_arr = $this->input->post("user_seq");
		$content_seq_arr = $this->input->post("content_seq");
		$homework_title = $this->input->post("homework_title");
		$final_date = $this->input->post("final_date");

		$new_user_seq = $this->input->post("new_user_seq");
		$delete_user_seq = $this->input->post("delete_user_seq");
		$new_content_seq = $this->input->post("new_content_seq");
		$delete_content_seq = $this->input->post("delete_content_seq");

		$data = array(
			"homework_title"	=>	$homework_title,
			"homework_seq"	=>	$homework_seq,
			"academy_class"	=>	$academy_class,
			"userData"	=>	$user_seq_arr,
			"contentData"	=>	$content_seq_arr,
			"final_date"	=>	$final_date,
			"new_user_seq"	=>	$new_user_seq,
			"delete_user_seq"	=>	$delete_user_seq,
			"new_content_seq"	=>	$new_content_seq,
			"delete_content_seq"	=>	$delete_content_seq
		);

		$result = $this->academi_model->updateAllocation($data);

		if($result){
			echo '{"result":"success"}';
			exit;
		}else{
			echo '{"result":"failed"}';
			exit;
		}
	}

	public function homeworkDelete($seq)
	{
		$this->academi_model->deleteHomework($seq);
		$this->msg("삭제했습니다.");
		$this->goURL("/admin/academiAdm/homeworkList");
		exit;
	}

	//숙재현황 리스트
	public function homeworkCurrentList()
	{
		$depth1 = "admin";
		$depth2 = "homeworkCurrentList";
		$title = "숙제배정인원";
		$sub_title = "숙제배정인원";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$where = "";

		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%'";
			}
		}
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND a.academy_seq = '{$academy_seq}'";
		}

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getHomeworkCurrentTotalCount($whereData);

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

		$homeworkList = $this->academi_model->getHomeworkCurrentList($whereData);

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
		$homeworkList = $this->add_counting($homeworkList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/homeworkCurrentList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($homeworkList); $i++)
		{
			$homeworkList[$i]['user_per'] = round($homeworkList[$i]['complete_cnt']/$homeworkList[$i]['cnt']*100);
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"homeworkList"	=>	$homeworkList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN
		);




		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/homework/homework-current-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//숙재현황 리스트
	public function homeworkDetail($user_seq)
	{
		$memberData = $this->member_model->getStudent($user_seq);
		$user_id = $memberData['user_id'];

		$depth1 = "admin";
		$depth2 = "homeworkCurrentList";
		$title = $memberData['user_name']." 숙제현황";
		$sub_title = "숙제현황";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$where = "AND user_id = '{$user_id}'";

		$page_size = 10;
		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->academi_model->getHomeworkDetailTotalCount($whereData);

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

		$homeworkList = $this->academi_model->getHomeworkDetailList($whereData);

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
		$homeworkList = $this->add_counting($homeworkList,$list_total,$num);

		$paging = $this->make_paging2("/admin/academiAdm/homeworkDetail/".$user_seq,$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;


		//customSetting
		for($i = 0; $i < count($homeworkList); $i++)
		{
			if($homeworkList[$i]['content_type'] == "C"){
				$content_url = "/upload/academy/".$homeworkList[$i]["content_academy_seq"]."/content/".$homeworkList[$i]['content_file'];
			}else{
				$content_url = "/upload/audio/".$homeworkList[$i]['content_file'];
			}

			$audio_url = $_SERVER['DOCUMENT_ROOT'].$content_url;
	    $getID3 = new getID3;
	    $file_info = $getID3->analyze($audio_url);
			$homeworkList[$i]['content_time'] = $file_info['playtime_seconds'];

			if($homeworkList[$i]['update_time'] >= $homeworkList[$i]['content_time']){
				$homeworkList[$i]['update_time'] = $homeworkList[$i]['content_time'];
			}


			$homeworkList[$i]['content_time_str'] = $this->getTimeFromSeconds($file_info['playtime_seconds']);

			$homeworkList[$i]['update_time_str'] = $this->getTimeFromSeconds($homeworkList[$i]['update_time']);

			$homeworkList[$i]['user_per'] = round($homeworkList[$i]['update_time']/$homeworkList[$i]['content_time']*100);
			$homeworkList[$i]['user_per'] = ($homeworkList[$i]['user_per'] > 100) ? 100 : $homeworkList[$i]['user_per'];
			$homeworkList[$i]['color_class'] = ($homeworkList[$i]['user_per'] == "100") ? "green" : "blue";
			switch($homeworkList[$i]['status']){
				case "R":
				$homeworkList[$i]['status'] = "<span style='color:#28a745'>숙제완료</span>";
				break;
				case "M":
				$homeworkList[$i]['status'] = "숙제중";
				break;
				case "D":
				$homeworkList[$i]['status'] = "숙제대기";
				break;
			}

			$homeworkList[$i]['final_date'] = date("Y-m-d",strtotime($homeworkList[$i]['final_date']));

			if($homeworkList[$i]['end_homework']=="Y" && $homeworkList[$i]['status'] != "<span style='color:#28a745'>숙제완료</span>"){
				$homeworkList[$i]['final_date'] = "<span style='color:red'>".$homeworkList[$i]['final_date']."</span>";
				$homeworkList[$i]['status'] = "<span style='color:red'>미완료</span>";
			}

		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"homeworkList"	=>	$homeworkList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN
		);




		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/homework/homework-detail-list",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function contentListPop()
	{
		$depth1 = "admin";
		$depth2 = "homeworkList";
		$title = "숙제배정하기";
		$sub_title = "숙제배정하기";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/homework/content-list-pop",$content_data);


	}

	public function studentListPop()
	{
		$depth1 = "admin";
		$depth2 = "homeworkList";
		$title = "숙제배정하기";
		$sub_title = "숙제배정하기";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND academy_seq = '{$academy_seq}'";
		}

		$whereData = array(
			"where"	=>	$where,
			"limit"	=>	""
		);

		$academy_class = $this->academi_model->getAcademiClassList($whereData);

		$num = $num ?? 0;

		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "";

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"academy_class"	=>	$academy_class
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/homework/student-list-pop",$content_data);


	}

	public function studentDownLoad()
	{


		$this->load->library('excel');

		$srcN = $this->input->post('srcN_excel');
		$srcType = $this->input->post('srcType_excel');
		$status = $this->input->post('status_excel');


		$srcN = $srcN ?? "";

		$srcType = $srcType ?? "all";

		$status = $status ?? "all";

		$where = "";

		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%'";
			}
		}

		if($status!="all"){
			$where .= "AND user.status = '{$status}'";
		}

		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND user.academy_seq = '{$academy_seq}'";
		}

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	""
		);

		$studentList = $this->academi_model->getStudentList($whereData);

		//customSetting
		for($i = 0; $i < count($studentList); $i++)
		{
			$studentList[$i]['reg_date'] = date("Y-m-d",strtotime($studentList[$i]['reg_date']));

      switch($studentList[$i]['status']){
        case "C":
        $studentList[$i]['status'] = "승인";
        break;

        case "R":
        $studentList[$i]['status'] = "대기";
        break;

        case "L":
        $studentList[$i]['status'] = "탈퇴";
        break;

        case "D":
        $studentList[$i]['status'] = "삭제";
        break;
      }

			switch($studentList[$i]['school_year']){
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				$studentList[$i]['school_year'] = "초등 ".$studentList[$i]['school_year']."학년";
				break;
				case 7:
				case 8:
				case 9:
				$studentList[$i]['school_year'] = "중등 ".($studentList[$i]['school_year']-6)."학년";
				break;
				case 10:
				case 11:
				case 12:
				$studentList[$i]['school_year'] = "고등 ".($studentList[$i]['school_year']-9)."학년";
				break;
			}
		}




		// 워크시트 1번째는 활성화
		$this->excel->setActiveSheetIndex(0);

		// A1의 내용을 입력
		$this->excel->getActiveSheet()->setCellValue('A1', '회원아이디');
		$this->excel->getActiveSheet()->setCellValue('B1', '회원이름');
		$this->excel->getActiveSheet()->setCellValue('C1', '이메일');
		$this->excel->getActiveSheet()->setCellValue('D1', '성별');
		$this->excel->getActiveSheet()->setCellValue('E1', '핸드폰');
		$this->excel->getActiveSheet()->setCellValue('F1', '부모연락처');
		$this->excel->getActiveSheet()->setCellValue('G1', '학교이름');
		$this->excel->getActiveSheet()->setCellValue('H1', '학년');
		$this->excel->getActiveSheet()->setCellValue('I1', '반');
		$this->excel->getActiveSheet()->setCellValue('J1', '상태');
		$this->excel->getActiveSheet()->setCellValue('K1', '등록일');


		for($i=0; $i<count($studentList); $i++){
		  $this->excel->getActiveSheet()->setCellValue('A'.($i+2),$studentList[$i]['user_id']);
			$this->excel->getActiveSheet()->setCellValue('B'.($i+2),$studentList[$i]['user_name']);
			$this->excel->getActiveSheet()->setCellValue('C'.($i+2),$studentList[$i]['email']);
			$this->excel->getActiveSheet()->setCellValue('D'.($i+2),$studentList[$i]['gender']);
			$this->excel->getActiveSheet()->setCellValue('E'.($i+2),$studentList[$i]['phone']);
			$this->excel->getActiveSheet()->setCellValue('F'.($i+2),$studentList[$i]['parent_phone']);
			$this->excel->getActiveSheet()->setCellValue('G'.($i+2),$studentList[$i]['school_name']);
			$this->excel->getActiveSheet()->setCellValue('H'.($i+2),$studentList[$i]['school_year']);
			$this->excel->getActiveSheet()->setCellValue('I'.($i+2),$studentList[$i]['class_name']);
			$this->excel->getActiveSheet()->setCellValue('J'.($i+2),$studentList[$i]['status']);
			$this->excel->getActiveSheet()->setCellValue('K'.($i+2),$studentList[$i]['reg_date']);

		}

		$this->excel->setActiveSheetIndex(0);

		$title = "회원내역_".date("Ymd").".xls";

		$filename = iconv("UTF-8", "EUC-KR", $title); // 엑셀 파일 이름

		header('Content-Type: application/vnd.ms-excel'); //mime 타입
		header('Content-Disposition: attachment;filename="'.$filename.'"'); // 브라우저에서 받을 파일 이름
		header('Cache-Control: max-age=0'); //no cache


		// Excel5 포맷으로 저장 엑셀 2007 포맷으로 저장하고 싶은 경우 'Excel2007'로 변경합니다.
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		// 서버에 파일을 쓰지 않고 바로 다운로드 받습니다.
		$objWriter->save('php://output');
	}

	public function updateUserStatus()
	{
		$user_status = $this->input->post("user_status");
		$user_seq_arr = $this->input->post("chk");

		$student_arr = $this->academi_model->getStudentArray($user_seq_arr);

		for($i=0; $i<count($student_arr); $i++){
			$user_seq = $student_arr[$i]['user_seq'];
			//승인인원체크
			if($user_status == "C"){
				$student_total = $this->academi_model->getStudentTotal($student_arr[$i]['academy_seq']);
				$current_total = $this->academi_model->getCurrentStudent($student_arr[$i]['academy_seq']);
				if($student_total <= $current_total){
					echo '{"result":"failed","msg":"student over"}';
					exit;
				}
			}

			$this->academi_model->updateUserStatus($user_seq,$user_status);
		}

		echo '{"result":"success"}';
		exit;


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
