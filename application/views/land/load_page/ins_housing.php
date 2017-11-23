<div class="row">
    <div class="form-group col-sm-3">
        <label for="option_type">옵션구분</label>
        <select class="form-control form-control-sm" name="option_type" id="option_type">
            <option value="">선택</option>
            <option value="1">일반룸</option>
            <option value="2">풀옵션</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="living_room_size">거실크기</label>
        <select class="form-control form-control-sm" name="living_room_size" id="living_room_size">
            <option value="">선택</option>
            <option value="1">대</option>
            <option value="2">중</option>
            <option value="3">소</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="structure_type">구조형태</label>
        <select class="form-control form-control-sm" name="structure_type" id="structure_type">
            <option value="">선택</option>
            <option value="1">오픈형</option>
            <option value="2">분리형</option>
            <option value="3">원룸원거실</option>
            <option value="4">세미분리형</option>
            <option value="5">복층</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="terrace">테라스</label>
        <select class="form-control form-control-sm" name="terrace" id="terrace">
            <option value="">선택</option>
            <option value="Y">유</option>
            <option value="N">무</option>
        </select>
    </div>

</div>
<!--/.row-->

<div class="row">
    <div class="form-group col">
        <label for="">옵션사항</label>
        <div class="row">
            <div class="col checkbox-custom">
                <?php foreach ($option as $row) { ?>
                <label>
                    <input class="checkbox-inline" type="checkbox" name="option_idx[]" value="<?= $row['OPTION_IDX'] ?>"><?= $row['NAME'] ?>
                </label>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
                <!--/.row-->