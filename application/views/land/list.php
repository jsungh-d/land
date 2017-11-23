<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <select class="form-control" id="search_kind" name="kind">
            <option value="ALL" <?php if ($search_kind == 'ALL') echo 'selected'; ?>>매물전체</option>
            <option value="A" <?php if ($search_kind == 'A') echo 'selected'; ?>>아파트</option>
            <option value="H" <?php if ($search_kind == 'H') echo 'selected'; ?>>주택/다가구</option>
            <option value="V" <?php if ($search_kind == 'V') echo 'selected'; ?>>빌라</option>
            <option value="R" <?php if ($search_kind == 'R') echo 'selected'; ?>>원룸/도시형</option>
            <option value="O" <?php if ($search_kind == 'O') echo 'selected'; ?>>오피스텔</option>
            <option value="W" <?php if ($search_kind == 'W') echo 'selected'; ?>>사무실</option>
            <option value="S" <?php if ($search_kind == 'S') echo 'selected'; ?>>상가점포</option>
            <option value="B" <?php if ($search_kind == 'B') echo 'selected'; ?>>상가건물(매)</option>
            <option value="P" <?php if ($search_kind == 'P') echo 'selected'; ?>>분양권</option>
            <option value="D" <?php if ($search_kind == 'D') echo 'selected'; ?>>재개발</option>
            <option value="F" <?php if ($search_kind == 'F') echo 'selected'; ?>>공장/창고</option>
            <option value="L" <?php if ($search_kind == 'L') echo 'selected'; ?>>토지</option>
        </select>
    </li>
    <li class="breadcrumb-item">
        <select class="form-control" id="search_land_type" name="land_type">
            <option value="ALL" <?php if ($search_land_type == 'ALL') echo 'selected'; ?>>전체</option>
            <option value="1" <?php if ($search_land_type == '1') echo 'selected'; ?>>매매</option>
            <option value="2" <?php if ($search_land_type == '2') echo 'selected'; ?>>전세</option>
            <option value="3" <?php if ($search_land_type == '3') echo 'selected'; ?>>월세</option>
            <option value="4" <?php if ($search_land_type == '4') echo 'selected'; ?>>단기</option>
            <option value="5" <?php if ($search_land_type == '5') echo 'selected'; ?>>전월세</option>
        </select>
    </li>
    <li class="breadcrumb-item">
        <select class="form-control" id="search_gu" name="search_gu">
            <option value="ALL">전체구</option>
            <?php foreach ($gu_lists as $row) { ?>
                <option value="<?= $row['ADDR'] ?>" <?php if ($search_gu == $row['ADDR']) echo 'selected'; ?>><?= $row['ADDR'] ?></option>
            <?php } ?>
        </select>
    </li>
    <li class="breadcrumb-item">
        <div class="input-group">
            <input class="form-control" type="text" id="addr_text" placeholder="지역" value="<?= $text ?>">
            <button class="input-group-addon" type="button" id="searchBtn">검색</button>
        </div>
    </li>
    <li class="breadcrumb-item">
        <div class="input-group">
            <input class="form-control" type="text" id="tot_text" placeholder="통합검색" value="<?= $tot_text ?>">
            <button class="input-group-addon" type="button" id="totSearchBtn">검색</button>
        </div>
    </li>
</ol>


<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-title">
                        <strong>매물 목록</strong>
                        <small>매물명을 클릭하시면 수정 가능합니다</small>
                    </div>

                    <div class="card-actions">
                        <a href="#" class="btn-setting" data-toggle="modal" data-target="#landAdd">
                            <i class="icon-plus"></i>
                            등록
                        </a>

                        <button class="btn-setting" type="button" id="copyBtn">
                            <i class="icon-plus"></i>
                            복사
                        </button>

                        <button class="btn-setting" type="button" id="delBtn">
                            <i class="icon-plus"></i>
                            삭제
                        </button>

                        <button class="btn-setting" type="button" id="excelBtn">
                            <i class="icon-plus"></i>
                            엑셀다운
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-custom land_list_table">
                        <colgroup><col width="30px"><col width="80px"><col width="80px"></colgroup>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="allChk"></th>
                                <th>등록일</th>
                                <th>확인일</th>
                                <th>매물종류</th>
                                <th>형태</th>
                                <th>지역</th>
                                <th>건물명</th>
                                <th>이미지</th>
                                <th>전화번호</th>
                                <th>동</th>
                                <th>해당층</th>
                                <th>호수</th>
                                <th>임평</th>
                                <th>실평</th>
                                <th>보증금</th>
                                <th>월세</th>
                                <th>관리비</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$lists) { ?>
                                <tr>
                                    <td colspan="21" style="text-align: center">
                                        등록사항이 없습니다.
                                    </td>
                                </tr>
                                <?php
                            } else {
                                if ($this->uri->segment(3) == 'q') {
                                    $num = $total_rows - $this->uri->segment(9);
                                    $page = $this->uri->segment(9);
                                    $gubun = $this->uri->segment(5);
                                    $title = $this->uri->segment(7);
                                } else {
                                    $num = $total_rows - $this->uri->segment(4);
                                    $page = $this->uri->segment(4);
                                    $gubun = "none";
                                    $title = "none";
                                }
                                foreach ($lists as $row) {
                                    ?>
                                    <tr class="tb_row" data-bind="<?= $row['LAND_IDX'] ?>" style="cursor: pointer">
                                        <th scope="row">
                                            <input type="checkbox" class="row_chk" value="<?= $row['LAND_IDX'] ?>">
                                        </th>
                                        <td><?= $row['INS_TIME'] ?></td>
                                        <td><?= $row['MOD_TIME'] ?></td>
                                        <td><?= $row['KIND'] ?></td>
                                        <td><?= $row['LAND_TYPE'] ?></td>
                                        <td><?= $row['ADDR'] ?></td>
                                        <td><?= $row['LAND_NAME'] ?></td>
                                        <td style="padding:0;background-image: url('<?= $row['IMG'] ?>');background-size:cover;width:70px;"></td>
                                        <td><?= $row['PHONE'] ?></td>
                                        <td><?= $row['DONG'] ?></td>
                                        <td><?= $row['FLOOR'] ?></td>
                                        <td><?= $row['ROOM_NUMBER'] ?></td>
                                        <td><?= $row['RENTAL_PRICE'] ?></td>
                                        <td><?= $row['RENTAL_SQUARE'] ?></td>
                                        <td><?= number_format($row['DEPOSIT']) ?></td>
                                        <td><?= number_format($row['MONTHLY']) ?></td>
                                        <td><?= $row['ADMINISTRATIVE_EXPENSES'] ?></td>
                                    </tr>
                                    <?php
                                    $num--;
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <?= $pagination ?>
                </div>
            </div>
        </div>

    </div><!-- end row -->
</div><!-- end container -->

<!--add Modal-->
<div class="modal fade" id="landAdd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="landAddForm" method="post" enctype="multipart/form-data" action="/index.php/dataFunction/insLand">
            <input type="hidden" name="se3" value="<?= $this->uri->segment(3) ?>">
            <input type="hidden" name="se4" value="<?= $this->uri->segment(4) ?>">
            <input type="hidden" name="se5" value="<?= $this->uri->segment(5) ?>">
            <input type="hidden" name="se6" value="<?= $this->uri->segment(6) ?>">
            <input type="hidden" name="se7" value="<?= $this->uri->segment(7) ?>">
            <input type="hidden" name="se8" value="<?= $this->uri->segment(8) ?>">
            <input type="hidden" name="se9" value="<?= $this->uri->segment(9) ?>">
            <input type="hidden" name="se10" value="<?= $this->uri->segment(10) ?>">
            <input type="hidden" name="se11" value="<?= $this->uri->segment(11) ?>">
            <?php if ($this->uri->segment(12)) { ?>
                <input type="hidden" name="se12" value="<?= $this->uri->segment(12) ?>">
            <?php } else { ?>
                <input type="hidden" name="se12" value="page">
            <?php } ?>
            <input type="hidden" name="se13" value="<?= $this->uri->segment(13) ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">매물등록</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-2 form-group">
                            <label for="kind">매물선택</label>
                            <select id="kind" name="kind" class="form-control form-control-sm kind_select">
                                <option value="A">아파트</option>
                                <option value="H">주택/다가구</option>
                                <option value="V">빌라</option>
                                <option value="R">원룸/도시형</option>
                                <option value="O">오피스텔</option>
                                <option value="W">사무실</option>
                                <option value="S">상가점포</option>
                                <option value="B">상가건물(매)</option>
                                <option value="P">분양권</option>
                                <option value="D">재개발</option>
                                <option value="F">공장/창고</option>
                                <option value="L">토지</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="type">구분</label>
                            <select id="type" class="form-control form-control-sm" name="type_idx">
                                <option value="">구분</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="land_type">형태</label>
                            <select id="land_type" class="form-control form-control-sm" name="land_type">
                                <option value="">선택</option>
                                <option value="1">매매</option>
                                <option value="2">전세</option>
                                <option value="3">월세</option>
                                <option value="4">단기</option>
                                <option value="5">전월세</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="timestamp">등록일</label>
                            <input id="timestamp" type="text" class="form-control form-control-sm" name="timestamp" value="<?= date('Y-m-d') ?>" placeholder="등록일" readonly>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="check_date">확인일</label>
                            <input id="check_date" type="text" class="form-control form-control-sm" name="check_date" value="" placeholder="확인일" disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="ad_yn">광고</label>
                            <select id="ad_yn" class="form-control form-control-sm" name="ad_yn">
                                <option value="N">OFF</option>
                                <option value="Y">ON</option>
                            </select>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="addr">주소</label>
                            <input id="addr" type="text" class="form-control form-control-sm" name="addr" placeholder="주소" onclick="openDaumPostcode();" readonly>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="mod_url">건축물대장</label><br>
                            <a href="#" id="addBuildingModalBtn" data-toggle="modal" data-target="#buildingModal">
                                <button type="button" class="btn btn-primary" style="height: 32px;">확인하기</button>
                            </a>
                            <!-- <input id="mod_url" type="url" class="form-control form-control-sm" name="url" value="" placeholder="연동URL"> -->
                        </div>

                        <!--                        <div class="form-group col-sm-4">
                                                    <label for="url">건축물대장</label>
                                                    <input id="url" type="url" class="form-control form-control-sm" name="url" value="" placeholder="연동URL">
                                                </div>-->

                        <div class="form-group col-sm-2">
                            <label for="completion_year">준공연도</label>
                            <input id="completion_year" type="text" class="form-control form-control-sm" placeholder="준공연도" name="completion_year" maxlength="준공년도 입력">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="land_name">건물명</label>
                            <input id="land_name" type="text" class="form-control form-control-sm" placeholder="건물명" name="land_name" maxlength="10">
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="building_interior_room">건물내공실</label>
                            <select id="building_interior_room" class="form-control form-control-sm" name="building_interior_room">
                                <option value="">선택</option>
                                <option value="Y">유</option>
                                <option value="N">무</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="dong">동/호수</label>
                            <div class="row">
                                <div class="col">
                                    <input id="dong" type="text" class="form-control form-control-sm" placeholder="동" name="dong" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="room_number" type="text" class="form-control form-control-sm" placeholder="호" name="room_number" maxlength="5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="floor">층/방/욕</label>

                            <div class="row">
                                <div class="col">
                                    <input id="floor" type="text" class="form-control form-control-sm" placeholder="층" name="floor" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="room" type="text" class="form-control form-control-sm" placeholder="방" name="room" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="bath" type="text" class="form-control form-control-sm" placeholder="욕" name="bath" maxlength="5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="underground">총 층</label>
                            <div class="row">
                                <div class="col">
                                    <input id="underground" type="text" class="form-control form-control-sm" placeholder="지하" name="underground" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="ground" type="text" class="form-control form-control-sm" placeholder="지상" name="ground" maxlength="5">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">

                        <div class="form-group col-sm-2">
                            <label for="price">기준가 <small>(만원)</small></label>
                            <input id="price" type="text" class="form-control form-control-sm" placeholder="기준가자동계산" disabled>
                        </div>

                        <div class="form-group col-sm-2">
                            <label id="deposit_text" for="deposit">보증금 <small>(만원)</small></label>
                            <input id="deposit" type="text" class="form-control form-control-sm add_price" pattern="[0-9]*" placeholder="만원" name="deposit" maxlength="10">
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="monthly">월세 <small>(만원)</small></label>
                            <input id="monthly" type="text" class="form-control form-control-sm add_price" pattern="[0-9]*" placeholder="만원" name="monthly" maxlength="10">
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="administrative_expenses">관리비 <small>(만원)</small></label>
                            <input id="administrative_expenses" type="text" class="form-control form-control-sm" pattern="[0-9.]*" placeholder="만원" name="administrative_expenses" maxlength="10">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="rental_price">임대/전용평수 <small>㎡</small></label>
                            <div class="row">
                                <div class="col">
                                    <input id="rental_price" type="text" class="form-control form-control-sm" placeholder="임대㎡" name="rental_price" pattern="[0-9.]*" maxlength="10">
                                </div>
                                <div class="col">
                                    <input id="unique_number" type="text" class="form-control form-control-sm" placeholder="전용㎡" name="unique_number" pattern="[0-9.]*" maxlength="10">
                                </div>
                                <div class="col">
                                    <input id="rental_area" type="text" class="form-control form-control-sm" placeholder="임대평" name="rental_square" pattern="[0-9.]*">
                                </div>
                                <div class="col">
                                    <input id="unique_area" type="text" class="form-control form-control-sm" placeholder="전용평" name="unique_square" pattern="[0-9.]*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="parking">주차</label>
                            <div class="row">
                                <div class="col">
                                    <select id="parking" class="form-control form-control-sm" name="parking">
                                        <option value="">선택</option>
                                        <option value="1">자주식</option>
                                        <option value="2">기계식</option>
                                        <option value="3">리프트</option>
                                        <option value="4">자주기계식</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="parking_cnt" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="대" name="parking_cnt" maxlength="2">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="ev_yn">EV</label>
                            <div class="row">
                                <div class="col">
                                    <select id="building_interior_room" class="form-control form-control-sm" name="ev_yn">
                                        <option value="">선택</option>
                                        <option value="Y">유</option>
                                        <option value="N">무</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="ev_cnt" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="대" name="ev_cnt" maxlength="2">
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="room_cnt">룸</label>
                            <select id="building_interior_room" class="form-control form-control-sm" name="room_cnt">
                                <option value="">선택</option>
                                <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="fees">수수료 <small>(만원)</small></label>
                            <input id="fees" type="text" class="form-control form-control-sm" pattern="[0-9.]*" placeholder="만원" name="fees" maxlength="10">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="moving_date">입주일자</label>
                            <input id="moving_date" type="text" class="form-control form-control-sm" placeholder="입주 가능일자 입력" name="moving_date" maxlength="10">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="">냉/난방 시설</label>
                            <div>
                                <div class="row">
                                    <div class="col checkbox-custom">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="1" name="air_heathing[]">중앙냉난방
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="2" name="air_heathing[]">개별냉난방
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="3" name="air_heathing[]">중앙난방
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" value="4" name="air_heathing[]">바닥난방
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="contents" name="contents" class="form-control form-control-sm" placeholder="상세정보 기입">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="tenant_phone">세입자연락처</label>
                            <input id="tenant_phone" type="text" class="form-control form-control-sm" pattern="[0-9]*" name="tenant_phone" placeholder="세입자연락처" maxlength="11">
                        </div>
                    </div>
                    <!--/.row-->

                    <!--추가정보-->
                    <div id="add_detail">
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="building_interior_room_contents">건물내공실</label>
                            <textarea id="building_interior_room_contents" class="form-control form-control-sm" name="building_interior_room_contents" placeholder="건물내공실"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="uniqueness">특이사항</label>
                            <textarea id="uniqueness" class="form-control form-control-sm" name="uniqueness" placeholder="특이사항"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="memo">상담메모</label>
                            <textarea id="memo" class="form-control form-control-sm" name="memo" placeholder="상담메모"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>임대인연락처</label>
                            <i class="icon-plus phone_add_btn" style="position:relative; top:2px"></i>
                            <div class="row rent_tel">
                                <div class="col-3 rent_num">
                                    <input type="text" class="form-control form-control-sm" placeholder="이름" name="phone_name[]">
                                    <input type="text" class="form-control form-control-sm" placeholder="연락처" name="phone[]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                </div>
                <!--/.modal body-->

                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-close"></i> 닫기</button>
                        <button type="button" class="btn btn-success"><i class="icon-plus"></i> 미디어 등록</button>
                        <button type="submit" class="btn btn-success"><i class="icon-plus"></i> 등록</button>
                        <button type="button" class="btn btn-success"><i class="icon-plus"></i> 계속등록</button>
                    </div>
                </div>
            </div>
            <!--end modal content-->

            <div class="modal_img_upload">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">사진/영상</h5>
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="video">동영상</label>
                            <input type="file" id="video" class="form-control" name="video" accept="video/*">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>이미지</label>
                            <i class="icon-plus addImgBtn" style="position: relative; top: 2px;"></i>
                            <!--                            <div class="box_img">
                                                            <div class="input-group">
                                                                <input type="file" class="form-control" name="file[]" accept="image/*">
                                                                <span class="input-group-addon addImgBtn">
                                                                     <button type="button" class="btn btn-primary addImgBtn btn-sm">추가</button>	 
                                                                    <i class="icon-plus"></i>
                                                                </span>
                                                            </div>
                                                        </div>-->
                        </div>
                    </div>
                    <!--/.row-->
                </div>
            </div>
        </form>
    </div>
</div>


<!--mod Modal-->
<div class="modal fade" id="modModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="landModForm" method="post" enctype="multipart/form-data" action="/index.php/dataFunction/modLand">
            <input type="hidden" name="se3" value="<?= $this->uri->segment(3) ?>">
            <input type="hidden" name="se4" value="<?= $this->uri->segment(4) ?>">
            <input type="hidden" name="se5" value="<?= $this->uri->segment(5) ?>">
            <input type="hidden" name="se6" value="<?= $this->uri->segment(6) ?>">
            <input type="hidden" name="se7" value="<?= $this->uri->segment(7) ?>">
            <input type="hidden" name="se8" value="<?= $this->uri->segment(8) ?>">
            <input type="hidden" name="se9" value="<?= $this->uri->segment(9) ?>">
            <input type="hidden" name="se10" value="<?= $this->uri->segment(10) ?>">
            <input type="hidden" name="se11" value="<?= $this->uri->segment(11) ?>">
            <?php if ($this->uri->segment(12)) { ?>
                <input type="hidden" name="se12" value="<?= $this->uri->segment(12) ?>">
            <?php } else { ?>
                <input type="hidden" name="se12" value="page">
            <?php } ?>
            <input type="hidden" name="se13" value="<?= $this->uri->segment(13) ?>">
            <input type="hidden" id="land_idx" name="land_idx" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">매물수정</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-2 form-group">
                            <label for="mod_kind">매물선택</label>
                            <select id="mod_kind" name="kind" class="form-control form-control-sm mod_kind_select">
                                <option value="A">아파트</option>
                                <option value="H">주택/다가구</option>
                                <option value="V">빌라</option>
                                <option value="R">원룸/도시형</option>
                                <option value="O">오피스텔</option>
                                <option value="W">사무실</option>
                                <option value="S">상가점포</option>
                                <option value="B">상가건물(매)</option>
                                <option value="P">분양권</option>
                                <option value="D">재개발</option>
                                <option value="F">공장/창고</option>
                                <option value="L">토지</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="mod_type">구분</label>
                            <select id="mod_type" class="form-control form-control-sm" name="type_idx">
                                <option value="">구분</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="mod_land_type">형태</label>
                            <select id="mod_land_type" class="form-control form-control-sm" name="land_type">
                                <option value="">선택</option>
                                <option value="1">매매</option>
                                <option value="2">전세</option>
                                <option value="3">월세</option>
                                <option value="4">단기</option>
                                <option value="5">전월세</option>
                            </select>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="mod_timestamp">등록일</label>
                            <input id="mod_timestamp" type="text" class="form-control form-control-sm " name="timestamp" value="" placeholder="등록일" style="position: relative; z-index: 100000;" readonly>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="mod_check_date">확인일</label>
                            <input id="mod_check_date" type="text" class="form-control form-control-sm" name="check_date" value="" placeholder="확인일" disabled>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="mod_ad_yn">광고</label>
                            <select id="mod_ad_yn" class="form-control form-control-sm" name="ad_yn">
                                <option value="N">OFF</option>
                                <option value="Y">ON</option>
                            </select>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="mod_addr">주소</label>
                            <input id="mod_addr" type="text" class="form-control form-control-sm" name="addr" placeholder="주소" onclick="openDaumPostcode2();" readonly>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="mod_url">건축물대장</label><br>
                            <a href="#" id="buildingModalBtn" data-toggle="modal" data-target="#buildingModal">
                                <button type="button" class="btn btn-primary" style="height: 32px;">확인하기</button>
                            </a>
                            <!-- <input id="mod_url" type="url" class="form-control form-control-sm" name="url" value="" placeholder="연동URL"> -->
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_completion_year">준공연도</label>
                            <input id="mod_completion_year" type="text" class="form-control form-control-sm" placeholder="준공연도" name="completion_year" maxlength="10">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="mod_land_name">건물명</label>
                            <input id="mod_land_name" type="text" class="form-control form-control-sm" placeholder="건물명" name="land_name" maxlength="10">
                        </div>

                        <div class="form-group col-sm-2">
                            <label class="form-control-label" for="mod_building_interior_room">건물내공실</label>
                            <select id="mod_building_interior_room" class="form-control form-control-sm" name="building_interior_room">
                                <option value="">선택</option>
                                <option value="Y">유</option>
                                <option value="N">무</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_dong">동/호수</label>
                            <div class="row">
                                <div class="col">
                                    <input id="mod_dong" type="text" class="form-control form-control-sm" placeholder="동" name="dong" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="mod_room_number" type="text" class="form-control form-control-sm" placeholder="호수" name="room_number" maxlength="5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_floor">층/방/욕</label>
                            <div class="row">
                                <div class="col">
                                    <input id="mod_floor" type="text" class="form-control form-control-sm" placeholder="층" name="floor" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="mod_room" type="text" class="form-control form-control-sm" placeholder="방" name="room" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="mod_bath" type="text" class="form-control form-control-sm" placeholder="욕" name="bath" maxlength="5">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_underground">총 층</label>
                            <div class="row">
                                <div class="col">
                                    <input id="mod_underground" type="text" class="form-control form-control-sm" placeholder="지하" name="underground" maxlength="5">
                                </div>
                                <div class="col">
                                    <input id="mod_ground" type="text" class="form-control form-control-sm" placeholder="지상" name="ground" maxlength="5">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">

                        <div class="form-group col-sm-2">
                            <label for="modPrice">기준가 <small>(만원)</small></label>
                            <input id="modPrice" type="text" class="form-control form-control-sm" placeholder="기준가자동계산" disabled>
                        </div>

                        <div class="form-group col-sm-2">
                            <label id="mod_deposit_text" for="modDeposit">보증금 <small>(만원)</small></label>
                            <input id="modDeposit" type="text" class="form-control form-control-sm mod_price" pattern="[0-9]*" placeholder="만원" name="deposit" maxlength="10">
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="modMonthly">월세 <small>(만원)</small></label>
                            <input id="modMonthly" type="text" class="form-control form-control-sm mod_price" pattern="[0-9]*" placeholder="만원" name="monthly" maxlength="10">
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_administrative_expenses">관리비 <small>(만원)</small></label>
                            <input id="mod_administrative_expenses" type="text" class="form-control form-control-sm" pattern="[0-9.]*" placeholder="만원" name="administrative_expenses" maxlength="10">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="mod_rental_price">임대/전용평수</label>
                            <div class="row">
                                <div class="col">
                                    <input id="mod_rental_price" type="text" class="form-control form-control-sm" placeholder="임대㎡" name="rental_price" pattern="[0-9.]*" maxlength="10">
                                </div>
                                <div class="col">
                                    <input id="mod_unique_number" type="text" class="form-control form-control-sm" placeholder="전용㎡" name="unique_number" pattern="[0-9.]*" maxlength="10">
                                </div>
                                <div class="col">
                                    <input id="mod_rental_area" type="text" class="form-control form-control-sm" placeholder="임대평" name="rental_square" pattern="[0-9.]*">
                                </div>
                                <div class="col">
                                    <input id="mod_unique_area" type="text" class="form-control form-control-sm" placeholder="전용평"  name="unique_square" pattern="[0-9.]*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-2">
                            <label for="mod_parking">주차</label>
                            <div class="row">
                                <div class="col">
                                    <select id="mod_parking" class="form-control form-control-sm" name="parking">
                                        <option value="">선택</option>
                                        <option value="1">자주식</option>
                                        <option value="2">기계식</option>
                                        <option value="3">리프트</option>
                                        <option value="4">자주기계식</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="mod_parking_cnt" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="대" name="parking_cnt" maxlength="2">
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <label for="mod_ev_yn">EV</label>
                            <div class="row">
                                <div class="col">
                                    <select id="mod_ev_yn" class="form-control form-control-sm" name="ev_yn">
                                        <option value="">선택</option>
                                        <option value="Y">유</option>
                                        <option value="N">무</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <input id="mod_ev_cnt" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="E/V대수" name="ev_cnt" maxlength="2">
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="mod_room_cnt">룸</label>
                            <select id="mod_room_cnt" class="form-control form-control-sm" name="room_cnt">
                                <option value="">선택</option>
                                <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-sm-2">
                            <label for="mod_fees">수수료 <small>(만원)</small></label>
                            <input id="mod_fees" type="text" class="form-control form-control-sm" pattern="[0-9.]*" placeholder="수수료" name="fees" maxlength="10">
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="mod_moving_date">입주일자</label>
                            <input id="mod_moving_date" type="text" class="form-control form-control-sm" placeholder="입주 가능일자 입력" name="moving_date" maxlength="10">
                        </div>
                    </div>
                    <!--/.row-->

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="">냉/난방 시설</label>
                            <div>
                                <div class="row">
                                    <div id="mod_air_heathing_area" class="col checkbox-custom">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="mod_contents" name="contents" class="form-control form-control-sm" placeholder="상세정보 기입">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="mod_tenant_phone">세입자연락처</label>
                            <input id="mod_tenant_phone" type="text" class="form-control form-control-sm" pattern="[0-9]*" name="tenant_phone" placeholder="세입자연락처" maxlength="11">
                        </div>
                    </div>
                    <!--/.row-->

                    <!--추가정-->
                    <div id="mod_detail">

                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="mod_building_interior_room_contents">건물내공실</label>
                            <textarea id="mod_building_interior_room_contents" class="form-control form-control-sm" name="building_interior_room_contents" placeholder="건물내공실"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="mod_uniqueness">특이사항</label>
                            <textarea id="mod_uniqueness" class="form-control form-control-sm" name="uniqueness" placeholder="특이사항"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="mod_memo">상담메모</label>
                            <textarea id="mod_memo" class="form-control form-control-sm" name="memo" placeholder="상담메모"></textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label>임대인연락처</label>
                            <i class="icon-plus phone_add_btn" style="position:relative; top:2px"></i>
                            <div id="mod_phone_area" class="row rent_tel">

                            </div>
                        </div>
                    </div>
                    <!--/.row-->
                </div>

                <div class="modal-footer">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon-close"></i> 닫기</button>
                        <button type="button" class="btn btn-success"><i class="icon-plus"></i> 미디어 등록</button>
                        <button type="submit" class="btn btn-success"><i class="icon-plus"></i> 수정</button>
                    </div>
                </div>
            </div>

            <div class="modal_img_upload">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">사진/영상</h5>
                    <button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="modVideo">동영상</label>
                            <div id="modVideoArea">
                                <input type="file" id="modVideo" class="form-control" name="video" accept="video/*">
                                <input type="hidden" id="video_location" name="video_location" value="">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>이미지</label>
                            <i class="icon-plus addImgBtn" style="position: relative; top: 2px;"></i>
                            <div id="mod_img_area">
                            </div>



                        </div>
                    </div>
                    <!--/.row-->
                </div>
            </div>
        </form>
    </div>
</div>


<!--building Modal-->
<div class="modal fade" id="buildingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 950px">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card-body row">
                    <div class="col-12">
                        <table class="table table-custom pop_table">
                            <colgroup>
                                <col width="16.6%">
                                <col width="16.6%">
                                <col width="16.6%">
                                <col width="16.6%">
                                <col width="16.6%">
                                <col width="16.6%">
                            </colgroup>
                            <thead class="drag_btn_target">
                                <tr>
                                    <th colspan="6">일반건축물</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th>대지위치</th>
                                    <td colspan="3"><span class="platPlc"></span></td>
<!--                                    <th>지번</th>
                                    <td>
                                        <span class="bun"></span> / 
                                        <span class="ji"></span>
                                    </td>-->
                                    <th>특이사항</th>
                                    <td><span class=""></span></td>
                                </tr>
                                <tr>
                                    <th>용도지역</th>
                                    <td><span class=""></span></td>
                                    <th>용도지구</th>
                                    <td><span class=""></span></td>
                                    <th>구역</th>
                                    <td><span class=""></span></td>
                                </tr>
                                <tr>
                                    <th>대지면적</th>
                                    <td><span class="platArea"></span>㎡</td>
                                    <th>연면적</th>
                                    <td><span class="totArea"></span>㎡</td>
                                    <th>명칭 및 번호</th>
                                    <td><span class="strctCd"></span></td>
                                </tr>
                                <tr>
                                    <th>건축면적</th>
                                    <td><span class="archArea"></span>㎡</td>
                                    <th>용적률 산적용 연면적</th>
                                    <td><span class=""></span>㎡</td>
                                    <th>건물수</th>
                                    <td><span class=""></span></td>
                                </tr>
                                <tr>
                                    <th>건폐율</th>
                                    <td><span class="bcRat"></span>%</td>
                                    <th>용적률</th>
                                    <td><span class="vlRat">%</span></td>
                                    <th>총호수</th>
                                    <td><span class="hhldCnt"></span>세대</td>
                                </tr>
                                <tr>
                                    <th>주용도</th>
                                    <td><span class="mainPurpsCdNm"></span></td>
                                    <th>주구조</th>
                                    <td><span class="strctCdNm"></span></td>
                                    <th>층수</th>
                                    <td>
                                        <span>지하:</span>
                                        <span class="ugrndFlrCnt"></span> / 
                                        <span>지상:</span>
                                        <span class="grndFlrCnt"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>허가일자</th>
                                    <td><span class="pmsDay"></span></td>
                                    <th>착공일자</th>
                                    <td><span class="stcnsDay"></span></td>
                                    <th>사용승인일자</th>
                                    <td><span class="useAprDay"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-8">
                        <table class="bootstrapTable table table-custom pop_table pop_none_br floorApiTarget_header">
                            <thead>
                                <tr>
                                    <th>건축물현황</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="floorApiTarget_wrapper">
                            <table class="bootstrapTable table table-custom pop_table pop_none_br floorApiTarget_table sortable">
                                <thead>
                                    <tr class="custom_tb">
                                        <th id="divSort" data-defaultsort="asc">구분</th>
                                        <th id="floorSort">층별</th>
                                        <th>구조</th>
                                        <th>용도</th>
                                        <th>연면적</th>
                                    </tr>
                                </thead>
                                <tbody class="floorApiTarget">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-4">
                        <table class="table table-custom pop_table pop_none_br">
                            <thead>
                                <tr>
                                    <th colspan="2">기타시설</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>주차장</th>
                                    <td class="totalMechCnt"></td>
                                </tr>
                                <tr>
                                    <th>승강기</th>
                                    <td class="totalElvtCnt"></td>
                                </tr>
                                <tr>
                                    <th>오수정화시설</th>
                                    <td class="modeCdNm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="/js/sortable/Contents/bootstrap-sortable.css" rel="stylesheet"/>
<script src="/js/sortable/Scripts/bootstrap-sortable.js"></script>

<!--jquery validation 플러그인-->
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.min.js"></script>
<script src="/js/messages_ko.min.js"></script>
<!--jquery validation 플러그인-->
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script type="text/javascript">
                                $(document).ready(function () {

                                    $("#buildingModal").draggable({
                                        handle: ".drag_btn_target"
                                    });

                                    var value = $("#kind").select().val();
                                    var data = {value: value};

                                    $.ajax({
                                        url: '/index.php/dataFunction/getType',
                                        type: 'post',
                                        dataType: 'text',
                                        data: data,
                                        success: function (data, status, xhr) {
                                            $("#type").html(data);
                                        }
                                    });

                                    $.post("/index.php/dataFunction/addLandLoad", data, function (data) {
                                        $("#add_detail").html(data);
                                    });

                                    $("#addr_text").keydown(function (key) {
                                        var search_kind = $("#search_kind").select().val();
                                        var search_land_type = $("#search_land_type").select().val();
                                        var search_gu = $("#search_gu").select().val();
                                        var text = $("#addr_text").val();

                                        if (!text) {
                                            text = 'none';
                                        }

                                        if (text === search_gu) {
                                            $(this).val('');
                                            return false;
                                        }

                                        if (key.keyCode == 13) {

                                            location.href = '/index/main/q/type/location/search_kind/' + search_kind + '/search_land_type/' + search_land_type + '/text/' + text + '/search_gu/' + search_gu;
                                        }
                                    });

                                    $("#tot_text").keydown(function (key) {
                                        var text = $("#tot_text").val();

                                        if (!text) {
                                            text = 'none';
                                        }

                                        if (key.keyCode == 13) {
                                            location.href = '/index/main/q/type/total/search_kind/ALL/search_land_type/ALL/text/' + text + '/search_gu/ALL';
                                        }
                                    });

                                    $("#searchBtn").click(function () {
                                        var search_kind = $("#search_kind").select().val();
                                        var search_land_type = $("#search_land_type").select().val();
                                        var search_gu = $("#search_gu").select().val();

                                        if ($("#addr_text").val() === search_gu) {
                                            $("#addr_text").val('');
                                        }

                                        var text = $("#addr_text").val();

                                        if (!text) {
                                            text = 'none';
                                        }

                                        location.href = '/index/main/q/type/location/search_kind/' + search_kind + '/search_land_type/' + search_land_type + '/text/' + text + '/search_gu/' + search_gu;
                                    });

                                    $("#totSearchBtn").click(function () {
                                        var text = $("#tot_text").val();

                                        if (!text) {
                                            text = 'none';
                                        }

                                        location.href = '/index/main/q/type/total/search_kind/ALL/search_land_type/ALL/text/' + text + '/search_gu/ALL';
                                    });

                                    $("#allChk").click(function () {
                                        if ($(this).is(":checked")) {
                                            $(".row_chk").attr('checked', true);
                                        } else {
                                            $(".row_chk").attr('checked', false);
                                        }
                                    });

                                    $("#copyBtn").click(function () {

                                        var cnt = $(".row_chk:checked").length;
                                        var check_number = "";

                                        if (cnt === 0) {
                                            alert("항목을 선택해주세요.");
                                            return false;
                                        } else {
                                            $(".row_chk:checked").each(function (index) {
                                                check_number += $(this).val() + ",";
                                            });
                                            var appNum = check_number.substr(0, check_number.length - 1);
                                            var data = {idxs: appNum};

                                            $.ajax({
                                                url: '/index.php/dataFunction/copyLand',
                                                type: 'post',
                                                dataType: 'text',
                                                data: data,
                                                success: function (data, status, xhr) {
                                                    if (data === 'SUCCESS') {
                                                        alert("복사 되었습니다.");
                                                        location.reload();
                                                    } else {
                                                        alert("데이터 처리오류!!");
                                                        return false;
                                                    }
                                                }
                                            });
                                        }
                                    });

                                    $("#delBtn").click(function () {
                                        var cnt = $(".row_chk:checked").length;
                                        var check_number = "";

                                        if (cnt === 0) {
                                            alert("항목을 선택해주세요.");
                                            return false;
                                        } else {
                                            $(".row_chk:checked").each(function (index) {
                                                check_number += $(this).val() + ",";
                                            });
                                            var appNum = check_number.substr(0, check_number.length - 1);
                                            var data = {idxs: appNum};

                                            var f = confirm("매물을 삭제하시겠습니까?");
                                            if (f) {
                                                $.ajax({
                                                    url: '/index.php/dataFunction/delLand',
                                                    type: 'post',
                                                    dataType: 'text',
                                                    data: data,
                                                    success: function (data, status, xhr) {
                                                        if (data === 'SUCCESS') {
                                                            alert("삭제 되었습니다.");
                                                            location.reload();
                                                        } else {
                                                            alert("데이터 처리오류!!");
                                                            return false;
                                                        }
                                                    }
                                                });
                                            } else {
                                                return false;
                                            }
                                        }
                                    });

                                    $("#excelBtn").click(function () {

                                        var cnt = $(".row_chk:checked").length;
                                        var check_number = "";

                                        if (cnt === 0) {
                                            location.href = '/index.php/dataFunction/excelDown';
                                        } else {
                                            $(".row_chk:checked").each(function (index) {
                                                check_number += $(this).val() + "_";
                                            });
                                            var appNum = check_number.substr(0, check_number.length - 1);

                                            location.href = '/index.php/dataFunction/excelDown?idxs=' + appNum + '';
                                        }
                                    });

                                    $(".phone_add_btn").click(function () {
                                        var html = '<div class="col-3 rent_num"><input type="text" class="form-control form-control-sm" placeholder="이름" name="phone_name[]"><input type="text" class="form-control form-control-sm" placeholder="연락처" name="phone[]" required><i class="icon-close del_phone_btn"></i></div>';
                                        $(this).parent().children('div').eq(0).append(html);
                                        $(".del_phone_btn").click(function () {
                                            $(this).parent().remove();
                                        });
                                    });

                                    $(".add_price").keyup(function () {
                                        var monthly = parseInt($.trim($("#monthly").val()));
                                        var deposit = $("#deposit").val();
                                        if (!$.trim(deposit)) {
                                            deposit = 0;
                                        }

                                        var price = (monthly * parseInt(100)) + parseInt(deposit);
                                        if (!$.trim($("#monthly").val())) {
                                            price = '';
                                        }
                                        $("#price").val(price);
                                    });

                                    $(".mod_price").keyup(function () {
                                        var monthly = parseInt($.trim($("#modMonthly").val()));
                                        var deposit = $("#modDeposit").val();
                                        if (!$.trim(deposit)) {
                                            deposit = 0;
                                        }

                                        var price = (monthly * parseInt(100)) + parseInt(deposit);
                                        if (!$.trim($("#modMonthly").val())) {
                                            price = '';
                                        }
                                        $("#modPrice").val(price);
                                    });

                                    $("#rental_price").keyup(function () {
                                        var rental_price = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = rental_price * parseFloat(0.3025);
                                            $("#rental_area").val(value.toFixed(2));
                                        } else {
                                            $("#rental_area").val('');
                                        }
                                    });

                                    $("#rental_area").keyup(function () {
                                        var rental_square = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = rental_square / parseFloat(0.3025);
                                            $("#rental_price").val(value.toFixed(2));
                                        } else {
                                            $("#rental_price").val('');
                                        }
                                    });

                                    $("#unique_number").keyup(function () {
                                        var unique_number = parseFloat($.trim($(this).val()));

                                        if ($.trim($(this).val())) {
                                            var value = unique_number * parseFloat(0.3025);
                                            $("#unique_area").val(value.toFixed(2));
                                        } else {
                                            $("#unique_area").val('');
                                        }
                                    });

                                    $("#unique_area").keyup(function () {
                                        var unique_square = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = unique_square / parseFloat(0.3025);
                                            $("#unique_number").val(value.toFixed(2));
                                        } else {
                                            $("#unique_number").val('');
                                        }
                                    });

                                    $("#mod_rental_price").keyup(function () {
                                        var rental_price = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = rental_price * parseFloat(0.3025);
                                            $("#mod_rental_area").val(value.toFixed(2));
                                        } else {
                                            $("#mod_rental_area").val('');
                                        }
                                    });

                                    $("#mod_rental_area").keyup(function () {
                                        var rental_square = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = rental_square / parseFloat(0.3025);
                                            $("#mod_rental_price").val(value.toFixed(2));
                                        } else {
                                            $("#mod_rental_price").val('');
                                        }
                                    });

                                    $("#mod_unique_number").keyup(function () {
                                        var unique_number = parseFloat($.trim($(this).val()));

                                        if ($.trim($(this).val())) {
                                            var value = unique_number * parseFloat(0.3025);
                                            $("#mod_unique_area").val(value.toFixed(2));
                                        } else {
                                            $("#mod_unique_area").val('');
                                        }
                                    });

                                    $("#mod_unique_area").keyup(function () {
                                        var unique_square = parseFloat($.trim($(this).val()));
                                        if ($.trim($(this).val())) {
                                            var value = unique_square / parseFloat(0.3025);
                                            $("#mod_unique_number").val(value.toFixed(2));
                                        } else {
                                            $("#mod_unique_number").val('');
                                        }
                                    });

                                    $(".kind_select").change(function () {
                                        var value = $(this).select().val();
                                        var data = {value: value};

                                        $.ajax({
                                            url: '/index.php/dataFunction/getType',
                                            type: 'post',
                                            dataType: 'text',
                                            data: data,
                                            success: function (data, status, xhr) {
                                                $("#type").html(data);
                                            }
                                        });


                                        $.post("/index.php/dataFunction/addLandLoad", data, function (data) {
                                            $("#add_detail").html(data);
                                        });
                                    });

                                    $(".mod_kind_select").change(function () {
                                        var value = $(this).select().val();
                                        var data = {value: value};

                                        $.ajax({
                                            url: '/index.php/dataFunction/getType',
                                            type: 'post',
                                            dataType: 'text',
                                            data: data,
                                            success: function (data, status, xhr) {
                                                $("#type").html(data);
                                            }
                                        });


                                        $.post("/index.php/dataFunction/addLandLoad", data, function (data) {
                                            $("#mod_detail").html(data);
                                        });
                                    });

                                    $("#land_type").change(function () {
                                        var value = $(this).select().val();

                                        if (value === '1' || value === '2') {
                                            $("#deposit_text").html("금액");
                                            $("#deposit").prop("placeholder", '금액');
                                        } else {
                                            $("#deposit_text").html("보증금");
                                            $("#deposit").prop("placeholder", '보증금');
                                        }
                                    });

                                    $("#mod_land_type").change(function () {
                                        var value = $(this).select().val();

                                        if (value === '1' || value === '2') {
                                            $("#mod_deposit_text").html("금액");
                                            $("#modDeposit").prop("placeholder", '금액');
                                        } else {
                                            $("#mod_deposit_text").html("보증금");
                                            $("#modDeposit").prop("placeholder", '보증금');
                                        }
                                    });

                                    $(".datepicker").datepicker({
                                        dateFormat: "yy-mm-dd",
                                        showMonthAfterYear: true, // 월, 년순의 셀렉트 박스를 년,월 순으로 바꿔준다. 
                                        dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'],
                                        yearRange: '1950:2017',
                                        changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
                                        changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
                                        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                                        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                                        defaultDate: new Date(1970, 00, 01)
                                    });

                                    $(".datepicker").keydown(function (event) {
                                        event.preventDefault();
                                    });

                                    $(".addImgBtn").click(function () {
                                        var idx = $(this).index('.addImgBtn');
                                        if (idx == 0) {
                                            $(this).parent().parent().parent().append('<div class="box_img"><div class="input-group "><input type="file" class="form-control add_img" name="file[]" accept="image/*"><span class="input-group-addon delImgBtn"><i class="icon-close"></i></span></div><img class="add_img_prev" src="#" alt="이미지 미리보기" /></div>');
                                        } else {
                                            $(this).parent().parent().parent().append('<div class="box_img"><div class="input-group "><input type="file" class="form-control mod_img" name="file[]" accept="image/*"><span class="input-group-addon delImgBtn"><i class="icon-close"></i></span></div><img class="mod_img_prev" src="#" alt="이미지 미리보기" /></div>');
                                        }
                                        $(".delImgBtn").click(function () {
                                            $(this).parent().parent().remove();
                                        });

                                        $(".add_img").change(function () {
                                            var index = $(this).index('.add_img');
                                            readURL(this, index);
                                        });

                                        $(".mod_img").change(function () {
                                            var index = $(this).index('.mod_img');
                                            readURL2(this, index);
                                        });
                                    });

                                    $('#landAddForm').validate({
                                        debug: true,
                                        errorClass: 'is-invalid',
                                        validClass: 'is-valid',
                                        errorElement: 'div',
                                        errorPlacement: function (error, element) {
                                            if (element.attr('type') == 'file') {
                                                error.appendTo(element.parent().parent());
                                            } else {
                                                error.appendTo(element.parent());
                                            }
                                        },
                                        //validation이 끝난 이후의 submit 직전 추가 작업할 부분
                                        submitHandler: function (form) {
                                            var f = confirm("매물을 등록하시겠습니까?");
                                            if (f) {
                                                form.submit();
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        },
                                        rules: {
//                                            land_name: {
//                                                required: true
//                                            },
                                            addr: {
                                                required: true
                                            },
                                            land_type: {
                                                required: true
                                            },
                                            'file[]': {
                                                required: true
                                            }
                                        },
                                        //규칙체크 실패시 출력될 메시지
                                        messages: {
//                                            land_name: {
//                                                required: "명칭을 입력해주세요."
//                                            },
                                            addr: {
                                                required: "주소를 입력해주세요."
                                            },
                                            land_type: {
                                                required: "매물형태를 선택해주세요."
                                            },
                                            'file[]': {
                                                required: "이미지를 선택해주세요."

                                            }
                                        }
                                    });

                                    $('#landModForm').validate({
                                        debug: true,
                                        errorClass: 'is-invalid',
                                        validClass: 'is-valid',
                                        errorElement: 'div',
                                        errorPlacement: function (error, element) {
                                            if (element.attr('type') == 'file') {
                                                error.appendTo(element.parent().parent());
                                            } else {
                                                error.appendTo(element.parent());
                                            }
                                        },
                                        //validation이 끝난 이후의 submit 직전 추가 작업할 부분
                                        submitHandler: function (form) {
                                            var f = confirm("매물을 수정하시겠습니까?");
                                            if (f) {
                                                form.submit();
                                                return true;
                                            } else {
                                                return false;
                                            }
                                        },
                                        rules: {
//                                            land_name: {
//                                                required: true
//                                            },
                                            addr: {
                                                required: true
                                            },
                                            land_type: {
                                                required: true
                                            },
                                            'file[]': {
                                                required: true
                                            }
                                        },
                                        //규칙체크 실패시 출력될 메시지
                                        messages: {
//                                            land_name: {
//                                                required: "명칭을 입력해주세요."
//                                            },
                                            addr: {
                                                required: "주소를 입력해주세요."
                                            },
                                            land_type: {
                                                required: "매물형태를 선택해주세요."
                                            },
                                            'file[]': {
                                                required: "이미지를 선택해주세요."

                                            }
                                        }
                                    });

                                    $(".tb_row").find('td').click(function () {
                                        var idx = $(this).parent().attr('data-bind');
                                        var data = {idx: idx};
                                        $.ajax({
                                            url: '/index.php/dataFunction/getLandInfo',
                                            type: 'post',
                                            dataType: 'json',
                                            data: data,
                                            success: function (data, status, xhr) {
                                                if (data['RESULT'] === 'SUCCESS') {
                                                    $("#land_idx").val(data['LAND_IDX']);

                                                    $("#mod_detail").html(data['PAGE']);

                                                    $("#mod_kind").select().val(data['KIND']);

                                                    var type = data['TYPE'];
                                                    $.ajax({
                                                        url: '/index.php/dataFunction/getType',
                                                        type: 'post',
                                                        dataType: 'text',
                                                        data: {value: data['KIND']},
                                                        success: function (data, status, xhr) {
                                                            $("#mod_type").prop('disabled', false);
                                                            $("#mod_type").html(data);
                                                            $("#mod_type").select().val(type);
                                                        }
                                                    });

                                                    $("#mod_land_type").select().val(data['LAND_TYPE']);

                                                    if (data['KIND'] !== 'B') {
                                                        if (data['LAND_TYPE'] === '1' || data['LAND_TYPE'] === '2') {
                                                            $("#mod_deposit_text").html("금액");
                                                            $("#modDeposit").prop("placeholder", '금액');
                                                        } else {
                                                            $("#mod_deposit_text").html("보증금");
                                                            $("#modDeposit").prop("placeholder", '보증금');
                                                        }
                                                    }

                                                    $("#mod_timestamp").val(data['TIMESTAMP']);
                                                    $("#mod_url").val(data['URL']);
                                                    $("#mod_addr").val(data['ADDR']);
                                                    $("#mod_completion_year").val(data['COMPLETION_YEAR']);
                                                    $("#mod_check_date").val(data['CHECK_DATE']);
                                                    $("#mod_ad_yn").select().val(data['AD_YN']);
                                                    $("#mod_land_name").val(data['NAME']);
                                                    $("#mod_dong").val(data['DONG']);
                                                    $("#mod_room_number").val(data['ROOM_NUMBER']);
                                                    $("#mod_building_interior_room").select().val(data['BUILDING_INTERIOR_ROOM']);
                                                    $("#mod_rental_price").val(data['RENTAL_PRICE']);
                                                    $("#mod_unique_number").val(data['UNIQUE_NUMBER']);
                                                    $("#mod_rental_area").val(data['RENTAL_SQUARE']);
                                                    $("#mod_unique_area").val(data['UNIQUE_SQUARE']);
                                                    $("#mod_floor").val(data['FLOOR']);
                                                    $("#mod_room").val(data['ROOM']);
                                                    $("#mod_bath").val(data['BATH']);
                                                    $("#mod_underground").val(data['UNDERGROUND']);
                                                    $("#mod_ground").val(data['GROUND']);
                                                    $("#modDeposit").val(data['DEPOSIT']);
                                                    $("#modMonthly").val(data['MONTHLY']);

                                                    var monthly = parseInt($.trim($("#modMonthly").val()));
                                                    var deposit = $("#modDeposit").val();
                                                    if (!$.trim(deposit)) {
                                                        deposit = 0;
                                                    }

                                                    var price = (monthly * parseInt(100)) + parseInt(deposit);
                                                    if (!$.trim($("#modMonthly").val())) {
                                                        price = '';
                                                    }
                                                    $("#modPrice").val(price);

                                                    $("#mod_administrative_expenses").val(data['ADMINISTRATIVE_EXPENSES']);
                                                    $("#mod_parking").select().val(data['PARKING']);
                                                    $("#mod_parking_cnt").val(data['PARKING_CNT']);
                                                    $("#mod_ev_yn").select().val(data['EV_YN']);
                                                    $("#mod_ev_cnt").val(data['EV_CNT']);
                                                    $("#mod_room_cnt").select().val(data['ROOM_CNT']);
                                                    $("#mod_fees").val(data['FEES']);
                                                    $("#mod_moving_date").val(data['MOVING_DATE']);
                                                    $("#mod_air_heathing_area").html(data['AIR_HEATHING']);
                                                    $("#mod_contents").val(data['CONTENTS']);
                                                    $("#mod_tenant_phone").val(data['TENANT_PHONE']);
                                                    $("#mod_building_interior_room_contents").val(data['BUILDING_INTERIOR_ROOM_CONTENTS']);
                                                    $("#mod_uniqueness").val(data['UNIQUENESS']);
                                                    $("#mod_memo").val(data['MEMO']);
                                                    $("#mod_phone_area").html(data['PHONE']);
                                                    $("#mod_img_area").html(data['IMG']);

                                                    if (data['VIDEO']) {
                                                        $("#modVideo").remove();
                                                        $("#video_location").val(data['VIDEO']);
                                                    } else {
                                                        $("#video_location").val("");
                                                    }

                                                    $(".modImgBtn").click(function () {
                                                        var html = '<input type="file" class="form-control mod_img" name="file[]" accept="image/*"><img class="mod_img_prev" src="#" alt="이미지 미리보기" />';
                                                        $(this).parent().find('input[type="hidden"]').remove();
                                                        $(this).parent().find('img').remove();
                                                        $(this).parent().prepend(html);
                                                        $(this).remove();

                                                        $(".mod_img").change(function () {
                                                            var index = $(this).index('.mod_img');
                                                            readURL2(this, index);
                                                        });

                                                    });

                                                    $(".modDelImgBtn").click(function () {
                                                        $(this).parent().parent().remove();
//                                                        if ($(".modDelImgBtn").length == 0) {
//                                                            var html = '<input type="file" class="form-control" name="file[]" accept="image/*">';
//                                                            $("#mod_img_area").prepend(html);
//                                                        }
                                                    });

                                                    $(".del_phone_btn").click(function () {
                                                        $(this).parent().remove();
                                                    });

                                                    $("#modModal").modal();
                                                } else {
                                                    alert("데이터 처리오류!!");
                                                    return false;
                                                }
                                            }
                                        });
                                    });

                                    $("#buildingModalBtn").click(function () {
                                        if (!$.trim($("#mod_addr").val())) {
                                            alert("주소를 입력해주세요.");
                                            return false;
                                        }
                                        var data = {addr: $("#mod_addr").val()};
                                        $.ajax({
                                            url: '/index.php/dataFunction/buildingApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("item");
                                                $(".mainPurpsCdNm").text($(xmlData).find("mainPurpsCdNm").text());
                                                $(".etcPurps").text($(xmlData).find("etcPurps").text());
                                                $(".roofCd").text($(xmlData).find("roofCd").text());
                                                $(".roofCdNm").text($(xmlData).find("roofCdNm").text());
                                                $(".etcRoof").text($(xmlData).find("etcRoof").text());
                                                $(".hhldCnt").text($(xmlData).find("hhldCnt").text());
                                                $(".fmlyCnt").text($(xmlData).find("fmlyCnt").text());
                                                $(".heit").text($(xmlData).find("heit").text());
                                                $(".grndFlrCnt").text($(xmlData).find("grndFlrCnt").text());
                                                $(".ugrndFlrCnt").text($(xmlData).find("ugrndFlrCnt").text());
                                                $(".rideUseElvtCnt").text($(xmlData).find("rideUseElvtCnt").text());
                                                $(".emgenUseElvtCnt").text($(xmlData).find("emgenUseElvtCnt").text());
                                                $(".atchBldCnt").text($(xmlData).find("atchBldCnt").text());
                                                $(".atchBldArea").text($(xmlData).find("atchBldArea").text());
                                                $(".totDongTotArea").text($(xmlData).find("totDongTotArea").text());
                                                $(".indrMechUtcnt").text($(xmlData).find("indrMechUtcnt").text());
                                                $(".indrMechArea").text($(xmlData).find("indrMechArea").text());
                                                $(".oudrMechUtcnt").text($(xmlData).find("oudrMechUtcnt").text());
                                                $(".oudrMechArea").text($(xmlData).find("oudrMechArea").text());
                                                $(".indrAutoUtcnt").text($(xmlData).find("indrAutoUtcnt").text());
                                                $(".indrAutoArea").text($(xmlData).find("indrAutoArea").text());
                                                $(".oudrAutoUtcnt").text($(xmlData).find("oudrAutoUtcnt").text());
                                                $(".oudrAutoArea").text($(xmlData).find("oudrAutoArea").text());
                                                var text = $(xmlData).find("pmsDay").text();
                                                var year = text.substr(0,4);
                                                var month = text.substr(4,2);
                                                var day = text.substr(6,2);
                                                $(".pmsDay").text(year + '-' + month + '-' + day);
                                                
                                                text = $(xmlData).find("stcnsDay").text();
                                                year = text.substr(0,4);
                                                month = text.substr(4,2);
                                                day = text.substr(6,2);
                                                $(".stcnsDay").text(year + '-' + month + '-' + day);
                                                
                                                text = $(xmlData).find("useAprDay").text();
                                                year = text.substr(0,4);
                                                month = text.substr(4,2);
                                                day = text.substr(6,2);
                                                $(".useAprDay").text(year + '-' + month + '-' + day);
                                                
                                                $(".pmsnoYear").text($(xmlData).find("pmsnoYear").text());
                                                $(".pmsnoKikCd").text($(xmlData).find("pmsnoKikCd").text());
                                                $(".pmsnoKikCdNm").text($(xmlData).find("pmsnoKikCdNm").text());
                                                $(".pmsnoGbCd").text($(xmlData).find("pmsnoGbCd").text());
                                                $(".pmsnoGbCdNm").text($(xmlData).find("pmsnoGbCdNm").text());
                                                $(".hoCnt").text($(xmlData).find("hoCnt").text());
                                                $(".engrGrade").text($(xmlData).find("engrGrade").text());
                                                $(".engrRat").text($(xmlData).find("engrRat").text());
                                                $(".engrEpi").text($(xmlData).find("engrEpi").text());
                                                $(".gnBldGrade").text($(xmlData).find("gnBldGrade").text());
                                                $(".gnBldCert").text($(xmlData).find("gnBldCert").text());
                                                $(".itgBldGrade").text($(xmlData).find("itgBldGrade").text());
                                                $(".itgBldCert").text($(xmlData).find("itgBldCert").text());
                                                $(".crtnDay").text($(xmlData).find("crtnDay").text());
                                                $(".rnum").text($(xmlData).find("rnum").text());
                                                $(".platPlc").text($(xmlData).find("platPlc").text());
                                                $(".sigunguCd").text($(xmlData).find("sigunguCd").text());
                                                $(".bjdongCd").text($(xmlData).find("bjdongCd").text());
                                                $(".platGbCd").text($(xmlData).find("platGbCd").text());
                                                $(".bun").text($(xmlData).find("bun").text());
                                                $(".ji").text($(xmlData).find("ji").text());
                                                $(".mgmBldrgstPk").text($(xmlData).find("mgmBldrgstPk").text());
                                                $(".regstrGbCd").text($(xmlData).find("regstrGbCd").text());
                                                $(".regstrGbCdNm").text($(xmlData).find("regstrGbCdNm").text());
                                                $(".regstrKindCd").text($(xmlData).find("regstrKindCd").text());
                                                $(".regstrKindCdNm").text($(xmlData).find("regstrKindCdNm").text());
                                                $(".newPlatPlc").text($(xmlData).find("newPlatPlc").text());
                                                $(".bldNm").text($(xmlData).find("bldNm").text());
                                                $(".splotNm").text($(xmlData).find("splotNm").text());
                                                $(".block").text($(xmlData).find("block").text());
                                                $(".lot").text($(xmlData).find("lot").text());
                                                $(".bylotCnt").text($(xmlData).find("bylotCnt").text());
                                                $(".naRoadCd").text($(xmlData).find("naRoadCd").text());
                                                $(".naBjdongCd").text($(xmlData).find("naBjdongCd").text());
                                                $(".naUgrndCd").text($(xmlData).find("naUgrndCd").text());
                                                $(".naMainBun").text($(xmlData).find("naMainBun").text());
                                                $(".naSubBun").text($(xmlData).find("naSubBun").text());
                                                $(".dongNm").text($(xmlData).find("dongNm").text());
                                                $(".mainAtchGbCd").text($(xmlData).find("mainAtchGbCd").text());
                                                $(".mainAtchGbCdNm").text($(xmlData).find("mainAtchGbCdNm").text());
                                                $(".platArea").text($(xmlData).find("platArea").text());
                                                $(".archArea").text($(xmlData).find("archArea").text());
                                                $(".bcRat").text($(xmlData).find("bcRat").text());
                                                $(".totArea").text($(xmlData).find("totArea").text());
                                                $(".vlRatEstmTotArea").text($(xmlData).find("vlRatEstmTotArea").text());
                                                $(".vlRat").text($(xmlData).find("vlRat").text());
                                                $(".strctCd").text($(xmlData).find("strctCd").text());
                                                $(".strctCdNm").text($(xmlData).find("strctCdNm").text());
                                                $(".etcStrct").text($(xmlData).find("etcStrct").text());
                                                $(".mainPurpsCd").text($(xmlData).find("mainPurpsCd").text());

                                                // 주차장 ( 옥내기계식대수 + 옥외기계식대수 + 옥내자주식대수 + 옥외자주식대수 )
                                                var totalMechCnt = parseInt($(xmlData).find("indrMechUtcnt").text()) + parseInt($(xmlData).find("oudrMechUtcnt").text()) + parseInt($(xmlData).find("indrAutoUtcnt").text()) + parseInt($(xmlData).find("oudrAutoUtcnt").text());

                                                $(".totalMechCnt").text("총 " + totalMechCnt + " 대");

                                                // 승강기 ( 승용승강기수 + 비상용승강기수 )
                                                var totalElvtCnt = parseInt($(xmlData).find("rideUseElvtCnt").text()) + parseInt($(xmlData).find("emgenUseElvtCnt").text());

                                                $(".totalElvtCnt").text("총 " + totalElvtCnt + " 대");
                                            }
                                        });

                                        $.ajax({
                                            url: '/index.php/dataFunction/floorApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("items").eq(0).find("item");
                                                $(".floorApiTarget").empty();
                                                $(xmlData).each(function (index, element) {
                                                    var tr = $("<tr/>");
                                                    
                                                    var addText = "";
                                                    if($(xmlData).eq(index).find("flrGbCdNm").text() == "옥탑"){
                                                     addText = 2;
                                                    }else if($(xmlData).eq(index).find("flrGbCdNm").text() == "지상"){
                                                     addText = 1;   
                                                    }else if($(xmlData).eq(index).find("flrGbCdNm").text() == "지하"){
                                                      addText = 0;  
                                                    }
                                                    
                                                    $("<td/>").addClass("text-center").attr("data-value", addText + $(xmlData).eq(index).find("flrGbCdNm").text()).text($(xmlData).eq(index).find("flrGbCdNm").text()).appendTo(tr);
                                                    $("<td/>").addClass("text-center").attr("data-value", $(xmlData).eq(index).find("flrNoNm").text()).text($(xmlData).eq(index).find("flrNoNm").text()).appendTo(tr);
                                                    $("<td/>").attr("data-value", $(xmlData).eq(index).find("strctCdNm").text()).text($(xmlData).eq(index).find("strctCdNm").text()).appendTo(tr);
                                                    $("<td/>").attr("data-value", $(xmlData).eq(index).find("etcPurps").text()).text($(xmlData).eq(index).find("etcPurps").text()).appendTo(tr);
                                                    // $("<td/>").text($(xmlData).eq(index).find("area").text()).appendTo(tr);

                                                    var textA = $(xmlData).eq(index).text();
                                                    var textB = textA.split($(xmlData).eq(index).find("bjdongCd").text());
                                                    var textC = textB[0];
                                                    var textD = textC.split(".");

                                                    if (textD[1]) {
                                                        if (textD[1].substring(textD.length, textD.length + 1) == "0") {
                                                            textC = textC.substring(0, textC.length - 1);
                                                        }
                                                    }

                                                    $("<td/>").attr("data-value", textC).text(textC + "㎡").appendTo(tr);

                                                    $(".floorApiTarget").append(tr);

                                                    $("#floorSort").trigger("click");
                                                    $("#divSort").trigger("click");
                                                });
                                            }
                                        });


                                        $.ajax({
                                            url: '/index.php/dataFunction/cleanApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("items").eq(0).find("item");
                                                $(".modeCdNm").text($(xmlData).find("modeCdNm").text());
                                            }
                                        });

                                    });

                                    $("#addBuildingModalBtn").click(function () {
                                        if (!$.trim($("#addr").val())) {
                                            alert("주소를 입력해주세요.");
                                            return false;
                                        }
                                        var data = {addr: $("#addr").val()};
                                        $.ajax({
                                            url: '/index.php/dataFunction/buildingApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("item");
                                                $(".mainPurpsCdNm").text($(xmlData).find("mainPurpsCdNm").text());
                                                $(".etcPurps").text($(xmlData).find("etcPurps").text());
                                                $(".roofCd").text($(xmlData).find("roofCd").text());
                                                $(".roofCdNm").text($(xmlData).find("roofCdNm").text());
                                                $(".etcRoof").text($(xmlData).find("etcRoof").text());
                                                $(".hhldCnt").text($(xmlData).find("hhldCnt").text());
                                                $(".fmlyCnt").text($(xmlData).find("fmlyCnt").text());
                                                $(".heit").text($(xmlData).find("heit").text());
                                                $(".grndFlrCnt").text($(xmlData).find("grndFlrCnt").text());
                                                $(".ugrndFlrCnt").text($(xmlData).find("ugrndFlrCnt").text());
                                                $(".rideUseElvtCnt").text($(xmlData).find("rideUseElvtCnt").text());
                                                $(".emgenUseElvtCnt").text($(xmlData).find("emgenUseElvtCnt").text());
                                                $(".atchBldCnt").text($(xmlData).find("atchBldCnt").text());
                                                $(".atchBldArea").text($(xmlData).find("atchBldArea").text());
                                                $(".totDongTotArea").text($(xmlData).find("totDongTotArea").text());
                                                $(".indrMechUtcnt").text($(xmlData).find("indrMechUtcnt").text());
                                                $(".indrMechArea").text($(xmlData).find("indrMechArea").text());
                                                $(".oudrMechUtcnt").text($(xmlData).find("oudrMechUtcnt").text());
                                                $(".oudrMechArea").text($(xmlData).find("oudrMechArea").text());
                                                $(".indrAutoUtcnt").text($(xmlData).find("indrAutoUtcnt").text());
                                                $(".indrAutoArea").text($(xmlData).find("indrAutoArea").text());
                                                $(".oudrAutoUtcnt").text($(xmlData).find("oudrAutoUtcnt").text());
                                                $(".oudrAutoArea").text($(xmlData).find("oudrAutoArea").text());
                                                $(".pmsDay").text($(xmlData).find("pmsDay").text());
                                                $(".stcnsDay").text($(xmlData).find("stcnsDay").text());
                                                $(".useAprDay").text($(xmlData).find("useAprDay").text());
                                                $(".pmsnoYear").text($(xmlData).find("pmsnoYear").text());
                                                $(".pmsnoKikCd").text($(xmlData).find("pmsnoKikCd").text());
                                                $(".pmsnoKikCdNm").text($(xmlData).find("pmsnoKikCdNm").text());
                                                $(".pmsnoGbCd").text($(xmlData).find("pmsnoGbCd").text());
                                                $(".pmsnoGbCdNm").text($(xmlData).find("pmsnoGbCdNm").text());
                                                $(".hoCnt").text($(xmlData).find("hoCnt").text());
                                                $(".engrGrade").text($(xmlData).find("engrGrade").text());
                                                $(".engrRat").text($(xmlData).find("engrRat").text());
                                                $(".engrEpi").text($(xmlData).find("engrEpi").text());
                                                $(".gnBldGrade").text($(xmlData).find("gnBldGrade").text());
                                                $(".gnBldCert").text($(xmlData).find("gnBldCert").text());
                                                $(".itgBldGrade").text($(xmlData).find("itgBldGrade").text());
                                                $(".itgBldCert").text($(xmlData).find("itgBldCert").text());
                                                $(".crtnDay").text($(xmlData).find("crtnDay").text());
                                                $(".rnum").text($(xmlData).find("rnum").text());
                                                $(".platPlc").text($(xmlData).find("platPlc").text());
                                                $(".sigunguCd").text($(xmlData).find("sigunguCd").text());
                                                $(".bjdongCd").text($(xmlData).find("bjdongCd").text());
                                                $(".platGbCd").text($(xmlData).find("platGbCd").text());
                                                $(".bun").text($(xmlData).find("bun").text());
                                                $(".ji").text($(xmlData).find("ji").text());
                                                $(".mgmBldrgstPk").text($(xmlData).find("mgmBldrgstPk").text());
                                                $(".regstrGbCd").text($(xmlData).find("regstrGbCd").text());
                                                $(".regstrGbCdNm").text($(xmlData).find("regstrGbCdNm").text());
                                                $(".regstrKindCd").text($(xmlData).find("regstrKindCd").text());
                                                $(".regstrKindCdNm").text($(xmlData).find("regstrKindCdNm").text());
                                                $(".newPlatPlc").text($(xmlData).find("newPlatPlc").text());
                                                $(".bldNm").text($(xmlData).find("bldNm").text());
                                                $(".splotNm").text($(xmlData).find("splotNm").text());
                                                $(".block").text($(xmlData).find("block").text());
                                                $(".lot").text($(xmlData).find("lot").text());
                                                $(".bylotCnt").text($(xmlData).find("bylotCnt").text());
                                                $(".naRoadCd").text($(xmlData).find("naRoadCd").text());
                                                $(".naBjdongCd").text($(xmlData).find("naBjdongCd").text());
                                                $(".naUgrndCd").text($(xmlData).find("naUgrndCd").text());
                                                $(".naMainBun").text($(xmlData).find("naMainBun").text());
                                                $(".naSubBun").text($(xmlData).find("naSubBun").text());
                                                $(".dongNm").text($(xmlData).find("dongNm").text());
                                                $(".mainAtchGbCd").text($(xmlData).find("mainAtchGbCd").text());
                                                $(".mainAtchGbCdNm").text($(xmlData).find("mainAtchGbCdNm").text());
                                                $(".platArea").text($(xmlData).find("platArea").text());
                                                $(".archArea").text($(xmlData).find("archArea").text());
                                                $(".bcRat").text($(xmlData).find("bcRat").text());
                                                $(".totArea").text($(xmlData).find("totArea").text());
                                                $(".vlRatEstmTotArea").text($(xmlData).find("vlRatEstmTotArea").text());
                                                $(".vlRat").text($(xmlData).find("vlRat").text());
                                                $(".strctCd").text($(xmlData).find("strctCd").text());
                                                $(".strctCdNm").text($(xmlData).find("strctCdNm").text());
                                                $(".etcStrct").text($(xmlData).find("etcStrct").text());
                                                $(".mainPurpsCd").text($(xmlData).find("mainPurpsCd").text());

                                                // 주차장 ( 옥내기계식대수 + 옥외기계식대수 + 옥내자주식대수 + 옥외자주식대수 )
                                                var totalMechCnt = parseInt($(xmlData).find("indrMechUtcnt").text()) + parseInt($(xmlData).find("oudrMechUtcnt").text()) + parseInt($(xmlData).find("indrAutoUtcnt").text()) + parseInt($(xmlData).find("oudrAutoUtcnt").text());

                                                $(".totalMechCnt").text("총 " + totalMechCnt + " 대");

                                                // 승강기 ( 승용승강기수 + 비상용승강기수 )
                                                var totalElvtCnt = parseInt($(xmlData).find("rideUseElvtCnt").text()) + parseInt($(xmlData).find("emgenUseElvtCnt").text());

                                                $(".totalElvtCnt").text("총 " + totalElvtCnt + " 대");
                                            }
                                        });

                                        $.ajax({
                                            url: '/index.php/dataFunction/floorApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("items").eq(0).find("item");
                                                $(".floorApiTarget").empty();
                                                $(xmlData).each(function (index, element) {
                                                    var tr = $("<tr/>");
                                                    
                                                    var addText = "";
                                                    if($(xmlData).eq(index).find("flrGbCdNm").text() == "옥탑"){
                                                     addText = 2;
                                                    }else if($(xmlData).eq(index).find("flrGbCdNm").text() == "지상"){
                                                     addText = 1;   
                                                    }else if($(xmlData).eq(index).find("flrGbCdNm").text() == "지하"){
                                                      addText = 0;  
                                                    }
                                                    
                                                    $("<td/>").attr("data-value", addText + $(xmlData).eq(index).find("flrGbCdNm").text()).text($(xmlData).eq(index).find("flrGbCdNm").text()).appendTo(tr);
                                                    $("<td/>").attr("data-value", $(xmlData).eq(index).find("flrNoNm").text()).text($(xmlData).eq(index).find("flrNoNm").text()).appendTo(tr);
                                                    $("<td/>").attr("data-value", $(xmlData).eq(index).find("strctCdNm").text()).text($(xmlData).eq(index).find("strctCdNm").text()).appendTo(tr);
                                                    $("<td/>").attr("data-value", $(xmlData).eq(index).find("etcPurps").text()).text($(xmlData).eq(index).find("etcPurps").text()).appendTo(tr);
                                                    // $("<td/>").text($(xmlData).eq(index).find("area").text()).appendTo(tr);

                                                    var textA = $(xmlData).eq(index).text();
                                                    var textB = textA.split($(xmlData).eq(index).find("bjdongCd").text());
                                                    var textC = textB[0];
                                                    var textD = textC.split(".");

                                                    if (textD[1]) {
                                                        if (textD[1].substring(textD.length, textD.length + 1) == "0") {
                                                            textC = textC.substring(0, textC.length - 1);
                                                        }
                                                    }

                                                    $("<td/>").attr("data-value", textC).text(textC + "㎡").appendTo(tr);

                                                    $(".floorApiTarget").append(tr);

                                                    $("#floorSort").trigger("click");
                                                    $("#divSort").trigger("click");
                                                });
                                            }
                                        });


                                        $.ajax({
                                            url: '/index.php/dataFunction/cleanApiCall',
                                            type: 'GET',
                                            data: data,
                                            dataType: 'text',
                                            success: function (result) {
                                                var xmlData = $(result).find("items").eq(0).find("item");
                                                $(".modeCdNm").text($(xmlData).find("modeCdNm").text());
                                            }
                                        });

                                    });

                                });

                                function openDaumPostcode() {
                                    new daum.Postcode({
                                        oncomplete: function (data) {
                                            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                            var fullAddr = ''; // 최종 주소 변수
                                            var extraAddr = ''; // 조합형 주소 변수

                                            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                                fullAddr = data.roadAddress;

                                            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                                fullAddr = data.jibunAddress;
                                            }

                                            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                            if (data.userSelectedType === 'R') {
                                                //법정동명이 있을 경우 추가한다.
                                                if (data.bname !== '') {
                                                    extraAddr += data.bname;
                                                }
                                                // 건물명이 있을 경우 추가한다.
                                                if (data.buildingName !== '') {
                                                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                                }
                                                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                                fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                                            }

                                            // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                            //document.getElementById('sample6_postcode').value = data.zonecode; //5자리 새우편번호 사용
                                            document.getElementById('addr').value = fullAddr;

                                            // 커서를 상세주소 필드로 이동한다.
//                                            document.getElementById('url').focus();
                                        }
                                    }).open();
                                }

                                function openDaumPostcode2() {
                                    new daum.Postcode({
                                        oncomplete: function (data) {

                                            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                            var fullAddr = ''; // 최종 주소 변수
                                            var extraAddr = ''; // 조합형 주소 변수

                                            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                                fullAddr = data.roadAddress;

                                            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                                fullAddr = data.jibunAddress;
                                            }

                                            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                            if (data.userSelectedType === 'R') {
                                                //법정동명이 있을 경우 추가한다.
                                                if (data.bname !== '') {
                                                    extraAddr += data.bname;
                                                }
                                                // 건물명이 있을 경우 추가한다.
                                                if (data.buildingName !== '') {
                                                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                                }
                                                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                                fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                                            }

                                            // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                            //document.getElementById('sample6_postcode').value = data.zonecode; //5자리 새우편번호 사용
                                            document.getElementById('mod_addr').value = fullAddr;

                                            // 커서를 상세주소 필드로 이동한다.
//                                            document.getElementById('mod_url').focus();
                                        }
                                    }).open();
                                }

                                function readURL(input, idx) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            $('.add_img_prev').eq(idx).attr('src', e.target.result);
                                        }

                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }

                                function readURL2(input, idx) {
                                    if (input.files && input.files[0]) {
                                        var reader = new FileReader();

                                        reader.onload = function (e) {
                                            $('.mod_img_prev').eq(idx).attr('src', e.target.result);
                                        }

                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
</script>