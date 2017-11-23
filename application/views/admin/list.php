	<ol class="breadcrumb">
		<li class="breadcrumb-item">ERP</li>
		<li class="breadcrumb-item active"><b>관리자 관리</b></li>
	</ol>

	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<div class="card-header-title">
							<strong>관리자 목록</strong>
							<small>아이디를 클릭하시면 수정 가능합니다</small>
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
							<colgroup><col width="60px"><col width="*"><col width="*"><col width="*"><col width="120px"><col width="120px"></colgroup>
							<thead>
								<tr>
									<th>번호</th>
									<th>아이디</th>
									<th>이름</th>
									<th>연락처</th>
									<th>등급</th>
									<th>등록일</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!$lists) { ?>
								<tr>
									<td colspan="6" style="text-align: center">
										관리자가 없습니다.
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
									<tr class="tb_row" style="cursor: pointer">
										<th scope="row"><?= $num ?></th>
										<td><?= $row['ID'] ?></td>
										<td><?= $row['NAME'] ?></td>
										<td><?= $row['PHONE'] ?></td>
										<td>
											<span class="badge badge-success"><?= $row['LEVEL'] ?></span>
										</td>
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


	<!-- 등록모달 -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form id="adminAddForm" method="post" action="/index.php/dataFunction/insAdmin">
					<div class="modal-header">
						<h5 class="modal-title" id="addModalLabel">관리자등록</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="form-control-label" for="id">아이디</label>
							<input type="text" class="form-control" name="id" id="id" placeholder="아이디" maxlength="10">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="pwd">비밀번호</label>
							<input type="password" class="form-control" name="pwd" id="pwd" placeholder="비밀번호">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="pwdChk">비밀번호확인</label>
							<input type="password" class="form-control" name="pwdChk" id="pwdChk" placeholder="비밀번호">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="name">이름</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="이름" maxlength="10">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="phone">연락처</label>
							<input type="text" class="form-control" name="phone" id="phone" pattern="[0-9]*" maxlength="11" minlength="10" placeholder="연락처">
						</div>
						<div class="form-group">
							<label class="form-control-label" for="level">등급</label>
							<select id="level" name="level" class="form-control">
								<option value="N">일반관리자</option>
								<option value="A">최고관리자</option>
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
			<form id="adminModForm" method="post" action="/index.php/dataFunction/modAdmin">
				<div class="modal-header">
					<h5 class="modal-title" id="modModalLabel">관리자수정</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control-plaintext" name="id" id="modId" placeholder="아이디" maxlength="10" readonly>
					</div>
					<div class="form-group">
						<label class="form-control-label" for="pwd">변경할 비밀번호</label>
						<input type="password" class="form-control" name="pwd" id="modPwd" placeholder="변경할 비밀번호">
					</div>
					<div class="form-group">
						<label class="form-control-label" for="pwdChk">변경할 비밀번호확인</label>
						<input type="password" class="form-control" name="pwdChk" id="modPwdChk" placeholder="변경할 비밀번호확인">
					</div>
					<div class="form-group">
						<label class="form-control-label" for="name">이름</label>
						<input type="text" class="form-control" name="name" id="modName" placeholder="이름" maxlength="10">
					</div>
					<div class="form-group">
						<label class="form-control-label" for="phone">연락처</label>
						<input type="text" class="form-control" name="phone" id="modPhone" pattern="[0-9]*" maxlength="11" minlength="10" placeholder="연락처">
					</div>
					<div class="form-group">
						<label class="form-control-label" for="level">등급</label>
						<select id="modLevel" name="level" class="form-control">
							<option value="N">일반관리자</option>
							<option value="A">최고관리자</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
					<button type="button" class="btn btn-danger" id="delBtn">삭제</button>
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
		$('#adminAddForm').validate({
			debug: true,
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorElement: 'div',
			//validation이 끝난 이후의 submit 직전 추가 작업할 부분
			submitHandler: function (form) {
				var f = confirm("관리자를 등록하시겠습니까?");
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
				id: {
					required: true,
					remote: '/index.php/dataFunction/adminIdCheck'
				},
				pwd: {
					required: true
				},
				pwdChk: {
					required: true,
					equalTo: "#pwd"
				},
				name: {
					required: true
				},
				phone: {
					required: true,
					number: true
				}
			},
			//규칙체크 실패시 출력될 메시지
			messages: {
				id: {
					required: "아이디를 필수로 입력하세요.",
					remote: "중복된 아이디 입니다."
				},
				pwd: {
					required: "비밀번호 필수로 입력하세요."
				},
				pwdChk: {
					required: "비밀번호 확인 필수로 입력하세요.",
					equalTo: "비밀번호가 일치하지 않습니다."
				},
				name: {
					required: "이름을 입력하세요."
				},
				phone: {
					required: "연락처를 입력하세요.",
					number: "숫자만 입력하세요."
				}
			}
		});

		$(".tb_row").click(function () {
			var id = $(this).children('td:eq(0)').html();
			var data = {id: id};
			$.ajax({
				url: '/index.php/dataFunction/getAdminInfo',
				type: 'post',
				dataType: 'json',
				data: data,
				success: function (data, status, xhr) {
					if (data['RESULT'] === 'SUCCESS') {
						$("#modId").val(id);
						$("#modName").val(data['NAME']);
						$("#modPhone").val(data['PHONE']);
						$("#modLevel").select().val(data['LEVEL']);
						$("#delBtn").val(id);
						$("#modModal").modal();

					} else {
						alert("데이터 처리오류!!");
						return false;
					}
				}
			});
		});

		$('#adminModForm').validate({
			debug: true,
			errorClass: 'is-invalid',
			validClass: 'is-valid',
			errorElement: 'div',
			//validation이 끝난 이후의 submit 직전 추가 작업할 부분
			submitHandler: function (form) {
				var f = confirm("관리자를 수정하시겠습니까?");
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
				pwdChk: {
					equalTo: "#modPwd"
				},
				name: {
					required: true
				},
				phone: {
					required: true,
					number: true
				}
			},
			//규칙체크 실패시 출력될 메시지
			messages: {
				pwdChk: {
					equalTo: "비밀번호가 일치하지 않습니다."
				},
				name: {
					required: "이름을 입력하세요."
				},
				phone: {
					required: "연락처를 입력하세요.",
					number: "숫자만 입력하세요."
				}
			}
		});

		$("#delBtn").click(function () {
			var id = $(this).val();
			var data = {id: id};
			var f = confirm("관리자를 삭제하시겠습니까?");
			if (f) {
				$.ajax({
					url: '/index.php/dataFunction/delAdmin',
					type: 'POST',
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
		});
	});
</script>