<div class="row">

    <div class="form-group col-sm-2">
        <label for="mod_structure_type">구조형태</label>
        <select class="form-control form-control-sm" name="structure_type" id="mod_structure_type">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->STRUCTURE_TYPE == 1) echo 'selected'; ?>>전층사용</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->STRUCTURE_TYPE == 2) echo 'selected'; ?>>일부층사용</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->STRUCTURE_TYPE == 3) echo 'selected'; ?>>복층</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_appearance_type">외관유형</label>
        <select class="form-control form-control-sm" name="appearance_type" id="mod_appearance_type">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->APPEARANCE_TYPE == 1) echo 'selected'; ?>>통유리</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->APPEARANCE_TYPE == 2) echo 'selected'; ?>>대리석</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->APPEARANCE_TYPE == 3) echo 'selected'; ?>>벽돌</option>
            <option value="4" <?php if ($business_facilities_info && $business_facilities_info->APPEARANCE_TYPE == 4) echo 'selected'; ?>>노출콘크리트</option>
            <option value="5" <?php if ($business_facilities_info && $business_facilities_info->APPEARANCE_TYPE == 5) echo 'selected'; ?>>디자인</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_internal_type">내부유형</label>
        <input id="mod_internal_type" type="text" class="form-control form-control-sm" placeholder="내부유형" name="internal_type" value="<?php if ($business_facilities_info) echo $business_facilities_info->INTERNAL_TYPE ?>" maxlength="20">
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_floor_type">바닥유형</label>
        <select class="form-control form-control-sm" name="floor_type" id="mod_floor_type">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->FLOOR_TYPE == 1) echo 'selected'; ?>>에폭시</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->FLOOR_TYPE == 2) echo 'selected'; ?>>타일</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->FLOOR_TYPE == 3) echo 'selected'; ?>>카페트</option>
            <option value="4" <?php if ($business_facilities_info && $business_facilities_info->FLOOR_TYPE == 4) echo 'selected'; ?>>대리석</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_location">건물위치</label>
        <select class="form-control form-control-sm" name="location" id="mod_location">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->LOCATION == 1) echo 'selected'; ?>>대로변</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->LOCATION == 2) echo 'selected'; ?>>이면도로</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->LOCATION == 3) echo 'selected'; ?>>대로변 코너</option>
            <option value="4" <?php if ($business_facilities_info && $business_facilities_info->LOCATION == 4) echo 'selected'; ?>>이면도로 코너</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_form_sale">매물형태</label>
        <select class="form-control form-control-sm" name="form_sale" id="mod_form_sale">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 1) echo 'selected'; ?>>통사옥</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 2) echo 'selected'; ?>>단독주택</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 3) echo 'selected'; ?>>주택형사무실</option>
            <option value="4" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 4) echo 'selected'; ?>>신축</option>
            <option value="5" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 5) echo 'selected'; ?>>지하스튜디오</option>
            <option value="6" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 6) echo 'selected'; ?>>프리미엄빌딩</option>
            <option value="7" <?php if ($business_facilities_info && $business_facilities_info->FORM_SALE == 7) echo 'selected'; ?>>일반사무실</option>
        </select>
    </div>
</div>
<!--/.row-->

<div class="row">
    <div class="form-group col-sm-2">
        <label for="mod_restroom">화장실</label>
        <select class="form-control form-control-sm" name="restroom" id="mod_restroom">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->RESTROOM == 1) echo 'selected'; ?>>내부-남녀공용</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->RESTROOM == 2) echo 'selected'; ?>>내부-남녀분리</option>
            <option value="3" <?php if ($business_facilities_info && $business_facilities_info->RESTROOM == 3) echo 'selected'; ?>>외부-남녀공용</option>
            <option value="4" <?php if ($business_facilities_info && $business_facilities_info->RESTROOM == 4) echo 'selected'; ?>>외부-남녀분리</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_terrace">테라스</label>
        <select class="form-control form-control-sm" name="terrace" id="mod_terrace">
            <option value="">선택</option>
            <option value="Y" <?php if ($info->TERRACE == 'Y') echo 'selected'; ?>>유</option>
            <option value="N" <?php if ($info->TERRACE == 'N') echo 'selected'; ?>>무</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_interior">인테리어</label>
        <select class="form-control form-control-sm" name="interior" id="mod_interior">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->INTERIOR == 1) echo 'selected'; ?>>유</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->INTERIOR == 2) echo 'selected'; ?>>무</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_facility_reward">시설권리금</label>
        <input id="mod_facility_reward" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="시설권리금" name="facility_reward" value="<?php if ($business_facilities_info) echo $business_facilities_info->FACILITY_REWARD ?>" maxlength="10">
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_management_room">관리실</label>
        <select class="form-control form-control-sm" name="management_room" id="mod_management_room">
            <option value="">선택</option>
            <option value="1" <?php if ($business_facilities_info && $business_facilities_info->MANAGEMENT_ROOM == 1) echo 'selected'; ?>>유</option>
            <option value="2" <?php if ($business_facilities_info && $business_facilities_info->MANAGEMENT_ROOM == 2) echo 'selected'; ?>>무</option>
        </select>
    </div>

    <div class="form-group col-sm-2">
        <label for="mod_opening_time">건물개방시간</label>
        <input id="mod_opening_time" type="text" class="form-control form-control-sm" placeholder="건물개방시간" name="opening_time" value="<?php if ($business_facilities_info) echo $business_facilities_info->OPENING_TIME ?>" maxlength="10">
    </div>

</div>
<!--/.row-->