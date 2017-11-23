<div class="row">

	<div class="form-group col-sm-2">
		<label for="structure_type">구조형태</label>
		<select class="form-control form-control-sm" name="structure_type" id="structure_type">
			<option value="">선택</option>
			<option value="1">전층사용</option>
			<option value="2">일부층사용</option>
			<option value="3">복층</option>
		</select>
	</div>

	<div class="form-group col-sm-2">
		<label for="appearance_type">외관유형</label>
		<select class="form-control form-control-sm" name="appearance_type" id="appearance_type">
			<option value="">선택</option>
			<option value="1">통유리</option>
			<option value="2">대리석</option>
			<option value="3">벽돌</option>
			<option value="4">노출콘크리트</option>
			<option value="5">디자인</option>
		</select>
	</div>

	<div class="form-group col-sm-2">
		<label for="internal_type">내부유형</label>
		<input id="internal_type" type="text" class="form-control form-control-sm" placeholder="내부유형" name="internal_type" maxlength="20">
	</div>

	<div class="form-group col-sm-2">
		<label for="floor_type">바닥유형</label>
		<select class="form-control form-control-sm" name="floor_type" id="floor_type">
			<option value="">선택</option>
			<option value="1">에폭시</option>
			<option value="2">타일</option>
			<option value="3">카페트</option>
			<option value="4">대리석</option>
		</select>
	</div>

	<div class="form-group col-sm-2">
		<label for="location">건물위치</label>
		<select class="form-control form-control-sm" name="location" id="location">
			<option value="">선택</option>
			<option value="1">대로변</option>
			<option value="2">이면도로</option>
			<option value="3">대로변 코너</option>
			<option value="4">이면도로 코너</option>
		</select>
	</div>

	<div class="form-group col-sm-2">
		<label for="form_sale">매물형태</label>
		<select class="form-control form-control-sm" name="form_sale" id="form_sale">
			<option value="">선택</option>
			<option value="1">통사옥</option>
			<option value="2">단독주택</option>
			<option value="3">주택형사무실</option>
			<option value="4">신축</option>
			<option value="5">지하스튜디오</option>
			<option value="6">프리미엄빌딩</option>
			<option value="7">일반사무실</option>
		</select>
	</div>

</div>
<!--/.row-->

<div class="row">
	<div class="form-group col-sm-2">
		<label for="restroom">화장실</label>
		<select class="form-control form-control-sm" name="restroom" id="restroom">
			<option value="">선택</option>
			<option value="1">내부-남녀공용</option>
			<option value="2">내부-남녀분리</option>
			<option value="3">외부-남녀공용</option>
			<option value="4">외부-남녀분리</option>
		</select>
	</div>
	<div class="form-group col-sm-2">
		<label for="terrace">테라스</label>
		<select class="form-control form-control-sm" name="terrace" id="terrace">
			<option value="">선택</option>
			<option value="Y">유</option>
			<option value="N">무</option>
		</select>
	</div>
	<div class="form-group col-sm-2">
		<label for="interior">인테리어</label>
		<select class="form-control form-control-sm" name="interior" id="interior">
			<option value="">선택</option>
			<option value="1">유</option>
			<option value="2">무</option>
		</select>
	</div>
	<div class="form-group col-sm-2">
		<label for="facility_reward">시설권리금</label>
		<input id="facility_reward" type="text" class="form-control form-control-sm" pattern="[0-9]*" placeholder="시설권리금" name="facility_reward" maxlength="10">
	</div>
	<div class="form-group col-sm-2">
		<label for="management_room">관리실</label>
		<select class="form-control form-control-sm" name="management_room" id="management_room">
			<option value="">선택</option>
			<option value="1">유</option>
			<option value="2">무</option>
		</select>
	</div>
	<div class="form-group col-sm-2">
		<label for="opening_time">건물개방시간</label>
		<input id="opening_time" type="text" class="form-control form-control-sm" placeholder="건물개방시간" name="opening_time" maxlength="10">
	</div>
</div>
<!--/.row-->