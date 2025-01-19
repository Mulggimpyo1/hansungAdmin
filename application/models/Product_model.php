<?php
  class Product_Model extends CI_Model {
    function __construct(){
      parent::__construct();
    }

    //product list total
    public function getProductTotalCount($data="")
    {
      $where = "";
      if($data)
        $where = $data['where'];

      $query = "SELECT count(*) cnt FROM products WHERE 1=1 {$where} ";
      $rows = $this->db->query($query)->row_array();

      return $rows['cnt'];

    }

    //product list total
    public function getProductBrandTotalCount($data="")
    {
      $where = "";
      if($data)
        $where = $data['where'];

      $query = "SELECT count(*) cnt FROM products product inner join brands brand on product.brand_seq = brand.seq WHERE 1=1 {$where} ";
      $rows = $this->db->query($query)->row_array();

      return $rows['cnt'];

    }

    //product list total Layer popup
    public function getProductTotalPopupCount($data)
    {
      $where = "";
      if($data)
        $where = $data['where'];

      $query = "SELECT
                count(*) cnt
                FROM products as product
                LEFT JOIN brands as brand
                ON brand.seq = product.brand_seq
                LEFT JOIN categorys as category
                ON category.category_code = product.category_num
                WHERE 1=1 {$where}";

      $rows = $this->db->query($query)->row_array();

      return $rows['cnt'];
    }

    //product list
    public function getProductList($data)
    {
      $where = $data['where'];
      $limit = $data["limit"] == "" ? null : $data["limit"];
      $order = @$data["order"]?$data["order"]:" ORDER BY seq DESC ";

      $query = "SELECT
                product.seq,
                product.brand_seq,
                product.product_name,
                product.thumb_name,
                brand.brand_name,
                category.category_name_kor,
                product.kor_price,
                product.language,
                product.view_yn
                FROM products as product
                LEFT JOIN brands as brand
                ON brand.seq = product.brand_seq
                LEFT JOIN categorys as category
                ON category.category_code = product.category_num
                WHERE 1=1 {$where} {$order} {$limit}";

      $result = $this->db->query($query)->result_array();

      return $result;
    }

    //get product
    public function getProduct($seq)
    {
      $query = "SELECT product.*,brand.brand_name,category.category_name_kor,category.category_name_eng,category.category_name_chn,brand_designer,brand_designer_kor FROM products product
                LEFT JOIN categorys category
                ON category.category_code = product.category_num
                LEFT JOIN brands brand
                ON brand.seq = product.brand_seq
                WHERE product.seq = '{$seq}'";
      $result = $this->db->query($query)->row_array();

      return $result;
    }

    //get next product seq
    public function getNextSeq()
    {
      $query = "SELECT max(seq) max_num FROM products";
      $max_num = $this->db->query($query)->row_array();
      $max_num = $max_num['max_num'] += 1;

      return $max_num;
    }

    //insert product
    public function insertProduct($data)
    {
      $this->db->insert("products",$data);
      $result = $this->db->affected_rows();

      return $result;
    }

    //update product
    public function modifyProduct($data,$seq)
    {
      $this->db->where('seq',$seq);
      $this->db->update("products",$data);
      $result = $this->db->affected_rows();

      return $result;
    }

    //delete product
    public function deleteProduct($seq)
    {
      $query = "DELETE FROM products WHERE seq = '{$seq}'";
      $this->db->query($query);

      $result = $this->db->affected_rows();

      return $result;
    }

    //brand list
    public function getBrands($seq='')
    {
      if(empty($seq)){
        $query = "SELECT * FROM brands";
      }else{
        $query = "SELECT * FROM brands WHERE seq='{$seq}'";
      }

      $result = $this->db->query($query)->result_array();

      return $result;
    }

    //category list
    public function getCategorys()
    {
      $query = "SELECT * FROM categorys";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    //category 1Depth
    public function get1DepthCategory()
    {
      $query = "SELECT * FROM categorys WHERE CHAR_LENGTH(category_code) = 3 AND view_yn = 'Y' ORDER BY view_num ASC";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getProductBanner($char, $gender = "woman")
    {
      $lang = "";
      switch($char){
        case "en_US":
        $lang = "eng";
        break;

        case "ko_KOR":
        $lang = "kor";
        break;

        case "zh_CN":
        $lang = "chn";
        break;
      }

      $nowDate = date("Y-m-d H:i:s");

      $query = "SELECT * FROM product_main
                WHERE language = '{$lang}'
                AND b_start_date <= DATE('{$nowDate}')
                AND b_end_date >= DATE('{$nowDate}')
                AND category = '$gender'
                AND view_yn = 'Y'
                AND view_location = 'top' order by seq desc";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getList($where,$limit="")
    {
      $query = "SELECT product.*,brand.brand_name FROM products product
                LEFT JOIN categorys category
                ON category.category_code = product.category_num
                LEFT JOIN brands brand
                ON brand.seq = product.brand_seq
                WHERE 1=1 {$where}
                order by product.seq desc
                {$limit}

                ";
      $result = $this->db->query($query)->result_array();

      if( count($result) > 0 ){
        for( $i = 0; $i <  count($result); $i++ ){
          if(empty($result[$i]['thumb_name'])){
//            $result[$i]['thumb_name'] = "";
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }else{
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }

          $seq = $result[$i]['seq'];
          $user_id = $this->session->userdata('user_id');
          $query = "SELECT * FROM product_favorite WHERE product_seq = '{$seq}' AND user_id = '{$user_id}'";
          $favoritData = $this->db->query($query)->row_array();
          if(is_array($favoritData)){
            $result[$i]['favorit'] = "active";
          }else{
            $result[$i]['favorit'] = "";
          }

        }
      }

      return $result;
    }

    public function getSearchList($where,$limit="")
    {
      $query = "SELECT product.* FROM products product
                LEFT JOIN categorys category
                ON category.category_code = product.category_num
                LEFT JOIN brands brand
                ON brand.seq = product.brand_seq
                WHERE 1=1 {$where} order by product.seq desc {$limit}";
      $result = $this->db->query($query)->result_array();

      if( count($result) > 0 ){
        for( $i = 0; $i <  count($result); $i++ ){
          if(empty($result[$i]['thumb_name'])){
//            $result[$i]['thumb_name'] = "";
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }else{
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }

          $seq = $result[$i]['seq'];
          $user_id = $this->session->userdata('user_id');
          $query = "SELECT * FROM product_favorite WHERE product_seq = '{$seq}' AND user_id = '{$user_id}'";
          $favoritData = $this->db->query($query)->row_array();
          if(is_array($favoritData)){
            $result[$i]['favorit'] = "active";
          }else{
            $result[$i]['favorit'] = "";
          }

        }
      }

      return $result;
    }

    public function setFavorit($product)
    {
      $user_id = $this->session->userdata("user_id");
      $query = "SELECT * FROM product_favorite WHERE product_seq = '{$product}' AND user_id = '{$user_id}'";
      $result = $this->db->query($query)->row_array();

      if(is_array($result)){
        $seq = $result['seq'];
        $query = "DELETE FROM product_favorite WHERE seq = '{$seq}'";
        $this->db->query($query);

        $message = _("즐겨찾기가 해제 되었습니다.");
      }else{
        $query = "INSERT INTO product_favorite (product_seq,user_id) VALUES('{$product}','{$user_id}')";
        $this->db->query($query);

        $message = _("즐겨찾기가 추가 되었습니다.");
      }

      return $message;
    }


    public function getFavoriteList($data)
    {
      $where = $data['where'];

      $query = "SELECT product.*,brand.brand_name FROM products product
                LEFT JOIN categorys category
                ON category.category_code = product.category_num
                LEFT JOIN brands brand
                ON brand.seq = product.brand_seq
                INNER JOIN product_favorite pf
                on product.seq = pf.product_seq
                WHERE 1=1 {$where}";
      $result = $this->db->query($query)->result_array();

      if( count($result) > 0 ){
        for( $i = 0; $i <  count($result); $i++ ){
          if(empty($result[$i]['thumb_name'])){
//            $result[$i]['thumb_name'] = "";
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }else{
            $result[$i]['thumb_name'] = "<a href='/product/detail/".$result[$i]['seq']."'><img src='/upload/product/".$result[$i]['brand_seq']."/".$result[$i]['thumb_name']."' alt='' class='product_img' /></a>";
          }
        }
      }

      return $result;
    }

    public function getCart($where)
    {
      $query = "SELECT * FROM cart WHERE 1=1 {$where}";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function addCart($data)
    {
      $this->db->insert("cart",$data);
      $result = $this->db->insert_id();

      return $result;
    }

    public function deleteCart($seq)
    {
      $query = "DELETE FROM cart WHERE seq = '{$seq}'";
      $result = $this->db->query($query);
      $resultData = $this->db->affected_rows();

      return $resultData;
    }

    public function getAllCart($brand_seq)
    {
      $buyer_seq = $this->session->userdata('seq');
      $query = "SELECT cart.*,
                      product.thumb_name,
                      product.kor_price,
                      product.eng_price,
                      product.chn_price,
                      product.kor_size,
                      product.eng_size,
                      product.chn_size,
                      product.kor_color,
                      product.eng_color,
                      product.chn_color
                FROM cart cart
                LEFT JOIN products product
                ON product.seq = cart.product_seq
                WHERE cart.buyer_seq = '{$buyer_seq}' AND cart.brand_seq = '{$brand_seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getCartData($seq)
    {
      $query = "SELECT cart.*,
                      product.thumb_name,
                      product.kor_price,
                      product.eng_price,
                      product.chn_price,
                      product.kor_size,
                      product.eng_size,
                      product.chn_size,
                      product.kor_color,
                      product.eng_color,
                      product.chn_color
                FROM cart cart
                LEFT JOIN products product
                ON product.seq = cart.product_seq
                WHERE cart.seq = '{$seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function insertOrder($data)
    {
      $this->db->insert("orders",$data);
      $id = $this->db->insert_id();

      return $id;
    }

    public function insertRequest($data)
    {
      $this->db->insert("requests",$data);
      $id = $this->db->insert_id();

      return $id;
    }

    public function insertRequestItem($data)
    {
      $this->db->insert("requests_item",$data);
      $result = $this->db->affected_rows();

      return $result;
    }

    public function insertOrderItem($data)
    {
      $this->db->insert("orders_item",$data);
      $result = $this->db->affected_rows();

      return $result;
    }

    public function deleteCartData($seq)
    {
      $query = "DELETE FROM cart WHERE seq = '{$seq}'";
      $this->db->query($query);

      $result = $this->db->affected_rows();

      return $result;
    }

    public function getOrderTotalCount($buyer_seq)
  	{
  		$query = "SELECT count(*) cnt FROM orders
                WHERE buyer_seq = '{$buyer_seq}'";
      $return = $this->db->query($query)->row_array();

      $returnData = $return['cnt'];

      return $returnData;
  	}

    public function getOrderList($buyer_seq,$num,$page_size)
  	{
      /*
  		$query = "SELECT * FROM orders
                WHERE buyer_seq = '{$buyer_seq}'
                LIMIT {$num},{$page_size}";
      */
      $query = "SELECT orderA.*,item.brand_name FROM orders orderA
                INNER JOIN orders_item item
                ON item.order_seq = orderA.seq
                WHERE orderA.buyer_seq = '{$buyer_seq}' GROUP BY item.order_seq ORDER BY seq DESC LIMIT {$num},{$page_size}";
      $return = $this->db->query($query)->result_array();

      return $return;
  	}

    public function getOrder($order_seq)
    {
      $query = "SELECT * FROM orders WHERE seq = '{$order_seq}'";
      $result = $this->db->query($query)->row_array();

      return $result;
    }

    public function getOrderItem($order_seq)
    {
      $query = "SELECT * FROM orders_item WHERE order_seq = '{$order_seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getRequestList($buyer_seq,$num,$page_size)
  	{
      $query = "SELECT reqeustA.*,item.brand_name FROM requests reqeustA
                INNER JOIN requests_item item
                ON item.request_seq = reqeustA.seq
                WHERE reqeustA.buyer_seq = '{$buyer_seq}' GROUP BY item.request_seq ORDER BY seq DESC LIMIT {$num},{$page_size}";
      $return = $this->db->query($query)->result_array();

      return $return;
  	}

    public function getRequestItem($request_seq)
    {
      $query = "SELECT rq_item.*,product.eng_price price FROM requests_item rq_item
      LEFT JOIN products product
      ON product.seq = rq_item.product_seq
      WHERE request_seq = '{$request_seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getBrandOrderItem($order_seq)
    {
      $brand_seq = $this->session->userdata('brand_seq');
      $query = "SELECT * FROM orders_item WHERE order_seq = '{$order_seq}' AND brand_seq = '{$brand_seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function getOrderBrandItem($order_seq,$brand_seq)
    {
      $query = "SELECT order_item.*,
                        product.kor_price,
                        product.eng_price,
                        product.chn_price
                FROM orders_item order_item
                LEFT JOIN products product
                ON product.seq = order_item.product_seq
                WHERE order_item.order_seq = '{$order_seq}' AND order_item.brand_seq = '{$brand_seq}'";
      $result = $this->db->query($query)->result_array();

      return $result;
    }

    public function orderCancel($seq)
    {
      $query = "UPDATE orders SET order_state = 'ORDER_CANCEL' WHERE seq = '{$seq}'";
  		$this->db->query($query);
  		$result = $this->db->affected_rows();

      return $result;
    }

    public function getWeekProduct($searchData)
    {
      $lang = $searchData['lang'];
      $category = $searchData['category'];
      $query = "SELECT week_products FROM product_main WHERE view_location = 'week' and language='$lang' and category='$category'";
      $weekData = $this->db->query($query)->row_array();
      if(is_array($weekData)){
        $weekArr = explode("|",$weekData['week_products']);
        $weekStr = implode("','",$weekArr);

        $query = "SELECT * FROM products inner join brands on products.brand_seq = brands.seq WHERE products.seq in ('{$weekStr}') LIMIT 6";
        $result = $this->db->query($query)->result_array();

        for($i=0; $i<count($result); $i++){
          $seq = $result[$i]['seq'];
          $user_id = $this->session->userdata('user_id');
          $query = "SELECT * FROM product_favorite WHERE seq = '{$seq}' AND user_id = '{$user_id}'";
          $favoritData = $this->db->query($query)->row_array();

          if(is_array($favoritData)){
            $result[$i]['favorit'] = "active";
          }else{
            $result[$i]['favorit'] = "";
          }
        }


      }else{
        $result = "";
      }

      return $result;
    }

    public function getHotProduct($searchData)
    {
      $lang = $searchData['lang'];
      $category = $searchData['category'];
      $query = "SELECT hot_products FROM product_main WHERE view_location = 'hot' and language='$lang' and category='$category'";
      $hotData = $this->db->query($query)->row_array();
      if(is_array($hotData)){
        $hotArr = explode("|",$hotData['hot_products']);
        $hotStr = implode("','",$hotArr);

        $query = "SELECT * FROM products inner join brands on products.brand_seq = brands.seq  WHERE products.seq in ('{$hotStr}') LIMIT 6";
        $result = $this->db->query($query)->result_array();

        for($i=0; $i<count($result); $i++){
          $seq = $result[$i]['seq'];
          $user_id = $this->session->userdata('user_id');
          $query = "SELECT * FROM product_favorite WHERE seq = '{$seq}' AND user_id = '{$user_id}'";
          $favoritData = $this->db->query($query)->row_array();

          if(is_array($favoritData)){
            $result[$i]['favorit'] = "active";
          }else{
            $result[$i]['favorit'] = "";
          }
        }
      }else{
        $result = "";
      }

      return $result;
    }

    public function getNewProduct($searchData)
    {

      $lang = $searchData['lang'];
      $gender = $searchData['gender'];
      $category = $searchData['category'];

      $query = "SELECT b.*,a.*, b.seq as brand_seq FROM products a inner join brands b on a.brand_seq = b.seq WHERE a.view_yn='Y' ";
      if($gender) $query .= " AND a.gender='$gender'";
      if($category) $query .= " AND a.category_num in ($category)";
      $query.=" order by a.seq desc limit 0,6";
      $result = $this->db->query($query)->result_array();
        for($i=0; $i<count($result); $i++){
          $seq = $result[$i]['seq'];
          $user_id = $this->session->userdata('user_id');
          $query = "SELECT * FROM product_favorite WHERE seq = '{$seq}' AND user_id = '{$user_id}'";
          $favoritData = $this->db->query($query)->row_array();

          if(is_array($favoritData)){
            $result[$i]['favorit'] = "active";
          }else{
            $result[$i]['favorit'] = "";
          }
        }

      return $result;
    }

  }
?>
