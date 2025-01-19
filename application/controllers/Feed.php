<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends MY_Controller {

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
    $sub = "home";

		$depth1 = "feed";
		$depth2 = "home";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/header',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/home',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	//my list
	public function myList()
	{
		$this->loginCheck();
		$sub = "list";

		$depth1 = "feed";
		$depth2 = "myList";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$challengeList = $this->content_model->getChallengeDepth1();
		$userData = $this->CONFIG_DATA['userData'];

		$userChallengeCount = $this->content_model->getUserChallengeCount($userData['user_seq']);
		$total_challenge = 0;

		for($i=0; $i<count($userChallengeCount); $i++){
			$total_challenge += $userChallengeCount[$i]['total'];
		}

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"challengeList"	=>	$challengeList,
			"userData"	=>	$userData,
			"userChallengeCount"	=>	$userChallengeCount,
			"total_challenge"	=>	$total_challenge
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/my-list',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	//my album
	public function myAlbum($user_id="")
	{
		$this->loginCheck();
		$sub = "list";

		$depth1 = "feed";
		$depth2 = "myAlbum";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$challengeList = $this->content_model->getChallengeDepth1();
		if(empty($user_id)){
			$userData = $this->CONFIG_DATA['userData'];
		}else{
			$userData = $this->member_model->getUserData($user_id);
		}



		$userChallengeCount = $this->content_model->getUserChallengeCount($userData['user_seq']);
		$total_challenge = 0;

		for($i=0; $i<count($userChallengeCount); $i++){
			$total_challenge += $userChallengeCount[$i]['total'];
		}

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"challengeList"	=>	$challengeList,
			"userData"	=>	$userData,
			"userChallengeCount"	=>	$userChallengeCount,
			"total_challenge"	=>	$total_challenge,
			"user_id"	=>	$user_id
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/my-album',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

  //feed list
  public function list($str)
  {
		$this->loginCheck();
    $sub = "list";

		$depth1 = "feed";
		$depth2 = "list";

    $page_title = "에너지 챌린지";


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
      "page_title"  =>  $page_title
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/list',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

  //feed write
  public function write($str="")
  {
		$this->loginCheck();
    $sub = "write";

		$depth1 = "feed";
		$depth2 = "write";

    $page_title = "에너지 챌린지";

		$challenge_1 = $this->input->get("challenge_1");
		$challenge_2 = $this->input->get("challenge_2");

		$challenge_1 = empty($challenge_1)?"":$challenge_1;
		$challenge_2 = empty($challenge_2)?"":$challenge_2;

		$agree_text = "";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$challengeData = $this->content_model->getChallengeDepth1();
		for($i=0; $i<count($challengeData); $i++){
			$challenge2 = $this->content_model->getChallengeDepth2($challengeData[$i]['challenge_seq']);
			$challengeData[$i]['challenge2'] = $challenge2;
			for($j=0; $j<count($challenge2); $j++){
				if($challenge2[$j]['challenge_seq']==$challenge_2){
					$agree_text = $challenge2[$j]['agree_text'];
				}
			}
		}

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"challenge_1"	=>	$challenge_1,
			"challenge_2"	=>	$challenge_2,
      "page_title"  =>  $page_title,
			"challengeData"	=>	$challengeData,
			"agree_text"	=>	$agree_text
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/write',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	//feed write
  public function modify($feed_seq)
  {
		$this->loginCheck();
    $sub = "modify";

		$depth1 = "feed";
		$depth2 = "modify";

		$feedData = $this->content_model->getFeed($feed_seq);

    $page_title = $feedData['challenge_title']." 수정";

		$challenge_1 = $this->input->get("challenge_1");
		$challenge_2 = $this->input->get("challenge_2");

		$challenge_1 = $feedData['feed_parent_challenge_seq'];
		$challenge_2 = $feedData['feed_challenge_seq'];


		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;

		$challengeData = $this->content_model->getChallengeDepth1();
		for($i=0; $i<count($challengeData); $i++){
			$challenge2 = $this->content_model->getChallengeDepth2($challengeData[$i]['challenge_seq']);
			$challengeData[$i]['challenge2'] = $challenge2;
		}

		$images = explode("|",$feedData['feed_photo']);
		$feedData['images'] = $images;

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"challenge_1"	=>	$challenge_1,
			"challenge_2"	=>	$challenge_2,
      "page_title"  =>  $page_title,
			"challengeData"	=>	$challengeData,
			"feedData"	=>	$feedData,
			"feed_seq"	=>	$feed_seq
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/modify',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
  }

	public function challengeSelect()
	{
		$chal1 = $this->input->post("chal1");
		$challenge_data = $this->content_model->getChallengeDepth2($chal1);

		echo '{"result":"success","data":'.json_encode($challenge_data).'}';
		exit;
	}

	public function challengeSelect2()
	{
		$chal2 = $this->input->post("chal2");
		$challenge_data = $this->content_model->getChallenge($chal2);

		echo '{"result":"success","agree_text":"'.$challenge_data['agree_text'].'"}';
		exit;
	}

	//feed load
	public function feedLoad()
	{
		$same_school = $this->input->post("same_school");
		$same_class = $this->input->post("same_class");
		$user_id = $this->input->post("user_id");

		if(empty($user_id)){
			$userData = $this->CONFIG_DATA['userData'];
		}else{
			$userData = $this->member_model->getUserData($user_id);
		}


		$user_school_seq = empty($userData['school_seq'])?"":$userData['school_seq'];
		$user_school_year = empty($userData['school_year'])?"":$userData['school_year'];
		$user_school_class = empty($userData['school_class'])?"":$userData['school_class'];

		$user_id = $userData['user_id'];
		$user_seq = $userData['user_seq'];

		//type : main / user
		$type = $this->input->post("type");

		$challenge_parent_seq = $this->input->post("challenge_parent_seq");

		$page_size = $this->input->post("page_size");
		$num = $this->input->post("num");

		$num = empty($num) ? 0 : $num;

		$page_size = empty($page_size) ? 10 : $num;

		$where = "";
		if(!empty($same_school)){
			$where .= " AND users.school_seq = '{$user_school_seq}'";
		}

		if(!empty($same_class)){
			$where .= " AND users.school_seq = '{$user_school_seq}' AND users.school_year = '{$user_school_year}' AND users.school_class = '{$user_school_class}'";
		}


		if($type == "user"){
			$where .= " AND feed.user_seq = '{$user_seq}'";
		}

		if($challenge_parent_seq!="all"){
			$where .= " AND feed.feed_parent_challenge_seq = '{$challenge_parent_seq}'";
		}

		$where .= " AND feed.status = 'Y'";

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->member_model->getFeedTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	"ORDER BY feed.reg_date DESC",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".($num*$page_size).",".$page_size
		);

		$feedList = $this->member_model->getFeedList($whereData);

		//넘버링
		$current_page = ceil ( ($num + 1) / $page_size );

		$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
		$end_page = $start_page + $page_list_size - 1;

		if ($total_page < $end_page)
		{
				$end_page = $total_page;
		}

		for($i=0; $i<count($feedList); $i++){
			$feed_seq = $feedList[$i]['feed_seq'];

			//댓글불러오기
			$commentData = $this->content_model->getFeedComment($feed_seq);

			//댓글 총 갯수
			$commentTotal = $this->content_model->getFeedCommentTotal($feed_seq);
			//라이크 총 갯수
			$likeTotal = $this->content_model->getFeedLikeTotal($feed_seq);

			for($j=0; $j<count($commentData); $j++){
				$comment_seq = $commentData[$j]['feed_comment_seq'];
				$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

				$commentData[$j]['comment_to_comment'] = array();
				if($comment_seq != 0){
					//대댓글
					$comment_to_comment = $this->content_model->getFeedCommentToComment($comment_seq);
					for($t=0; $t<count($comment_to_comment); $t++){
						$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);
					}

					$commentData[$j]['comment_to_comment'] = $comment_to_comment;

				}
			}
			$feedList[$i]['comment'] = $commentData;
			$feedList[$i]['comment_total'] = $commentTotal;
			$feedList[$i]['like_total'] = $likeTotal;
			$images = explode("|",$feedList[$i]['feed_photo']);
			$feedList[$i]['images'] = $images;
			$feedList[$i]['type'] = "feed";

			$feedList[$i]['feed_content'] = nl2br($feedList[$i]['feed_content']);

			//좋아요를 했는지 안했는지 체크
			$is_like = $this->content_model->getLikeFeed($user_id,$feedList[$i]['feed_seq']);
			$is_like = $is_like>0?"Y":"N";

			$feedList[$i]['is_like'] = $is_like;

			//자기 자신건지 확인하기
			$is_me = $this->content_model->getMyFeed($user_seq,$feedList[$i]['feed_seq']);
			$is_me = $is_me>0?"Y":"N";
			$feedList[$i]['is_me'] = $is_me;

			$feedList[$i]['write_time'] = $this->secToString($feedList[$i]['reg_date']);


		}

		//광고넣기
		$adList = $this->content_model->getAdFeed($user_seq);
		if(count($adList)>0){
			shuffle($adList);
			//댓글불러오기
			$commentData = $this->content_model->getAdFeedComment($adList[0]['adv_seq']);

			//댓글 총 갯수
			$commentTotal = $this->content_model->getAdFeedCommentTotal($adList[0]['adv_seq']);
			//라이크 총 갯수
			$likeTotal = $this->content_model->getAdFeedLikeTotal($adList[0]['adv_seq']);

			for($j=0; $j<count($commentData); $j++){
				$comment_seq = $commentData[$j]['adv_comment_seq'];
				$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

				$commentData[$j]['comment_to_comment'] = array();
				if($comment_seq != 0){
					//대댓글
					$comment_to_comment = $this->content_model->getAdFeedCommentToComment($comment_seq);
					for($t=0; $t<count($comment_to_comment); $t++){
						$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);
					}

					$commentData[$j]['comment_to_comment'] = $comment_to_comment;

				}
			}
			$adList[0]['comment'] = $commentData;
			$adList[0]['comment_total'] = $commentTotal;
			$adList[0]['like_total'] = $likeTotal;
			$images = array();
			for($i=1; $i<=5; $i++){
				if(!empty($adList[0]['adv_image'.$i])){
					array_push($images,$adList[0]['adv_image'.$i]);
				}
			}
			$adList[0]['images'] = $images;
			$adList[0]['type'] = "ad";

			$adList[0]['adv_content'] = nl2br($adList[0]['adv_content']);

			//좋아요를 했는지 안했는지 체크
			$is_like = $this->content_model->getAdLikeFeed($user_id,$adList[0]['adv_seq']);
			$is_like = $is_like>0?"Y":"N";

			$adList[0]['is_like'] = $is_like;

			$is_me = "N";
			$adList[0]['is_me'] = $is_me;

			$adList[0]['write_time'] = $this->secToString($adList[0]['reg_date']);

			//광고 읽음처리
			$this->content_model->getReadAd($adList[0]['adv_seq'],$this->CONFIG_DATA['userData']['user_seq']);
			//광고 종료체크
			$this->content_model->getAdEndCheck($adList[0]['adv_seq']);

			$adFeed = $adList[0];
		}else{
			$adFeed = array();
		}



		$returnArr = array(
			"feedList"	=>	$feedList,
			"total_page"	=>	$total_page,
			"num"	=>	$num,
			"adList"	=>	$adFeed
		);

		echo '{"result":"success","data":'.json_encode($returnArr).'}';
		exit;
	}

	public function adLinkProc()
	{
		$adv_seq = $this->input->post("adv_seq");
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$this->content_model->insertAdLink($adv_seq,$user_seq);

		echo '{"result":"success"}';
		exit;
	}

	//댓글 불러오기
	public function adCommentLoad()
	{
		$adv_seq = $this->input->post("adv_seq");

		$adList = $this->content_model->getAdData($adv_seq);

		//댓글불러오기
		$commentData = $this->content_model->getAdFeedComment($adv_seq);

		//댓글 총 갯수
		$commentTotal = $this->content_model->getAdFeedCommentTotal($adv_seq);

		$user_id = $this->session->userdata("user_id");
		$user_seq = $this->CONFIG_DATA["userData"]['user_seq'];

		for($j=0; $j<count($commentData); $j++){
			$comment_seq = $commentData[$j]['adv_comment_seq'];
			$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

			$comment_is_like = $this->content_model->getAdCommentIsLike($comment_seq,$user_id);
			if($comment_is_like>0){
				$comment_is_like = "Y";
			}else{
				$comment_is_like = "N";
			}

			$commentData[$j]['is_like'] = $comment_is_like;
			$comment_like_total = $this->content_model->getAdCommentTotalLike($comment_seq);

			$commentData[$j]['like_total'] = $comment_like_total;

			$commentData[$j]['comment_to_comment'] = array();
			if($comment_seq != 0){
				//대댓글
				$comment_to_comment = $this->content_model->getAdFeedCommentToComment($comment_seq);
				for($t=0; $t<count($comment_to_comment); $t++){
					$comment_to_comment_seq = $comment_to_comment[$t]['adv_comment_seq'];
					$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);

					$comment_to_comment_is_like = $this->content_model->getAdCommentIsLike($comment_to_comment_seq,$user_id);
					$comment_to_comment_like_total = $this->content_model->getAdCommentTotalLike($comment_to_comment_seq);
					if($comment_to_comment_is_like>0){
						$comment_to_comment_is_like = "Y";
					}else{
						$comment_to_comment_is_like = "N";
					}

					$comment_to_comment[$t]['is_like'] = $comment_to_comment_is_like;
					$comment_to_comment[$t]['like_total'] = $comment_to_comment_like_total;

				}


				$commentData[$j]['comment_to_comment'] = $comment_to_comment;


			}
		}
		$adList['comment'] = $commentData;

		$adList['adv_content'] = nl2br($adList['adv_content']);

		$is_me = "N";
		$adList['is_me'] = $is_me;

		$adList['write_time'] = $this->secToString($adList['reg_date']);

		echo '{"result":"success","data":'.json_encode($adList).'}';
		exit;
	}

	//댓글 불러오기
	public function feedCommentLoad()
	{
		$feed_seq = $this->input->post("feed_seq");

		$feedList = $this->content_model->getFeed($feed_seq);

		//댓글불러오기
		$commentData = $this->content_model->getFeedComment($feed_seq);

		//댓글 총 갯수
		$commentTotal = $this->content_model->getFeedCommentTotal($feed_seq);

		$user_id = $this->session->userdata("user_id");
		$user_seq = $this->CONFIG_DATA["userData"]['user_seq'];

		for($j=0; $j<count($commentData); $j++){
			$comment_seq = $commentData[$j]['feed_comment_seq'];
			$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

			$comment_is_like = $this->content_model->getCommentIsLike($comment_seq,$user_id);
			if($comment_is_like>0){
				$comment_is_like = "Y";
			}else{
				$comment_is_like = "N";
			}

			$commentData[$j]['is_like'] = $comment_is_like;
			$comment_like_total = $this->content_model->getCommentTotalLike($comment_seq);

			$commentData[$j]['like_total'] = $comment_like_total;

			$commentData[$j]['comment_to_comment'] = array();
			if($comment_seq != 0){
				//대댓글
				$comment_to_comment = $this->content_model->getFeedCommentToComment($comment_seq);
				for($t=0; $t<count($comment_to_comment); $t++){
					$comment_to_comment_seq = $comment_to_comment[$t]['feed_comment_seq'];
					$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);

					$comment_to_comment_is_like = $this->content_model->getCommentIsLike($comment_to_comment_seq,$user_id);
					$comment_to_comment_like_total = $this->content_model->getCommentTotalLike($comment_to_comment_seq);
					if($comment_to_comment_is_like>0){
						$comment_to_comment_is_like = "Y";
					}else{
						$comment_to_comment_is_like = "N";
					}

					$comment_to_comment[$t]['is_like'] = $comment_to_comment_is_like;
					$comment_to_comment[$t]['like_total'] = $comment_to_comment_like_total;

				}


				$commentData[$j]['comment_to_comment'] = $comment_to_comment;


			}
		}
		$feedList['comment'] = $commentData;

		$feedList['feed_content'] = nl2br($feedList['feed_content']);

		//자기 자신건지 확인하기
		$is_me = $this->content_model->getMyFeed($user_seq,$feedList['feed_seq']);
		$is_me = $is_me>0?"Y":"N";
		$feedList['is_me'] = $is_me;

		$feedList['write_time'] = $this->secToString($feedList['reg_date']);

		echo '{"result":"success","data":'.json_encode($feedList).'}';
		exit;
	}

	public function commentLike()
	{
		$comment_seq = $this->input->post("comment_seq");
		$val = $this->input->post("val");
		$user_id = $this->CONFIG_DATA['userData']['user_id'];
		$user_name = $this->CONFIG_DATA['userData']['user_name'];
		if($val == "Y"){
			$result = $this->content_model->addCommentLike($comment_seq,$user_id,$user_name);
			if($user_id != $result['user_id']){
				$arr = array(
		      "send_id" =>  $user_id,
		      "alarm_target"  =>  "user",
		      "alarm_type"  =>  "comment",
		      "feed_seq"  =>  $result['feed_seq'],
		      "to_id" =>  $result['user_id'],
		      "title" =>  $user_id."님이 댓글을 좋아합니다",
		      "link"  =>  "https://app.netzeroschool.kr/feed/view/".$result['feed_seq'],
		      "reg_date"  =>  date("Y-m-d H:i:s"),
		    );
				$this->addAlarm($arr);
			}

		}else{
			$result = $this->content_model->removeCommentLike($comment_seq,$user_id,$user_name);
			if($user_id != $result['user_id']){
				$arr = array(
		      "send_id" =>  $user_id,
		      "alarm_target"  =>  "user",
		      "alarm_type"  =>  "comment",
		      "feed_seq"  =>  $result['feed_seq'],
		      "to_id" =>  $result['user_id'],
		      "title" =>  $user_id."님이 댓글을 좋아합니다",
		      "link"  =>  "https://app.netzeroschool.kr/feed/view/".$result['feed_seq'],
		      "reg_date"  =>  date("Y-m-d H:i:s"),
		    );
				$this->removeAlarm($arr);
			}
		}

		echo '{"result":"success"}';
		exit;
	}

	public function commentAdLike()
	{
		$comment_seq = $this->input->post("comment_seq");
		$val = $this->input->post("val");
		$user_id = $this->CONFIG_DATA['userData']['user_id'];
		$user_name = $this->CONFIG_DATA['userData']['user_name'];
		if($val == "Y"){
			$result = $this->content_model->addAdCommentLike($comment_seq,$user_id,$user_name);
		}else{
			$result = $this->content_model->removeAdCommentLike($comment_seq,$user_id,$user_name);
		}

		echo '{"result":"success"}';
		exit;
	}

	public function writeCommentProc()
	{
		$feed_seq = $this->input->post("feed_seq");
		$comment_seq = $this->input->post("comment_seq");
		$comment = $this->input->post("comment");
		$user_id = $this->session->userdata("user_id");
		$user_name = $this->CONFIG_DATA['userData']['user_name'];

		$data = array(
			"feed_seq"	=>	$feed_seq,
			"comment_seq"	=>	$comment_seq,
			"comment"	=>	$comment,
			"user_id"	=>	$user_id,
			"user_name"	=>	$user_name,
		);

		$result = $this->content_model->insertComment($data);

		if($result['user_id']!=$user_id)
		{
			$data = array(
				"send_id"	=>	$user_id,
				"alarm_target"	=>	"user",
				"alarm_type"	=>	"comment",
				"feed_seq"	=>	$feed_seq,
				"to_id"	=>	$result['user_id'],
				"title"	=>	$user_id."님이 게시글에 댓글을 달았습니다",
				"link"	=>	"/feed/feedView/".$feed_seq
			);

			$this->addAlarm($data);
		}

		echo '{"result":"success"}';
		exit;
	}

	public function writeAdCommentProc()
	{
		$adv_seq = $this->input->post("adv_seq");
		$comment_seq = $this->input->post("comment_seq");
		$comment = $this->input->post("comment");
		$user_id = $this->session->userdata("user_id");
		$user_name = $this->CONFIG_DATA['userData']['user_name'];

		$data = array(
			"adv_seq"	=>	$adv_seq,
			"comment_seq"	=>	$comment_seq,
			"comment"	=>	$comment,
			"user_id"	=>	$user_id,
			"user_name"	=>	$user_name,
		);

		$this->content_model->insertAdComment($data);

		echo '{"result":"success"}';
		exit;
	}

	public function feedView($feed_seq)
	{
		//$this->loginCheck();

		$sub = "main";

		$depth1 = "main";
		$depth2 = "main";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["is_main"]	=	"true";

		$this->CONFIG_DATA['og_url'] = "https://app.netzeroschool.kr/feed/feedView/".$feed_seq;
    $this->CONFIG_DATA['og_title'] = "저탄소스쿨";
    $this->CONFIG_DATA['og_desc'] = "저탄소 스쿨입니다.";
		$feedData = $this->content_model->getFeed($feed_seq);
		$photo = explode("|",$feedData['feed_photo']);

    $this->CONFIG_DATA['og_image'] = "https://app.netzeroschool.kr/upload/member/feed/".$photo[0];

		if(empty($this->session->userdata("admin_id"))){
			$this->loginCheck();
		}


		$userData = $this->CONFIG_DATA['userData'];


		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"feed_seq"	=>	$feed_seq,
			"userData"	=>	$userData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/feed-view',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);

	}

	public function adView($adv_seq)
	{
		$sub = "main";

		$depth1 = "main";
		$depth2 = "main";

		$this->CONFIG_DATA["depth1"] = $depth1;
		$this->CONFIG_DATA["depth2"] = $depth2;
		$this->CONFIG_DATA["is_main"]	=	"true";

		$userData = $this->CONFIG_DATA['userData'];

		$this->CONFIG_DATA['og_url'] = "https://app.netzeroschool.kr/feed/adView/".$adv_seq;
    $this->CONFIG_DATA['og_title'] = "저탄소스쿨";
    $this->CONFIG_DATA['og_desc'] = "저탄소 스쿨입니다.";
		$adData = $this->content_model->getAdData($adv_seq);

    $this->CONFIG_DATA['og_image'] = "https://app.netzeroschool.kr/upload/ad/".$adData['adv_image1'];

		//$this->loginCheck();

		$data = array(
			"depth1"	=>	$depth1,
			"depth2"	=>	$depth2,
			"adv_seq"	=>	$adv_seq,
			"userData"	=>	$userData
		);


		$this->CONFIG_DATA["sub"] = $sub;
		$this->parser->parse('include/head',$this->CONFIG_DATA);
		$this->parser->parse('include/header',$this->CONFIG_DATA);
		$this->parser->parse('include/aside',$this->CONFIG_DATA);
		$this->parser->parse('feed/ad-view',$data);
		$this->parser->parse('include/footer',$this->CONFIG_DATA);
	}

	//feed view load
	public function feedViewLoad()
	{
		$feed_seq = $this->input->post("feed_seq");
		if(empty($this->session->userdata("admin_id"))){
			$userData = $this->CONFIG_DATA['userData'];

			$user_id = $userData['user_id'];
			$user_seq = $userData['user_seq'];
		}else{
			$user_id = "admin";
			$user_seq = 0;
		}


		//type : main / user
		$type = $this->input->post("type");

		$num = empty($num) ? 0 : $num;

		$page_size = empty($page_size) ? 5 : $num;

		$where = " AND feed.feed_seq = '{$feed_seq}'";


		$where .= " AND feed.status = 'Y'";

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->member_model->getFeedTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	"ORDER BY feed.reg_date DESC",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".($num*$page_size).",".$page_size
		);

		$feedList = $this->member_model->getFeedList($whereData);

		//넘버링
		$current_page = ceil ( ($num + 1) / $page_size );

		$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
		$end_page = $start_page + $page_list_size - 1;

		if ($total_page < $end_page)
		{
				$end_page = $total_page;
		}

		for($i=0; $i<count($feedList); $i++){
			$feed_seq = $feedList[$i]['feed_seq'];

			//댓글불러오기
			$commentData = $this->content_model->getFeedComment($feed_seq);

			//댓글 총 갯수
			$commentTotal = $this->content_model->getFeedCommentTotal($feed_seq);
			//라이크 총 갯수
			$likeTotal = $this->content_model->getFeedLikeTotal($feed_seq);

			for($j=0; $j<count($commentData); $j++){
				$comment_seq = $commentData[$j]['feed_comment_seq'];
				$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

				$commentData[$j]['comment_to_comment'] = array();
				if($comment_seq != 0){
					//대댓글
					$comment_to_comment = $this->content_model->getFeedCommentToComment($comment_seq);
					for($t=0; $t<count($comment_to_comment); $t++){
						$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);
					}

					$commentData[$j]['comment_to_comment'] = $comment_to_comment;

				}
			}
			$feedList[$i]['comment'] = $commentData;
			$feedList[$i]['comment_total'] = $commentTotal;
			$feedList[$i]['like_total'] = $likeTotal;
			$images = explode("|",$feedList[$i]['feed_photo']);
			$feedList[$i]['images'] = $images;
			$feedList[$i]['type'] = "feed";

			$feedList[$i]['feed_content'] = nl2br($feedList[$i]['feed_content']);

			//좋아요를 했는지 안했는지 체크
			$is_like = $this->content_model->getLikeFeed($user_id,$feedList[$i]['feed_seq']);
			$is_like = $is_like>0?"Y":"N";

			$feedList[$i]['is_like'] = $is_like;

			//자기 자신건지 확인하기
			$is_me = $this->content_model->getMyFeed($user_seq,$feedList[$i]['feed_seq']);
			$is_me = $is_me>0?"Y":"N";
			$feedList[$i]['is_me'] = $is_me;

			$feedList[$i]['write_time'] = $this->secToString($feedList[$i]['reg_date']);


		}

		$returnArr = array(
			"feedList"	=>	$feedList,
			"total_page"	=>	$total_page,
			"num"	=>	$num
		);

		//광고넣기

		echo '{"result":"success","data":'.json_encode($returnArr).'}';
		exit;
	}

	//feed view load
	public function adViewLoad()
	{
		$adv_seq = $this->input->post("adv_seq");
		$userData = $this->CONFIG_DATA['userData'];

		$user_id = $userData['user_id'];
		$user_seq = $userData['user_seq'];

		//type : main / user
		$type = $this->input->post("type");

		$num = empty($num) ? 0 : $num;

		$page_size = empty($page_size) ? 5 : $num;

		$where = " AND ad.adv_seq = '{$adv_seq}'";


		$where .= " AND ad.status = 'Y'";

		$page_list_size = 10;
		$whereData = array(
			"where"			=>	$where,
		);
		$list_total = $this->member_model->getAdFeedTotalCount($whereData);

		if( $list_total <= 0 )
		{
			$list_total = 0;
		}

		$total_page = ceil( $list_total / $page_size );

		$params = "";

		$whereData = array(
				"sort"			=>	"ORDER BY ad.reg_date DESC",
			"where"			=>	$where,
			"limit"			=>	"LIMIT ".($num*$page_size).",".$page_size
		);

		$adList = $this->member_model->getAdFeedList($whereData);

		//넘버링
		$current_page = ceil ( ($num + 1) / $page_size );

		$start_page = floor ( ($current_page - 1) / $page_list_size ) * $page_list_size + 1;
		$end_page = $start_page + $page_list_size - 1;

		if ($total_page < $end_page)
		{
				$end_page = $total_page;
		}

		for($i=0; $i<count($adList); $i++){
			$adv_seq = $adList[$i]['adv_seq'];

			//댓글불러오기
			$commentData = $this->content_model->getAdFeedComment($adv_seq);

			//댓글 총 갯수
			$commentTotal = $this->content_model->getAdFeedCommentTotal($adv_seq);
			//라이크 총 갯수
			$likeTotal = $this->content_model->getAdFeedLikeTotal($adv_seq);

			for($j=0; $j<count($commentData); $j++){
				$comment_seq = $commentData[$j]['adv_comment_seq'];
				$commentData[$j]['write_time'] = $this->secToString($commentData[$j]['reg_date']);

				$commentData[$j]['comment_to_comment'] = array();
				if($comment_seq != 0){
					//대댓글
					$comment_to_comment = $this->content_model->getAdFeedCommentToComment($comment_seq);
					for($t=0; $t<count($comment_to_comment); $t++){
						$comment_to_comment[$t]['write_time'] = $this->secToString($comment_to_comment[$t]['reg_date']);
					}

					$commentData[$j]['comment_to_comment'] = $comment_to_comment;

				}
			}
			$adList[$i]['comment'] = $commentData;
			$adList[$i]['comment_total'] = $commentTotal;
			$adList[$i]['like_total'] = $likeTotal;
			$images = array();
			for($j=1; $j<=5; $j++){
				if(!empty($adList[$i]['adv_image'.$j])){
					array_push($images,$adList[$i]['adv_image'.$j]);
				}
			}
			$adList[$i]['images'] = $images;
			$adList[$i]['type'] = "ad";

			$adList[$i]['adv_content'] = nl2br($adList[$i]['adv_content']);

			//좋아요를 했는지 안했는지 체크
			$is_like = $this->content_model->getAdLikeFeed($user_id,$adList[$i]['adv_seq']);
			$is_like = $is_like>0?"Y":"N";

			$adList[$i]['is_like'] = $is_like;


			$is_me = "N";
			$adList[$i]['is_me'] = $is_me;

			$adList[$i]['write_time'] = $this->secToString($adList[$i]['reg_date']);


		}

		$returnArr = array(
			"adList"	=>	$adList,
			"total_page"	=>	$total_page,
			"num"	=>	$num
		);

		//광고넣기

		echo '{"result":"success","data":'.json_encode($returnArr).'}';
		exit;
	}

	public function feedReportProc()
	{
		$feed_seq = $this->input->post("feed_seq");
		$feed_report_category = $this->input->post("report_type");
		$feed_report_content = $this->input->post("report_text");

		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		$feedData = $this->content_model->getFeed($feed_seq);

		$data = array(
			"feed_seq"	=>	$feed_seq,
			"user_seq"	=>	$user_seq,
			"feed_challenge_seq"	=>	$feedData['challenge_seq'],
			"feed_challenge_title"	=>	$feedData['challenge_title'],
			"feed_report_category"	=>	$feed_report_category,
			"feed_report_content"	=>	$feed_report_content,
			"reg_date"	=>	date("Y-m-d H:i:s")
		);

		$reportData = $this->content_model->getFeedReport($feed_seq,$user_seq);

		if($reportData>0){
			echo '{"result":"failed"}';
			exit;
		}else{
			$this->content_model->insertFeedReport($data);
			echo '{"result":"success"}';
			exit;
		}
	}

	public function feedDeleteProc()
	{
		$feed_seq = $this->input->post("feed_seq");

		$this->content_model->deleteFeed($feed_seq);

		echo '{"result":"success"}';
		exit;
	}

	public function feedLikeAdd()
	{
		$feed_seq = $this->input->post("feed_seq");
		$userData = $this->CONFIG_DATA['userData'];

		$this->content_model->insertFeedLike($feed_seq,$userData);

		$feedUser = $this->content_model->getFeedUser($feed_seq);
		$to_id = $feedUser['user_id'];

		if($userData['user_id'] != $to_id){
			$data = array(
				"send_id"	=>	$userData['user_id'],
				"alarm_target"	=>	"user",
				"alarm_type"	=>	"like",
				"feed_seq"	=>	$feed_seq,
				"to_id"	=>	$to_id,
				"title"	=>	$userData['user_id']."님이 게시글에 좋아요를 보냈습니다",
				"link"	=>	"/feed/feedView/".$feed_seq
			);

			$this->addAlarm($data);
		}



		echo '{"result":"success"}';
		exit;
	}

	public function feedLikeDel()
	{
		$feed_seq = $this->input->post("feed_seq");
		$userData = $this->CONFIG_DATA['userData'];

		$feedUser = $this->content_model->getFeedUser($feed_seq);
		$to_id = $feedUser['user_id'];

		$this->content_model->deleteFeedLike($feed_seq,$userData);

		if($userData['user_id'] != $to_id){
			$data = array(
				"send_id"	=>	$userData['user_id'],
				"alarm_target"	=>	"user",
				"alarm_type"	=>	"like",
				"feed_seq"	=>	$feed_seq,
				"to_id"	=>	$to_id,
				"title"	=>	$userData['user_id']."님이 게시글에 좋아요를 보냈습니다",
				"link"	=>	"/feed/feedView/".$feed_seq
			);

			$this->removeAlarm($data);
		}

		echo '{"result":"success"}';
		exit;

		echo '{"result":"success"}';
		exit;
	}

	public function adLikeAdd()
	{
		$adv_seq = $this->input->post("adv_seq");
		$userData = $this->CONFIG_DATA['userData'];

		$this->content_model->insertAdLike($adv_seq,$userData);

		echo '{"result":"success"}';
		exit;
	}

	public function adLikeDel()
	{
		$adv_seq = $this->input->post("adv_seq");
		$userData = $this->CONFIG_DATA['userData'];

		$this->content_model->deleteAdLike($adv_seq,$userData);

		echo '{"result":"success"}';
		exit;
	}

	public function feedUploadProc()
	{
		$feed_parent_challenge_seq = $this->input->post("feed_parent_challenge_seq");
		$feed_challenge_seq = $this->input->post("feed_challenge_seq");
		$feed_content = $this->input->post("feed_content");
		$comment_yn = $this->input->post("comment_yn");
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];

		//등록일 구하기
		$day_diff_bool = $this->content_model->getDayDuplicate($feed_challenge_seq,$user_seq);
		if($day_diff_bool['bool'] == false){
			echo '{"result":"failed","limit":"'.$day_diff_bool['limit'].'"}';
			exit;
		}


		if(empty($comment_yn)){
			$comment_yn = 'Y';
		}
		$feed_challenge_title = $this->input->post("feed_challenge_title");
		$imageArr = $_FILES['image'];

		$photoArr = array();

		for($i=0; $i<count($imageArr['name']); $i++){
			$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/member/feed/";

			$file_name = $user_seq."_feed_".date("Ymdhis")."_".($i+1).".jpg";

			@unlink($upload_path.$file_name);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($imageArr["tmp_name"][$i],$upload_path.$file_name);

			$photoArr[$i] = $file_name;
		}
		$feed_photo = implode("|",$photoArr);

		$data = array(
			"feed_parent_challenge_seq"	=>	$feed_parent_challenge_seq,
			"feed_challenge_seq"	=>	$feed_challenge_seq,
			"feed_content"	=>	$feed_content,
			"feed_challenge_title"	=>	$feed_challenge_title,
			"comment_yn"	=>	$comment_yn,
			"user_seq"	=>	$user_seq,
			"feed_photo"	=>	$feed_photo,
			"status"	=>	"Y",
			"reg_date"	=>	date("Y-m-d H:i:s"),
		);

		//100kg계산
		$org_carbon = $this->content_model->getCarbonUserTotal($user_seq);

		$feed_seq = $this->content_model->insertFeed($data);

		if(!empty($this->CONFIG_DATA['userData']['school_seq'])){
			$alarmData = array(
	      "send_id" =>  $this->CONFIG_DATA['userData']['user_id'],
	      "alarm_target"  =>  'school_class',
	      "alarm_type"  =>  'feed',
	      "school_seq"  =>  $this->CONFIG_DATA['userData']['school_seq'],
	      "school_class_seq"  =>  $this->CONFIG_DATA['userData']['school_class_seq'],
	      "feed_seq"  =>  $feed_seq,
	      "title" =>  '같은 학급에서 새로운 피드를 등록했습니다',
	      "link"  =>  '/feed/feedView/'.$feed_seq,
	    );
			$this->addAlarm($alarmData);
		}


		$new_carbon = $this->content_model->getCarbonUserTotal($user_seq);

		$point_100_chk = floor($org_carbon/100) * 100;

		if($point_100_chk<floor($new_carbon/100)*100){

			$alarm_data = array(
				"send_id"	=>	$this->CONFIG_DATA['userData']['user_id'],
				"alarm_target"	=>	'user',
				"alarm_type"	=>	'carbon',
				"to_id"	=>	$this->CONFIG_DATA['userData']['user_id'],
				"title"	=>	"탄소절감 ".(floor($new_carbon/100)*100)."kg을 달성했어요!",
				"link"	=>	"/rank/achieve",
			);
			$this->addAlarm($alarm_data);
		}


		echo '{"result":"success"}';
		exit;
	}

	public function feedModifyProc()
	{
		$feed_seq = $this->input->post("feed_seq");
		$feed_parent_challenge_seq = $this->input->post("feed_parent_challenge_seq");
		$feed_challenge_seq = $this->input->post("feed_challenge_seq");
		$feed_content = $this->input->post("feed_content");
		$comment_yn = $this->input->post("comment_yn");
		$user_seq = $this->CONFIG_DATA['userData']['user_seq'];
		if(empty($comment_yn)){
			$comment_yn = 'Y';
		}
		$feed_challenge_title = $this->input->post("feed_challenge_title");
		$imageArr = $_FILES['image'];

		$photoArr = array();

		$feedData = $this->content_model->getFeed($feed_seq);
		$images = explode("|",$feedData['feed_photo']);

		$upload_path = $_SERVER['DOCUMENT_ROOT']."/upload/member/feed/";

		for($i=0; $i<count($images); $i++){
			@unlink($upload_path.$images[$i]);
		}


		for($i=0; $i<count($imageArr['name']); $i++){

			$file_name = $user_seq."_feed_".date("Ymdhis")."_".($i+1).".jpg";

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			move_uploaded_file($imageArr["tmp_name"][$i],$upload_path.$file_name);

			$photoArr[$i] = $file_name;
		}
		$feed_photo = implode("|",$photoArr);

		$data = array(
			"feed_parent_challenge_seq"	=>	$feed_parent_challenge_seq,
			"feed_challenge_seq"	=>	$feed_challenge_seq,
			"feed_content"	=>	$feed_content,
			"feed_challenge_title"	=>	$feed_challenge_title,
			"comment_yn"	=>	$comment_yn,
			"user_seq"	=>	$user_seq,
			"feed_photo"	=>	$feed_photo,
			"status"	=>	"Y",
			"update_time"	=>	date("Y-m-d H:i:s"),
		);

		$this->content_model->updateFeed($feed_seq,$data);

		echo '{"result":"success"}';
		exit;
	}

}
