<ol class="breadcrumb">
    <li class="breadcrumb-item">ERP</li>
    <li class="breadcrumb-item active"><b>매물 옵션</b></li>
</ol>

<div class="container-fluid">
    <div class="row">

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-title">
                        <strong>매물 옵션 등록</strong>
                        <small>매물에 옵션을 관리합니다</small>
                    </div>

                    <div class="card-actions">
                        <a href="#" class="btn-setting" data-toggle="modal" data-target="#addModal">
                            <i class="icon-plus"></i>
                            등록
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-custom land_list_table">
                        <colgroup><col width="60px"><col width="*"><col width="120px"><col width="120px"></colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>옵션명</th>
                                <th>사용여부</th>
                                <th>등록일</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$lists) { ?>
                                <tr>
                                    <td colspan="4" style="text-align: center">
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
                                    <tr class="tb_row" data-bind="<?= $row['OPTION_IDX'] ?>" style="cursor: pointer">
                                        <th scope="row"><?= $num ?></th>
                                        <td><?= $row['NAME'] ?></td>
                                        <td><?= $row['USE_YN'] ?></td>
                                        <td><?= $row['INS_TIME'] ?></td>
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



<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="optionAddForm" method="post" action="/index.php/dataFunction/insOption">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">매물옵션등록</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label" for="name">옵션명</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="옵션명" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="use_yn">사용여부</label>
                        <select class="form-control" name="use_yn" id="use_yn">
                            <option value="Y">사용</option>
                            <option value="N">미사용</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-primary">등록</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modModal" tabindex="-1" role="dialog" aria-labelledby="modModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="optionModForm" method="post" action="/index.php/dataFunction/modOption">
                <input type="hidden" id="option_idx" name="option_idx">
                <div class="modal-header">
                    <h5 class="modal-title" id="modModalLabel">매물옵션수정</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-control-label" for="modName">옵션명</label>
                        <input type="text" class="form-control" name="name" id="modName" placeholder="옵션명" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="modUse_yn">사용여부</label>
                        <select class="form-control" name="use_yn" id="modUse_yn">
                            <option value="Y">사용</option>
                            <option value="N">미사용</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-primary">수정</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--jquery validation 플러그인-->
<script src="/js/jquery.validate.min.js"></script>
<script src="/js/additional-methods.min.js"></script>
<script src="/js/messages_ko.min.js"></script>
<!--jquery validation 플러그인-->
<script type="text/javascript">
    $(document).ready(function () {
        $('#optionAddForm').validate({
            debug: true,
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            errorElement: 'div',
            //validation이 끝난 이후의 submit 직전 추가 작업할 부분
            submitHandler: function (form) {
                var f = confirm("매물옵션 등록하시겠습니까?");
                if (f) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'text',
                        data: $(form).serialize(),
                        success: function (data, status, xhr) {
                            if (data === 'SUCCESS') {
                                alert("등록 되었습니다.");
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
            },
            rules: {
                name: {
                    required: true
                }
            },
            //규칙체크 실패시 출력될 메시지
            messages: {
                name: {
                    required: "옵션명을 입력하세요."
                }
            }
        });

        $(".tb_row").click(function () {
            var idx = $(this).attr('data-bind');
            var data = {idx: idx};
            $.ajax({
                url: '/index.php/dataFunction/getOptionInfo',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (data, status, xhr) {
                    if (data['RESULT'] === 'SUCCESS') {
                        $("#option_idx").val(data['OPTION_IDX']);
                        $("#modName").val(data['NAME']);
                        $("#modUse_yn").select().val(data['USE_YN']);
                        $("#modModal").modal();
                    } else {
                        alert("데이터 처리오류!!");
                        return false;
                    }
                }
            });
        });

        $('#optionModForm').validate({
            debug: true,
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            errorElement: 'div',
            //validation이 끝난 이후의 submit 직전 추가 작업할 부분
            submitHandler: function (form) {
                var f = confirm("매물옵션 수정하시겠습니까?");
                if (f) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        dataType: 'text',
                        data: $(form).serialize(),
                        success: function (data, status, xhr) {
                            if (data === 'SUCCESS') {
                                alert("수정 되었습니다.");
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
            },
            rules: {
                name: {
                    required: true
                }
            },
            //규칙체크 실패시 출력될 메시지
            messages: {
                name: {
                    required: "옵션명을 입력하세요."
                }
            }
        });
    });
</script>