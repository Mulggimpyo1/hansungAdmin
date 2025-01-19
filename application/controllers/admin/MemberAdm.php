<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("board_model");
		$this->load->model("member_model");
		$this->load->model("school_model");
		$this->load->model("config_model");
		$this->load->model("adm_model");
		$this->load->library('excel');

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
			$this->memberList();
		}

	}

  public function memberList()
	{
		$depth1 = "order";
		$depth2 = "memberList";
		$title = "회원리스트";
		$sub_title = "회원리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcLevel = $this->input->get('srcLevel');
		$srcClass = $this->input->get('srcClass');
		$srcSchool = $this->input->get('srcSchool');
		$srcYear = $this->input->get('srcYear');
		$srcStatus = $this->input->get('srcStatus');
		$page_size = $this->input->get('page_size');

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcLevel = $srcLevel=="" ? "all" : $srcLevel;

		$srcClass = empty($srcClass) ? "all" : $srcClass;

		$srcSchool = empty($srcSchool) ? "all" : $srcSchool;

		$srcYear = empty($srcYear) ? "all" : $srcYear;

		$srcStatus = empty($srcStatus) ? "all" : $srcStatus;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&srcLevel={$srcLevel}&srcClass={$srcClass}&srcSchool={$srcSchool}&srcYear={$srcYear}&srcStatus={$srcStatus}&page_size={$page_size}";

		$where = "";

		if(!empty($srcN)){
			$where .= "AND (users.user_name LIKE '%{$srcN}%' OR users.user_id LIKE '%{$srcN}%')";
		}

		if($srcSchool != 'all'){
			if($srcSchool == "None"){
				$where .= "AND (users.school_seq = '' OR users.school_seq = 0)";
			}else{
				$where .= "AND users.school_seq = '{$srcSchool}'";
			}

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

		if($srcLevel != 'all'){
			$where .= "AND users.user_level = '{$srcLevel}'";
		}

		if($srcStatus != 'all'){
			$where .= "AND users.user_status = '{$srcStatus}'";
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
		$list_total = $this->member_model->getMemberTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&srcLevel={$srcLevel}&srcClass={$srcClass}&srcSchool={$srcSchool}&srcYear={$srcYear}&srcStatus={$srcStatus}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$memberList = $this->member_model->getMemberList($whereData);

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
		$memberList = $this->add_counting($memberList,$list_total,$num);

		$paging = $this->make_paging2("/admin/memberAdm/memberList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($memberList); $i++)
		{
			$memberList[$i]['reg_date'] = date("Y-m-d",strtotime($memberList[$i]['reg_date']));
			if(empty($memberList[$i]['last_login_time'])){
				$memberList[$i]['last_login_time'] = "-";
			}else{
				$memberList[$i]['last_login_time'] = date("Y-m-d",strtotime($memberList[$i]['last_login_time']));
			}


      switch($memberList[$i]['user_level']){
        case "0":
        $memberList[$i]['user_level'] = "본사관리자";
        break;
				case "1":
        $memberList[$i]['user_level'] = "기관관리자";
        break;
				case "2":
        $memberList[$i]['user_level'] = "학급관리자";
        break;
				case "6":
        $memberList[$i]['user_level'] = "학생회원";
        break;
				case "7":
        $memberList[$i]['user_level'] = "일반회원";
        break;
      }

			switch($memberList[$i]['user_status']){
        case "C":
        $memberList[$i]['user_status'] = "승인";
        break;
				case "L":
        $memberList[$i]['user_status'] = "<span style='color:red;'>탈퇴</span>";
        break;
				case "D":
        $memberList[$i]['user_status'] = "<span style='color:red;'>삭제</span>";
        break;
      }

			if(empty($memberList[$i]['school_year'])){
				$memberList[$i]['school_year'] = "-";
			}
			if(empty($memberList[$i]['school_class'])){
				$memberList[$i]['school_class'] = "-";
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

		$schoolList = $this->school_model->getSchoolList($whereData);

		$classList = $this->school_model->getClassGroupList();

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"memberList"	=>	$memberList,
			"schoolList"	=>	$schoolList,
			"classList"		=>	$classList,
			"paging"		=>	$paging,
			"srcLevel"		=>	$srcLevel,
			"srcN"			=>	$srcN,
			"srcSchool"		=>	$srcSchool,
			"srcClass"		=>	$srcClass,
			"srcYear"		=>	$srcYear,
			"srcStatus"	=>	$srcStatus,
			"page_size"		=>	$page_size,
			"num"				=>	$num,
      "list_total"  =>  $list_total,
			"param"	=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/member/member-list",$content_data);
		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//회원수정
	public function memberModify($user_seq)
	{
		$depth1 = "order";
		$depth2 = "memberList";
		$title = "회원관리";
		$sub_title = "회원관리";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcLevel = $this->input->get('srcLevel');
		$srcClass = $this->input->get('srcClass');
		$srcSchool = $this->input->get('srcSchool');
		$srcYear = $this->input->get('srcYear');
		$srcStatus = $this->input->get('srcStatus');
		$page_size = $this->input->get('page_size');

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcLevel = $srcLevel=="" ? "all" : $srcLevel;

		$srcClass = empty($srcClass) ? "all" : $srcClass;

		$srcSchool = empty($srcSchool) ? "all" : $srcSchool;

		$srcYear = empty($srcYear) ? "all" : $srcYear;

		$srcStatus = empty($srcStatus) ? "all" : $srcStatus;

		$page_size = empty($page_size) ? 20 : $page_size;

		$param = "?num={$num}&srcN={$srcN}&srcLevel={$srcLevel}&srcClass={$srcClass}&srcSchool={$srcSchool}&srcYear={$srcYear}&srcStatus={$srcStatus}&page_size={$page_size}";

		$userData = $this->member_model->getMember($user_seq);
		$contractData = $this->school_model->getContractList();

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	"",
			"limit"			=>	""
		);
		$classList = $this->school_model->getClassList($whereData);

		$locationData = $this->config_model->getConfig('location');

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"userData"	=>	$userData,
			"contractData"	=> $contractData,
			"classList"	=>	$classList,
			"locationData"	=>	$locationData,
			"param"	=>	$param,
			"user_seq"	=>	$user_seq
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/member/member-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function memberModifyProc()
	{
		$user_seq = $this->input->post("user_seq");
		$school_seq = $this->input->post("school_seq");
		$user_id = $this->input->post("user_id");
		$user_password = $this->input->post("user_password");
		$user_name = $this->input->post("user_name");
		$birthday = $this->input->post("birthday");
		$email = $this->input->post("email");
		$user_level = $this->input->post("user_level");
		$school_name = $this->input->post("school_name");
		$school_year = $this->input->post("school_year");
		$school_class = $this->input->post("school_class");
		$parent_name = $this->input->post("parent_name");
		$parent_phone = $this->input->post("parent_phone");
		$parent_email = $this->input->post("parent_email");
		$parent_zipcode = $this->input->post("parent_zipcode");
		$parent_addr1 = $this->input->post("parent_addr1");
		$parent_addr2 = $this->input->post("parent_addr2");
		$user_status = $this->input->post("user_status");
		$location = $this->input->post("location");


		$this->member_model->updateSchoolClassMember($user_seq,$school_seq,$school_name,$school_year,$school_class);


		$data = array(
			"school_seq"	=>	$school_seq,
			"user_id"	=>	$user_id,
			"user_name"	=>	$user_name,
			"birthday"	=>	$birthday,
			"email"	=>	$email,
			"user_level"	=>	$user_level,
			"school_name"	=>	$school_name,
			"school_year"	=>	$school_year,
			"school_class"	=>	$school_class,
			"parent_name"	=>	$parent_name,
			"parent_phone"	=>	$parent_phone,
			"parent_email"	=>	$parent_email,
			"parent_zipcode"	=>	$parent_zipcode,
			"parent_addr1"	=>	$parent_addr1,
			"parent_addr2"	=>	$parent_addr2,
			"user_status"		=>	$user_status,
			"location"	=>	$location,
			"update_time"	=>	date("Y-m-d H:i:s")
		);

		if(!empty($user_password)){
			$user_password = $this->encrypt("password",$user_password);
			$data["user_password"] = $user_password;
		}

		if($user_level==1){
			//기관관리자
			$result = $this->school_model->updateSchoolAdmin($user_seq,$school_seq);
			if($result==false){
				echo '{"result":"failed"}';
				exit;
			}
		}

		$result = $this->member_model->updateMember($data,$user_seq);

		echo '{"result":"success"}';
		exit;
	}

	//회원 엑셀 다운로드
	public function memberDownLoad()
	{

		$this->load->library('excel');

		$srcN = $this->input->get('srcN_excel');
		$srcLevel = $this->input->get('srcLevel_excel');
		$srcClass = $this->input->get('srcClass_excel');
		$srcSchool = $this->input->get('srcSchool_excel');
		$srcYear = $this->input->get('srcYear_excel');
		$srcStatus = $this->input->get('srcStatus_excel');

		$srcN = empty($srcN) ? "" : $srcN;

		$srcLevel = $srcLevel=="" ? "all" : $srcLevel;

		$srcClass = empty($srcClass) ? "all" : $srcClass;

		$srcSchool = empty($srcSchool) ? "all" : $srcSchool;

		$srcYear = empty($srcYear) ? "all" : $srcYear;

		$srcStatus = empty($srcStatus) ? "all" : $srcStatus;

		$where = "";

		if(!empty($srcN)){
			$where .= "AND (users.user_name LIKE '%{$srcN}%' OR users.user_id LIKE '%{$srcN}%')";
		}

		if($srcSchool != 'all'){
			if($srcSchool == "None"){
				$where .= "AND school.school_seq = ''";
			}else{
				$where .= "AND school.school_seq = '{$srcSchool}'";
			}

		}

		if($srcYear != 'all'){
			if($srcYear=="None"){
				$where .= "AND users.school_year = '{$srcYear}'";
			}else{
				$where .= "AND users.school_year = ''";
			}

		}

		if($srcClass != 'all'){
			$where .= "AND users.school_class = '{$srcClass}'";
		}

		if($srcLevel != 'all'){
			$where .= "AND users.user_level = '{$srcLevel}'";
		}

		if($srcStatus != 'all'){
			$where .= "AND users.user_status = '{$srcStatus}'";
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

		$params = "";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	""
		);

		$memberList = $this->member_model->getMemberList($whereData);

		//customSetting
		for($i = 0; $i < count($memberList); $i++)
		{
			$memberList[$i]['reg_date'] = date("Y-m-d",strtotime($memberList[$i]['reg_date']));
			if(empty($memberList[$i]['last_login_time'])){
				$memberList[$i]['last_login_time'] = "-";
			}else{
				$memberList[$i]['last_login_time'] = date("Y-m-d",strtotime($memberList[$i]['last_login_time']));
			}


      switch($memberList[$i]['user_level']){
        case "0":
        $memberList[$i]['user_level'] = "본사관리자";
        break;
				case "1":
        $memberList[$i]['user_level'] = "기관관리자";
        break;
				case "2":
        $memberList[$i]['user_level'] = "학급관리자";
        break;
				case "6":
        $memberList[$i]['user_level'] = "학생회원";
        break;
				case "7":
        $memberList[$i]['user_level'] = "일반회원";
        break;
      }

			switch($memberList[$i]['user_status']){
        case "C":
        $memberList[$i]['user_status'] = "승인";
        break;
				case "L":
        $memberList[$i]['user_status'] = "탈퇴";
        break;
				case "D":
        $memberList[$i]['user_status'] = "삭제";
        break;
      }

			if(empty($memberList[$i]['school_year'])){
				$memberList[$i]['school_year'] = "-";
			}
			if(empty($memberList[$i]['school_class'])){
				$memberList[$i]['school_class'] = "-";
			}
		}

		// 워크시트 1번째는 활성화
		$this->excel->setActiveSheetIndex(0);

		// A1의 내용을 입력
		$this->excel->getActiveSheet()->setCellValue('A1', '아이디');
		$this->excel->getActiveSheet()->setCellValue('B1', '이름');
		$this->excel->getActiveSheet()->setCellValue('C1', '생년월일');
		$this->excel->getActiveSheet()->setCellValue('D1', '이메일');
		$this->excel->getActiveSheet()->setCellValue('E1', '등급');
		$this->excel->getActiveSheet()->setCellValue('F1', '지역');
		$this->excel->getActiveSheet()->setCellValue('G1', '기관명');
		$this->excel->getActiveSheet()->setCellValue('H1', '학년');
		$this->excel->getActiveSheet()->setCellValue('I1', '반');
		$this->excel->getActiveSheet()->setCellValue('J1', '학부모이름');
		$this->excel->getActiveSheet()->setCellValue('K1', '학부모생년월일');
		$this->excel->getActiveSheet()->setCellValue('L1', '학부모휴대전화');
		$this->excel->getActiveSheet()->setCellValue('M1', '학부모이메일');
		$this->excel->getActiveSheet()->setCellValue('N1', '학부모우편번호');
		$this->excel->getActiveSheet()->setCellValue('O1', '학부모주소1');
		$this->excel->getActiveSheet()->setCellValue('P1', '학부모주소2');
		$this->excel->getActiveSheet()->setCellValue('Q1', '가입일');
		$this->excel->getActiveSheet()->setCellValue('R1', '최종접속일');
		$this->excel->getActiveSheet()->setCellValue('S1', '상태');


		for($i=0; $i<count($memberList); $i++){
		  $this->excel->getActiveSheet()->setCellValue('A'.($i+2),$memberList[$i]['user_id']);
			$this->excel->getActiveSheet()->setCellValue('B'.($i+2),$memberList[$i]['user_name']);
			$this->excel->getActiveSheet()->setCellValue('C'.($i+2),$memberList[$i]['birthday']);
			$this->excel->getActiveSheet()->setCellValue('D'.($i+2),$memberList[$i]['email']);
			$this->excel->getActiveSheet()->setCellValue('E'.($i+2),$memberList[$i]['user_level']);
			$this->excel->getActiveSheet()->setCellValue('F'.($i+2),$memberList[$i]['location']);
			$this->excel->getActiveSheet()->setCellValue('G'.($i+2),$memberList[$i]['school_name_org']);
			$this->excel->getActiveSheet()->setCellValue('H'.($i+2),$memberList[$i]['school_year']);
			$this->excel->getActiveSheet()->setCellValue('I'.($i+2),$memberList[$i]['school_class']);
			$this->excel->getActiveSheet()->setCellValue('J'.($i+2),$memberList[$i]['parent_name']);
			$this->excel->getActiveSheet()->setCellValue('K'.($i+2),$memberList[$i]['parent_birthday']);
			$this->excel->getActiveSheet()->setCellValue('L'.($i+2),$memberList[$i]['parent_phone']);
			$this->excel->getActiveSheet()->setCellValue('M'.($i+2),$memberList[$i]['parent_email']);
			$this->excel->getActiveSheet()->setCellValue('N'.($i+2),$memberList[$i]['parent_zipcode']);
			$this->excel->getActiveSheet()->setCellValue('O'.($i+2),$memberList[$i]['parent_addr1']);
			$this->excel->getActiveSheet()->setCellValue('P'.($i+2),$memberList[$i]['parent_addr2']);
			$this->excel->getActiveSheet()->setCellValue('Q'.($i+2),$memberList[$i]['reg_date']);
			$this->excel->getActiveSheet()->setCellValue('R'.($i+2),$memberList[$i]['last_login_time']);
			$this->excel->getActiveSheet()->setCellValue('S'.($i+2),$memberList[$i]['user_status']);

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

	//회원삭제
	public function deleteUsers()
	{
		$chk = $this->input->post("chk");

		for($i=0; $i<count($chk); $i++){
			$this->member_model->deleteUser($chk[$i]);
		}

		echo '{"result":"success"}';
		exit;
	}

	public function deleteUser()
	{
		$user_seq = $this->input->post("user_seq");
		$this->member_model->deleteuser($user_seq);

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
