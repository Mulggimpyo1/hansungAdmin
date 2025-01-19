<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoardAdm extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model("board_model");
		$this->load->model("member_model");
		$this->load->model("category_model");
		$uri = explode("/",uri_string());
		// login Check
    if( !$this->session->userdata("admin_id") ){
      if( $uri[count($uri)-1] != "login" && $uri[count($uri)-1] != "login_proc" ){
        $this->msg("로그인 해주시기 바랍니다.");
        $this->goURL(base_url("admin/login"));
        exit;
      }
		}


	}

	public function index()
	{
		//login page redirect
		$this->boardConfigList();
	}

	public function getWebNoticeTotalCount($where)
	{
		$sql = "SELECT count(*) cnt FROM tb_board_web_notice WHERE 1=1 $where";
		$result = $this->db->query($sql)->row_array();

		return $result['cnt'];
	}

    //courseList
    public function boardConfigList($type="")
    {
    	$depth1 = "boardAdm";
    	$depth2 = "boardConfigList";
    	$title = "게시판 관리";
    	$sub_title = "게시판 리스트";

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;

    	$num = $this->input->get('num');
    	$srcN = $this->input->get('srcN');
    	$srcType = $this->input->get('srcType');

    	$num = $num ?? 0;

    	$srcN = $srcN ?? "";

    	$srcType = $srcType ?? "";

    	$where = "";

    	$page_size = 10;
    	$page_list_size = 10;
    	$whereData = array(
    		"where"			=>	$where,
    	);
    	$list_total = $this->board_model->getBoardTotalCount($whereData);

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

    	$boardList = $this->board_model->getBoardList($whereData);

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
    	$boardList = $this->add_counting($boardList,$list_total,$num);

    	$paging = $this->make_paging2("/admin/boardAdm/boardConfigList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;

    	//customSetting
    	for($i = 0; $i < count($boardList); $i++)
    	{
    		$boardList[$i]['reg_time'] = date("Y-m-d",strtotime($boardList[$i]['reg_time']));
    	}

    	$content_data = array(
    		"depth1"		=>	$depth1,
    		"title"			=>	$title,
    		"sub_title"	=>	$sub_title,
    		"boardList"	=>	$boardList,
    		"paging"		=>	$paging,
    		"srcType"		=>	$srcType,
    		"srcN"			=>	$srcN
    	);

    	//header and css loads
    	$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

    	//menu
    	$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
    	//contents
    	$this->parser->parse("admin/board/board-config-list",$content_data);

    	//Footer
    	$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
    	//footer js files
    	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
    }

    //courseList
    public function boardConfigWrite($seq="")
    {
    	$depth1 = "boardAdm";
    	$depth2 = "boardConfigList";
    	$title = "게시판 관리";
    	$sub_title = "게시판 리스트";

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;

    	$num = $this->input->get('num');
    	$srcN = $this->input->get('srcN');
    	$srcType = $this->input->get('srcType');

    	$num = $num ?? 0;

    	$srcN = $srcN ?? "";

    	$srcType = $srcType ?? "";

    	$where = "";


    	$data = $this->board_model->getBoardConfig($seq);

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;



    	$content_data = array(
    		"depth1"		=>	$depth1,
    		"title"			=>	$title,
    		"sub_title"	=>	$sub_title,
    		"data"	=>	$data,
    		"srcType"		=>	$srcType,
    		"srcN"			=>	$srcN
    	);

    	//header and css loads
    	$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

    	//menu
    	$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
    	//contents
    	$this->parser->parse("admin/board/board-config-write",$content_data);

    	//Footer
    	$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
    	//footer js files
    	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
    }

    //courseList
    public function boardWrite($board_name="", $seq="")
    {
    	$depth1 = "boardAdm";
    	$depth2 = "boardConfigList";
    	$depth2 = $board_name;
    	$depth3 = $board_name;
    	$whereData = array(
    		"where"			=>	" AND board_name='$board_name'",
    	);
    	$configData = $this->board_model->getBoardConfigWhere($whereData);
    	$title = $configData['board_title']." 게시판 관리";
    	$sub_title = $configData['board_title']." 게시판 리스트";

    	$num = $this->input->get('num');
    	$srcN = $this->input->get('srcN');
    	$srcType = $this->input->get('srcType');

    	$num = $num ?? 0;

    	$srcN = $srcN ?? "";

    	$srcType = $srcType ?? "";

    	$where = "";

    	$whereData = array(
    	    "board_name"    =>  $board_name,
    		"seq"			=>	$seq,
    	);

    	$data = $this->board_model->getBoardStyleContents($whereData);

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;



    	$content_data = array(
    	    "base_url"		=>	$this->BASE_URL,
    	    "board_name"    => $board_name,
    		"depth1"		=>	$depth1,
    		"title"			=>	$title,
    		"sub_title"	=>	$sub_title,
    		"data"	=>	$data,
    		"srcType"		=>	$srcType,
    		"srcN"			=>	$srcN
    	);

    	//header and css loads
    	$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

    	//menu
    	$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
    	//contents
    	if($configData['board_skin'] == "comment")
    	    $this->parser->parse("admin/board/board-comment-write",$content_data);
    	else
    	    $this->parser->parse("admin/board/board-write",$content_data);

    	//Footer
    	$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
    	//footer js files
    	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
    }

	//설문내용 등록
	public function boardConfigProc()
	{
		$seq = $this->input->post("seq");
		$board_name = $this->input->post("board_name");
		$board_title = $this->input->post("board_title");
		$board_type = $board_skin = $this->input->post("board_skin");

		$board_category = $this->input->post("board_category");
		$board_read_level = $this->input->post("board_read_level");
		$board_delete_level = $this->input->post("board_delete_level");
		$board_write_level = $this->input->post("board_write_level");
		$board_reply_level = $this->input->post("board_reply_level");

		$board_course_yn = $this->input->post("board_course_yn");
		$board_state = $this->input->post("board_state");
		$sort_order = $this->input->post("sort_order");


		$admin_id = $this->input->post("admin_id");


		$reg_time = date("Y-m-d H:i:s");

		$data = array(
			"seq"	=>	$seq,
			"board_name"	=>	$board_name,
			"board_title"	=>	$board_title,
			"board_skin"	=>	$board_skin,
			"board_type"	=>	$board_type,
			"board_category"	=>	$board_category,
			"board_read_level"	=>	$board_read_level,

			"board_delete_level"	=>	$board_delete_level,
			"board_write_level"	=>	$board_write_level,
			"board_reply_level"	=>	$board_reply_level,
			"board_course_yn"	=>	$board_course_yn,
			"board_state"	=>	$board_state,
			"sort_order"	=>	$sort_order,

			"admin_id"	=>	$admin_id,
			"reg_time"	=>	$reg_time,
		);

        if($seq)
            $result = $this->board_model->updateBoardConfig($data);
        else
		    $result = $this->board_model->insertBoardConfig($data);

		$this->msg("정상적으로 등록되었습니다.");
		$this->goURL("/admin/boardAdm/boardConfigList");
		exit;
	}

	//설문내용 등록
	public function boardProc()
	{
	    $board_name = $this->input->post("board_name");
		$board_seq = $this->input->post("board_seq");
		$board_title = $this->input->post("board_title");
		$board_description = $this->input->post("board_description");
		$board_contents =  $this->input->post("board_contents");

		$file = $_FILES["file"]["name"];
		$file = empty($file) ? "" : $file;

		$board_view_yn = $this->input->post("board_view_yn");
		$board_display_yn = $this->input->post("board_display_yn");
		$board_writer_id = $this->input->post("board_writer_id");
		$board_writer_name = $this->input->post("board_writer_name");
		$board_reply = $this->input->post("board_reply");

		$board_reply_id = $this->input->post("board_reply_id");
		$board_reply_datetime = $this->input->post("board_reply_datetime");

		$rating = @$this->input->post("rating");

		$board_reg_datetime = date("Y-m-d H:i:s");
		$board_mod_datetime = date("Y-m-d H:i:s");

		$file_org = $this->input->post("file_org");

		if( !empty($file) ){
			$upload_path = $_SERVER['DOCUMENT_ROOT'].$this->BASE_URL."upload/board/";

			@unlink($upload_path.$file);

			if( !is_dir($upload_path) ){
				mkdir($upload_path,0777,true);
			}

			$file_name = $board_name."_".date("YmdHis")."_".$file;

			move_uploaded_file($_FILES["file"]["tmp_name"],$upload_path.$file_name);

			$file = $file_name;
		} else {
			$file = $file_org;
		}

		$data = array(
			"board_seq"	=>	$board_seq,
			"board_title"	=>	$board_title,
			"board_description"	=>	$board_description,
			"board_contents"	=>	$board_contents,
			"board_thumb"	=>	$file,
			"board_view_yn"	=>	$board_view_yn,
			"board_display_yn"	=>	$board_display_yn,

			"board_reply"	=>	$board_reply,
			"board_reply_id"	=>	$board_reply_id,
			"board_reply_datetime"	=>	$board_reply_datetime,
			"board_reg_datetime"	=>	$board_reg_datetime,
			"board_mod_datetime"	=>	$board_mod_datetime,
		);

    	$whereData = array(
    		"where"			=>	" AND board_name='$board_name'",
    	);
		$configData = $this->board_model->getBoardConfigWhere($whereData);
		if($configData['board_skin'] == "comment") {
		    $addData['rating'] = $rating;
		    $data = array_merge($data,$addData);
		}

        if($board_seq)
            $result = $this->board_model->updateBoard($data, $board_name);
        else
		    $result = $this->board_model->insertBoard($data, $board_name);

        echo '{"result":"success","msg":"정상적으로 등록되었습니다."}';
		//$this->msg("정상적으로 등록되었습니다.");
		//$this->goURL("/admin/boardAdm/boardList/".$board_name);
		exit;
	}

    //courseList
    public function boardList($board_name="")
    {
    	$depth1 = "boardAdm";
    	$depth2 = $board_name;
    	$depth3 = $board_name;
    	$whereData = array(
    		"where"			=>	" AND board_name='$board_name'",
    	);
    	$data = $this->board_model->getBoardConfigWhere($whereData);
    	$title = $data['board_title']." 게시판 관리";
    	$sub_title = $data['board_title']." 게시판 리스트";

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;

    	$num = $this->input->get('num');
    	$srcN = $this->input->get('srcN');
    	$srcType = $this->input->get('srcType');

    	$num = $num ?? 0;

    	$srcN = $srcN ?? "";

    	$srcType = $srcType ?? "";

    	$where = "";

    	$page_size = 10;
    	$page_list_size = 10;
    	$whereData = array(
    	    "board_name"    =>  $board_name,
    		"where"			=>	$where,
    	);
    	$list_total = $this->board_model->getBoardStyleTotalCount($whereData);

    	if( $list_total <= 0 )
    	{
    		$list_total = 0;
    	}

    	$total_page = ceil( $list_total / $page_size );

        $params = "";

    	$whereData = array(
    	    "board_name"    =>  $board_name,
    	    "sort"			=>	"",
    		"where"			=>	$where,
    		"limit"			=>	"LIMIT ".$num.",".$page_size
    	);

    	$boardList = $this->board_model->getBoardStyleList($whereData);

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
    	$boardList = $this->add_counting($boardList,$list_total,$num);

    	$paging = $this->make_paging2("/admin/boardAdm/boardConfigList",$start_page,$end_page,$page_size,$num,$srcN,$total_page,$params);

    	$this->CONFIG_DATA["depth1"] = $depth1;
    	$this->CONFIG_DATA["depth2"] = $depth2;

    	//customSetting
    	for($i = 0; $i < count($boardList); $i++)
    	{
    	    $boardList[$i]['board_name'] = $board_name;
    		$boardList[$i]['board_reg_datetime'] = date("Y-m-d",strtotime($boardList[$i]['board_reg_datetime']));
    	}

    	$content_data = array(
    	    "base_url"		=>	$this->BASE_URL,
    	    "board_name"    => $board_name,
    		"depth1"		=>	$depth1,
    		"title"			=>	$title,
    		"sub_title"	=>	$sub_title,
    		"boardList"	=>	$boardList,
    		"paging"		=>	$paging,
    		"srcType"		=>	$srcType,
    		"srcN"			=>	$srcN
    	);


    	//header and css loads
    	$this->parser->parse("admin/include/header",$this->CONFIG_DATA);

    	//menu
    	$this->parser->parse("admin/include/left",$this->CONFIG_DATA);
    	//contents
    	if($data['board_skin'] == "comment")
    	    $this->parser->parse("admin/board/board-comment-list",$content_data);
    	else if($data['board_skin'] == "gallery")
    	    $this->parser->parse("admin/board/board-gallery-list",$content_data);
    	else
    	    $this->parser->parse("admin/board/board-list",$content_data);

    	//Footer
    	$this->parser->parse("admin/include/footer",$this->CONFIG_DATA);
    	//footer js files
    	$this->parser->parse("admin/include/footer_js",$this->CONFIG_DATA);
    }

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
