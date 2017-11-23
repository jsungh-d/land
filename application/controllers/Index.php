<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Index
 *
 * @author dev_piljae
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->LAND = $this->load->database('LAND', TRUE);
        $this->load->model('Db_m');
        $this->load->library('session');
    }

    function _remap($method) {
        if ($this->uri->segment(2)) {
            if (!$this->session->userdata('ADMIN_IDX')) {
                $this->load->helper(array('alert'));
                alert('로그인 해주세요.', '/');
                exit;
            }

            $this->load->view('inc/header');

            if (method_exists($this, $method)) {
                $this->{"{$method}"}();
            }

            $this->load->view('inc/footer');
        } else {

            if (method_exists($this, $method)) {
                $this->{"{$method}"}();
            }
        }
    }

    function segment_explode($seg) {
        //세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
        $len = strlen($seg);
        if (substr($seg, 0, 1) == '/') {
            $seg = substr($seg, 1, $len);
        }

        $len = strlen($seg);
        if (substr($seg, -1) == '/') {
            $seg = substr($seg, 0, $len - 1);
        }

        $seg_exp = explode("/", $seg);
        return $seg_exp;
    }

    function url_explode($url, $key) {
        for ($i = 0; count($url) > $i; $i++) {
            if ($url[$i] == $key) {
                $k = $i + 1;
                return $url[$k];
            }
        }
    }

    function index() {
        $this->load->view('login');
    }

    function adminConfig() {

        if ($this->session->userdata('LEVEL') !== 'A') {
            $this->load->helper(array('alert'));
            alert('최고관리자만 접속 가능합니다.', '/index/main');
            exit;
        }

        $add_where = "";
        $data['gubun'] = "";
        $data['text'] = "";

        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 4;

        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환 
        $uri_array = $this->segment_explode($this->uri->uri_string());

        if (in_array('q', $uri_array)) {
            //주소에 검색어가 있을 경우의 처리. 즉 검색시 
            $gubun = urldecode($this->url_explode($uri_array, 'gubun'));
            $text = urldecode($this->url_explode($uri_array, 'text'));
            //페이지네이션용 주소 
            $page_url = '/q/gubun/' . $gubun . '/text/' . $text;
            $uri_segment = 9;

            if ($this->uri->segment(5) == 'title' && $this->uri->segment(7)) {
                $add_where .= "AND ID LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }

            if ($this->uri->segment(5) == 'contents' && $this->uri->segment(7)) {
                $add_where .= "AND NAME LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }
        }

        //페이지네이션 라이브러리 로딩 추가
        $this->load->library('pagination');

        //페이지네이션 설정 '.$page_url.'
        $config['base_url'] = '/index/adminConfig/' . $page_url . '/page/'; //페이징 주소
        //게시물의 전체 갯수
        $count_sql = "SELECT
                            COUNT(*) CNT
                          FROM
                            ADMIN
                          WHERE
                            ADMIN_IDX <> '' ";
        $count_sql .= $add_where;

        $count_res = $this->Db_m->getInfo($count_sql, 'LAND');

        $config['total_rows'] = $count_res->CNT;
        $data['total_rows'] = $count_res->CNT;

        $config['per_page'] = 15; //한 페이지에 표시할 게시물 수
        $config['uri_segment'] = $uri_segment; //페이지 번호가 위치한 세그먼트
        //$config['num_links'] = 2; //페이지 링크 갯수 설정
        $config['use_fixed_page'] = TRUE;
        $config['fixed_page_num'] = 10;

        $config['display_first_always'] = TRUE;
        $config['disable_first_link'] = TRUE;
        $config['display_last_always'] = TRUE;
        $config['disable_last_link'] = TRUE;
        $config['display_prev_always'] = TRUE;
        $config['display_next_always'] = TRUE;
        $config['disable_prev_link'] = TRUE;
        $config['disable_next_link'] = TRUE;

        //페이지네이션 전체 감싸는 태그추가
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        //항상나오는 처음으로 버튼 태그추가
        $config['disabled_first_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_first_tag_close'] = "</a></li>";

        //처음으로버튼 감싸는 태그추가
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        //항상나오는 마지막으로 버튼 태그추가
        $config['disabled_last_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_last_tag_close'] = "</a></li>";

        //마지막으로버튼 감싸는 태그추가
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        //항상나오는 다음버튼 감싸는 태그추가
        $config['disabled_next_tag_open'] = '<li class="page-item disabled"><a>';
        $config['disabled_next_tag_close'] = '</a></li>';

        //다음버튼 감싸는 태그추가
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        //항상나오는 이전버튼 태그추가
        $config['disabled_prev_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_prev_tag_close'] = "</a></li>";

        //이전버튼 감싸는 태그추가
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        //현재페이지번호 감싸는 태그추가
        $config['cur_tag_open'] = '<li class="page-item active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //페이지번호 감싸는 태그추가
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        //페이지네이션 초기화
        $this->pagination->initialize($config);

        //페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);

        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }

        $limit = $config['per_page'];

        $lists_sql = "SELECT
                          ADMIN_IDX,
                          ID,
                          NAME,
                          PHONE,
                          CASE 
                              LEVEL 
                              WHEN 'A' THEN '최고관리자' 
                              WHEN 'N' THEN '일반관리자'
                          END LEVEL,
                          DATE_FORMAT(TIMESTAMP, '%Y.%m.%d') INS_TIME,
                          IF(DATE_FORMAT(TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d'), 'Y', 'N') TODAY
                      FROM 
                          ADMIN
                      WHERE
                          ADMIN_IDX <> '' ";
        $lists_sql .= $add_where;
        $lists_sql .= "ORDER BY TIMESTAMP DESC LIMIT $start, $limit";

        $data['lists'] = $this->Db_m->getList($lists_sql, 'LAND');

        $this->load->view('admin/list', $data);
    }

    function typeConfig() {

        if ($this->session->userdata('LEVEL') !== 'A') {
            $this->load->helper(array('alert'));
            alert('최고관리자만 접속 가능합니다.', '/index/main');
            exit;
        }

        $add_where = "";
        $data['gubun'] = "";
        $data['text'] = "";

        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 4;

        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환 
        $uri_array = $this->segment_explode($this->uri->uri_string());

        if (in_array('q', $uri_array)) {
            //주소에 검색어가 있을 경우의 처리. 즉 검색시 
            $gubun = urldecode($this->url_explode($uri_array, 'gubun'));
            $text = urldecode($this->url_explode($uri_array, 'text'));
            //페이지네이션용 주소 
            $page_url = '/q/gubun/' . $gubun . '/text/' . $text;
            $uri_segment = 9;

            if ($this->uri->segment(5) == 'title' && $this->uri->segment(7)) {
                $add_where .= "AND ID LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }

            if ($this->uri->segment(5) == 'contents' && $this->uri->segment(7)) {
                $add_where .= "AND NAME LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }
        }

        //페이지네이션 라이브러리 로딩 추가
        $this->load->library('pagination');

        //페이지네이션 설정 '.$page_url.'
        $config['base_url'] = '/index/typeConfig/' . $page_url . '/page/'; //페이징 주소
        //게시물의 전체 갯수
        $count_sql = "SELECT
                        COUNT(*) CNT
                      FROM
                        TYPE
                      WHERE
                        TYPE_IDX <> '' ";
        $count_sql .= $add_where;

        $count_res = $this->Db_m->getInfo($count_sql, 'LAND');

        $config['total_rows'] = $count_res->CNT;
        $data['total_rows'] = $count_res->CNT;

        $config['per_page'] = 15; //한 페이지에 표시할 게시물 수
        $config['uri_segment'] = $uri_segment; //페이지 번호가 위치한 세그먼트
        //$config['num_links'] = 2; //페이지 링크 갯수 설정
        $config['use_fixed_page'] = TRUE;
        $config['fixed_page_num'] = 10;

        $config['display_first_always'] = TRUE;
        $config['disable_first_link'] = TRUE;
        $config['display_last_always'] = TRUE;
        $config['disable_last_link'] = TRUE;
        $config['display_prev_always'] = TRUE;
        $config['display_next_always'] = TRUE;
        $config['disable_prev_link'] = TRUE;
        $config['disable_next_link'] = TRUE;

        //페이지네이션 전체 감싸는 태그추가
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        //항상나오는 처음으로 버튼 태그추가
        $config['disabled_first_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_first_tag_close'] = "</a></li>";

        //처음으로버튼 감싸는 태그추가
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        //항상나오는 마지막으로 버튼 태그추가
        $config['disabled_last_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_last_tag_close'] = "</a></li>";

        //마지막으로버튼 감싸는 태그추가
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        //항상나오는 다음버튼 감싸는 태그추가
        $config['disabled_next_tag_open'] = '<li class="page-item disabled"><a>';
        $config['disabled_next_tag_close'] = '</a></li>';

        //다음버튼 감싸는 태그추가
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        //항상나오는 이전버튼 태그추가
        $config['disabled_prev_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_prev_tag_close'] = "</a></li>";

        //이전버튼 감싸는 태그추가
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        //현재페이지번호 감싸는 태그추가
        $config['cur_tag_open'] = '<li class="page-item active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //페이지번호 감싸는 태그추가
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        //페이지네이션 초기화
        $this->pagination->initialize($config);

        //페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);

        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }

        $limit = $config['per_page'];

        $lists_sql = "SELECT
                          TYPE_IDX,
                          CASE 
                              LAND_KIND 
                              WHEN 'H' THEN '주택/다가구' 
                              WHEN 'V' THEN '빌라'
                              WHEN 'R' THEN '원룸/도시형'
                              WHEN 'O' THEN '오피스텔'
                              WHEN 'S' THEN '상가점포'
                              WHEN 'B' THEN '상가건물(매)'
                              WHEN 'P' THEN '분양권'
                              WHEN 'D' THEN '재개발'
                              WHEN 'F' THEN '공장/창고'
                              WHEN 'L' THEN '토지'
                          END LAND_KIND,
                          NAME,
                          CASE 
                            USE_YN
                            WHEN 'Y' THEN '사용'
                            WHEN 'N' THEN '미사용'
                          END USE_YN,
                          DATE_FORMAT(TIMESTAMP, '%Y.%m.%d') INS_TIME,
                          IF(DATE_FORMAT(TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d'), 'Y', 'N') TODAY
                      FROM 
                          TYPE
                      WHERE
                          TYPE_IDX <> '' ";
        $lists_sql .= $add_where;
        $lists_sql .= "ORDER BY LAND_KIND ASC, TIMESTAMP ASC LIMIT $start, $limit";

        $data['lists'] = $this->Db_m->getList($lists_sql, 'LAND');

        $this->load->view('type/list', $data);
    }

    function optionConfig() {

        if ($this->session->userdata('LEVEL') !== 'A') {
            $this->load->helper(array('alert'));
            alert('최고관리자만 접속 가능합니다.', '/index/main');
            exit;
        }

        $add_where = "";
        $data['gubun'] = "";
        $data['text'] = "";

        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 4;

        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환 
        $uri_array = $this->segment_explode($this->uri->uri_string());

        if (in_array('q', $uri_array)) {
            //주소에 검색어가 있을 경우의 처리. 즉 검색시 
            $gubun = urldecode($this->url_explode($uri_array, 'gubun'));
            $text = urldecode($this->url_explode($uri_array, 'text'));
            //페이지네이션용 주소 
            $page_url = '/q/gubun/' . $gubun . '/text/' . $text;
            $uri_segment = 9;

            if ($this->uri->segment(5) == 'title' && $this->uri->segment(7)) {
                $add_where .= "AND ID LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }

            if ($this->uri->segment(5) == 'contents' && $this->uri->segment(7)) {
                $add_where .= "AND NAME LIKE '%" . urldecode($this->uri->segment(7)) . "%'";
                $data['gubun'] = $this->uri->segment(5);
                $data['text'] = urldecode($this->uri->segment(7));
            }
        }

        //페이지네이션 라이브러리 로딩 추가
        $this->load->library('pagination');

        //페이지네이션 설정 '.$page_url.'
        $config['base_url'] = '/index/optionConfig/' . $page_url . '/page/'; //페이징 주소
        //게시물의 전체 갯수
        $count_sql = "SELECT
                        COUNT(*) CNT
                      FROM
                        `OPTION`
                      WHERE
                        OPTION_IDX <> '' ";
        $count_sql .= $add_where;

        $count_res = $this->Db_m->getInfo($count_sql, 'LAND');

        $config['total_rows'] = $count_res->CNT;
        $data['total_rows'] = $count_res->CNT;

        $config['per_page'] = 15; //한 페이지에 표시할 게시물 수
        $config['uri_segment'] = $uri_segment; //페이지 번호가 위치한 세그먼트
        //$config['num_links'] = 2; //페이지 링크 갯수 설정
        $config['use_fixed_page'] = TRUE;
        $config['fixed_page_num'] = 10;

        $config['display_first_always'] = TRUE;
        $config['disable_first_link'] = TRUE;
        $config['display_last_always'] = TRUE;
        $config['disable_last_link'] = TRUE;
        $config['display_prev_always'] = TRUE;
        $config['display_next_always'] = TRUE;
        $config['disable_prev_link'] = TRUE;
        $config['disable_next_link'] = TRUE;

        //페이지네이션 전체 감싸는 태그추가
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        //항상나오는 처음으로 버튼 태그추가
        $config['disabled_first_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_first_tag_close'] = "</a></li>";

        //처음으로버튼 감싸는 태그추가
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        //항상나오는 마지막으로 버튼 태그추가
        $config['disabled_last_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_last_tag_close'] = "</a></li>";

        //마지막으로버튼 감싸는 태그추가
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        //항상나오는 다음버튼 감싸는 태그추가
        $config['disabled_next_tag_open'] = '<li class="page-item disabled"><a>';
        $config['disabled_next_tag_close'] = '</a></li>';

        //다음버튼 감싸는 태그추가
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        //항상나오는 이전버튼 태그추가
        $config['disabled_prev_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_prev_tag_close'] = "</a></li>";

        //이전버튼 감싸는 태그추가
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        //현재페이지번호 감싸는 태그추가
        $config['cur_tag_open'] = '<li class="page-item active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //페이지번호 감싸는 태그추가
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        //페이지네이션 초기화
        $this->pagination->initialize($config);

        //페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);

        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }

        $limit = $config['per_page'];

        $lists_sql = "SELECT
                          OPTION_IDX,
                          NAME,
                          CASE 
                            USE_YN
                            WHEN 'Y' THEN '사용'
                            WHEN 'N' THEN '미사용'
                          END USE_YN,
                          DATE_FORMAT(TIMESTAMP, '%Y.%m.%d') INS_TIME,
                          IF(DATE_FORMAT(TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d'), 'Y', 'N') TODAY
                      FROM 
                          `OPTION`
                      WHERE
                          OPTION_IDX <> '' ";
        $lists_sql .= $add_where;
        $lists_sql .= "ORDER BY TIMESTAMP DESC LIMIT $start, $limit";

        $data['lists'] = $this->Db_m->getList($lists_sql, 'LAND');

        $this->load->view('option/list', $data);
    }

    function main() {

        $gu_sql = "SELECT 
                        SUBSTRING_INDEX(SUBSTRING_INDEX(ADDR, ' ', 2), ' ', -1) ADDR
                   FROM 
                        LAND
                   GROUP BY SUBSTRING_INDEX(SUBSTRING_INDEX(ADDR, ' ', 2), ' ', -1)";

        $data['gu_lists'] = $this->Db_m->getList($gu_sql, 'LAND');

        $add_where = "";
        $add_having = "";
        if ($this->session->userdata('LEVEL') !== 'A') {
//            $add_where = "AND L.ADMIN_IDX = '" . $this->session->userdata('ADMIN_IDX') . "' ";
        }
        $data['search_kind'] = "";
        $data['search_land_type'] = "";
        $data['search_gu'] = "";
        $data['text'] = "";
        $data['tot_text'] = "";

        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 4;

        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환 
        $uri_array = $this->segment_explode($this->uri->uri_string());

        if (in_array('q', $uri_array)) {
            //주소에 검색어가 있을 경우의 처리. 즉 검색시 
            $type = urldecode($this->url_explode($uri_array, 'type'));
            $search_kind = urldecode($this->url_explode($uri_array, 'search_kind'));
            $search_land_type = urldecode($this->url_explode($uri_array, 'search_land_type'));
            $text = urldecode($this->url_explode($uri_array, 'text'));
            $search_gu = urldecode($this->url_explode($uri_array, 'search_gu'));
            //페이지네이션용 주소 
            $page_url = '/q/type/' . $type . '/search_kind/' . $search_kind . '/search_land_type/' . $search_land_type . '/text/' . $text . '/search_gu/' . $search_gu;
            $uri_segment = 15;

            if ($type === 'location') {
                if ($search_kind !== 'ALL') {
                    $add_where .= "AND L.KIND = '" . $search_kind . "' ";
                    $data['search_kind'] = $search_kind;
                }

                if ($search_land_type !== 'ALL') {
                    $add_where .= "AND L.LAND_TYPE = '" . $search_land_type . "' ";
                    $data['search_land_type'] = $search_land_type;
                }

                if ($text !== 'none' && $search_gu !== 'ALL') {
//                $add_where .= "AND MATCH(L.ADDR) AGAINST('" . $text . "' IN BOOLEAN MODE) ";
                    $add_where .= "AND L.ADDR LIKE '%" . $search_gu . " " . $text . "%' ";
                    $data['text'] = urldecode($text);
                    $data['search_gu'] = $search_gu;
                } else if ($text !== 'none' && $search_gu === 'ALL') {
                    $add_where .= "AND L.ADDR LIKE '%" . $text . "%' ";
                    $data['text'] = urldecode($text);
                } else if ($text === 'none' && $search_gu !== 'ALL') {
                    $add_where .= "AND L.ADDR LIKE '%" . $search_gu . "%' ";
                    $data['search_gu'] = $search_gu;
                }
            } else if ($type === 'total') {
                if ($text !== 'none') {
                    $add_having .= "HAVING 
                                        INS_TIME LIKE '%" . $text . "%' OR
                                        MOD_TIME LIKE '%" . $text . "%' OR
                                        KIND LIKE '%" . $text . "%' OR
                                        TYPE_NAME LIKE '%" . $text . "%' OR
                                        LAND_TYPE LIKE '%" . $text . "%' OR
                                        ADDR LIKE '%" . $text . "%' OR
                                        LAND_NAME LIKE '%" . $text . "%' OR
                                        PHONE LIKE '%" . $text . "%' OR
                                        DONG LIKE '%" . $text . "%' OR
                                        FLOOR LIKE '%" . $text . "%' OR
                                        ROOM_NUMBER LIKE '%" . $text . "%' OR
                                        RENTAL_PRICE LIKE '%" . $text . "%' OR
                                        RENTAL_SQUARE LIKE '%" . $text . "%' OR
                                        DEPOSIT LIKE '%" . $text . "%' OR
                                        MONTHLY LIKE '%" . $text . "%' OR
                                        ADMINISTRATIVE_EXPENSES LIKE '%" . $text . "%' ";
                    $data['tot_text'] = urldecode($text);
                }
            }
        }

        //페이지네이션 라이브러리 로딩 추가
        $this->load->library('pagination');

        //페이지네이션 설정 '.$page_url.'
        $config['base_url'] = '/index/main/' . $page_url . '/page/'; //페이징 주소
        //게시물의 전체 갯수
        $count_sql = "SELECT
                          DATE_FORMAT(L.TIMESTAMP, '%y.%m.%d') INS_TIME,
                          IF(L.CHECK_DATE, DATE_FORMAT(L.CHECK_DATE, '%y.%m.%d'), '') MOD_TIME,
                          CASE 
                              L.KIND 
                              WHEN 'A' THEN '아파트'
                              WHEN 'H' THEN '주택/다가구' 
                              WHEN 'V' THEN '빌라'
                              WHEN 'R' THEN '원룸/도시형'
                              WHEN 'O' THEN '오피스텔'
                              WHEN 'W' THEN '사무실'
                              WHEN 'S' THEN '상가점포'
                              WHEN 'B' THEN '상가건물(매)'
                              WHEN 'P' THEN '분양권'
                              WHEN 'D' THEN '재개발'
                              WHEN 'F' THEN '공장/창고'
                              WHEN 'L' THEN '토지'
                          END KIND,
                          T.NAME TYPE_NAME,
                          CASE
                            L.LAND_TYPE
                            WHEN '1' THEN '매매'
                            WHEN '2' THEN '전세'
                            WHEN '3' THEN '월세'
                            WHEN '4' THEN '단기'
                            WHEN '5' THEN '전월세'
                          END LAND_TYPE,
                          L.ADDR,
                          L.NAME LAND_NAME,
                          (
                            SELECT 
                                CONCAT(LP.NAME, ' ', LP.PHONE) 
                            FROM 
                                LAND_PHONE LP 
                            WHERE 
                                LP.LAND_IDX = L.LAND_IDX AND
                                LP.PHONE <> ''
                                ORDER BY LP.LAND_PHONE_IDX ASC LIMIT 0, 1
                          ) PHONE,
                          L.DONG,
                          L.FLOOR,
                          L.ROOM_NUMBER,
                          L.RENTAL_PRICE,
                          L.RENTAL_SQUARE,
                          L.DEPOSIT,
                          L.MONTHLY,
                          L.ADMINISTRATIVE_EXPENSES
                      FROM
                        LAND L LEFT JOIN TYPE T ON L.TYPE_IDX = T.TYPE_IDX, ADMIN A
                      WHERE
                        L.ADMIN_IDX = A.ADMIN_IDX ";
        $count_sql .= $add_where;
        $count_sql .= "GROUP BY L.LAND_IDX ";
        $count_sql .= $add_having;

        $count_res = $this->Db_m->getList($count_sql, 'LAND');

        $config['total_rows'] = count($count_res);
        $data['total_rows'] = count($count_res);

        $config['per_page'] = 15; //한 페이지에 표시할 게시물 수
        $config['uri_segment'] = $uri_segment; //페이지 번호가 위치한 세그먼트
        //$config['num_links'] = 2; //페이지 링크 갯수 설정
        $config['use_fixed_page'] = TRUE;
        $config['fixed_page_num'] = 10;

        $config['display_first_always'] = TRUE;
        $config['disable_first_link'] = TRUE;
        $config['display_last_always'] = TRUE;
        $config['disable_last_link'] = TRUE;
        $config['display_prev_always'] = TRUE;
        $config['display_next_always'] = TRUE;
        $config['disable_prev_link'] = TRUE;
        $config['disable_next_link'] = TRUE;

        //페이지네이션 전체 감싸는 태그추가
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        //항상나오는 처음으로 버튼 태그추가
        $config['disabled_first_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_first_tag_close'] = "</a></li>";

        //처음으로버튼 감싸는 태그추가
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        //항상나오는 마지막으로 버튼 태그추가
        $config['disabled_last_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_last_tag_close'] = "</a></li>";

        //마지막으로버튼 감싸는 태그추가
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        //항상나오는 다음버튼 감싸는 태그추가
        $config['disabled_next_tag_open'] = '<li class="page-item disabled"><a>';
        $config['disabled_next_tag_close'] = '</a></li>';

        //다음버튼 감싸는 태그추가
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        //항상나오는 이전버튼 태그추가
        $config['disabled_prev_tag_open'] = "<li class='page-item disabled'><a>";
        $config['disabled_prev_tag_close'] = "</a></li>";

        //이전버튼 감싸는 태그추가
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        //현재페이지번호 감싸는 태그추가
        $config['cur_tag_open'] = '<li class="page-item active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //페이지번호 감싸는 태그추가
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        //페이지네이션 초기화
        $this->pagination->initialize($config);

        //페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();

        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);

        if ($page > 1) {
            $start = (($page / $config['per_page'])) * $config['per_page'];
        } else {
            $start = ($page - 1) * $config['per_page'];
        }

        $limit = $config['per_page'];

        $lists_sql = "SELECT
                          L.LAND_IDX,
                          DATE_FORMAT(L.TIMESTAMP, '%y.%m.%d') INS_TIME,
                          IF(L.CHECK_DATE, DATE_FORMAT(L.CHECK_DATE, '%y.%m.%d'), '') MOD_TIME,
                          CASE 
                              L.KIND 
                              WHEN 'A' THEN '아파트'
                              WHEN 'H' THEN '주택/다가구' 
                              WHEN 'V' THEN '빌라'
                              WHEN 'R' THEN '원룸/도시형'
                              WHEN 'O' THEN '오피스텔'
                              WHEN 'W' THEN '사무실'
                              WHEN 'S' THEN '상가점포'
                              WHEN 'B' THEN '상가건물(매)'
                              WHEN 'P' THEN '분양권'
                              WHEN 'D' THEN '재개발'
                              WHEN 'F' THEN '공장/창고'
                              WHEN 'L' THEN '토지'
                          END KIND,
                          T.NAME TYPE_NAME,
                          CASE
                            L.LAND_TYPE
                            WHEN '1' THEN '매매'
                            WHEN '2' THEN '전세'
                            WHEN '3' THEN '월세'
                            WHEN '4' THEN '단기'
                          END LAND_TYPE,
                          L.ADDR,
                          L.NAME LAND_NAME,
                          (
                            SELECT 
                                LOCATION
                            FROM 
                                LAND_IMG LI
                            WHERE
                                LI.LAND_IDX = L.LAND_IDX
                            ORDER BY LI.LAND_IMG_IDX ASC LIMIT 0, 1
                          ) IMG,
                          (
                            SELECT 
                                CONCAT(LP.NAME, ' ', LP.PHONE) 
                            FROM 
                                LAND_PHONE LP 
                            WHERE 
                                LP.LAND_IDX = L.LAND_IDX AND
                                LP.PHONE <> ''
                                ORDER BY LP.LAND_PHONE_IDX ASC LIMIT 0, 1
                          ) PHONE,
                          L.DONG,
                          L.FLOOR,
                          L.ROOM_NUMBER,
                          L.RENTAL_PRICE,
                          L.RENTAL_SQUARE,
                          L.DEPOSIT,
                          L.MONTHLY,
                          L.ADMINISTRATIVE_EXPENSES,
                          IF(DATE_FORMAT(L.TIMESTAMP, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d'), 'Y', 'N') TODAY
                      FROM 
                        LAND L 
                        LEFT JOIN 
                            TYPE T 
                        ON L.TYPE_IDX = T.TYPE_IDX,
                        ADMIN A
                      WHERE
                        L.ADMIN_IDX = A.ADMIN_IDX ";
        $lists_sql .= $add_where;
        $lists_sql .= "GROUP BY L.LAND_IDX ";
        $lists_sql .= $add_having;
        $lists_sql .= "ORDER BY L.LAND_IDX DESC, L.TIMESTAMP DESC LIMIT $start, $limit";

//        echo $lists_sql;

        $data['lists'] = $this->Db_m->getList($lists_sql, 'LAND');

        $this->load->view('land/list', $data);
    }

    function main2() {
        $this->load->view('land/list2');
    }

}
