<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		/**
		* 언어셋 설정
		*/
		$this->load->config('gettext');
		$this->load->helper('gettext');
		$this->load->model("member_model");
		$this->load->model("school_model");
		$this->load->model("config_model");
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
	}

	public function join($str)
	{
		$sub = "join";

		if($str == "trems"){
			$page_title = "약관 동의";
		}else{
			$page_title = "회원 가입";
		}

		$depth1 = "join";
		$depth2 = "join";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["page_title"] = $page_title;

		$age = "";
		$locationData = $this->config_model->getConfig('location');

		$data = array(
			"page_title"	=>	$page_title,
		);

		if($str == "terms"){
			$sitecode = CERT_SITE_CODE;					// NICE로부터 부여받은 사이트 코드
	    $sitepasswd = CERT_PASSWORD;				// NICE로부터 부여받은 사이트 패스워드

	    // Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
	    $cb_encode_path = $_SERVER['DOCUMENT_ROOT']."/plugin/cert/CPClient";

			$authtype = "";      		// 없으면 기본 선택화면, M(휴대폰), X(인증서공통), U(공동인증서), F(금융인증서), S(PASS인증서), C(신용카드)

	    $customize 	= "";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)

	    $reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
	                                    // 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.

	    // 실행방법은 백틱(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
	    // 위의 실행함수를 통해 아무런 값도 출력이 안될 경우 쉘 스크립트 오류출력(2>&1)을 통해 오류 확인 부탁드립니다.
	    $reqseq = `$cb_encode_path SEQ $sitecode`;

	    // CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
	    // 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
	    $returnurl = "https://app.netzeroschool.kr/member/cert_success";	// 성공시 이동될 URL
	    $errorurl = "https://app.netzeroschool.kr/member/cert_fail";		// 실패시 이동될 URL

	    // reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

	    $_SESSION["REQ_SEQ"] = $reqseq;

	    // 입력될 plain 데이타를 만든다.
	    $plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
					 "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
					 "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
					 "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
					 "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
					 "9:CUSTOMIZE" . strlen($customize) . ":" . $customize;

	    $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

	    $returnMsg = "";

	    if( $enc_data == -1 )
	    {
	        $returnMsg = "암/복호화 시스템 오류입니다.";
	        $enc_data = "";
	    }
	    else if( $enc_data== -2 )
	    {
	        $returnMsg = "암호화 처리 오류입니다.";
	        $enc_data = "";
	    }
	    else if( $enc_data== -3 )
	    {
	        $returnMsg = "암호화 데이터 오류 입니다.";
	        $enc_data = "";
	    }
	    else if( $enc_data== -9 )
	    {
	        $returnMsg = "입력값 오류 입니다.";
	        $enc_data = "";
	    }

			$data['enc_data'] = $enc_data;
		}

		if($str == "step1"){
			$age = $this->input->post("age");
			$data['age']	= $age;
			$data['locationData']	=	$locationData;

		}else if($str == "step2"){
			$user_type = $this->input->post("user_type");
			$user_id = $this->input->post("user_id");
			$user_password = $this->input->post("user_password");
			$user_name = $this->input->post("user_name");
			$phone = $this->input->post("phone");
			$phone_cert = $this->input->post("phone_cert");
			$email = $this->input->post("email");
			$birth_year = $this->input->post("birth_year");
			$birth_month = $this->input->post("birth_month");
			$birth_day = $this->input->post("birth_day");
			$gender = $this->input->post("gender");
			$location = $this->input->post("location");
			$zipcode = $this->input->post("zipcode");
			$addr1 = $this->input->post("addr1");
			$addr2 = $this->input->post("addr2");
			$parent_name = $this->input->post("parent_name");
			$parent_birthday = $this->input->post("parent_birthday");
			$parent_phone = $this->input->post("parent_phone");

			$data['user_type'] = $user_type;
			$data['user_id'] = $user_id;
			$data['user_password'] = $user_password;
			$data['user_name'] = $user_name;
			$data['phone'] = $phone;
			$data['phone_cert'] = $phone_cert;
			$data['email'] = $email;
			$data['birth_year'] = $birth_year;
			$data['birth_month'] = $birth_month;
			$data['birth_day'] = $birth_day;
			$data['gender'] = $gender;
			$data['location'] = $location;
			$data['zipcode'] = $zipcode;
			$data['addr1'] = $addr1;
			$data['addr2'] = $addr2;
			$data['parent_name'] = $parent_name;
			$data['parent_birthday'] = $parent_birthday;
			$data['parent_phone'] = $parent_phone;

		}else if($str == "step3"){

		}




		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/join-'.$str,$data);
	}

	public function duplicatePhone()
	{
		$phone = $this->input->post("phone");
		$phone = str_replace("-","",$phone);

		$chk = $this->member_model->getDuplicatePhone($phone);
		if(count($chk)>0){
			echo '{"result":"failed"}';
			exit;
		}else{
			echo '{"result":"success"}';
			exit;
		}
	}

	//기관검색 팝업
	public function schoolSearchPop()
	{
		$depth1 = "join";
		$depth2 = "schoolSearch";
		$title = "기관검색";
		$sub_title = "기관검색";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$school_name = $this->input->get("school_name");

		$content_data = array(
			"depth1"		=>	$depth1,
			"title"			=>	$title,
			"sub_title"	=>	$sub_title,
			"school_name"	=>	$school_name
		);

		//header and css loads
		$this->parser->parse("admin/include/pop-header",$this->CONFIG_DATA);
		//footer js files
		$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);

		//contents
		$this->parser->parse("member/school-find-pop",$content_data);
	}

	//기관검색 결과
	public function schoolSearchProc()
	{
		$school_name = $this->input->post("school_name");

		$schoolData = $this->school_model->getSchoolSearchPop3($school_name);

		$data = array(
			"result"	=>	"success",
			"data"		=>	$schoolData
		);

		echo json_encode($data);
		exit;

	}

	public function setVerifiNum()
	{
		$phone_num = $this->input->post("phone");
		//인증번호 난수생성 및 세션저장
		$rand_num = sprintf('%06d',rand(000000,999999));
		$this->session->set_userdata("verifi_num",$rand_num);
		$msg = "[저탄소스쿨 본인인증]
인증번호 : ".$rand_num;

		$this->send_sms($phone_num,"본인인증",$msg,"","","","","D");

		echo '{"result":"success"}';
		exit;
	}

	public function getVerifiNum()
	{
		$num = $this->input->post("phone_certification");
		$org_num = $this->session->userdata("verifi_num");

		$chk_yn = "N";
		if($num==$org_num){
			$chk_yn = "Y";
		}

		$returnData = array(
			"chk_yn"	=>	$chk_yn,
			"num"	=>	$num,
			"org_num"	=>	$org_num
		);

		echo '{"result":"success","data":'.json_encode($returnData).'}';
		exit;
	}

	public function join_proc()
	{
		$user_type = $this->input->post("user_type");
		$user_id = $this->input->post("user_id");
		$user_password = $this->input->post("user_password");
		$user_name = $this->input->post("user_name");
		$phone = $this->input->post("phone");
		$phone_cert = $this->input->post("phone_cert");
		$email = $this->input->post("email");
		$birth_year = $this->input->post("birth_year");
		$birth_month = $this->input->post("birth_month");
		$birth_day = $this->input->post("birth_day");
		$birthday = $birth_year."-".$birth_month."-".$birth_day;
		$gender = $this->input->post("gender");
		$location = $this->input->post("location");
		$zipcode = $this->input->post("zipcode");
		$addr1 = $this->input->post("addr1");
		$addr2 = $this->input->post("addr2");
		$parent_name = $this->input->post("parent_name");
		$parent_birthday = $this->input->post("parent_birthday");
		$parent_phone = $this->input->post("parent_phone");

		$school_seq = $this->input->post("school_seq");
		$school_year = $this->input->post("school_year");
		$school_class = $this->input->post("school_class");
		$school_chk = $this->input->post("school_chk");

		$school_year = empty($school_year) ? "" : $school_year;
		$school_class = empty($school_class) ? "" : $school_class;
		$school_name = "";

		$app_key = $this->input->post("app_key");


		if($school_chk=="Y"){
			$school_seq = "";
			$user_level = 7;
		}else{
			$user_level = 6;
			$school_name = $this->school_model->getSchoolName($school_seq);
		}

		$user_data = array(
			"user_type"	=>	$user_type,
			"user_id"	=>	$user_id,
			"user_password"	=>	$this->encrypt("password",$user_password),
			"user_name"	=>	$user_name,
			"phone"	=>	$phone,
			"phone_cert"	=>	$phone_cert,
			"email"	=>	$email,
			"birthday"	=>	$birthday,
			"gender"	=>	$gender,
			"location"	=>	$location,
			"zipcode"	=>	$zipcode,
			"addr1"	=>	$addr1,
			"addr2"	=>	$addr2,
			"school_seq"	=>	$school_seq,
			"school_year"	=>	$school_year,
			"school_class"	=>	$school_class,
			"school_name"	=>	$school_name,
			"user_level"	=>	$user_level,
			"app_key"	=>	$app_key,
			"parent_name"	=>	$parent_name,
			"parent_birthday"	=>	$parent_birthday,
			"parent_name"	=>	$parent_name,
			"reg_date"	=>	date("Y-m-d H:i:s")
		);

		$this->member_model->insertMember($user_data);

		$this->session->sess_destroy();


		echo '{"result":"success"}';
		exit;
	}

	public function sns_join()
	{
		$sub = "join";

		$depth1 = "join";
		$depth2 = "join";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$user_name	= $this->session->userdata("user_name");
		$sns_key	= $this->session->userdata("sns_key");
		$gender	= $this->session->userdata("gender");
		$email	= $this->session->userdata("email");
		$phone	= $this->session->userdata("phone");
		$birthday	= $this->session->userdata("birthday");
		$user_type = $this->session->userdata("user_type");

		$year = "";
		$month = "";
		$day = "";

		if(!empty($birthday)){
			$birthday = explode("-",$birthday);
			$year = $birthday[0];
			$month = $birthday[1];
			$day = $birthday[2];
		}

		$locationData = $this->config_model->getConfig('location');

		$data = array(
			"page_title"	=>	"SNS 간편가입",
			"user_name"	=>	$user_name,
			"sns_key"	=>	$sns_key,
			"gender"	=>	$gender,
			"email"	=>	$email,
			"phone"	=>	$phone,
			"year"	=>	$year,
			"month"	=>	$month,
			"day"	=>	$day,
			"user_type"	=>	$user_type,
			"locationData"	=>	$locationData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/sns-join',$data);
	}

	public function sns_join2()
	{
		$sub = "join";

		$depth1 = "join";
		$depth2 = "join";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$user_type = $this->input->post("user_type");
		$sns_key = $this->input->post("sns_key");
		$user_id = $this->input->post("user_id");
		$user_name = $this->input->post("user_name");
		$phone = $this->input->post("phone");
		$email = $this->input->post("email");
		$birth_year = $this->input->post("birth_year");
		$birth_month = $this->input->post("birth_month");
		$birth_day = $this->input->post("birth_day");
		$gender = $this->input->post("gender");
		$parent_name = $this->input->post("parent_name");
		$parent_birthday = $this->input->post("parent_birthday");
		$parent_phone = $this->input->post("parent_phone");
		if($gender=="F"){
			$gender = "W";
		}else{
			$gender = "M";
		}

		$location = $this->input->post("location");
		$zipcode = $this->input->post("zipcode");
		$addr1 = $this->input->post("addr1");
		$addr2 = $this->input->post("addr2");

		$data = array(
			"page_title"	=>	"SNS 간편가입",
			"user_type"	=>	$user_type,
			"sns_key"	=>	$sns_key,
			"user_id"	=>	$user_id,
			"user_name"	=>	$user_name,
			"phone"	=>	$phone,
			"email"	=>	$email,
			"birth_year"	=>	$birth_year,
			"birth_month"	=>	$birth_month,
			"birth_day"	=>	$birth_day,
			"gender"	=>	$gender,
			"location"	=>	$location,
			"zipcode"	=>	$zipcode,
			"addr1"	=>	$addr1,
			"addr2"	=>	$addr2,
			"parent_name"	=>	$parent_name,
			"parent_birthday"	=>	$parent_birthday,
			"parent_phone"	=>	$parent_phone
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/sns-join-step2',$data);
	}

	public function sns_join_proc()
	{
		$user_type = $this->input->post("user_type");
		$sns_key = $this->input->post("sns_key");
		$user_id = $this->input->post("user_id");
		$user_name = $this->input->post("user_name");
		$phone = $this->input->post("phone");
		$email = $this->input->post("email");
		$birth_year = $this->input->post("birth_year");
		$birth_month = $this->input->post("birth_month");
		$birth_day = $this->input->post("birth_day");
		$birthday = $birth_year."-".$birth_month."-".$birth_day;
		$gender = $this->input->post("gender");
		$location = $this->input->post("location");
		$zipcode = $this->input->post("zipcode");
		$addr1 = $this->input->post("addr1");
		$addr2 = $this->input->post("addr2");
		$parent_name = $this->input->post("parent_name");
		$parent_birthday = $this->input->post("parent_birthday");
		$parent_phone = $this->input->post("parent_phone");
		$phone_cert = "Y";

		$school_seq = $this->input->post("school_seq");
		$school_year = $this->input->post("school_year");
		$school_class = $this->input->post("school_class");
		$school_chk = $this->input->post("school_chk");

		$school_year = empty($school_year) ? "" : $school_year;
		$school_class = empty($school_class) ? "" : $school_class;
		$school_name = "";

		$app_key = $this->input->post("app_key");


		if($school_chk=="Y"){
			$school_seq = "";
			$user_level = 7;
		}else{
			$user_level = 6;
			$school_name = $this->school_model->getSchoolName($school_seq);
		}

		$user_data = array(
			"user_type"	=>	$user_type,
			"sns_key"	=>	$sns_key,
			"user_id"	=>	$user_id,
			"user_name"	=>	$user_name,
			"phone"	=>	$phone,
			"email"	=>	$email,
			"birthday"	=>	$birthday,
			"gender"	=>	$gender,
			"location"	=>	$location,
			"zipcode"	=>	$zipcode,
			"addr1"	=>	$addr1,
			"addr2"	=>	$addr2,
			"phone_cert"	=>	$phone_cert,
			"school_seq"	=>	$school_seq,
			"school_year"	=>	$school_year,
			"school_class"	=>	$school_class,
			"school_name"	=>	$school_name,
			"user_level"	=>	$user_level,
			"app_key"	=>	$app_key,
			"parent_name"	=>	$parent_name,
			"parent_birthday"	=>	$parent_birthday,
			"parent_phone"	=>	$parent_phone,
			"reg_date"	=>	date("Y-m-d H:i:s")
		);

		$this->member_model->insertMember($user_data);

		$this->session->sess_destroy();


		echo '{"result":"success"}';
		exit;
	}

	public function duplicateId()
	{
		$user_id = $this->input->post("user_id");
		$duplicateChk = $this->member_model->getDuplicateId($user_id);

		if($duplicateChk>0){
			echo '{"result":"failed"}';
			exit;
		}else{
			echo '{"result":"success"}';
			exit;
		}
	}

	public function findId()
	{
		$sub = "findId";

		$page_title = "아이디/비밀번호찾기";

		$depth1 = "findId";
		$depth2 = "findId";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["page_title"] = $page_title;

		$data = array(
			"page_title"	=>	$page_title
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/find-id',$data);
	}

	public function schoolFind()
	{
		$school_name = $this->input->post("school_name");

		$returnArr = $this->school_model->getSchoolNameFind($school_name);

		echo '{"result":"success","data":'.json_encode($returnArr).'}';
		exit;
	}

	public function schoolYearFind()
	{
		$school_seq = $this->input->post("school_seq");

		$school_year = $this->school_model->getSchoolYear($school_seq);

		echo '{"result":"success","data":'.json_encode($school_year).'}';
		exit;
	}

	public function schoolClassFind()
	{
		$school_seq = $this->input->post("school_seq");
		$school_year = $this->input->post("school_year");

		$school_class = $this->school_model->getSchoolClass($school_seq,$school_year);

		echo '{"result":"success","data":'.json_encode($school_class).'}';
		exit;
	}

	public function findIdProc()
	{
		$sub = "findIdProc";

		$page_title = "아이디/비밀번호찾기";

		$depth1 = "findIdProc";
		$depth2 = "findIdProc";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["page_title"] = $page_title;

		$user_name = $this->input->post("user_name");
		$email = $this->input->post("email");

		if(empty($user_name)){
			$this->msg("잘못된 접근입니다.");
			$this->goURL("/login");
			exit;
		}

		$userData = $this->member_model->getFindId($user_name,$email);

		$data = array(
			"page_title"	=>	$page_title,
			"userData"	=>	$userData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/find-id-proc',$data);
	}

	public function findPw()
	{
		$sub = "findPw";

		$page_title = "아이디/비밀번호찾기";

		$depth1 = "findPw";
		$depth2 = "findPw";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["page_title"] = $page_title;

		$data = array(
			"page_title"	=>	$page_title
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/find-pw',$data);
	}

	public function findPwProc()
	{
		$sub = "findPwProc";

		$page_title = "아이디/비밀번호찾기";

		$depth1 = "findPwProc";
		$depth2 = "findPwProc";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["page_title"] = $page_title;

		$user_id = $this->input->post("user_id");
		$user_name = $this->input->post("user_name");
		$email = $this->input->post("email");

		if(empty($user_id)){
			$this->msg("잘못된 접근입니다");
			$this->goURL("/member/findPw");
			exit;
		}
		if(empty($user_name)){
			$this->msg("잘못된 접근입니다");
			$this->goURL("/member/findPw");
			exit;
		}
		if(empty($email)){
			$this->msg("잘못된 접근입니다");
			$this->goURL("/member/findPw");
			exit;
		}

		$userData = $this->member_model->getFindPw($user_id,$user_name,$email);

		if(!is_array($userData)){
			$this->msg("일치하는 정보가 없습니다.");
			$this->goURL("/member/findPw");
			exit;
		}else{
			$user_email = $userData['email'];
			$user_name = $userData['user_name'];
			$new_password = $this->passwordGenerator();
			$new_password_encrypt = $this->encrypt("password",$new_password);
			$this->member_model->changePassword($user_id,$new_password_encrypt);
			$domain = "https://app.netzeroschool.kr/";
			$message = '<!DOCTYPE html>
	    <html lang="ko">

	    <head>
	        <meta charset="UTF-8">
	        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	        <title>Document</title>
	    </head>

	    <body>
	    <div style="margin:0 auto;width:700px;">
	            <h1 style="padding: 42px 0; margin: 0; text-align: center; border-bottom: 3px solid #000">저탄소 스쿨</h1>
	            <h1 style="padding: 42px 0; margin: 0; text-align: center;">임시 비밀번호 안내</h1>
	            <div style="margin: 0px auto 100px; text-align: center;">
	                <h2 style="font-size: 16px;font-weight: bold;">안녕하세요. '.$user_name.'님<br> 임시 비밀번호가 발급되었습니다.</h2>
	                <h2 class="key" style="font-size: 20px; color: #ff0000">'.$new_password.'</h2>
	                <p style="color: #000; font-size: 16px;;">로그인후 비밀번호 변경을 해주시기 바랍니다.</p>
	            </div>
	            <div class="footer" style="padding: 31px 32px; background: #f7f7f7; font-size: 14px; color: #666">
	                도움이 필요 하시면 이메일로 문의 바랍니다.<br>
	                저탄소스쿨
	            </div>
	        </div>
	    </body>

	    </html>';

			$this->send_htmlmail("netzeroschool@naver.com", "저탄소스쿨", $user_email, $userData['user_name'], "[저탄소스쿨]비밀번호 재설정", $message);
		}

		$data = array(
			"page_title"	=>	$page_title,
			"user_email"	=>	$user_email
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('member/find-pw-proc',$data);
	}

	//설정
	public function setting()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "setting";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"userData"	=>	$this->CONFIG_DATA["userData"]
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/setting',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	public function changeSchool_proc()
	{
		$user_id = $this->session->userdata("user_id");
		$school_seq = $this->input->post("school_seq");
		$school_year = $this->input->post("school_year");
		$school_class = $this->input->post("school_class");
		$school_chk = $this->input->post("school_chk");

		$school_year = empty($school_year) ? "" : $school_year;
		$school_class = empty($school_class) ? "" : $school_class;
		$school_name = "";

		if($school_chk=="Y"){
			$school_seq = "";
			$school_year = "";
			$school_class = "";
			$user_level = 7;
		}else{
			$user_level = 6;
			$school_name = $this->school_model->getSchoolName($school_seq);
		}

		$data = array(
			"school_seq"	=>	$school_seq,
			"school_year"	=>	$school_year,
			"school_class"	=>	$school_class,
			"school_name"	=>	$school_name,
			"user_level"	=>	$user_level,
			"update_time"	=>	date("Y-m-d H:i:s")
		);

		$this->member_model->changeSchool($user_id,$data);

		echo '{"result":"success"}';
		exit;
	}

	//비밀번호 변경
	public function changePw()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "changePw";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/change-pw',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	public function changePw_proc()
	{
		$old_password = $this->input->post("user_password");
		$new_password = $this->input->post("new_password");

		$user_id = $this->session->userdata("user_id");
		$userdata = $this->member_model->getUserData($user_id);
		$user_password = $this->decrypt("password",$userdata['user_password']);
		if($old_password != $user_password){
			echo '{"result":"failed","msg":"기존비밀번호가 다릅니다."}';
			exit;
		}
		$new_password = $this->encrypt("password",$new_password);
		$this->member_model->changePassword($user_id,$new_password);

		echo '{"result":"success"}';
		exit;
	}

	public function leave_proc()
	{
		$user_id = $this->session->userdata("user_id");
		$withdrawal_type = $this->input->post("withdrawal_type");
		$withdrawal_text = $this->input->post("withdrawal_text");
		$withdrawal_date = date("Y-m-d H:i:s");

		$data = array(
			"withdrawal_type"	=>	$withdrawal_type,
			"withdrawal_text"	=>	$withdrawal_text,
			"withdrawal_date"	=>	$withdrawal_date
		);

		$this->member_model->leaveUser($user_id,$data);

		$this->session->sess_destroy();

		echo '{"result":"success"}';
		exit;
	}

	public function changePush()
	{
		$user_id = $this->session->userdata("user_id");
		$type = $this->input->post("type");
		$val = $this->input->post("val");

		$this->member_model->changePush($user_id,$type,$val);

		echo '{"result":"success"}';
		exit;
	}

	//학교정보 변경
	public function changeSchool()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "changeSchool";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/change-school',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	//회원탈퇴
	public function leave()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "leave";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/leave',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	public function leaveStep2()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "leave";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/leave-step2',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	public function leaveStep3()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "leave";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/leave-step3',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	public function leaveStep4()
	{
		$sub = "member";

		$depth1 = "setting";
		$depth2 = "leave";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('member/leave-step4',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	//네이버 로그인 콜백
	public function naver_login_callback()
	{

		if ($this->session->userdata('naver_login_state') != $this->input->get('state')) {
			$this->msg("오류가 발생했습니다. 잘못된 경로로 접근했습니다.");
			$this->goURL("/");
			exit;
			// 오류가 발생하였습니다. 잘못된 경로로 접근 하신것 같습니다.
		}

		$naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&code=".$_GET['code']."&state=".$_GET['state'];

		// 토큰값 가져오기
		$is_post = false;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $naver_curl);
		curl_setopt($ch, CURLOPT_POST, $is_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec ($ch);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close ($ch);
		if($status_code == 200) {
			$responseArr = json_decode($response, true);

			$_SESSION['naver_access_token'] = $responseArr['access_token'];
			$_SESSION['naver_refresh_token'] = $responseArr['refresh_token'];

			// 토큰값으로 네이버 회원정보 가져오기
			$me_headers = array(
				'Content-Type: application/json',
				sprintf('Authorization: Bearer %s', $responseArr['access_token'])
			);
			$me_is_post = false;
			$me_ch = curl_init();
			curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
			curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
			curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
			curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
			$me_response = curl_exec ($me_ch);
			$me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
			curl_close ($me_ch);

			$me_responseArr = json_decode($me_response, true);

			if ($me_responseArr['response']['id']) {
				$sns_key = $me_responseArr['response']['id'];
				// 회원가입 DB에서 회원이 있으면(이미 가입되어 있다면) 토큰을 업데이트 하고 로그인함
				$is_member = $this->member_model->getSnsMember("naver",$sns_key);
				if( $is_member["result"] == "success" ){
					//이미 회원일때 로그인
					$user_seq = $is_member['user_seq'];
					$user_id = $is_member['user_id'];
					$school_seq = $is_member['school_seq'];
					//session에 저장
					$this->session->set_userdata("user_seq" , $user_seq);
					$this->session->set_userdata("user_id" , $user_id);
					$this->session->set_userdata("school_seq",$school_seq);

					$this->member_model->addAutoLogin($user_id);

					$login_key = random_string("alnum",15);

					$loginData = array(
						"user_seq"	=>	$user_seq,
						"user_id"	=>	$user_id,
						"login_key"	=> $login_key,
						"user_ip"	=> $this->input->ip_address(),
						"reg_date"	=>	date("Y-m-d H:i:s"),
					);

					$this->session->set_userdata("login_key",$login_key);

					$this->member_model->deleteLogin($user_id);

					$this->member_model->insertLogin($loginData);

					$app_key = $this->session->userdata("app_key");
					if(!empty($app_key)){
						$this->member_model->updateAppKey($user_id,$app_key);
					}


					$this->goURL("/main");
					//$this->msg($app_key);
					exit;

				}else{
					$message = "";

					switch($is_member["msg"]){
						case "status_r":
							$message = "승인대기 상태입니다. 관리자에 문의주세요";
							$this->msg2($message,"/");exit;
						break;

						case "status_l":
							$message = "탈퇴 상태입니다. 관리자에 문의주세요";
							$this->msg2($message,"/");exit;
						break;

						case "status_d":
							$message = "삭제된 아이디입니다. 관리자에 문의주세요";
							$this->msg2($message,"/");exit;
						break;

						case "school_end":
							$message = "기관의 계약기간이 만료되었습니다.";
							$this->msg2($message,"/");exit;
						break;

						case "id":
							//회원이 아닐때 회원가입
							$user_name = $me_responseArr['response']['name'];
							$sns_key = $me_responseArr['response']['id'];
							$gender = $me_responseArr['response']['gender'];
							$email = $me_responseArr['response']['email'];
							$phone = $me_responseArr['response']['mobile'];
							$birthday = $me_responseArr['response']['birthday'];
							$birthyear = $me_responseArr['response']['birthyear'];

							if(!empty($birthday)){
								if(!empty($birthyear)){
									$birthday = $birthyear."-".$birthday;
								}
							}

							$data = array(
								"user_name"	=>	$user_name,
								"sns_key"	=>	$sns_key,
								"gender"	=>	$gender,
								"email"	=>	$email,
								"phone"	=>	$phone,
								"birthday"	=>	$birthday,
								"user_type"	=>	"naver"
							);
							$this->session->set_userdata($data);
							$this->goURL("/member/sns_join");
							exit;
						break;
					}
				}
				//if (회원정보가 있다면) {
					// 멤버 DB에 토큰값 업데이트 $responseArr['access_token']
					// 로그인
				//}	else {
					// 회원아이디 $mb_uid
					/*
					$mb_nickname = $me_responseArr['response']['nickname']; // 닉네임
					$mb_email = $me_responseArr['response']['email']; // 이메일
					$mb_gender = $me_responseArr['response']['gender']; // 성별 F: 여성, M: 남성, U: 확인불가
					$mb_age = $me_responseArr['response']['age']; // 연령대
					$mb_birthday = $me_responseArr['response']['birthday']; // 생일(MM-DD 형식)
					$mb_profile_image = $me_responseArr['response']['profile_image']; // 프로필 이미지
					*/

					// 멤버 DB에 토큰과 회원정보를 넣고 로그인
				//}

			} else {
				$this->msg("회원정보를 가져오지 못했습니다.");
				$this->goURL("/");
				exit;
			}

		} else {
			$this->msg("토큰값을 가져오지 못했습니다.");
			$this->goURL("/");
			exit;
		}

	}

	public function kakao_login_callback()
	{

		//token
		$code = $this->input->get("code");
		$ACCESS_TOKEN = $this->getToken(KAKAO_API_KEY, urlencode(KAKAO_CALLBACK_URL), KAKAO_CLIENT_SECRET)->access_token;
		$profile = $this->getProfile($ACCESS_TOKEN);

		$user_name = "";
		$sns_key = $profile->id;
		$gender = $profile->kakao_account->gender=="male"?"M":"W";
		$email = $profile->kakao_account->email;
		$phone = "";
		$birthday = "";
		$user_type = "kakao";

		$is_member = $this->member_model->getSnsMember("kakao",$sns_key);
		if( $is_member["result"] == "success" ){
			$user_seq = $is_member['user_seq'];
			$user_id = $is_member['user_id'];
			$school_seq = $is_member['school_seq'];
			//session에 저장
			$this->session->set_userdata("user_seq" , $user_seq);
			$this->session->set_userdata("user_id" , $user_id);
			$this->session->set_userdata("school_seq",$school_seq);

			$this->member_model->addAutoLogin($user_id);

			$login_key = random_string("alnum",15);

			$loginData = array(
				"user_seq"	=>	$user_seq,
				"user_id"	=>	$user_id,
				"login_key"	=> $login_key,
				"user_ip"	=> $this->input->ip_address(),
				"reg_date"	=>	date("Y-m-d H:i:s"),
			);

			$this->session->set_userdata("login_key",$login_key);

			$this->member_model->deleteLogin($user_id);

			$this->member_model->insertLogin($loginData);

			$app_key = $this->session->userdata("app_key");
			if(!empty($app_key)){
				$this->member_model->updateAppKey($user_id,$app_key);
			}

			$this->goURL("/main");
			//$this->msg($app_key);
			exit;

		}else{
			$message = "";

			switch($is_member["msg"]){
				case "status_r":
					$message = "승인대기 상태입니다. 관리자에 문의주세요";
					$this->msg2($message,"/");
					exit;
				break;

				case "status_l":
					$message = "탈퇴 상태입니다. 관리자에 문의주세요";
					$this->msg2($message,"/");
					exit;
				break;

				case "status_d":
					$message = "삭제된 아이디입니다. 관리자에 문의주세요";
					$this->msg2($message,"/");
					exit;
				break;

				case "school_end":
					$message = "기관의 계약기간이 만료되었습니다.";
					$this->msg2($message,"/");
					exit;
				break;

				case "id":
					//회원이 아닐때 회원가입
					$data = array(
						"user_name"	=>	$user_name,
						"sns_key"	=>	$sns_key,
						"gender"	=>	$gender,
						"email"	=>	$email,
						"phone"	=>	$phone,
						"birthday"	=>	$birthday,
						"user_type"	=>	$user_type
					);
					$this->session->set_userdata($data);
					$this->goURL("/member/sns_join");
					exit;
				break;
			}
		}
		exit;

	}

	public function facebook_login_callback()
	{
		$code = $this->input->get('code');

		$appID = FACEBOOK_API_KEY;	//페이스북 앱 아이디
		$appSecret = FACEBOOK_CLIENT_SECRET;	//페이스북 앱 시크릿
		$redirectUri = urlencode(FACEBOOK_CALLBACK_URL);	//로그인 요청 처리할 주소와 같은 주소

		// 액세스 토큰을 받을 주소
		$tokenUrl = "https://graph.facebook.com/v16.0/oauth/access_token?client_id=$appID&redirect_uri=$redirectUri&client_secret=$appSecret&code=$code";

		// curl로 get 요청
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $tokenUrl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$response = json_decode(curl_exec($curl));

		//액세스 토큰 변수에 저장
		$accessToken = $response->access_token;

		// 장기 토큰으로 변환
		$url = "https://graph.facebook.com/v16.0/oauth/access_token?grant_type=fb_exchange_token&client_id=$appID&client_secret=$appSecret&fb_exchange_token=$accessToken";
		curl_setopt($curl, CURLOPT_URL, $url);
		$response = json_decode(curl_exec($curl));

		// 저장된 토큰 변경
		$accessToken = $response->access_token;

		$url = "https://graph.facebook.com/v16.0/me?fields=id,name,email,birthday,gender&access_token=$accessToken";
		curl_setopt($curl, CURLOPT_URL, $url);
		$profile = json_decode(curl_exec($curl));


		$user_name = $profile->name;
		$sns_key = $profile->id;
		$gender = empty($profile->gender) ? "" : $profile->gender;
		if(!empty($gender)){
			$gender = $gender=="male"?"M":"W";
		}
		$email = empty($profile->email) ? "" : $profile->email;
		$phone = "";
		$birthday = empty($profile->birthday) ? "" : $profile->birthday;
		$user_type = "facebook";

		$is_member = $this->member_model->getSnsMember("facebook",$sns_key);
		if( $is_member["result"] == "success" ){
			$user_seq = $is_member['user_seq'];
			$user_id = $is_member['user_id'];
			$school_seq = $is_member['school_seq'];
			//session에 저장
			$this->session->set_userdata("user_seq" , $user_seq);
			$this->session->set_userdata("user_id" , $user_id);
			$this->session->set_userdata("school_seq",$school_seq);

			$this->member_model->addAutoLogin($user_id);

			$login_key = random_string("alnum",15);

			$loginData = array(
				"user_seq"	=>	$user_seq,
				"user_id"	=>	$user_id,
				"login_key"	=> $login_key,
				"user_ip"	=> $this->input->ip_address(),
				"reg_date"	=>	date("Y-m-d H:i:s"),
			);

			$this->session->set_userdata("login_key",$login_key);

			$this->member_model->deleteLogin($user_id);

			$this->member_model->insertLogin($loginData);

			$app_key = $this->session->userdata("app_key");
			if(!empty($app_key)){
				$this->member_model->updateAppKey($user_id,$app_key);
			}

			$this->goURL("/main");
			exit;

		}else{
			$message = "";

			switch($is_member["msg"]){
				case "status_r":
					$message = "승인대기 상태입니다. 관리자에 문의주세요";
				break;

				case "status_l":
					$message = "탈퇴 상태입니다. 관리자에 문의주세요";
				break;

				case "status_d":
					$message = "삭제된 아이디입니다. 관리자에 문의주세요";
				break;

				case "school_end":
					$message = "기관의 계약기간이 만료되었습니다.";
				break;

				case "id":
					//회원이 아닐때 회원가입
					if(!empty($birthday)){
						$birthdayArr = explode("/",$birthday);
						$birthday_year = $birthdayArr[2];
						$birthday_month = $birthdayArr[1];
						$birthday_day = $birthdayArr[0];

						$birthday = $birthday_year."-".$birthday_month."-".$birthday_day;
					}


					$data = array(
						"user_name"	=>	$user_name,
						"sns_key"	=>	$sns_key,
						"gender"	=>	$gender,
						"email"	=>	$email,
						"phone"	=>	$phone,
						"birthday"	=>	$birthday,
						"user_type"	=>	$user_type
					);
					$this->session->set_userdata($data);
					$this->goURL("/member/sns_join");
					exit;
				break;
			}
		}
	}

	public function Call($callUrl, $method, $headers = array(), $data = array(), $returnType="jsonObject")
	{
	    try {
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, $callUrl);
	        if ($method == "POST") {
	            curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        } else {
	            curl_setopt($ch, CURLOPT_POST, false);
	        }
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($ch, CURLOPT_HTTP200ALIASES, array(400));
	        $response = curl_exec($ch);
	        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	        curl_close($ch);

	        if ($returnType=="jsonObject") return json_decode($response);
	        else return $response;
	    } catch (Exception $e) {
	        echo $e;
	    }
	}

	function getToken($REST_API_KEY, $REDIRECT_URI, $CLIENT_SECRET) //로그인 : 토큰 조회
	{
	    $code = $_GET["code"]; //Redirect URI로 돌아올 때, 받아온 파라메터
	    $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=".$REST_API_KEY."&redirect_uri=".$REDIRECT_URI."&code=".$code."&client_secret=".$CLIENT_SECRET;
	    $res = $this->Call($callUrl, "POST");
			if(!empty($res->error_code)){
				if($res->error_code == "KOE320") $this->goURL("/");
			}

	    return $res;
	}

	function getProfile($ACCESS_TOKEN) //로그인 : 플로필 조회
	{
	    $callUrl = "https://kapi.kakao.com/v2/user/me";
	    $headers[] = "Authorization: Bearer ".$ACCESS_TOKEN;
	    $res = $this->Call($callUrl, "POST", $headers);
	    //if($res->properties == "") die("내 애플리케이션>제품 설정>카카오 로그인> 동의항목 : profile 필수 설정");
	    return $res;
	}

	public function profileUploadProc()
	{
		$profile_img = $_FILES['profile_img']['name'];
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/member/";

		$file_name = $user_seq."_profile_".$profile_img;

		@unlink($upload_path.$file_name);

		if( !is_dir($upload_path) ){
			mkdir($upload_path,0777,true);
		}

		move_uploaded_file($_FILES['profile_img']["tmp_name"],$upload_path.$file_name);

		//image size
		$file = getimagesize($upload_path.$file_name);
		if($file['mime'] == 'image/png'){
			$image = imagecreatefrompng($upload_path.$file_name);
		}else if($file['mime'] == 'image/gif'){
			$image = imagecreatefromgif($upload_path.$file_name);
		}else{
			$image = imagecreatefromjpeg($upload_path.$file_name);
		}
		$exif = exif_read_data($upload_path.$file_name);
    if(!empty($exif['Orientation'])) {
        switch($exif['Orientation']) {
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
        }
    }

		imagejpeg($image,$upload_path.$file_name,50);

		$this->member_model->updateProfile($user_seq,$file_name);

		echo '{"result":"success"}';
		exit;

	}

	public function alarmReadProc()
	{
		$alarm_seq = $this->input->post("alarm_seq");
		$user_id = $this->CONFIG_DATA['userData']['user_id'];
		$read_date = date("Y-m-d H:i:s");

		$data = array(
			"alarm_seq"	=>	$alarm_seq,
			"user_id"	=>	$user_id,
			"read_date"	=>	$read_date
		);

		$this->member_model->readAlarm($data);

		echo '{"result":"success"}';
		exit;
	}

	public function alarmReadAllProc()
	{
		$user_id = $this->CONFIG_DATA['userData']['user_id'];
		$alarmData = $this->CONFIG_DATA['alarmData'];

		$this->member_model->readAllAlarm($user_id,$alarmData);

		echo '{"result":"success"}';
		exit;
	}

	public function cert_success()
	{
		$sitecode = CERT_SITE_CODE;					// NICE로부터 부여받은 사이트 코드
    $sitepasswd = CERT_PASSWORD;				// NICE로부터 부여받은 사이트 패스워드

    // Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
    $cb_encode_path = $_SERVER['DOCUMENT_ROOT']."/plugin/cert/CPClient";

    $enc_data = $_REQUEST["EncodeData"];		// 암호화된 결과 데이타

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가.
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////

    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
        echo "[plaindata]  " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
						$this->msg3($returnMsg);
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
						$this->msg3($returnMsg);
        }else{
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)

            $requestnumber = $this->GetValue($plaindata , "REQ_SEQ");
            $responsenumber = $this->GetValue($plaindata , "RES_SEQ");
            $authtype = $this->GetValue($plaindata , "AUTH_TYPE");
            //$name = $this->GetValue($plaindata , "NAME");
            $name = $this->GetValue($plaindata , "UTF8_NAME"); //charset utf8 사용시 주석 해제 후 사용
            $birthdate = $this->GetValue($plaindata , "BIRTHDATE");
            $gender = $this->GetValue($plaindata , "GENDER");
            $nationalinfo = $this->GetValue($plaindata , "NATIONALINFO");	//내/외국인정보(사용자 매뉴얼 참조)
            $dupinfo = $this->GetValue($plaindata , "DI");
            $conninfo = $this->GetValue($plaindata , "CI");
						$mobileno = $this->GetValue($plaindata , "MOBILE_NO");
            $mobileco = $this->GetValue($plaindata , "MOBILE_CO");

						$this->session->set_userdata("parent_name",urldecode($name));
						$this->session->set_userdata("parent_phone",$mobileno);
						$this->session->set_userdata("parent_birthday",$birthdate);

						echo '<script>opener.parent.location="/member/join/step1";window.close()</script>';
						exit;

            if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0)
            {
            	echo "세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.<br>";
                $requestnumber = "";
                $responsenumber = "";
                $authtype = "";
                $name = "";
            	$birthdate = "";
            	$gender = "";
            	$nationalinfo = "";
            	$dupinfo = "";
            	$conninfo = "";
							$mobileno = "";
							$mobileco = "";
            }
        }
    }
	}

	public function cert_fail()
	{
		$config['csrf_protection'] = false;
		$sitecode = CERT_SITE_CODE;					// NICE로부터 부여받은 사이트 코드
    $sitepasswd = CERT_PASSWORD;				// NICE로부터 부여받은 사이트 패스워드

    // Linux = /절대경로/ , Window = D:\\절대경로\\ , D:\절대경로\
    $cb_encode_path = $_SERVER['DOCUMENT_ROOT']."/plugin/cert/CPClient";

    $enc_data = $_REQUEST["EncodeData"];		// 암호화된 결과 데이타

		//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
    if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "입력 값 확인이 필요합니다 : ".$match[0]; exit;} // 문자열 점검 추가.
    if(base64_encode(base64_decode($enc_data))!=$enc_data) {echo "입력 값 확인이 필요합니다"; exit;}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////

    if ($enc_data != "") {

        $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;		// 암호화된 결과 데이터의 복호화
        echo "[plaindata] " . $plaindata . "<br>";

        if ($plaindata == -1){
            $returnMsg  = "암/복호화 시스템 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -4){
            $returnMsg  = "복호화 처리 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -5){
            $returnMsg  = "HASH값 불일치 - 복호화 데이터는 리턴됨";
						$this->msg3($returnMsg);
        }else if ($plaindata == -6){
            $returnMsg  = "복호화 데이터 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -9){
            $returnMsg  = "입력값 오류";
						$this->msg3($returnMsg);
        }else if ($plaindata == -12){
            $returnMsg  = "사이트 비밀번호 오류";
						$this->msg3($returnMsg);
        }else{
            // 복호화가 정상적일 경우 데이터를 파싱합니다.
            $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;	// 암호화된 결과 데이터 검증 (복호화한 시간획득)

            $requestnumber = $this->GetValue($plaindata , "REQ_SEQ");
            $errcode = $this->GetValue($plaindata , "ERR_CODE");
            $authtype = $this->GetValue($plaindata , "AUTH_TYPE");

						switch($errcode){
							case "0001":
							$this->msg3("인증 불일치");
							break;
							case "0003":
							$this->msg3("기타인증오류");
							break;
							case "0010":
							$this->msg3("인증번호 불일치");
							break;
							case "0012":
							$this->msg3("요청정보오류");
							break;
							case "0013":
							$this->msg3("암호화 시스템 오류");
							break;
							case "0014":
							$this->msg3("암호화 처리 오류");
							break;
							case "0015":
							$this->msg3("암호화 데이터 오류");
							break;
							case "0016":
							$this->msg3("복호화 처리 오류");
							break;
							case "0017":
							$this->msg3("복호화 데이터 오류");
							break;
							case "0018":
							$this->msg3("통신오류");
							break;
							case "0019":
							$this->msg3("데이터베이스 오류");
							break;
							case "0020":
							$this->msg3("유효하지않은 CP코드");
							break;
							case "0021":
							$this->msg3("중단된 CP코드");
							break;
							case "0022":
							$this->msg3("휴대전화본인확인 사용불가 CP코드");
							break;
							case "0023":
							$this->msg3("미등록 CP코드");
							break;
							case "0031":
							$this->msg3("유효한 인증이력 없음");
							break;
							case "0035":
							$this->msg3("기인증완료건");
							break;
							case "0040":
							$this->msg3("본인확인차단고객");
							break;
							case "0041":
							$this->msg3("인증문자발송차단고객");
							break;
							case "0050":
							$this->msg3("NICE 명의보호서비스 이용고객 차단");
							break;
							case "0052":
							$this->msg3("부정사용차단");
							break;
							case "0070":
							$this->msg3("간편인증앱 미설치");
							break;
							case "0071":
							$this->msg3("앱인증 미완료");
							break;
							case "0072":
							$this->msg3("간편인증 처리중 오류");
							break;
							case "0073":
							$this->msg3("간편인증앱 미설치");
							break;
							case "0074":
							$this->msg3("간편인증앱 재설치필요");
							break;
							case "0075":
							$this->msg3("간편인증사용불가-스마트폰아님");
							break;
							case "0076":
							$this->msg3("간편인증앱 미설치");
							break;
							case "0078":
							$this->msg3("14세 미만 인증 오류");
							break;
							case "0079":
							$this->msg3("간편인증 시스템 오류");
							break;
							case "9097":
							$this->msg3("인증번호 3회 불일치");
							break;
						}
        }
    }
	}

	public function GetValue($str , $name)
	{
			$pos1 = 0;  //length의 시작 위치
			$pos2 = 0;  //:의 위치

			while( $pos1 <= strlen($str) )
			{
					$pos2 = strpos( $str , ":" , $pos1);
					@$len = substr($str , $pos1 , $pos2 - $pos1);
					@$key = substr($str , $pos2 + 1 , $len);
					$pos1 = $pos2 + $len + 1;
					if( $key == $name )
					{
							$pos2 = strpos( $str , ":" , $pos1);
							@$len = substr($str , $pos1 , $pos2 - $pos1);
							@$value = substr($str , $pos2 + 1 , $len);
							return $value;
					}
					else
					{
							// 다르면 스킵한다.
							$pos2 = strpos( $str , ":" , $pos1);
							@$len = substr($str , $pos1 , $pos2 - $pos1);
							$pos1 = $pos2 + $len + 1;
					}
			}
	}



}
