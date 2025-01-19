<?php
  class Order_Model extends CI_Model {
    function __construct(){
      parent::__construct();
    }

    public function getOrderChk($user_id,$class_code,$course_code)
    {
      $sql = "SELECT * FROM tb_course_order WHERE user_id = '{$user_id}' AND class_code = '{$class_code}' AND course_code = '{$course_code}'";
      $query = $this->db->query($sql)->row_array();

      return $query;
    }

    /*
    @param array $data
    @return int
    */
    public function insertCourseOrder($data)
    {
      $this->db->insert("tb_course_order",$data);
      $return = $this->db->insert_id();

      return $return;
    }

    /*
    @param array $data
    @return int
    */
    public function insertStudyClass($data)
    {
      $this->db->insert("tb_study_class",$data);
      $return = $this->db->insert_id();

      return $return;
    }

    /*
    @param array $data
    @return int
    */
    public function insertStudyCount($data)
    {
      $company_seq = $data['company_seq'];
      $company_name = $data['company_name'];
      $class_code = $data['class_code'];
      $course_code = $data['course_code'];
      $course_name = $data['course_name'];

      //있는지 여부 있으면 업데이트 없으면 인서트
      $sql = "SELECT * FROM tb_study_count WHERE company_seq = '{$company_seq}' AND class_code = '{$class_code}' AND course_code = '{$course_code}'";
      $studyCountData = $this->db->query($sql)->row_array();
      if( is_array($studyCountData) ){
        $course_register_cnt = $studyCountData['course_register_cnt'] + 1;
        $seq = $studyCountData['seq'];
        $sql = "UPDATE tb_study_count SET course_register_cnt = '{$course_register_cnt}' WHERE seq = '{$seq}'";
        $query = $this->db->query($sql);
        $return = $this->db->affected_rows();
      }else{
        //총 멤버수 확인
        $sql = "SELECT count(*) cnt FROM tb_user WHERE company_seq = '{$company_seq}' AND user_level = 10";
        $query = $this->db->query($sql)->row_array();
        $member_cnt = $query['cnt'];

        //인서트
        $sql = "INSERT INTO tb_study_count (company_seq,company_name,class_code,course_code,course_name,member_cnt,course_register_cnt)
                VALUES ('{$company_seq}','{$company_name}','{$class_code}','{$course_code}','{$course_name}','{$member_cnt}',1)";
        $query = $this->db->query($sql);
        $return = $this->db->affected_rows();
      }

      return $return;
    }

    /*
    @param string $course_code, $class_code, $company_seq
    @return array
    */
    public function getCourseUserList($course_code,$class_code,$company_seq)
    {
      $sql = "SELECT users.user_id,
                    users.user_name,
                    orders.company_name,
                    users.cell,
                    users.dept,
                    study_class.class,
                    course_user.total_class,
                    course_user.clear_class,
                    course_user.last_score,
                    course_user.report_yn,
                    course_user.step_score,
                    course_user.pass_yn,
                    (SELECT count(*) FROM tb_exam_history WHERE user_id = orders.user_id AND class_code = orders.class_code AND exam_type = 'STEP') step_yn,
                    (SELECT count(*) FROM tb_exam_history WHERE user_id = orders.user_id AND class_code = orders.class_code AND exam_type = 'LAST') last_yn
                     FROM tb_course_order orders
              INNER JOIN tb_user users
              ON users.user_id = orders.user_id
              INNER JOIN tb_study_class study_class
              ON study_class.user_id = orders.user_id
              LEFT JOIN tb_course_user course_user
              ON course_user.user_id = orders.user_id AND course_user.class_code = orders.class_code AND course_user.course_code = orders.course_code
              WHERE orders.course_code = '{$course_code}' AND orders.class_code = '{$class_code}' AND orders.company_seq = '{$company_seq}'";
      $query = $this->db->query($sql)->result_array();

      return $query;

    }

  }
?>
