<div class="row">

    <div class="form-group col-sm-3">
        <label for="mod_option_type">옵션구분</label>
        <select class="form-control form-control-sm" name="option_type" id="mod_option_type">
            <option value="">선택</option>
            <option value="1" <?php if ($housing_info && $housing_info->OPTION_TYPE == 1) echo 'selected'; ?>>일반룸</option>
            <option value="2" <?php if ($housing_info && $housing_info->OPTION_TYPE == 2) echo 'selected'; ?>>풀옵션</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="mod_living_room_size">거실크기</label>
        <select class="form-control form-control-sm" name="living_room_size" id="mod_living_room_size">
            <option value="">선택</option>
            <option value="1" <?php if ($housing_info && $housing_info->LIVING_ROOM_SIZE == 1) echo 'selected'; ?>>대</option>
            <option value="2" <?php if ($housing_info && $housing_info->LIVING_ROOM_SIZE == 2) echo 'selected'; ?>>중</option>
            <option value="3" <?php if ($housing_info && $housing_info->LIVING_ROOM_SIZE == 3) echo 'selected'; ?>>소</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="mod_structure_type">구조형태</label>
        <select class="form-control form-control-sm" name="structure_type" id="mod_structure_type">
            <option value="">선택</option>
            <option value="1" <?php if ($housing_info && $housing_info->STRUCTURE_TYPE == 1) echo 'selected'; ?>>오픈형</option>
            <option value="2" <?php if ($housing_info && $housing_info->STRUCTURE_TYPE == 2) echo 'selected'; ?>>분리형</option>
            <option value="3" <?php if ($housing_info && $housing_info->STRUCTURE_TYPE == 3) echo 'selected'; ?>>원룸원거실</option>
            <option value="4" <?php if ($housing_info && $housing_info->STRUCTURE_TYPE == 4) echo 'selected'; ?>>세미분리형</option>
            <option value="5" <?php if ($housing_info && $housing_info->STRUCTURE_TYPE == 5) echo 'selected'; ?>>복층</option>
        </select>
    </div>

    <div class="form-group col-sm-3">
        <label for="mod_terrace">테라스</label>
        <select class="form-control form-control-sm" name="terrace" id="mod_terrace">
            <option value="">선택</option>
            <option value="Y" <?php if ($info->TERRACE == 'Y') echo 'selected'; ?>>유</option>
            <option value="N" <?php if ($info->TERRACE == 'N') echo 'selected'; ?>>무</option>
        </select>
    </div>

</div>
<!--/.row-->

<div class="row">
    <div class="form-group col">
        <label class="form-control-label">옵션사항</label>
        <div class="row">
            <div class="col checkbox-custom">
                <?php foreach ($option as $row) { ?>
                    <label>
                        <input type="checkbox" name="option_idx[]" value="<?= $row['OPTION_IDX'] ?>" <?= $row['CHECKED'] ?>><?= $row['NAME'] ?>
                    </label>
                <?php } ?>
            </div>
        </div>
    </div>
</div>