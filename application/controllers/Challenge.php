<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Challenge extends MY_Controller {

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
				//$this->loginCheck();
	}

	public function index()
	{

	}

  public function home()
  {
		$this->loginCheck();
    $sub = "home";

		$depth1 = "challenge";
		$depth2 = "home";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$challengeData = $this->content_model->getChallengeDepth1();

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"challengeData"	=>	$challengeData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('challenge/home',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //challenge list
  public function list($challenge_seq)
  {
    $sub = "list";

		$depth1 = "challenge";
		$depth2 = "list";

		$challengeData = $this->content_model->getChallenge($challenge_seq);

    $page_title = $challengeData['challenge_title']." 챌린지";

		$challenge2Depth = $this->content_model->getChallengeDepth2($challenge_seq);


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
      "page_title"  =>  $page_title,
			"challenge2Depth"	=>	$challenge2Depth
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('challenge/list',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //challenge view
  public function view($challenge_seq)
  {
    $sub = "view";

		$depth1 = "challenge";
		$depth2 = "view";

		$challengeData = $this->content_model->getChallenge($challenge_seq);

    $page_title = $challengeData['challenge_title'];

		$parent_challenge = $this->content_model->getFindParentChallenge($challenge_seq);

		$challenge_1 = $parent_challenge['challenge_seq'];
		$challenge_2 = $challenge_seq;


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
      "page_title"  =>  $page_title,
			"challengeData"	=>	$challengeData,
			"challenge_1"	=>	$challenge_1,
			"challenge_2"	=>	$challenge_2
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('challenge/view',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

}
