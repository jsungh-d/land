<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataFunction
 *
 * @author dev_piljae
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class DataFunction extends CI_Controller {

    //put your code here
    function __construct() {
        parent::__construct();

        $this->LAND = $this->load->database('LAND', TRUE);
        $this->load->model('Db_m');
        $this->load->library('session');
    }

    function adminIdCheck() {

        //sql 인젝션 방지
        $id = $this->LAND->escape($this->input->get('id', TRUE));

        $sql = "SELECT
                    COUNT(*) CNT 
                FROM 
                    ADMIN 
                WHERE 
                    ID = $id";

        $this->LAND->trans_start(); // Query will be rolled back

        $res = $this->Db_m->getInfo($sql, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'false';
        } else {
            if ($res->CNT == 0) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
    }

    function insAdmin() {
        $insArray = array(
            'ID' => $this->input->post('id', TRUE),
            'PWD' => password_hash($this->input->post('pwd', true), PASSWORD_DEFAULT),
            'NAME' => $this->input->post('name', true),
            'PHONE' => $this->input->post('phone', true),
            'LEVEL' => $this->input->post('level', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->insData('ADMIN', $insArray, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function modAdmin() {

        $updateWhere = array(
            'ID' => $this->input->post('id', TRUE)
        );

        if ($this->input->post('pwd', true)) {
            $updateArray = array(
                'PWD' => password_hash($this->input->post('pwd', true), PASSWORD_DEFAULT),
                'NAME' => $this->input->post('name', true),
                'PHONE' => $this->input->post('phone', true),
                'LEVEL' => $this->input->post('level', true)
            );
        } else {
            $updateArray = array(
                'NAME' => $this->input->post('name', true),
                'PHONE' => $this->input->post('phone', true),
                'LEVEL' => $this->input->post('level', true)
            );
        }

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->update('ADMIN', $updateArray, $updateWhere, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function delAdmin() {
        $delWhere = array(
            'ID' => $this->input->post('id', TRUE)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->delete('ADMIN', $delWhere, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function adminLogin() {

        $this->load->helper(array('alert'));

        //sql 인젝션 방지
        $id = $this->LAND->escape($this->input->post('adminId', TRUE));
        $pwd = $this->input->post('adminPw', TRUE);

        $sql = "SELECT
                    ADMIN_IDX,
                    PWD,
                    LEVEL
                FROM 
                    ADMIN 
                WHERE 
                    ID = $id";

        $this->LAND->trans_start(); // Query will be rolled back

        $res = $this->Db_m->getInfo($sql, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            alert("데이터 처리오류!!", '/');
        } else {
            if ($res && password_verify($pwd, $res->PWD)) {
                //세션 생성
                $newdata = array(
                    'ADMIN_IDX' => $res->ADMIN_IDX,
                    'LEVEL' => $res->LEVEL
                );
                $this->session->set_userdata($newdata);
                alert('로그인 되었습니다.', '/index/main');
            } else {
                alert("일치하는 정보가 없습니다.", '/');
            }
        }
    }

    function getAdminInfo() {

        //sql 인젝션 방지
        $id = $this->LAND->escape($this->input->post('id', TRUE));

        $sql = "SELECT
                    NAME, 
                    PHONE, 
                    LEVEL 
                FROM 
                    ADMIN 
                WHERE 
                    ID = $id";

        $this->LAND->trans_start(); // Query will be rolled back

        $res = $this->Db_m->getInfo($sql, 'LAND');

        $data = array();

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            $data = array(
                'RESULT' => 'FAILED'
            );
        } else {
            if ($res) {
                $data = array(
                    'RESULT' => 'SUCCESS',
                    'NAME' => $res->NAME,
                    'PHONE' => $res->PHONE,
                    'LEVEL' => $res->LEVEL
                );
            } else {
                $data = array(
                    'RESULT' => 'FAILED'
                );
            }
        }

        print_r(json_encode($data));
    }

    function insType() {
        $insArray = array(
            'LAND_KIND' => $this->input->post('kind', true),
            'NAME' => $this->input->post('name', true),
            'USE_YN' => $this->input->post('use_yn', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->insData('TYPE', $insArray, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function getTypeInfo() {
        $sql = "SELECT
                    TYPE_IDX, 
                    LAND_KIND, 
                    NAME,
                    USE_YN
                FROM 
                    TYPE 
                WHERE 
                    TYPE_IDX = '" . $this->input->post('idx', TRUE) . "'";

        $this->LAND->trans_start(); // Query will be rolled back

        $res = $this->Db_m->getInfo($sql, 'LAND');

        $data = array();

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            $data = array(
                'RESULT' => 'FAILED'
            );
        } else {
            if ($res) {
                $data = array(
                    'RESULT' => 'SUCCESS',
                    'TYPE_IDX' => $res->TYPE_IDX,
                    'LAND_KIND' => $res->LAND_KIND,
                    'NAME' => $res->NAME,
                    'USE_YN' => $res->USE_YN
                );
            } else {
                $data = array(
                    'RESULT' => 'FAILED'
                );
            }
        }

        print_r(json_encode($data));
    }

    function modType() {
        $updateWhere = array(
            'TYPE_IDX' => $this->input->post('type_idx', true)
        );

        $updateArray = array(
            'LAND_KIND' => $this->input->post('kind', true),
            'NAME' => $this->input->post('name', true),
            'USE_YN' => $this->input->post('use_yn', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->update('TYPE', $updateArray, $updateWhere, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function insOption() {
        $insArray = array(
            'NAME' => $this->input->post('name', true),
            'USE_YN' => $this->input->post('use_yn', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->insData('OPTION', $insArray, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function getOptionInfo() {
        $sql = "SELECT
                    OPTION_IDX, 
                    NAME,
                    USE_YN
                FROM 
                    `OPTION`
                WHERE 
                    OPTION_IDX = '" . $this->input->post('idx', TRUE) . "'";

        $this->LAND->trans_start(); // Query will be rolled back

        $res = $this->Db_m->getInfo($sql, 'LAND');

        $data = array();

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            $data = array(
                'RESULT' => 'FAILED'
            );
        } else {
            if ($res) {
                $data = array(
                    'RESULT' => 'SUCCESS',
                    'OPTION_IDX' => $res->OPTION_IDX,
                    'NAME' => $res->NAME,
                    'USE_YN' => $res->USE_YN
                );
            } else {
                $data = array(
                    'RESULT' => 'FAILED'
                );
            }
        }

        print_r(json_encode($data));
    }

    function modOption() {
        $updateWhere = array(
            'OPTION_IDX' => $this->input->post('option_idx', true)
        );

        $updateArray = array(
            'NAME' => $this->input->post('name', true),
            'USE_YN' => $this->input->post('use_yn', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->update('OPTION', $updateArray, $updateWhere, 'LAND');

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo 'FAILED';
        } else {
            echo 'SUCCESS';
        }
    }

    function getType() {
        $sql = "SELECT
                    TYPE_IDX, 
                    NAME 
                FROM 
                    TYPE 
                WHERE 
                    LAND_KIND = '" . $this->input->post('value', TRUE) . "' AND
                    USE_YN = 'Y'";

        $res = $this->Db_m->getList($sql, 'LAND');

        $data = '<option value="">선택</option>';
        foreach ($res as $row) {
            $data .= '<option value="' . $row['TYPE_IDX'] . '">' . $row['NAME'] . '</option>';
        }

        echo $data;
    }

    function addLandLoad() {

        if ($this->input->post('value', true) === 'A' || $this->input->post('value', true) === 'H' || $this->input->post('value', true) === 'V' || $this->input->post('value', true) === 'R' || $this->input->post('value', true) === 'O') {
            $sql = "SELECT
                        OPTION_IDX, 
                        NAME 
                    FROM 
                        `OPTION` 
                    WHERE 
                        USE_YN = 'Y'";

            $data['option'] = $this->Db_m->getList($sql, 'LAND');
            $this->load->view('land/load_page/ins_housing', $data);
        } else {
            $this->load->view('land/load_page/ins_office');
        }
    }

    function insLand() {

        if (@$_FILES['video']['name']) {

            $this->load->library('upload');

            $url_path = "/land_video";
            $upload_config = Array(
                'upload_path' => $_SERVER['DOCUMENT_ROOT'] . $url_path,
                'allowed_types' => 'avi|mp4|wmv|mov|mpeg|MTS',
                'encrypt_name' => TRUE,
                'max_size' => '10240'
            );

            $this->upload->initialize($upload_config);

            $upfile = $_FILES['video']['name'];
            if (!$this->upload->do_upload('video')) {
                echo $this->upload->display_errors();
            }
            $info = $this->upload->data();
            $file['video'] = $url_path . "/" . $info['file_name'];
        } else {
            $file['video'] = '';
        }

        if ($this->input->post('timestamp') != date('Y-m-d')) {
            $insDate = $this->input->post('timestamp');
        } else {
            $insDate = date("Y-m-d H:i:s", time());
        }

        if ($this->input->post('type_idx', TRUE)) {
            $type_idx = $this->input->post('type_idx', TRUE);
        } else {
            $type_idx = NULL;
        }

        if ($this->input->post('rental_price', true)) {
            $rental_price = $this->input->post('rental_price', true);
        } else {
            $rental_price = NULL;
        }

        if ($this->input->post('rental_square', true)) {
            $rental_square = $this->input->post('rental_square', true);
        } else {
            $rental_square = NULL;
        }

        if ($this->input->post('unique_number', true)) {
            $unique_number = $this->input->post('unique_number', true);
        } else {
            $unique_number = NULL;
        }

        if ($this->input->post('unique_square', true)) {
            $unique_square = $this->input->post('unique_square', true);
        } else {
            $unique_square = NULL;
        }

        if ($this->input->post('deposit', TRUE)) {
            $deposit = $this->input->post('deposit', TRUE);
        } else {
            $deposit = NULL;
        }

        if ($this->input->post('monthly', TRUE)) {
            $monthly = $this->input->post('monthly', TRUE);
        } else {
            $monthly = NULL;
        }

        if ($this->input->post('administrative_expenses', TRUE)) {
            $administrative_expenses = $this->input->post('administrative_expenses', TRUE);
        } else {
            $administrative_expenses = NULL;
        }

        if ($this->input->post('parking', TRUE)) {
            $parking = $this->input->post('parking', TRUE);
        } else {
            $parking = NULL;
        }

        if ($this->input->post('parking_cnt', TRUE)) {
            $parking_cnt = $this->input->post('parking_cnt', TRUE);
        } else {
            $parking_cnt = NULL;
        }

        if ($this->input->post('ev_cnt', TRUE)) {
            $ev_cnt = $this->input->post('ev_cnt', TRUE);
        } else {
            $ev_cnt = NULL;
        }

        if ($this->input->post('room_cnt', TRUE)) {
            $room_cnt = $this->input->post('room_cnt', TRUE);
        } else {
            $room_cnt = NULL;
        }

        if ($this->input->post('fees', true)) {
            $fees = $this->input->post('fees', true);
        } else {
            $fees = NULL;
        }

        if ($this->input->post('air_heathing', true)) {
            $air_heathing = "";
            for ($i = 0; $i < count($this->input->post('air_heathing', true)); $i++) {
                $air_heathing .= $this->input->post('air_heathing', true)[$i] . ',';
            }
            $air_heathing_val = substr($air_heathing, 0, -1);
        } else {
            $air_heathing_val = NULL;
        }

        $insArray = array(
            'ADMIN_IDX' => $this->session->userdata('ADMIN_IDX'),
            'KIND' => $this->input->post('kind', true),
            'LAND_TYPE' => $this->input->post('land_type'),
            'ADDR' => $this->input->post('addr', true),
            'TYPE_IDX' => $type_idx,
            'URL' => $this->input->post('url', true),
            'COMPLETION_YEAR' => $this->input->post('completion_year', true),
            'NAME' => $this->input->post('land_name', true),
            'DONG' => $this->input->post('dong', true),
            'ROOM_NUMBER' => $this->input->post('room_number', true),
            'BUILDING_INTERIOR_ROOM' => $this->input->post('building_interior_room', true),
            'RENTAL_PRICE' => $rental_price,
            'RENTAL_SQUARE' => $rental_square,
            'UNIQUE_NUMBER' => $unique_number,
            'UNIQUE_SQUARE' => $unique_square,
            'FLOOR' => $this->input->post('floor', true),
            'ROOM' => $this->input->post('room', true),
            'BATH' => $this->input->post('bath', true),
            'UNDERGROUND' => $this->input->post('underground', true),
            'GROUND' => $this->input->post('ground', true),
            'DEPOSIT' => $deposit,
            'MONTHLY' => $monthly,
            'ADMINISTRATIVE_EXPENSES' => $administrative_expenses,
            'PARKING' => $parking,
            'PARKING_CNT' => $parking_cnt,
            'EV_YN' => $this->input->post('ev_yn', true),
            'EV_CNT' => $ev_cnt,
            'ROOM_CNT' => $room_cnt,
            'FEES' => $fees,
            'MOVING_DATE' => $this->input->post('moving_date', true),
            'AIR_HEATHING' => $air_heathing_val,
            'CONTENTS' => $this->input->post('contents', true),
            'TENANT_PHONE' => $this->input->post('tenant_phone', true),
            'TERRACE' => $this->input->post('terrace', true),
            'BUILDING_INTERIOR_ROOM_CONTENTS' => $this->input->post('building_interior_room_contents', true),
            'UNIQUENESS' => $this->input->post('uniqueness', true),
            'MEMO' => $this->input->post('memo', true),
            'AD_YN' => $this->input->post('ad_yn', true),
            'VIDEO' => $file['video'],
            'TIMESTAMP' => $insDate
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->insData('LAND', $insArray, 'LAND');
        $ins_id = $this->LAND->insert_id();

        if (@$_FILES['file']) {

            $this->load->library('upload');

            $uploaded_files = $_FILES;
            $url_path = "/land_img";
            $count = count($_FILES['file']['name']);
            for ($i = 0; $i < $count; $i++) {
//                echo "$i" . "<br>";
                if ($uploaded_files['file']['name'][$i] == null)
                    continue;
                unset($_FILES);
                $_FILES['file']['name'] = $uploaded_files['file']['name'][$i];
                $_FILES['file']['type'] = $uploaded_files['file']['type'][$i];
                $_FILES['file']['tmp_name'] = $uploaded_files['file']['tmp_name'][$i];
                $_FILES['file']['error'] = $uploaded_files['file']['error'][$i];
                $_FILES['file']['size'] = $uploaded_files['file']['size'][$i];

                $upload_config1 = Array(
                    'upload_path' => $_SERVER['DOCUMENT_ROOT'] . $url_path,
                    'allowed_types' => 'gif|jpg|jpeg|png|bmp|PNG',
                    'encrypt_name' => TRUE,
                    'max_size' => '512000'
                );
                $this->upload->initialize($upload_config1);
                if (!$this->upload->do_upload('file')) {
                    echo $this->upload->display_errors();
                }
                $info = $this->upload->data();

                $stamp_file['file'] = $url_path . "/" . $info['file_name'];
                $stamp_file['origin_name'] = $info['orig_name'];

                $ins_file_array[] = array(
                    'LAND_IDX' => $ins_id,
                    'LOCATION' => $stamp_file['file']
                );
            }
            $this->Db_m->insMultiData('LAND_IMG', $ins_file_array, 'LAND');
        }

        if ($this->input->post('phone', true)) {
            for ($i = 0; $i < count($this->input->post('phone', true)); $i++) {
                $insPhoneArray[] = array(
                    'LAND_IDX' => $ins_id,
                    'NAME' => $this->input->post('phone_name', true)[$i],
                    'PHONE' => $this->input->post('phone', true)[$i]
                );
            }
            $this->Db_m->insMultiData('LAND_PHONE', $insPhoneArray, 'LAND');
        }

        //주거일때
        if ($this->input->post('kind', true) === 'A' || $this->input->post('kind', true) === 'H' || $this->input->post('kind', true) === 'V' || $this->input->post('kind', true) === 'R' || $this->input->post('kind', true) === 'O') {

            if ($this->input->post('option_type', true)) {
                $option_type = $this->input->post('option_type', true);
            } else {
                $option_type = NULL;
            }

            if ($this->input->post('living_room_size', true)) {
                $living_room_size = $this->input->post('living_room_size', true);
            } else {
                $living_room_size = NULL;
            }

            if ($this->input->post('structure_type', true)) {
                $structure_type = $this->input->post('structure_type', true);
            } else {
                $structure_type = NULL;
            }

            $insHousingtArray = array(
                'LAND_IDX' => $ins_id,
                'OPTION_TYPE' => $option_type,
                'LIVING_ROOM_SIZE' => $living_room_size,
                'STRUCTURE_TYPE' => $structure_type
            );

            $this->Db_m->insData('HOUSING', $insHousingtArray, 'LAND');

            if ($this->input->post('option_idx', true)) {
                for ($i = 0; $i < count($this->input->post('option_idx', true)); $i++) {
                    $insHousingOptionArray[] = array(
                        'LAND_IDX' => $ins_id,
                        'OPTION_IDX' => $this->input->post('option_idx', true)[$i]
                    );
                }

                $this->Db_m->insMultiData('HOUSING_OPTION', $insHousingOptionArray, 'LAND');
            }
        } else {

            if ($this->input->post('structure_type', true)) {
                $structure_type = $this->input->post('structure_type', true);
            } else {
                $structure_type = NULL;
            }

            if ($this->input->post('appearance_type', true)) {
                $appearance_type = $this->input->post('appearance_type', true);
            } else {
                $appearance_type = NULL;
            }

            if ($this->input->post('floor_type', true)) {
                $floor_type = $this->input->post('floor_type', true);
            } else {
                $floor_type = NULL;
            }

            if ($this->input->post('location', true)) {
                $location = $this->input->post('location', true);
            } else {
                $location = NULL;
            }

            if ($this->input->post('form_sale', true)) {
                $form_sale = $this->input->post('form_sale', true);
            } else {
                $form_sale = NULL;
            }

            if ($this->input->post('restroom', true)) {
                $restroom = $this->input->post('restroom', true);
            } else {
                $restroom = NULL;
            }

            if ($this->input->post('interior', true)) {
                $interior = $this->input->post('interior', true);
            } else {
                $interior = NULL;
            }

            if ($this->input->post('facility_reward', true)) {
                $facility_reward = $this->input->post('facility_reward', true);
            } else {
                $facility_reward = NULL;
            }

            if ($this->input->post('management_room', true)) {
                $management_room = $this->input->post('management_room', true);
            } else {
                $management_room = NULL;
            }

            $insOfficeArray = array(
                'LAND_IDX' => $ins_id,
                'STRUCTURE_TYPE' => $structure_type,
                'APPEARANCE_TYPE' => $appearance_type,
                'INTERNAL_TYPE' => $this->input->post('internal_type', true),
                'FLOOR_TYPE' => $floor_type,
                'LOCATION' => $location,
                'FORM_SALE' => $form_sale,
                'RESTROOM' => $restroom,
                'INTERIOR' => $interior,
                'FACILITY_REWARD' => $facility_reward,
                'MANAGEMENT_ROOM' => $management_room,
                'OPENING_TIME' => $this->input->post('opening_time', true)
            );

            $this->Db_m->insData('BUSINESS_FACILITIES', $insOfficeArray, 'LAND');
        }

        $this->LAND->trans_complete();

        $this->load->helper(array('alert'));

        if ($this->LAND->trans_status() === FALSE) {
            if ($this->input->post('se3', true) === 'q') {
                alert('데이터 처리오류!!', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '/' . $this->input->post('se5', true) . '/' . $this->input->post('se6', true) . '/' . $this->input->post('se7', true) . '/' . $this->input->post('se8', true) . '/' . $this->input->post('se9', true) . '/' . $this->input->post('se10', true) . '/' . $this->input->post('se11', true) . '/' . $this->input->post('se12', true) . '/' . $this->input->post('se13', true) . '');
            } else if ($this->input->post('se3', true) === 'page') {
                alert('데이터 처리오류!!', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '');
            } else {
                alert('데이터 처리오류!!', '/index/main');
            }
        } else {
            if ($this->input->post('se3', true) === 'q') {
                alert('등록 되었습니다.', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '/' . $this->input->post('se5', true) . '/' . $this->input->post('se6', true) . '/' . $this->input->post('se7', true) . '/' . $this->input->post('se8', true) . '/' . $this->input->post('se9', true) . '/' . $this->input->post('se10', true) . '/' . $this->input->post('se11', true) . '/' . $this->input->post('se12', true) . '/' . $this->input->post('se13', true) . '');
            } else if ($this->input->post('se3', true) === 'page') {
                alert('등록 되었습니다.', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '');
            } else {
                alert('등록 되었습니다.', '/index/main');
            }
        }
    }

    function modLand() {

        if (!$this->input->post('video_location', true)) {
            if (@$_FILES['video']['name']) {

                $this->load->library('upload');

                $url_path = "/land_video";
                $upload_config = Array(
                    'upload_path' => $_SERVER['DOCUMENT_ROOT'] . $url_path,
                    'allowed_types' => 'avi|mp4|wmv|mov|mpeg|MTS',
                    'encrypt_name' => TRUE,
                    'max_size' => '10240'
                );

                $this->upload->initialize($upload_config);

                $upfile = $_FILES['video']['name'];
                if (!$this->upload->do_upload('video')) {
                    echo $this->upload->display_errors();
                }
                $info = $this->upload->data();
                $file['video'] = $url_path . "/" . $info['file_name'];
            } else {
                $file['video'] = '';
            }
        } else {
            $file['video'] = $this->input->post('video_location', true);
        }

        if ($this->input->post('timestamp') != date('Y-m-d')) {
            $insDate = $this->input->post('timestamp');
        } else {
            $insDate = date("Y-m-d H:i:s", time());
        }

        if ($this->input->post('type_idx', TRUE)) {
            $type_idx = $this->input->post('type_idx', TRUE);
        } else {
            $type_idx = NULL;
        }

        if ($this->input->post('rental_price', true)) {
            $rental_price = $this->input->post('rental_price', true);
        } else {
            $rental_price = NULL;
        }

        if ($this->input->post('rental_square', true)) {
            $rental_square = $this->input->post('rental_square', true);
        } else {
            $rental_square = NULL;
        }

        if ($this->input->post('unique_number', true)) {
            $unique_number = $this->input->post('unique_number', true);
        } else {
            $unique_number = NULL;
        }

        if ($this->input->post('unique_square', true)) {
            $unique_square = $this->input->post('unique_square', true);
        } else {
            $unique_square = NULL;
        }

        if ($this->input->post('deposit', TRUE)) {
            $deposit = $this->input->post('deposit', TRUE);
        } else {
            $deposit = NULL;
        }

        if ($this->input->post('monthly', TRUE)) {
            $monthly = $this->input->post('monthly', TRUE);
        } else {
            $monthly = NULL;
        }

        if ($this->input->post('administrative_expenses', TRUE)) {
            $administrative_expenses = $this->input->post('administrative_expenses', TRUE);
        } else {
            $administrative_expenses = NULL;
        }

        if ($this->input->post('parking', TRUE)) {
            $parking = $this->input->post('parking', TRUE);
        } else {
            $parking = NULL;
        }

        if ($this->input->post('parking_cnt', TRUE)) {
            $parking_cnt = $this->input->post('parking_cnt', TRUE);
        } else {
            $parking_cnt = NULL;
        }

        if ($this->input->post('ev_cnt', TRUE)) {
            $ev_cnt = $this->input->post('ev_cnt', TRUE);
        } else {
            $ev_cnt = NULL;
        }

        if ($this->input->post('room_cnt', TRUE)) {
            $room_cnt = $this->input->post('room_cnt', TRUE);
        } else {
            $room_cnt = NULL;
        }

        if ($this->input->post('fees', true)) {
            $fees = $this->input->post('fees', true);
        } else {
            $fees = NULL;
        }

        if ($this->input->post('air_heathing', true)) {
            $air_heathing = "";
            for ($i = 0; $i < count($this->input->post('air_heathing', true)); $i++) {
                $air_heathing .= $this->input->post('air_heathing', true)[$i] . ',';
            }
            $air_heathing_val = substr($air_heathing, 0, -1);
        } else {
            $air_heathing_val = NULL;
        }

        $updateArray = array(
            'KIND' => $this->input->post('kind', true),
            'LAND_TYPE' => $this->input->post('land_type'),
            'ADDR' => $this->input->post('addr', true),
            'TYPE_IDX' => $type_idx,
            'URL' => $this->input->post('url', true),
            'COMPLETION_YEAR' => $this->input->post('completion_year', true),
            'NAME' => $this->input->post('land_name', true),
            'DONG' => $this->input->post('dong', true),
            'ROOM_NUMBER' => $this->input->post('room_number', true),
            'BUILDING_INTERIOR_ROOM' => $this->input->post('building_interior_room', true),
            'RENTAL_PRICE' => $rental_price,
            'RENTAL_SQUARE' => $rental_square,
            'UNIQUE_NUMBER' => $unique_number,
            'UNIQUE_SQUARE' => $unique_square,
            'FLOOR' => $this->input->post('floor', true),
            'ROOM' => $this->input->post('room', true),
            'BATH' => $this->input->post('bath', true),
            'UNDERGROUND' => $this->input->post('underground', true),
            'GROUND' => $this->input->post('ground', true),
            'DEPOSIT' => $deposit,
            'MONTHLY' => $monthly,
            'ADMINISTRATIVE_EXPENSES' => $administrative_expenses,
            'PARKING' => $parking,
            'PARKING_CNT' => $parking_cnt,
            'EV_YN' => $this->input->post('ev_yn', true),
            'EV_CNT' => $ev_cnt,
            'ROOM_CNT' => $room_cnt,
            'FEES' => $fees,
            'MOVING_DATE' => $this->input->post('moving_date', true),
            'AIR_HEATHING' => $air_heathing_val,
            'CONTENTS' => $this->input->post('contents', true),
            'TENANT_PHONE' => $this->input->post('tenant_phone', true),
            'TERRACE' => $this->input->post('terrace', true),
            'BUILDING_INTERIOR_ROOM_CONTENTS' => $this->input->post('building_interior_room_contents', true),
            'UNIQUENESS' => $this->input->post('uniqueness', true),
            'MEMO' => $this->input->post('memo', true),
            'AD_YN' => $this->input->post('ad_yn', true),
            'VIDEO' => $file['video'],
            'CHECK_DATE' => date("Y-m-d H:i:s", time())
        );

        $updateWhere = array(
            'LAND_IDX' => $this->input->post('land_idx', true)
        );

        $this->LAND->trans_start(); // Query will be rolled back

        $this->Db_m->update('LAND', $updateArray, $updateWhere, 'LAND');

        $this->Db_m->delete('LAND_IMG', $updateWhere, 'LAND');

        if ($this->input->post('mod_location')) {
            for ($i = 0; $i < count($this->input->post('mod_location')); $i++) {
                $ins_image_array[] = array(
                    'LAND_IDX' => $this->input->post('land_idx', true),
                    'LOCATION' => $this->input->post('mod_location')[$i]
                );
            }
            $this->Db_m->insMultiData('LAND_IMG', $ins_image_array, 'LAND');
        }

        if (@$_FILES['file']) {

            $this->load->library('upload');

            $uploaded_files = $_FILES;
            $url_path = "/land_img";
            $count = count($_FILES['file']['name']);
            for ($i = 0; $i < $count; $i++) {
//                echo "$i" . "<br>";
                if ($uploaded_files['file']['name'][$i] == null)
                    continue;
                unset($_FILES);
                $_FILES['file']['name'] = $uploaded_files['file']['name'][$i];
                $_FILES['file']['type'] = $uploaded_files['file']['type'][$i];
                $_FILES['file']['tmp_name'] = $uploaded_files['file']['tmp_name'][$i];
                $_FILES['file']['error'] = $uploaded_files['file']['error'][$i];
                $_FILES['file']['size'] = $uploaded_files['file']['size'][$i];

                $upload_config1 = Array(
                    'upload_path' => $_SERVER['DOCUMENT_ROOT'] . $url_path,
                    'allowed_types' => 'gif|jpg|jpeg|png|bmp|PNG',
                    'encrypt_name' => TRUE,
                    'max_size' => '512000'
                );
                $this->upload->initialize($upload_config1);
                if (!$this->upload->do_upload('file')) {
                    echo $this->upload->display_errors();
                }
                $info = $this->upload->data();

                $stamp_file['file'] = $url_path . "/" . $info['file_name'];
                $stamp_file['origin_name'] = $info['orig_name'];

                $ins_file_array[] = array(
                    'LAND_IDX' => $this->input->post('land_idx', true),
                    'LOCATION' => $stamp_file['file']
                );
            }
            $this->Db_m->insMultiData('LAND_IMG', $ins_file_array, 'LAND');
        }

        $this->Db_m->delete('LAND_PHONE', $updateWhere, 'LAND');

        if ($this->input->post('phone', true)) {
            for ($i = 0; $i < count($this->input->post('phone', true)); $i++) {
                $insPhoneArray[] = array(
                    'LAND_IDX' => $this->input->post('land_idx', true),
                    'NAME' => $this->input->post('phone_name', true)[$i],
                    'PHONE' => $this->input->post('phone', true)[$i]
                );
            }
            $this->Db_m->insMultiData('LAND_PHONE', $insPhoneArray, 'LAND');
        }

        $this->Db_m->delete('HOUSING', $updateWhere, 'LAND');
        $this->Db_m->delete('HOUSING_OPTION', $updateWhere, 'LAND');
        $this->Db_m->delete('BUSINESS_FACILITIES', $updateWhere, 'LAND');

        //주거일때
        if ($this->input->post('kind', true) === 'A' || $this->input->post('kind', true) === 'H' || $this->input->post('kind', true) === 'V' || $this->input->post('kind', true) === 'R' || $this->input->post('kind', true) === 'O') {

            if ($this->input->post('option_type', true)) {
                $option_type = $this->input->post('option_type', true);
            } else {
                $option_type = NULL;
            }

            if ($this->input->post('living_room_size', true)) {
                $living_room_size = $this->input->post('living_room_size', true);
            } else {
                $living_room_size = NULL;
            }

            if ($this->input->post('structure_type', true)) {
                $structure_type = $this->input->post('structure_type', true);
            } else {
                $structure_type = NULL;
            }

            $insHousingtArray = array(
                'LAND_IDX' => $this->input->post('land_idx', true),
                'OPTION_TYPE' => $option_type,
                'LIVING_ROOM_SIZE' => $living_room_size,
                'STRUCTURE_TYPE' => $structure_type
            );

            $this->Db_m->insData('HOUSING', $insHousingtArray, 'LAND');

            if ($this->input->post('option_idx', true)) {
                for ($i = 0; $i < count($this->input->post('option_idx', true)); $i++) {
                    $insHousingOptionArray[] = array(
                        'LAND_IDX' => $this->input->post('land_idx', true),
                        'OPTION_IDX' => $this->input->post('option_idx', true)[$i]
                    );
                }

                $this->Db_m->insMultiData('HOUSING_OPTION', $insHousingOptionArray, 'LAND');
            }
        } else {

            if ($this->input->post('structure_type', true)) {
                $structure_type = $this->input->post('structure_type', true);
            } else {
                $structure_type = NULL;
            }

            if ($this->input->post('appearance_type', true)) {
                $appearance_type = $this->input->post('appearance_type', true);
            } else {
                $appearance_type = NULL;
            }

            if ($this->input->post('floor_type', true)) {
                $floor_type = $this->input->post('floor_type', true);
            } else {
                $floor_type = NULL;
            }

            if ($this->input->post('location', true)) {
                $location = $this->input->post('location', true);
            } else {
                $location = NULL;
            }

            if ($this->input->post('form_sale', true)) {
                $form_sale = $this->input->post('form_sale', true);
            } else {
                $form_sale = NULL;
            }

            if ($this->input->post('restroom', true)) {
                $restroom = $this->input->post('restroom', true);
            } else {
                $restroom = NULL;
            }

            if ($this->input->post('interior', true)) {
                $interior = $this->input->post('interior', true);
            } else {
                $interior = NULL;
            }

            if ($this->input->post('facility_reward', true)) {
                $facility_reward = $this->input->post('facility_reward', true);
            } else {
                $facility_reward = NULL;
            }

            if ($this->input->post('management_room', true)) {
                $management_room = $this->input->post('management_room', true);
            } else {
                $management_room = NULL;
            }

            $insOfficeArray = array(
                'LAND_IDX' => $this->input->post('land_idx', true),
                'STRUCTURE_TYPE' => $structure_type,
                'APPEARANCE_TYPE' => $appearance_type,
                'INTERNAL_TYPE' => $this->input->post('internal_type', true),
                'FLOOR_TYPE' => $floor_type,
                'LOCATION' => $location,
                'FORM_SALE' => $form_sale,
                'RESTROOM' => $restroom,
                'INTERIOR' => $interior,
                'FACILITY_REWARD' => $facility_reward,
                'MANAGEMENT_ROOM' => $management_room,
                'OPENING_TIME' => $this->input->post('opening_time', true)
            );

            $this->Db_m->insData('BUSINESS_FACILITIES', $insOfficeArray, 'LAND');
        }

        $this->LAND->trans_complete();

        $this->load->helper(array('alert'));

        if ($this->LAND->trans_status() === FALSE) {
            if ($this->input->post('se3', true) === 'q') {
                alert('데이터 처리오류!!', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '/' . $this->input->post('se5', true) . '/' . $this->input->post('se6', true) . '/' . $this->input->post('se7', true) . '/' . $this->input->post('se8', true) . '/' . $this->input->post('se9', true) . '/' . $this->input->post('se10', true) . '/' . $this->input->post('se11', true) . '/' . $this->input->post('se12', true) . '/' . $this->input->post('se13', true) . '');
            } else if ($this->input->post('se3', true) === 'page') {
                alert('데이터 처리오류!!', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '');
            } else {
                alert('데이터 처리오류!!', '/index/main');
            }
        } else {
            if ($this->input->post('se3', true) === 'q') {
                alert('등록 되었습니다.', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '/' . $this->input->post('se5', true) . '/' . $this->input->post('se6', true) . '/' . $this->input->post('se7', true) . '/' . $this->input->post('se8', true) . '/' . $this->input->post('se9', true) . '/' . $this->input->post('se10', true) . '/' . $this->input->post('se11', true) . '/' . $this->input->post('se12', true) . '/' . $this->input->post('se13', true) . '');
            } else if ($this->input->post('se3', true) === 'page') {
                alert('등록 되었습니다.', '/index/main/' . $this->input->post('se3', true) . '/' . $this->input->post('se4', true) . '');
            } else {
                alert('등록 되었습니다.', '/index/main');
            }
        }
    }

    function getLandInfo() {

        $this->LAND->trans_start(); // Query will be rolled back

        $sql = "SELECT
                    L.LAND_IDX,
                    L.KIND, 
                    L.TYPE_IDX,
                    L.LAND_TYPE,
                    L.ADDR,
                    L.TYPE_IDX,
                    L.URL,
                    L.COMPLETION_YEAR,
                    L.NAME,
                    L.DONG,
                    L.ROOM_NUMBER,
                    L.BUILDING_INTERIOR_ROOM,
                    L.RENTAL_PRICE,
                    L.RENTAL_SQUARE,
                    L.UNIQUE_NUMBER,
                    L.UNIQUE_SQUARE,
                    L.FLOOR,
                    L.ROOM,
                    L.BATH,
                    L.UNDERGROUND,
                    L.GROUND,
                    L.DEPOSIT,
                    L.MONTHLY,
                    L.ADMINISTRATIVE_EXPENSES,
                    L.PARKING,
                    L.PARKING_CNT,
                    L.EV_YN,
                    L.EV_CNT,
                    L.ROOM_CNT,
                    L.FEES,
                    L.MOVING_DATE,
                    L.AIR_HEATHING,
                    L.CONTENTS,
                    L.TENANT_PHONE,
                    L.TERRACE,
                    L.BUILDING_INTERIOR_ROOM_CONTENTS,
                    L.UNIQUENESS,
                    L.MEMO,
                    L.AD_YN,
                    L.VIDEO,
                    IF(L.CHECK_DATE, L.CHECK_DATE, '') CHECK_DATE,
                    L.TIMESTAMP
                FROM 
                    LAND L
                WHERE 
                    L.LAND_IDX = '" . $this->input->post('idx', true) . "'";

        $data['info'] = $this->Db_m->getInfo($sql, 'LAND');

        $phone_sql = "SELECT
                        NAME, 
                        PHONE
                      FROM 
                        LAND_PHONE 
                      WHERE 
                        LAND_IDX = '" . $this->input->post('idx', true) . "' AND PHONE <> ''";

        $phone_res = $this->Db_m->getList($phone_sql, 'LAND');

        $phone = "";

        if ($phone_res) {
            $i = 0;
            foreach ($phone_res as $row) {

                if ($i > 0) {
                    $del_btn = '<i class="icon-close del_phone_btn"></i>';
                } else {
                    $del_btn = '';
                }

                $phone .= '<div class="col-3 rent_num">
                                <input type="text" class="form-control form-control-sm" placeholder="이름" name="phone_name[]" value="' . $row['NAME'] . '">
                                <input type="text" class="form-control form-control-sm" placeholder="연락처" name="phone[]" value="' . $row['PHONE'] . '" >
                                ' . $del_btn . '
                            </div>';
                $i++;
            }
        }

        $img_sql = "SELECT
                        LOCATION 
                    FROM 
                        LAND_IMG 
                    WHERE 
                        LAND_IDX = '" . $this->input->post('idx', true) . "'";

        $img_res = $this->Db_m->getList($img_sql, 'LAND');

        $img = "";
        if ($img_res) {
            foreach ($img_res as $row) {
                $img .= '<div>
                            <input type="hidden" name="mod_location[]" value="' . $row['LOCATION'] . '">
                            <div class="modIMG">
                            <img src="' . $row['LOCATION'] . '">
                            <i class="icon-settings modImgBtn"></i>
                            <i class="icon-close modDelImgBtn"></i>
                            </div>
                         </div>';
            }
        }

        $page = "";

        //주거일때
        if ($data['info']->KIND === 'A' || $data['info']->KIND === 'H' || $data['info']->KIND === 'V' || $data['info']->KIND === 'R' || $data['info']->KIND === 'O') {
            $sql = "SELECT
                        O.OPTION_IDX, 
                        O.NAME,
                        IF(HO.OPTION_IDX, 'CHECKED', '') CHECKED
                    FROM 
                        `OPTION` O
                        LEFT JOIN HOUSING_OPTION HO
                        ON
                        O.OPTION_IDX = HO.OPTION_IDX AND
                        HO.LAND_IDX = '" . $data['info']->LAND_IDX . "'
                    WHERE 
                        O.USE_YN = 'Y'";

            $data['option'] = $this->Db_m->getList($sql, 'LAND');

            $housing_info_sql = "SELECT
                                     OPTION_TYPE,
                                     LIVING_ROOM_SIZE, 
                                     STRUCTURE_TYPE
                                 FROM 
                                     HOUSING 
                                 WHERE 
                                     LAND_IDX = '" . $data['info']->LAND_IDX . "'";

            $data['housing_info'] = $this->Db_m->getInfo($housing_info_sql, 'LAND');

            $page = $this->load->view('land/load_page/mod_housing', $data, true);
        } else {

            $business_facilities_sql = "SELECT
                                            STRUCTURE_TYPE,
                                            APPEARANCE_TYPE, 
                                            INTERNAL_TYPE,
                                            FLOOR_TYPE,
                                            LOCATION,
                                            FORM_SALE,
                                            RESTROOM,
                                            INTERIOR,
                                            FACILITY_REWARD,
                                            MANAGEMENT_ROOM,
                                            OPENING_TIME
                                        FROM 
                                            BUSINESS_FACILITIES 
                                        WHERE 
                                            LAND_IDX = '" . $data['info']->LAND_IDX . "'";

            $data['business_facilities_info'] = $this->Db_m->getInfo($business_facilities_sql, 'LAND');

            $page = $this->load->view('land/load_page/mod_office', $data, true);
        }

        $result = array();

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            $result = array(
                'RESULT' => 'FAILED'
            );
        } else {
            if (!$data['info']) {
                $result = array(
                    'RESULT' => 'FAILED'
                );
            } else {

                $air_heathing_exp = explode(',', $data['info']->AIR_HEATHING);
                $air_heathing_text = array('중앙냉난방', '개별냉난방', '중앙난방', '바닥난방');
                $air_heathing = "";

                for ($i = 0; $i < 4; $i++) {

                    if (in_array(($i + 1), $air_heathing_exp)) {
                        $check = 'checked';
                    } else {
                        $check = '';
                    }

                    $air_heathing .= '<label><input type="checkbox" value="' . ($i + 1) . '" name="air_heathing[]" ' . $check . '>' . $air_heathing_text[$i] . '</label>';
                }

                $result = array(
                    'RESULT' => 'SUCCESS',
                    'LAND_IDX' => $data['info']->LAND_IDX,
                    'AD_YN' => $data['info']->AD_YN,
                    'KIND' => $data['info']->KIND,
                    'PAGE' => $page,
                    'TYPE' => $data['info']->TYPE_IDX,
                    'LAND_TYPE' => $data['info']->LAND_TYPE,
                    'TIMESTAMP' => $data['info']->TIMESTAMP,
                    'ADDR' => $data['info']->ADDR,
                    'URL' => $data['info']->URL,
                    'COMPLETION_YEAR' => $data['info']->COMPLETION_YEAR,
                    'CHECK_DATE' => $data['info']->CHECK_DATE,
                    'NAME' => $data['info']->NAME,
                    'DONG' => $data['info']->DONG,
                    'ROOM_NUMBER' => $data['info']->ROOM_NUMBER,
                    'BUILDING_INTERIOR_ROOM' => $data['info']->BUILDING_INTERIOR_ROOM,
                    'RENTAL_PRICE' => $data['info']->RENTAL_PRICE,
                    'RENTAL_SQUARE' => $data['info']->RENTAL_SQUARE,
                    'UNIQUE_NUMBER' => $data['info']->UNIQUE_NUMBER,
                    'UNIQUE_SQUARE' => $data['info']->UNIQUE_SQUARE,
                    'FLOOR' => $data['info']->FLOOR,
                    'ROOM' => $data['info']->ROOM,
                    'BATH' => $data['info']->BATH,
                    'UNDERGROUND' => $data['info']->UNDERGROUND,
                    'GROUND' => $data['info']->GROUND,
                    'DEPOSIT' => $data['info']->DEPOSIT,
                    'MONTHLY' => $data['info']->MONTHLY,
                    'ADMINISTRATIVE_EXPENSES' => $data['info']->ADMINISTRATIVE_EXPENSES,
                    'PARKING' => $data['info']->PARKING,
                    'PARKING_CNT' => $data['info']->PARKING_CNT,
                    'EV_YN' => $data['info']->EV_YN,
                    'EV_CNT' => $data['info']->EV_CNT,
                    'ROOM_CNT' => $data['info']->ROOM_CNT,
                    'FEES' => $data['info']->FEES,
                    'MOVING_DATE' => $data['info']->MOVING_DATE,
                    'AIR_HEATHING' => $air_heathing,
                    'CONTENTS' => $data['info']->CONTENTS,
                    'TENANT_PHONE' => $data['info']->TENANT_PHONE,
                    'BUILDING_INTERIOR_ROOM_CONTENTS' => $data['info']->BUILDING_INTERIOR_ROOM_CONTENTS,
                    'UNIQUENESS' => $data['info']->UNIQUENESS,
                    'MEMO' => $data['info']->MEMO,
                    'PHONE' => $phone,
                    'VIDEO' => $data['info']->VIDEO,
                    'IMG' => $img
                );
            }
        }

        print_r(json_encode($result));
    }

    function copyLand() {

        $this->LAND->trans_start(); // Query will be rolled back

        $sql = "SELECT
                    LAND_IDX,
                    ADMIN_IDX,
                    KIND,
                    LAND_TYPE,
                    ADDR,
                    TYPE_IDX,
                    URL,
                    COMPLETION_YEAR,
                    NAME,
                    DONG,
                    ROOM_NUMBER,
                    BUILDING_INTERIOR_ROOM,
                    RENTAL_PRICE,
                    RENTAL_SQUARE,
                    UNIQUE_NUMBER,
                    UNIQUE_SQUARE,
                    FLOOR,
                    ROOM,
                    BATH,
                    UNDERGROUND,
                    GROUND,
                    DEPOSIT,
                    MONTHLY,
                    ADMINISTRATIVE_EXPENSES,
                    PARKING,
                    PARKING_CNT,
                    EV_YN,
                    EV_CNT,
                    ROOM_CNT,
                    FEES,
                    MOVING_DATE,
                    AIR_HEATHING,
                    CONTENTS,
                    TENANT_PHONE,
                    TERRACE,
                    BUILDING_INTERIOR_ROOM_CONTENTS,
                    UNIQUENESS,
                    MEMO,
                    AD_YN,
                    VIDEO,
                    SHOW_YN,
                    CHECK_DATE,
                    TIMESTAMP
                FROM 
                    LAND 
                WHERE 
                    LAND_IDX IN (" . $this->input->post('idxs', TRUE) . ")";
        $res = $this->Db_m->getList($sql, 'LAND');

        foreach ($res as $row) {
            $insArray = array(
                'ADMIN_IDX' => $row['ADMIN_IDX'],
                'KIND' => $row['KIND'],
                'LAND_TYPE' => $row['LAND_TYPE'],
                'ADDR' => $row['ADDR'],
                'TYPE_IDX' => $row['TYPE_IDX'],
                'URL' => $row['URL'],
                'COMPLETION_YEAR' => $row['COMPLETION_YEAR'],
                'NAME' => $row['NAME'],
                'DONG' => $row['DONG'],
                'ROOM_NUMBER' => $row['ROOM_NUMBER'],
                'BUILDING_INTERIOR_ROOM' => $row['BUILDING_INTERIOR_ROOM'],
                'RENTAL_PRICE' => $row['RENTAL_PRICE'],
                'RENTAL_SQUARE' => $row['RENTAL_SQUARE'],
                'UNIQUE_NUMBER' => $row['UNIQUE_NUMBER'],
                'UNIQUE_SQUARE' => $row['UNIQUE_SQUARE'],
                'FLOOR' => $row['FLOOR'],
                'ROOM' => $row['ROOM'],
                'BATH' => $row['BATH'],
                'UNDERGROUND' => $row['UNDERGROUND'],
                'GROUND' => $row['GROUND'],
                'DEPOSIT' => $row['DEPOSIT'],
                'MONTHLY' => $row['MONTHLY'],
                'ADMINISTRATIVE_EXPENSES' => $row['ADMINISTRATIVE_EXPENSES'],
                'PARKING' => $row['PARKING'],
                'PARKING_CNT' => $row['PARKING_CNT'],
                'EV_YN' => $row['EV_YN'],
                'EV_CNT' => $row['EV_CNT'],
                'ROOM_CNT' => $row['ROOM_CNT'],
                'FEES' => $row['FEES'],
                'MOVING_DATE' => $row['MOVING_DATE'],
                'AIR_HEATHING' => $row['AIR_HEATHING'],
                'CONTENTS' => $row['CONTENTS'],
                'TENANT_PHONE' => $row['TENANT_PHONE'],
                'TERRACE' => $row['TERRACE'],
                'BUILDING_INTERIOR_ROOM_CONTENTS' => $row['BUILDING_INTERIOR_ROOM_CONTENTS'],
                'UNIQUENESS' => $row['UNIQUENESS'],
                'MEMO' => $row['MEMO'],
                'AD_YN' => $row['AD_YN'],
                'VIDEO' => $row['VIDEO'],
                'SHOW_YN' => $row['SHOW_YN'],
                'CHECK_DATE' => $row['CHECK_DATE'],
                'TIMESTAMP' => $row['TIMESTAMP']
            );

            $this->Db_m->insData('LAND', $insArray, 'LAND');
            $ins_id = $this->LAND->insert_id();

            if ($row['KIND'] === 'A' || $row['KIND'] === 'H' || $row['KIND'] === 'V' || $row['KIND'] === 'R' || $row['KIND'] === 'O') {

                $housing_sql = "SELECT 
                                    OPTION_TYPE,
                                    LIVING_ROOM_SIZE,
                                    STRUCTURE_TYPE
                                FROM 
                                    HOUSING
                                WHERE 
                                    LAND_IDX = " . $row['LAND_IDX'] . "";

                $housing_res = $this->Db_m->getInfo($housing_sql, 'LAND');

                $insHousingArray = array(
                    'LAND_IDX' => $ins_id,
                    'OPTION_TYPE' => $housing_res->OPTION_TYPE,
                    'LIVING_ROOM_SIZE' => $housing_res->LIVING_ROOM_SIZE,
                    'STRUCTURE_TYPE' => $housing_res->STRUCTURE_TYPE
                );

                $this->Db_m->insData('HOUSING', $insHousingArray, 'LAND');

                $housing_option_sql = "SELECT 
                                           OPTION_IDX
                                       FROM 
                                           HOUSING_OPTION
                                       WHERE 
                                           LAND_IDX = " . $row['LAND_IDX'] . "";

                $housing_option_res = $this->Db_m->getList($housing_option_sql, 'LAND');

                if ($housing_option_res) {
                    foreach ($housing_option_res as $housing_option_row) {
                        $insHousingOptionArray = array(
                            'LAND_IDX' => $ins_id,
                            'OPTION_IDX' => $housing_option_row['OPTION_IDX']
                        );
                        $this->Db_m->insData('HOUSING_OPTION', $insHousingOptionArray, 'LAND');
                    }
                }
            } else {

                $business_facilities_sql = "SELECT 
                                                STRUCTURE_TYPE,
                                                APPEARANCE_TYPE,
                                                INTERNAL_TYPE,
                                                FLOOR_TYPE,
                                                LOCATION,
                                                FORM_SALE,
                                                RESTROOM,
                                                INTERIOR,
                                                FACILITY_REWARD,
                                                MANAGEMENT_ROOM,
                                                OPENING_TIME
                                            FROM 
                                                BUSINESS_FACILITIES
                                            WHERE 
                                                LAND_IDX = " . $row['LAND_IDX'] . "";

                $business_facilities_res = $this->Db_m->getInfo($business_facilities_sql, 'LAND');

                $insBusinessFacilitiesArray = array(
                    'LAND_IDX' => $ins_id,
                    'STRUCTURE_TYPE' => $business_facilities_res->STRUCTURE_TYPE,
                    'APPEARANCE_TYPE' => $business_facilities_res->APPEARANCE_TYPE,
                    'INTERNAL_TYPE' => $business_facilities_res->INTERNAL_TYPE,
                    'FLOOR_TYPE' => $business_facilities_res->FLOOR_TYPE,
                    'LOCATION' => $business_facilities_res->LOCATION,
                    'FORM_SALE' => $business_facilities_res->FORM_SALE,
                    'RESTROOM' => $business_facilities_res->RESTROOM,
                    'INTERIOR' => $business_facilities_res->INTERIOR,
                    'FACILITY_REWARD' => $business_facilities_res->FACILITY_REWARD,
                    'MANAGEMENT_ROOM' => $business_facilities_res->MANAGEMENT_ROOM,
                    'OPENING_TIME' => $business_facilities_res->OPENING_TIME
                );

                $this->Db_m->insData('BUSINESS_FACILITIES', $insBusinessFacilitiesArray, 'LAND');
            }

            $sql_phone = "SELECT
                            NAME, 
                            PHONE 
                          FROM 
                            LAND_PHONE 
                          WHERE 
                            LAND_IDX = " . $row['LAND_IDX'] . "";

            $phone_res = $this->Db_m->getList($sql_phone, 'LAND');

            foreach ($phone_res as $phone_row) {
                $insPhoneArray = array(
                    'LAND_IDX' => $ins_id,
                    'NAME' => $phone_row['NAME'],
                    'PHONE' => $phone_row['PHONE']
                );
                $this->Db_m->insData('LAND_PHONE', $insPhoneArray, 'LAND');
            }

            $sql_img = "SELECT
                          LOCATION
                        FROM 
                          LAND_IMG 
                        WHERE 
                          LAND_IDX = " . $row['LAND_IDX'] . "";

            $img_res = $this->Db_m->getList($sql_img, 'LAND');

            if ($img_res) {
                foreach ($img_res as $img_row) {
                    $insImgArray = array(
                        'LAND_IDX' => $ins_id,
                        'LOCATION' => $img_row['LOCATION']
                    );
                    $this->Db_m->insData('LAND_IMG', $insImgArray, 'LAND');
                }
            }
        }

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo "FAILED";
        } else {
            echo 'SUCCESS';
        }
    }

    function delLand() {
        $sql = "DELETE
                FROM
                    LAND
                WHERE 
                    LAND_IDX IN(" . $this->input->post('idxs', true) . ")";

        $this->LAND->trans_start(); // Query will be rolled back

        $this->LAND->query($sql);

        $this->LAND->trans_complete();

        if ($this->LAND->trans_status() === FALSE) {
            echo "FAILED";
        } else {
            echo 'SUCCESS';
        }
    }

    function excelDown() {

        $add_where = " ";
        if ($this->session->userdata('LEVEL') !== 'A') {
//            $add_where = " AND L.ADMIN_IDX = '" . $this->session->userdata('ADMIN_IDX') . "' ";
        }

        if ($this->input->get('idxs', true)) {
            $add_where = " AND L.LAND_IDX IN (" . str_replace('_', ',', $this->input->get('idxs', true)) . ") ";
        }

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
                      L.ADMIN_IDX = A.ADMIN_IDX";
        $lists_sql .= $add_where;
        $lists_sql .= "ORDER BY L.TIMESTAMP DESC, L.LAND_IDX DESC";

        $res = $this->Db_m->getList($lists_sql, 'LAND');

        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/x-msexcel; charset=utf-8");
        header("Content-Disposition: attachment; filename = 매물정보.xls");
        header("Content-Description: PHP4 Generated Data");

        echo " 
            <meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel;charset=utf-8\"> 
            <TABLE border='1'>
                <TR>
                    <TD>등록일</TD>
                    <TD>확인일</TD>                
                    <TD>매물종류</TD>
                    <TD>형태</TD>
                    <TD>지역</TD>
                    <TD>건물명</TD>
                    <TD>전화번호</TD>
                    <TD>동</TD>
                    <TD>해당층</TD>
                    <TD>호수</TD>
                    <TD>임평</TD>
                    <TD>실평</TD>
                    <TD>보증금</TD>
                    <TD>월세</TD>
                    <TD>관리비</TD>";
        $number = 'mso-number-format:"\@";'; //다운로드 서식 숫자로 인식시키기
        $date = 'mso-number-format:"yyyy-mm-dd"'; //다운로드 서식 날짜 변환

        foreach ($res as $row) {

            echo " 
                <TR>
                    <TD style='$date'>$row[INS_TIME]</TD>
                    <TD>$row[MOD_TIME]</TD>
                    <TD>$row[KIND]</TD>
                    <TD>$row[LAND_TYPE]</TD>
                    <TD>$row[ADDR]</TD>
                    <TD>$row[LAND_NAME]</TD>
                    <TD>$row[PHONE]</TD>
                    <TD>$row[DONG]</TD>
                    <TD>$row[FLOOR]</TD>
                    <TD>$row[ROOM_NUMBER]</TD>
                    <TD>$row[RENTAL_PRICE]</TD>
                    <TD>$row[RENTAL_SQUARE]</TD>
                    <TD>$row[DEPOSIT]</TD>
                    <TD>$row[MONTHLY]</TD>
                    <TD>$row[ADMINISTRATIVE_EXPENSES]</TD>
                </TR>";
        }
        echo "</TR>	
            </TABLE>";
    }

//    function downLoad() {
//        $this->load->library('s3');
//        $file = 'support_download/201702080424_04991.zip';
//        $res = S3::getObject('idisglobal-admin', $file, $_SERVER['DOCUMENT_ROOT'] . "/temp/" . 'NVR_DR-8364(D)_IDIS.zip');
//        if ($res) {
//            echo "성공";
//        } else {
//            echo "실패";
//        }
//    }
//
//    function test() {
//        $this->load->view('test');
//    }
//
//    function upLoad() {
//        $this->load->library('s3');
//        print_r($_FILES['file']);
//        $input = S3::inputFile($_FILES['file']['tmp_name']);
//        $type = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1);
//
//        if (S3::putObject($input, 'idisglobal-admin', 'support_download/test2.' . $type . '', S3::ACL_PUBLIC_READ)) {
//            echo "성공";
//        } else {
//            echo "실패";
//        }
//    }

    function buildingApiCall() {

        $exp_addr = explode(' ', $this->input->get('addr', true));
        $exp_bunji = explode('-', $exp_addr[3]);
        $sql = "SELECT 
                    CODE
                FROM 
                    COURT_CODE 
                WHERE 
                    ADDR LIKE '%" . $exp_addr[1] . ' ' . $exp_addr[2] . "%'";

        $res = $this->Db_m->getInfo($sql, 'LAND');

        if (strlen($exp_bunji[0]) < 4) {
            $add_zero = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[0]); $i++) {
                $add_zero .= '0';
            }
            $bun = $add_zero . $exp_bunji[0];
        } else if (strlen($exp_bunji[0]) == 4) {
            $bun = $exp_bunji[0];
        }

        if (strlen($exp_bunji[1]) < 4) {
            $add_zero2 = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[1]); $i++) {
                $add_zero2 .= '0';
            }
            $ji = $add_zero2 . $exp_bunji[1];
        } else if (strlen($exp_bunji[1]) == 4) {
            $ji = $exp_bunji[1];
        }
        
//        print_r($bun);
//        print_r($ji);

        $code = $res->CODE;

        $ch = curl_init();
        $url = 'http://apis.data.go.kr/1611000/BldRgstService/getBrTitleInfo'; /* URL */
        $queryParams = '?' . urlencode('ServiceKey') . '&ServiceKey=j%2F5BLvCQ7voW3i1RXwug4q5DDJrjyCfRukUTuyZ1GPBCARlxBNprr8CEza13yc46EQ5HOr6%2BeNlKhAeiIs8vSA%3D%3D'; /* Service Key */
        $queryParams .= '&' . urlencode('sigunguCd') . '=' . urlencode(substr($code, 0, 5)); /* 행정표준코드 */
        $queryParams .= '&' . urlencode('bjdongCd') . '=' . urlencode(substr($code, 5)); /* 법정동코드 */
        $queryParams .= '&' . urlencode('platGbCd') . '=' . urlencode('0'); /* 0:대지 1:산 2:블록 */
        $queryParams .= '&' . urlencode('bun') . '=' . urlencode($bun); /* 번 */
        $queryParams .= '&' . urlencode('ji') . '=' . urlencode($ji); /* 지 */
        $queryParams .= '&' . urlencode('startDate') . '=' . urlencode('20100101'); /* YYYYMMDD */
        $today = date('Ymd');
        $queryParams .= '&' . urlencode('endDate') . '=' . urlencode($today); /* YYYYMMDD */
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1'); /* 페이지당 목록 수 */
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /* 페이지번호 */


        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }

    function floorApiCall() {

        $exp_addr = explode(' ', $this->input->get('addr', true));
        $exp_bunji = explode('-', $exp_addr[3]);
        $sql = "SELECT 
                    CODE
                FROM 
                    COURT_CODE 
                WHERE 
                    ADDR LIKE '%" . $exp_addr[1] . ' ' . $exp_addr[2] . "%'";

        $res = $this->Db_m->getInfo($sql, 'LAND');

        if (strlen($exp_bunji[0]) < 4) {
            $add_zero = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[0]); $i++) {
                $add_zero .= '0';
            }
            $bun = $add_zero . $exp_bunji[0];
        } else if (strlen($exp_bunji[0]) == 4) {
            $bun = $exp_bunji[0];
        }

        if (strlen($exp_bunji[1]) < 4) {
            $add_zero2 = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[1]); $i++) {
                $add_zero2 .= '0';
            }
            $ji = $add_zero2 . $exp_bunji[1];
        } else if (strlen($exp_bunji[1]) == 4) {
            $ji = $exp_bunji[1];
        }
        
//        print_r($bun);
//        print_r($ji);

        $code = $res->CODE;

        $ch = curl_init();
        $url = 'http://apis.data.go.kr/1611000/BldRgstService/getBrFlrOulnInfo'; /* URL */
        $queryParams = '?' . urlencode('ServiceKey') . '&ServiceKey=j%2F5BLvCQ7voW3i1RXwug4q5DDJrjyCfRukUTuyZ1GPBCARlxBNprr8CEza13yc46EQ5HOr6%2BeNlKhAeiIs8vSA%3D%3D'; /* Service Key */
        $queryParams .= '&' . urlencode('sigunguCd') . '=' . urlencode(substr($code, 0, 5)); /* 행정표준코드 */
        $queryParams .= '&' . urlencode('bjdongCd') . '=' . urlencode(substr($code, 5)); /* 법정동코드 */
        $queryParams .= '&' . urlencode('platGbCd') . '=' . urlencode('0'); /* 0:대지 1:산 2:블록 */
        $queryParams .= '&' . urlencode('bun') . '=' . urlencode($bun); /* 번 */
        $queryParams .= '&' . urlencode('ji') . '=' . urlencode($ji); /* 지 */
        $queryParams .= '&' . urlencode('startDate') . '=' . urlencode('20100101'); /* YYYYMMDD */
        $today = date('Ymd');
        $queryParams .= '&' . urlencode('endDate') . '=' . urlencode($today); /* YYYYMMDD */
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('20'); /* 페이지당 목록 수 */
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /* 페이지번호 */


        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }

    function cleanApiCall() {

        $exp_addr = explode(' ', $this->input->get('addr', true));
        $exp_bunji = explode('-', $exp_addr[3]);
        $sql = "SELECT 
                    CODE
                FROM 
                    COURT_CODE 
                WHERE 
                    ADDR LIKE '%" . $exp_addr[1] . ' ' . $exp_addr[2] . "%'";

        $res = $this->Db_m->getInfo($sql, 'LAND');

        if (strlen($exp_bunji[0]) < 4) {
            $add_zero = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[0]); $i++) {
                $add_zero .= '0';
            }
            $bun = $add_zero . $exp_bunji[0];
        } else if (strlen($exp_bunji[0]) == 4) {
            $bun = $exp_bunji[0];
        }

        if (strlen($exp_bunji[1]) < 4) {
            $add_zero2 = '0';
            for ($i = 1; $i < 4 - strlen($exp_bunji[1]); $i++) {
                $add_zero2 .= '0';
            }
            $ji = $add_zero2 . $exp_bunji[1];
        } else if (strlen($exp_bunji[1]) == 4) {
            $ji = $exp_bunji[1];
        }
        
//        print_r($bun);
//        print_r($ji);

        $code = $res->CODE;

        $ch = curl_init();
        $url = 'http://apis.data.go.kr/1611000/BldRgstService/getBrWclfInfo'; /* URL */
        $queryParams = '?' . urlencode('ServiceKey') . '&ServiceKey=j%2F5BLvCQ7voW3i1RXwug4q5DDJrjyCfRukUTuyZ1GPBCARlxBNprr8CEza13yc46EQ5HOr6%2BeNlKhAeiIs8vSA%3D%3D'; /* Service Key */
        $queryParams .= '&' . urlencode('sigunguCd') . '=' . urlencode(substr($code, 0, 5)); /* 행정표준코드 */
        $queryParams .= '&' . urlencode('bjdongCd') . '=' . urlencode(substr($code, 5)); /* 법정동코드 */
        $queryParams .= '&' . urlencode('platGbCd') . '=' . urlencode('0'); /* 0:대지 1:산 2:블록 */
        $queryParams .= '&' . urlencode('bun') . '=' . urlencode($bun); /* 번 */
        $queryParams .= '&' . urlencode('ji') . '=' . urlencode($ji); /* 지 */
        $queryParams .= '&' . urlencode('startDate') . '=' . urlencode('20100101'); /* YYYYMMDD */
        $today = date('Ymd');
        $queryParams .= '&' . urlencode('endDate') . '=' . urlencode($today); /* YYYYMMDD */
        $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1'); /* 페이지당 목록 수 */
        $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /* 페이지번호 */


        curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }

}
