<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SchoolAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("board_model");
		$this->load->model("member_model");
		$this->load->model("school_model");
		$this->load->model("adm_model");
		$this->load->model("config_model");
		$this->load->helper('load_controller');
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
			$this->schoolList();
		}

	}

  public function schoolList()
	{
		$depth1 = "order";
		$depth2 = "schoolList";
		$title = "기관리스트";
		$sub_title = "기관리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcType = empty($srcType) ? "all" : $srcType;

		$status = empty($status) ? "all" : $status;

		$page_size = empty($page_size) ? 20 : $page_size;

		$where = "";

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&page_size={$page_size}";




		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND school.school_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (school.school_name LIKE '%{$srcN}%' OR user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%')";
			}
		}

		if($status != 'all'){
			$where .= "AND school.status = '{$status}'";
		}

		//기관관리자 접근
		if($this->session->userdata("admin_level")==1){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= "AND school.school_seq = '{$admin_school_seq}'";
		}

		/*
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND user.academy_seq = '{$academy_seq}'";
		}
		*/

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->school_model->getSchoolTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&srcType={$srcType}&status={$status}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$schoolList = $this->school_model->getSchoolList($whereData);

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
		$schoolList = $this->add_counting($schoolList,$list_total,$num);

		$paging = $this->make_paging2("/admin/schoolAdm/schoolList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($schoolList); $i++)
		{
			$schoolList[$i]['reg_date'] = date("Y-m-d",strtotime($schoolList[$i]['reg_date']));

      switch($schoolList[$i]['status']){
        case "Y":
        $schoolList[$i]['status'] = "승인";
        break;

        case "N":
        $schoolList[$i]['status'] = "<span style='color:red'>미승인</span>";
        break;
      }

			if(empty($schoolList[$i]['admin_id'])){
				$schoolList[$i]['admin_id'] = "<span style='color:red'>미지정</span>";
			}

			if(empty($schoolList[$i]['admin_name'])){
				$schoolList[$i]['admin_name'] = "<span style='color:red'>미지정</span>";
			}
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"schoolList"	=>	$schoolList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"status"		=>	$status,
			"num"				=>	$num,
			"page_size"	=>	$page_size,
      "list_total"  =>  $list_total
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/school-list",$content_data);
		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function schoolWrite()
	{
		$depth1 = "order";
		$depth2 = "schoolList";
		$title = "학교등록";
		$sub_title = "학교등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&page_size={$page_size}";

		$contractData = $this->school_model->getContractList();

		$data = array(
			"where"	=>	"",
			"limit"	=>	""
		);

		$school_total = $this->school_model->getSchoolTotalCount($data);

		$school_no = "Z".sprintf('%06d',($school_total+1));

		$locationData = $this->config_model->getConfig('location');


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"contractData"	=>	$contractData,
			"school_no"	=>	$school_no,
			"param"	=>	$param,
			"locationData"	=>	$locationData
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/school-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//기관등록
	public function schoolWriteProc()
	{
		$contract_type = $this->input->post("contract_type");
		$school_no = $this->input->post("school_no");
		$school_name = $this->input->post("school_name");
		$school_classification = $this->input->post("school_classification");
		$zipcode = $this->input->post("zipcode");
		$addr_1 = $this->input->post("addr_1");
		$addr_2 = $this->input->post("addr_2");
		$lat = $this->input->post("lat");
		$lng = $this->input->post("lng");
		$tel = $this->input->post("tel");
		$status = $this->input->post("status");
		$contract_start_date = $this->input->post("contract_start_date");
		$contract_end_date = $this->input->post("contract_end_date");
		$memo = $this->input->post("memo");
		$email = $this->input->post("email");
		$book_yn = $this->input->post("book_yn");
		$location = $this->input->post("location");


		$self_write = $this->input->post("self_write");

		$logo_image = $_FILES['logo_image']['name'];
		$logo_image = empty($logo_image) ? "" : $logo_image;

		if(!empty($logo_image)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

			$tmp = explode('.', $logo_image);
			$ext = $tmp[1];

			$file_name = $school_no."_logo.".$ext;

			@unlink($upload_path.$file_name);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["logo_image"]["tmp_name"],$upload_path.$file_name);

			$logo_image = $file_name;
		}

		$data = array(
			"contract_type"	=>	$contract_type,
			"school_no"	=>	$school_no,
			"school_name"	=>	$school_name,
			"school_classification"	=>	$school_classification,
			"zipcode"	=>	$zipcode,
			"addr_1"	=>	$addr_1,
			"addr_2"	=>	$addr_2,
			"lat"	=>	$lat,
			"lng"	=>	$lng,
			"location"	=>	$location,
			"tel"	=>	$tel,
			"status"	=>	$status,
			"contract_start_date"	=>	$contract_start_date,
			"contract_end_date"	=>	$contract_end_date,
			"memo"	=>	$memo,
			"email"	=>	$email,
			"book_yn"	=>	$book_yn,
			"logo_image"	=>	$logo_image,
			"reg_date"	=>	date("Y-m-d H:i:s"),
		);

		$result = $this->school_model->insertSchool($data);

		//직접입력이라면 학교등록
		if(!empty($self_write)){
			$data = array(
				"school_name"	=>	$school_name,
				"school_classification"	=>	$school_classification,
				"tel"	=>	$tel,
				"email"	=>	$email,
				"zipcode"	=>	$zipcode,
				"addr_1"	=>	$addr_1,
				"addr_2"	=>	$addr_2,
				"lat"	=>	$lat,
				"lng"	=>	$lng,
				"reg_date"	=>	date("Y-m-d H:i:s")
			);

			$this->school_model->insertSchoolConfig($data);
		}

		echo '{"result"	:	"success"}';
		exit;

	}

	//기관 삭제
	public function deleteSchool($school_seq)
	{
		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&page_size={$page_size}";

		$schoolData = $this->school_model->getSchool($school_seq);

		$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

		@unlink($upload_path.$schoolData['logo_image']);

		$this->school_model->deleteSchool($school_seq);

		$this->msg("삭제되었습니다.");
		$this->goURL("/admin/schoolAdm/schoolList".$param);
		exit;
	}

	//기관 수정
	public function schoolModify($school_seq)
	{
		$depth1 = "order";
		$depth2 = "schoolList";
		$title = "기관수정";
		$sub_title = "기관수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&page_size={$page_size}";

		$contractData = $this->school_model->getContractList();

		$schoolData = $this->school_model->getSchool($school_seq);

		$locationData = $this->config_model->getConfig('location');

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"contractData"	=>	$contractData,
			"schoolData"	=>	$schoolData,
			"locationData"	=>	$locationData,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/school-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//기관수정
	public function schoolModifyProc()
	{
		$school_seq = $this->input->post("school_seq");
		$contract_type = $this->input->post("contract_type");
		$school_no = $this->input->post("school_no");
		$school_name = $this->input->post("school_name");
		$school_classification = $this->input->post("school_classification");
		$zipcode = $this->input->post("zipcode");
		$addr_1 = $this->input->post("addr_1");
		$addr_2 = $this->input->post("addr_2");
		$tel = $this->input->post("tel");
		$status = $this->input->post("status");
		$contract_start_date = $this->input->post("contract_start_date");
		$contract_end_date = $this->input->post("contract_end_date");
		$memo = $this->input->post("memo");
		$email = $this->input->post("email");
		$book_yn = $this->input->post("book_yn");
		$location = $this->input->post("location");
		$lat = $this->input->post("lat");
		$lng = $this->input->post("lng");


		$self_write = $this->input->post("self_write");

		$logo_image_org = $this->input->post("logo_image_org");

		$logo_image = $_FILES['logo_image']['name'];
		$logo_image = empty($logo_image) ? "" : $logo_image;

		if(!empty($logo_image)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

			$tmp = explode('.', $logo_image);
			$ext = $tmp[1];

			$file_name = $school_no."_logo_".date("YmdHis").".".$ext;

			@unlink($upload_path.$logo_image_org);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["logo_image"]["tmp_name"],$upload_path.$file_name);

			$logo_image = $file_name;
		}else{
			$logo_image = $logo_image_org;
		}

		$data = array(
			"contract_type"	=>	$contract_type,
			"school_no"	=>	$school_no,
			"school_name"	=>	$school_name,
			"school_classification"	=>	$school_classification,
			"zipcode"	=>	$zipcode,
			"addr_1"	=>	$addr_1,
			"addr_2"	=>	$addr_2,
			"lat"	=>	$lat,
			"lng"	=>	$lng,
			"location"	=>	$location,
			"tel"	=>	$tel,
			"status"	=>	$status,
			"contract_start_date"	=>	$contract_start_date,
			"contract_end_date"	=>	$contract_end_date,
			"memo"	=>	$memo,
			"email"	=>	$email,
			"book_yn"	=>	$book_yn,
			"logo_image"	=>	$logo_image,
			"update_time"	=>	date("Y-m-d H:i:s"),
		);

		$result = $this->school_model->updateSchool($school_seq,$data);

		//직접입력이라면 학교등록
		if(!empty($self_write)){
			$data = array(
				"school_name"	=>	$school_name,
				"school_classification"	=>	$school_classification,
				"tel"	=>	$tel,
				"email"	=>	$email,
				"zipcode"	=>	$zipcode,
				"addr_1"	=>	$addr_1,
				"addr_2"	=>	$addr_2,
				"lat"	=>	$lat,
				"lng"	=>	$lng,
				"reg_date"	=>	date("Y-m-d H:i:s")
			);

			$this->school_model->insertSchoolConfig($data);
		}

		echo '{"result"	:	"success"}';
		exit;

	}

	//상태변경
	public function updateSchoolStatus()
	{
		$school_seq = $this->input->post("chk");
		$school_status = $this->input->post("school_status");

		for($i=0; $i<count($school_seq); $i++){
			$this->school_model->updateSchoolStatus($school_seq[$i],$school_status);
		}

		echo '{"result":"success"}';
		exit;
	}

	//계약구분 팝업
	public function contractPop()
	{
		$depth1 = "admin";
		$depth2 = "schoolList";
		$title = "계약구분";
		$sub_title = "계약구분";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$contractData = $this->school_model->getContractList();

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"contractData"	=>	$contractData
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/school/contract-list-pop",$content_data);
	}

	public function contractAdd()
	{
		$contract_name = $this->input->post("contract_name");

		$this->school_model->insertContract($contract_name);

		$contractData = $this->school_model->getContractList();

		$data = array(
			"result"	=>	"success",
			"data"		=>	$contractData
		);

		echo json_encode($data);
		exit;
	}

	public function contractDelete()
	{
		$seq = $this->input->post("seq");
		$this->school_model->deleteContract($seq);

		$contractData = $this->school_model->getContractList();

		$data = array(
			"result"	=>	"success",
			"data"		=>	$contractData
		);

		echo json_encode($data);
		exit;

	}

	//기관검색 팝업
	public function schoolSearchPop()
	{
		$depth1 = "admin";
		$depth2 = "schoolSearch";
		$title = "기관검색";
		$sub_title = "기관검색";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
		);

		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/school/school-search-pop",$content_data);
	}

	//기관검색 결과
	public function schoolSearchProc()
	{
		$school_classification = $this->input->post("school_classification");
		$school_name = $this->input->post("school_name");

		$schoolData = $this->school_model->getSchoolSearchPop($school_classification,$school_name);

		$data = array(
			"result"	=>	"success",
			"data"		=>	$schoolData
		);

		echo json_encode($data);
		exit;

	}

	//기관검색 팝업
	public function schoolOrgSearchPop1()
	{
		$depth1 = "admin";
		$depth2 = "schoolSearch";
		$title = "기관검색";
		$sub_title = "기관검색";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
		);

		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/school/school-org-search-pop1",$content_data);
	}

	//기관검색 팝업
	public function schoolOrgSearchPop()
	{
		$depth1 = "admin";
		$depth2 = "schoolSearch";
		$title = "기관검색";
		$sub_title = "기관검색";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
		);

		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/school/school-org-search-pop",$content_data);
	}

	//기관검색 결과
	public function schoolOrgSearchProc()
	{
		$school_classification = $this->input->post("school_classification");
		$school_name = $this->input->post("school_name");

		$schoolData = $this->school_model->getSchoolOrgSearchPop($school_classification,$school_name);

		$data = array(
			"result"	=>	"success",
			"data"		=>	$schoolData
		);

		echo json_encode($data);
		exit;

	}

	//기관 엑셀 다운로드
	public function schoolDownLoad()
	{

		$this->load->library('excel');

		$srcN = $this->input->post('srcN_excel');
		$srcType = $this->input->post('srcType_excel');
		$status = $this->input->post('status_excel');


		$srcN = empty($srcN) ? "" : $srcN;

		$srcType = empty($srcType) ? "all" : $srcType;

		$status = empty($status) ? "all" : $status;

		$where = "";

		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND school.school_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (school.school_name LIKE '%{$srcN}%' OR user.user_name LIKE '%{$srcN}%' OR user.user_id LIKE '%{$srcN}%')";
			}
		}

		if($status != 'all'){
			$where .= "AND school.status = '{$status}'";
		}

		/*
		if(!empty($this->session->userdata("academy_seq"))){
			$academy_seq = $this->session->userdata("academy_seq");
			$where .= "AND user.academy_seq = '{$academy_seq}'";
		}
		*/

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	""
		);

		$schoolList = $this->school_model->getSchoolList($whereData);

		//customSetting
		for($i = 0; $i < count($schoolList); $i++)
		{
			$schoolList[$i]['reg_date'] = date("Y-m-d",strtotime($schoolList[$i]['reg_date']));

      switch($schoolList[$i]['status']){
        case "Y":
        $schoolList[$i]['status'] = "승인";
        break;

        case "N":
        $schoolList[$i]['status'] = "미승인";
        break;
      }

			if(empty($schoolList[$i]['admin_id'])){
				$schoolList[$i]['admin_id'] = "미지정";
			}

			if(empty($schoolList[$i]['admin_name'])){
				$schoolList[$i]['admin_name'] = "미지정";
			}

			switch($schoolList[$i]['school_classification']){
				case "ELE":
				$schoolList[$i]['school_classification'] = "초등학교";
				break;
				case "MID":
				$schoolList[$i]['school_classification'] = "중학교";
				break;
				case "HIG":
				$schoolList[$i]['school_classification'] = "고등학교";
				break;
				case "ETC":
				$schoolList[$i]['school_classification'] = "기타";
				break;
			}
		}

		// 워크시트 1번째는 활성화
		$this->excel->setActiveSheetIndex(0);

		// A1의 내용을 입력
		$this->excel->getActiveSheet()->setCellValue('A1', '계약구분');
		$this->excel->getActiveSheet()->setCellValue('B1', '관리코드');
		$this->excel->getActiveSheet()->setCellValue('C1', '기관명');
		$this->excel->getActiveSheet()->setCellValue('D1', '기관구분');
		$this->excel->getActiveSheet()->setCellValue('E1', '우편번호');
		$this->excel->getActiveSheet()->setCellValue('F1', '주소1');
		$this->excel->getActiveSheet()->setCellValue('G1', '주소2');
		$this->excel->getActiveSheet()->setCellValue('H1', '연락처');
		$this->excel->getActiveSheet()->setCellValue('I1', '승인유무');
		$this->excel->getActiveSheet()->setCellValue('J1', '계약시작일');
		$this->excel->getActiveSheet()->setCellValue('K1', '계약종료일');
		$this->excel->getActiveSheet()->setCellValue('L1', '메모');
		$this->excel->getActiveSheet()->setCellValue('M1', '이메일');
		$this->excel->getActiveSheet()->setCellValue('N1', '지역');
		$this->excel->getActiveSheet()->setCellValue('O1', '도서열람가능여부');


		for($i=0; $i<count($schoolList); $i++){
		  $this->excel->getActiveSheet()->setCellValue('A'.($i+2),$schoolList[$i]['contract_type']);
			$this->excel->getActiveSheet()->setCellValue('B'.($i+2),$schoolList[$i]['school_no']);
			$this->excel->getActiveSheet()->setCellValue('C'.($i+2),$schoolList[$i]['school_name']);
			$this->excel->getActiveSheet()->setCellValue('D'.($i+2),$schoolList[$i]['school_classification']);
			$this->excel->getActiveSheet()->setCellValue('E'.($i+2),$schoolList[$i]['zipcode']);
			$this->excel->getActiveSheet()->setCellValue('F'.($i+2),$schoolList[$i]['addr_1']);
			$this->excel->getActiveSheet()->setCellValue('G'.($i+2),$schoolList[$i]['addr_2']);
			$this->excel->getActiveSheet()->setCellValue('H'.($i+2),$schoolList[$i]['tel']);
			$this->excel->getActiveSheet()->setCellValue('I'.($i+2),$schoolList[$i]['status']);
			$this->excel->getActiveSheet()->setCellValue('J'.($i+2),$schoolList[$i]['contract_start_date']);
			$this->excel->getActiveSheet()->setCellValue('K'.($i+2),$schoolList[$i]['contract_end_date']);
			$this->excel->getActiveSheet()->setCellValue('L'.($i+2),$schoolList[$i]['memo']);
			$this->excel->getActiveSheet()->setCellValue('M'.($i+2),$schoolList[$i]['email']);
			$this->excel->getActiveSheet()->setCellValue('N'.($i+2),$schoolList[$i]['location']);
			$this->excel->getActiveSheet()->setCellValue('O'.($i+2),$schoolList[$i]['book_yn']);

		}

		$this->excel->setActiveSheetIndex(0);

		$title = "기관내역_".date("Ymd").".xls";

		$filename = iconv("UTF-8", "EUC-KR", $title); // 엑셀 파일 이름

		header('Content-Type: application/vnd.ms-excel'); //mime 타입
		header('Content-Disposition: attachment;filename="'.$filename.'"'); // 브라우저에서 받을 파일 이름
		header('Cache-Control: max-age=0'); //no cache


		// Excel5 포맷으로 저장 엑셀 2007 포맷으로 저장하고 싶은 경우 'Excel2007'로 변경합니다.
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		// 서버에 파일을 쓰지 않고 바로 다운로드 받습니다.
		$objWriter->save('php://output');
	}

	//기관 등록 엑셀 팝업
	public function schoolExcel()
	{
		$sub_title = "기관 엑셀 업로드";
		$depth1 = "";
		$depth2 = "";

		$this->CONFIG_DATA['depth1'] = $depth1;
		$this->CONFIG_DATA['depth2'] = $depth2;

  	$content_data = array(
      "base_url"  	=>  $this->BASE_URL,
  		"sub_title"		=>	$sub_title,
			"depth1"			=>	$depth1
    );

  	//header and css loads
    $this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);

  	//footer js files
  	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
  	//contents
    $this->parser->parse("admin/school/school-excel-pop",$content_data);
	}

	//기관 등록 엑셀 저장
	public function schoolExcelProc()
	{
		$excel = load_controller('admin/excelAdm');
		$excel_file = $_FILES['excel']['tmp_name'];

		$objPHPExcel = PHPExcel_IOFactory::load($excel_file);
		$objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		/*sheetData
		A = 계약구분
		B = 기관명
		C = 기관구분
		D = 우편번호
		E = 주소1
		F = 주소2
		G = 연락처
		H = 승인유무
		I = 계약시작날짜
		J = 계약종료날짜
		K = 메모
		L = 이메일
		M = 지역
		N = lat
		O = lng
		*/

		//엑셀 제목 삭제
		array_shift($sheetData);

		//에러 정리 array
		$errorArr = array();

		if( count($sheetData) > 0 ){
			$errorArr['noData'] = true;
			$success = 0;
			$failed = 0;
			for( $i = 0; $i < count($sheetData); $i++ ){
				$contract_type = $sheetData[$i]['A'];
				$school_name = $sheetData[$i]['B'];

				if(empty($school_name)){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "기관명을 입력해야합니다.";
					$failed++;
					continue;
				}

				if(empty($contract_type)){
					$errorArr[$failed]['user_id'] = $school_name;
					$errorArr[$failed]['error_msg'] = "계약구분을 입력해야합니다.";
					$failed++;
					continue;
				}


				$school_classification = $sheetData[$i]['C'];
				$zipcode = $sheetData[$i]['D'];
				$addr_1 = $sheetData[$i]['E'];
				$addr_2 = $sheetData[$i]['F'];
				$tel = $sheetData[$i]['G'];
				$status = $sheetData[$i]['H'];
				$contract_start_date = $sheetData[$i]['I'];
				$contract_end_date = $sheetData[$i]['J'];
				$memo = $sheetData[$i]['K'];
				$email = $sheetData[$i]['L'];
				$location = $sheetData[$i]['M'];
				$lat = $sheetData[$i]['N'];
				$lng = $sheetData[$i]['O'];
				$reg_date = date("Y-m-d H:i:s");


				//등록여부
				$school_duplicate = $this->school_model->getDuplicateSchoolName($school_name);

				if($school_duplicate==0){
					$data = array(
						"where"	=>	"",
						"limit"	=>	""
					);

					$school_total = $this->school_model->getSchoolTotalCount($data);

					$school_no = "Z".sprintf('%06d',($school_total+1));

					//등록진행
					$data = array(
						"contract_type"	=>	$contract_type,
						"school_no"	=>	$school_no,
						"school_name"	=>	$school_name,
						"school_classification"	=>	$school_classification,
						"zipcode"	=>	$zipcode,
						"addr_1"	=>	$addr_1,
						"addr_2"	=>	$addr_2,
						"lat"	=>	$lat,
						"lng"	=>	$lng,
						"tel"	=>	$tel,
						"status"	=>	$status,
						"contract_start_date"	=>	$contract_start_date,
						"contract_end_date"	=>	$contract_end_date,
						"memo"	=>	$memo,
						"email"	=>	$email,
						"location"	=>	$location,
						"reg_date"	=>	$reg_date,
					);

					$result = $this->school_model->insertSchool($data);
					$success++;
				}else{
					$errorArr[$failed]['user_id'] = $school_name;
					$errorArr[$failed]['error_msg'] = "{$school_name}는 이미 등록된 기관입니다.";
					$failed++;
					continue;
				}
			}

		}else{
			$errorArr['noData'] = true;
		}

		$sub_title = "기관 엑셀 업로드 결과";
		$depth1 = "";
		$depth2 = "";

		$this->CONFIG_DATA['depth1'] = $depth1;
		$this->CONFIG_DATA['depth2'] = $depth2;

  	$content_data = array(
  		"sub_title"		=>	$sub_title,
			"depth1"			=>	$depth1,
			"success"			=>	$success,
			"failed"			=>	$failed,
			"errorArr"		=>	$errorArr
    );

  	//header and css loads
    $this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);

  	//footer js files
  	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
  	//contents
    $this->parser->parse("admin/school/school-excel-proc",$content_data);
	}

	//학급 등록 엑셀 팝업
	public function schoolClassExcel()
	{
		$sub_title = "학급 엑셀 업로드";
		$depth1 = "";
		$depth2 = "";

		$this->CONFIG_DATA['depth1'] = $depth1;
		$this->CONFIG_DATA['depth2'] = $depth2;

  	$content_data = array(
      "base_url"  	=>  $this->BASE_URL,
  		"sub_title"		=>	$sub_title,
			"depth1"			=>	$depth1
    );

  	//header and css loads
    $this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);

  	//footer js files
  	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
  	//contents
    $this->parser->parse("admin/school/school-class-excel-pop",$content_data);
	}

	//기관 등록 엑셀 저장
	public function schoolClassExcelProc()
	{
		$excel = load_controller('admin/excelAdm');
		$excel_file = $_FILES['excel']['tmp_name'];

		$objPHPExcel = PHPExcel_IOFactory::load($excel_file);
		$objPHPExcel->setActiveSheetIndex(0);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

		/*sheetData
		A = 기관고유번호
		B = 학년
		C = 반
		D = 학급관리자아이디
		*/

		//엑셀 제목 삭제
		array_shift($sheetData);

		//에러 정리 array
		$errorArr = array();

		if( count($sheetData) > 0 ){
			$errorArr['noData'] = true;
			$success = 0;
			$failed = 0;
			for( $i = 0; $i < count($sheetData); $i++ ){
				$school_no = $sheetData[$i]['A'];
				$school_year = $sheetData[$i]['B'];
				$school_class = $sheetData[$i]['C'];
				$class_admin_id = $sheetData[$i]['D'];
				$reg_date = date("Y-m-d H:i:s");

				$school_data = $this->school_model->getSchoolNoData($school_no);

				if(empty($school_no)){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "기관고유번호를 입력해야합니다.";
					$failed++;
					continue;
				}

				if(!is_array($school_data)){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "기관고유번호를 확인해주세요.";
					$failed++;
					continue;
				}

				if(empty($school_year)){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "학년을 입력해야합니다.";
					$failed++;
					continue;
				}

				if(empty($school_class)){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "반을 입력해야합니다.";
					$failed++;
					continue;
				}

				$school_name = $school_data['school_name'];
				$school_seq = $school_data['school_seq'];

				$school_duplicate = $this->school_model->getDuplicateSchoolClass($school_seq,$school_year,$school_class);

				if(count($school_duplicate)>0){
					$errorArr[$failed]['user_id'] = ($i+1)."번";
					$errorArr[$failed]['error_msg'] = "이미 등록된 학급입니다.";
					$failed++;
					continue;
				}

				if(!empty($class_admin_id)){
					//같은학교에 있는지 확인
					$class_admin_chk = $this->school_model->getClassAdminChk($school_seq,$class_admin_id);
					if(is_array($class_admin_chk)){
						//다른학급에 지정되어있는지 확인
						$class_admin_chk2 = $this->school_model->getClassAdminChk2($school_seq,$class_admin_id);
						if(is_array($class_admin_chk2)){
							$errorArr[$failed]['user_id'] = $class_admin_id;
							$errorArr[$failed]['error_msg'] = "이미 등록된 학급이 있습니다.";
							$failed++;
							continue;
						}
					}else{
						$errorArr[$failed]['user_id'] = $class_admin_id;
						$errorArr[$failed]['error_msg'] = "같은 기관의 학생이 아니거나 학급관리자 레벨이 아닙니다.";
						$failed++;
						continue;
					}
				}

				$data = array(
					"school_seq"	=>	$school_seq,
					"school_name"	=>	$school_name,
					"school_class"	=>	$school_class,
					"school_year"	=>	$school_year,
					"class_admin_id"	=>	$class_admin_id,
					"reg_date"	=>	date("Y-m-d H:i:s"),
				);

				if(!empty($class_admin_id)){
					$this->member_model->updateSchoolClass($class_admin_id,$school_year,$school_class);
				}

				$result = $this->school_model->insertClass($data);
				$success++;
			}

		}else{
			$errorArr['noData'] = true;
		}

		$sub_title = "학급 엑셀 업로드 결과";
		$depth1 = "";
		$depth2 = "";

		$this->CONFIG_DATA['depth1'] = $depth1;
		$this->CONFIG_DATA['depth2'] = $depth2;

  	$content_data = array(
  		"sub_title"		=>	$sub_title,
			"depth1"			=>	$depth1,
			"success"			=>	$success,
			"failed"			=>	$failed,
			"errorArr"		=>	$errorArr
    );

  	//header and css loads
    $this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);

  	//footer js files
  	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
  	//contents
    $this->parser->parse("admin/school/school-class-excel-proc",$content_data);
	}

  public function classList()
	{
		$depth1 = "order";
		$depth2 = "classList";
		$title = "학급리스트";
		$sub_title = "학급리스트";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$s_class = $this->input->get('s_class');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";



		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcType = empty($srcType) ? "all" : $srcType;

		$status = empty($status) ? "all" : $status;

		$s_class = empty($s_class) ? "all" : $s_class;

		$page_size = empty($page_size) ? 20 : $page_size;

		$where = "";




		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND school.school_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_name"){
				$where .= "AND users.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_id"){
				$where .= "AND users.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (users.user_id LIKE '%{$srcN}%' OR users.user_name LIKE '%{$srcN}%' OR school.school_name LIKE '%{$srcN}%')";
			}
		}

		if($s_class != 'all'){
			$where .= "AND class.school_year = '{$s_class}'";
		}

		if($status != 'all'){
			$where .= "AND school.status = '{$status}'";
		}

		//기관관리자 접근
		if($this->session->userdata("admin_level")>0 && $this->session->userdata("admin_level")<=2){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= "AND school.school_seq = '{$admin_school_seq}'";
		}

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->school_model->getClassTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".$num.",".$page_size
		);

		$classList = $this->school_model->getClassList($whereData);

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

		$paging = $this->make_paging2("/admin/schoolAdm/classList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		//customSetting
		for($i = 0; $i < count($classList); $i++)
		{
			$classList[$i]['reg_date'] = date("Y-m-d",strtotime($classList[$i]['reg_date']));

      switch($classList[$i]['status']){
        case "Y":
        $classList[$i]['status'] = "승인";
        break;

        case "N":
        $classList[$i]['status'] = "미승인";
        break;
      }

			if(empty($classList[$i]['admin_id'])){
				$classList[$i]['admin_id'] = "미지정";
			}else{
				$classList[$i]['admin_id'] = $classList[$i]['admin_name']."(".$classList[$i]['admin_id'].")";
			}

			if(empty($classList[$i]['class_admin_name'])){
				$classList[$i]['class_admin_name'] = "미지정";
			}else{
				$classList[$i]['class_admin_name'] = $classList[$i]['class_admin_name']."(".$classList[$i]['class_admin_id'].")";
			}

			if(empty($classList[$i]['school_year'])){
				$classList[$i]['school_year'] = "선택안함";
			}else{
				$classList[$i]['school_year']."학년";
			}
		}

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"classList"	=>	$classList,
			"paging"		=>	$paging,
			"srcType"		=>	$srcType,
			"srcN"			=>	$srcN,
			"status"		=>	$status,
			"s_class"		=>	$s_class,
			"num"				=>	$num,
      "list_total"  =>  $list_total,
			"page_size"	=>	$page_size,
			"param"			=>	$param
		);


		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/class-list",$content_data);
		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	public function classWrite()
	{
		$depth1 = "order";
		$depth2 = "classList";
		$title = "학급등록";
		$sub_title = "학급등록";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$s_class = $this->input->get('s_class');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";

		$where = "";
		//기관관리자 접근
		if($this->session->userdata("admin_level")>0 && $this->session->userdata("admin_level")<=2){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= "AND school.school_seq = '{$admin_school_seq}'";
		}

		$data = array(
			"where"	=>	$where,
			"sort"	=>	"ORDER BY school.school_name ASC",
			"limit"	=>	""
		);

		$schoolList = $this->school_model->getSchoolList($data);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"schoolList"	=>	$schoolList,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/class-write",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//학급등록
	public function classWriteProc()
	{
		$school_seq = $this->input->post("school_seq");
		$school_class = $this->input->post("school_class");
		$self_write = $this->input->post("self_write");
		$self_input = $this->input->post("self_input");
		$class_admin_id = $this->input->post("class_admin_id");
		$school_year = $this->input->post("school_year");

		$school_name = $this->school_model->getSchoolName($school_seq);

		if(!empty($self_write)){
			$school_class = $self_input;
		}

		$class_image = $_FILES['class_image']['name'];
		$class_image = empty($class_image) ? "" : $class_image;

		if(!empty($class_image)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

			$tmp = explode('.', $class_image);
			$ext = $tmp[1];

			$file_name = $school_seq."_".date("YmdHis")."_class_image.".$ext;

			@unlink($upload_path.$file_name);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["class_image"]["tmp_name"],$upload_path.$file_name);

			$class_image = $file_name;
		}

		$data = array(
			"school_seq"	=>	$school_seq,
			"school_name"	=>	$school_name,
			"school_class"	=>	$school_class,
			"school_year"	=>	$school_year,
			"class_admin_id"	=>	$class_admin_id,
			"class_image"	=>	$class_image,
			"reg_date"	=>	date("Y-m-d H:i:s"),
		);

		$duplicateClass = $this->school_model->getDuplicateSchoolClass($school_seq,$school_year,$school_class);
		if(count($duplicateClass)){
			echo '{"result":"failed"}';
			exit;
		}

		if(!empty($class_admin_id)){
			$this->member_model->updateSchoolClass($class_admin_id,$school_year,$school_class);
		}

		$result = $this->school_model->insertClass($data);

		echo '{"result"	:	"success"}';
		exit;

	}

	//학교별 반 로드
	public function schoolClassLoad()
	{
		$school_seq = $this->input->post("school_seq");
		$school_year = $this->input->post("school_year");
		$classData = $this->school_model->getSchoolSeqClass($school_seq,$school_year);

		echo json_encode($classData);
		exit;
	}

	//학급 엑셀 다운로드
	public function classDownLoad()
	{

		$this->load->library('excel');

		$num = 0;
		$srcN = $this->input->post('srcN_excel');
		$srcType = $this->input->post('srcType_excel');
		$status = $this->input->post('status_excel');
		$s_class = $this->input->post('s_class_excel');
		$page_size = $this->input->post('page_size_excel');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";



		$num = empty($num) ? 0 : $num;

		$srcN = empty($srcN) ? "" : $srcN;

		$srcType = empty($srcType) ? "all" : $srcType;

		$status = empty($status) ? "all" : $status;

		$s_class = empty($s_class) ? "all" : $s_class;

		$page_size = empty($page_size) ? 20 : $page_size;

		$where = "";




		if(!empty($srcN)){
			if($srcType=="name"){
				$where .= "AND school.school_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_name"){
				$where .= "AND user.user_name LIKE '%{$srcN}%'";
			}else if($srcType=="a_id"){
				$where .= "AND user.user_id LIKE '%{$srcN}%'";
			}else{
				$where .= "AND (user.user_id LIKE '%{$srcN}%' OR user.user_name LIKE '%{$srcN}%' OR school.school_name LIKE '%{$srcN}%')";
			}
		}

		if($s_class != 'all'){
			$where .= "AND class.school_year = '{$s_class}'";
		}

		if($status != 'all'){
			$where .= "AND school.status = '{$status}'";
		}

		$whereData = array(
				"sort"			=>	"",
			"where"			=>	$where,
			"limit"			=>	""
		);

		$classList = $this->school_model->getClassList($whereData);

		//customSetting
		for($i = 0; $i < count($classList); $i++)
		{
			$classList[$i]['reg_date'] = date("Y-m-d",strtotime($classList[$i]['reg_date']));

      switch($classList[$i]['status']){
        case "Y":
        $classList[$i]['status'] = "승인";
        break;

        case "N":
        $classList[$i]['status'] = "미승인";
        break;
      }

			if(empty($classList[$i]['admin_id'])){
				$classList[$i]['admin_id'] = "미지정";
			}

			if(empty($classList[$i]['class_admin_name'])){
				$classList[$i]['class_admin_name'] = "미지정";
			}

			if(empty($classList[$i]['school_year'])){
				$classList[$i]['school_year'] = "선택안함";
			}else{
				$classList[$i]['school_year']."학년";
			}

			$classList[$i]['total_user'] = $classList[$i]['total_user']."명";
		}

		// 워크시트 1번째는 활성화
		$this->excel->setActiveSheetIndex(0);

		// A1의 내용을 입력
		$this->excel->getActiveSheet()->setCellValue('A1', '계약구분');
		$this->excel->getActiveSheet()->setCellValue('B1', '학교명');
		$this->excel->getActiveSheet()->setCellValue('C1', '학년');
		$this->excel->getActiveSheet()->setCellValue('D1', '반');
		$this->excel->getActiveSheet()->setCellValue('E1', '인원');
		$this->excel->getActiveSheet()->setCellValue('F1', '상태');
		$this->excel->getActiveSheet()->setCellValue('G1', '학급관리자');
		$this->excel->getActiveSheet()->setCellValue('H1', '관리자계정');


		for($i=0; $i<count($classList); $i++){
		  $this->excel->getActiveSheet()->setCellValue('A'.($i+2),$classList[$i]['contract_type']);
			$this->excel->getActiveSheet()->setCellValue('B'.($i+2),$classList[$i]['school_name']);
			$this->excel->getActiveSheet()->setCellValue('C'.($i+2),$classList[$i]['school_year']);
			$this->excel->getActiveSheet()->setCellValue('D'.($i+2),$classList[$i]['school_class']);
			$this->excel->getActiveSheet()->setCellValue('E'.($i+2),$classList[$i]['total_user']);
			$this->excel->getActiveSheet()->setCellValue('F'.($i+2),$classList[$i]['status']);
			$this->excel->getActiveSheet()->setCellValue('G'.($i+2),$classList[$i]['class_admin_name']);
			$this->excel->getActiveSheet()->setCellValue('H'.($i+2),$classList[$i]['admin_id']);
		}

		$this->excel->setActiveSheetIndex(0);

		$title = "학급내역_".date("Ymd").".xls";

		$filename = iconv("UTF-8", "EUC-KR", $title); // 엑셀 파일 이름

		header('Content-Type: application/vnd.ms-excel'); //mime 타입
		header('Content-Disposition: attachment;filename="'.$filename.'"'); // 브라우저에서 받을 파일 이름
		header('Cache-Control: max-age=0'); //no cache


		// Excel5 포맷으로 저장 엑셀 2007 포맷으로 저장하고 싶은 경우 'Excel2007'로 변경합니다.
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		// 서버에 파일을 쓰지 않고 바로 다운로드 받습니다.
		$objWriter->save('php://output');
	}

	//학급수정
	public function classModify($school_class_seq)
	{
		$depth1 = "order";
		$depth2 = "classList";
		$title = "학급수정";
		$sub_title = "학급수정";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$s_class = $this->input->get('s_class');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";

		$where = "";
		//기관관리자 접근
		if($this->session->userdata("admin_level")>0 && $this->session->userdata("admin_level")<=2){
			$admin_school_seq = $this->session->userdata("school_seq");
			$where .= "AND school.school_seq = '{$admin_school_seq}'";
		}

		$data = array(
			"where"	=>	$where,
			"limit"	=>	""
		);

		$schoolList = $this->school_model->getSchoolList($data);
		$classData = $this->school_model->getClassData($school_class_seq);


		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"schoolList"	=>	$schoolList,
			"classData"	=>	$classData,
			"school_class_seq"	=>	$school_class_seq,
			"param"	=>	$param
		);

		//header and css loads
		$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

		//menu
		$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
		//contents
		$this->parser->parse("admin/school/class-modify",$content_data);

		//Footer
		$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
	}

	//학급 수정
	public function classModifyProc()
	{
		$school_class_seq = $this->input->post("school_class_seq");
		$school_seq = $this->input->post("school_seq");
		$school_class = $this->input->post("school_class");
		$self_write = $this->input->post("self_write");
		$self_input = $this->input->post("self_input");
		$class_admin_id = $this->input->post("class_admin_id");
		$school_year = $this->input->post("school_year");

		$school_name = $this->school_model->getSchoolName($school_seq);

		if(!empty($self_write)){
			$school_class = $self_input;
		}

		$class_image = $_FILES['class_image']['name'];
		$class_image = empty($class_image) ? "" : $class_image;
		$class_image_org = $this->input->post("class_image_org");

		if(!empty($class_image)){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

			$tmp = explode('.', $class_image);
			$ext = $tmp[1];

			$file_name = $school_seq."_".date("YmdHis")."_class_image.".$ext;

			@unlink($upload_path.$class_image_org);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($_FILES["class_image"]["tmp_name"],$upload_path.$file_name);

			$class_image = $file_name;
		}else{
			$class_image = $class_image_org;
		}

		if(!empty($class_admin_id)){
			$this->member_model->updateSchoolClass($class_admin_id,$school_year,$school_class);
		}

		$data = array(
			"school_seq"	=>	$school_seq,
			"school_name"	=>	$school_name,
			"school_class"	=>	$school_class,
			"school_year"	=>	$school_year,
			"class_admin_id"	=>	$class_admin_id,
			"class_image"	=>	$class_image,
			"update_time"	=>	date("Y-m-d H:i:s"),
		);

		$result = $this->school_model->updateClass($school_class_seq,$data);

		echo '{"result"	:	"success"}';
		exit;

	}

	//학급삭제
	public function deleteClass($school_class_seq)
	{
		$num = $this->input->get('num');
		$srcN = $this->input->get('srcN');
		$srcType = $this->input->get('srcType');
		$status = $this->input->get('status');
		$s_class = $this->input->get('s_class');
		$page_size = $this->input->get('page_size');

		$param = "?num={$num}&srcN={$srcN}&srcType={$srcType}&status={$status}&s_class={$s_class}&page_size={$page_size}";

		$classData = $this->school_model->getClassData($school_class_seq);

		$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/school/";

		@unlink($upload_path.$classData['class_image']);

		$this->school_model->deleteClass($school_class_seq);

		$this->msg("삭제되었습니다.");
		$this->goURL("/admin/schoolAdm/classList".$param);
		exit;
	}

	//학급관리자 팝업
	public function classFindAdminPop($school_seq)
	{
		$depth1 = "admin";
		$depth2 = "classList";
		$title = "학급관리자";
		$sub_title = "학급관리자";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$classAdminData = $this->school_model->getAllClassAdmin($school_seq);

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"classAdminData"	=>	$classAdminData,
			"school_seq"	=>	$school_seq
		);




		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("admin/school/class-find-admin-pop",$content_data);
	}

	public function findUserName()
	{
		$user_name = $this->input->post("srcN");
		$school_seq = $this->input->post("school_seq");

		$userData = $this->school_model->getFindClassAdminName($school_seq,$user_name);

		echo '{"result":"success","data":'.json_encode($userData).'}';
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
            $pageArr[]['no'] = '<li><a class="page-link" href="'.$url.'?num='.((($end_page*$page_size)-10)+10).'&srcN='.$srcN.$params.'">></a></li>';
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
