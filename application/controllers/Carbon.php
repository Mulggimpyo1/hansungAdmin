<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carbon extends MY_Controller {

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
		$this->load->model("school_model");
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

  public function oath()
  {
		$sub = "carbon";

		$depth1 = "oath";
		$depth2 = "oath";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$carbonData = $this->member_model->getCarbonOauthData($user_seq);

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"carbonData"	=>	$carbonData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/oath',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	//탄소북
	public function list()
  {
		$sub = "carbon";

		$depth1 = "list";
		$depth2 = "list";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$whereData = array(
			"where"	=>	"",
			"sort"	=>	"",
			"limit"	=>	""
		);

		$school_seq = $this->CONFIG_DATA['userData']['school_seq'];

		$schoolData = $this->school_model->getSchool($school_seq);

		$book_read_yn = $schoolData['book_yn'];

		$bookList = $this->board_model->getBookList($whereData);


		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"bookList"	=>	$bookList,
			"book_read_yn"	=>	$book_read_yn
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/carbon-list',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function viewBook()
	{
		$this->loginCheck();
		//$pdf = $this->content_model->getCarbornPdf($seq);
		$data = array(
			//"pdf"	=>	$pdf,
		);


		$this->parser->parse('carbon/pdf-view',$data);
	}

  //탄소서약서 작성
	public function write()
  {
		$sub = "carbon";

		$depth1 = "write";
		$depth2 = "write";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/carbon-write',$this->CONFIG_DATA);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //탄소서약서
  public function certificate()
  {
    $sub = "carbon";

		$depth1 = "write";
		$depth2 = "write";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/certificate',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //서약현황
  public function implement($area="city")
  {
    $sub = "carbon";

		$depth1 = "write";
		$depth2 = "write";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;



		if($area=="city"){
			$oauthData = $this->member_model->getOauthInsight($where="");

			for($i=0; $i<count($oauthData['oauthList']); $i++)
			{
				$oauthData['oauthList'][$i]['per'] = ($oauthData['oauthList'][$i]['cnt'] / $oauthData['oauthTotal']) * 100;
			}
		}else{
			$school_name = $this->CONFIG_DATA['userData']['school_name'];
			$oauthData = $this->member_model->getOauthSchool($school_name);
			for($i=0; $i<count($oauthData['rankData']); $i++){
				$oauthData['rankData'][$i]['per'] = ($oauthData['rankData'][$i]['cnt'] / $oauthData['oauthTotal']) * 100;
			}
			$oauthData['myPer'] = ($oauthData['myTotal'] / $oauthData['oauthTotal']) * 100;

		}

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"oauthData"	=>	$oauthData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/implement-'.$area,$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //계산기
  public function calculate()
  {
    $sub = "carbon";

		$depth1 = "calculate";
		$depth2 = "calculate";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/calculate',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }


	//탄소북
	public function view()
  {
		$sub = "carbon";

		$depth1 = "list";
		$depth2 = "list";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$whereData = array(
			"where"	=>	"",
			"sort"	=>	"",
			"limit"	=>	""
		);


		$data = array(
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('carbon/carbon-view',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

}
