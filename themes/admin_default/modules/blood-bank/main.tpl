<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">

<div class="well">
	<form action="{NV_BASE_ADMINURL}index.php" method="get">
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

		<div class="row">
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<input class="form-control" type="text" value="{SEARCH.keywords}" name="keywords" placeholder="{LANG.keywords}">
				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<select class="form-control" name="user_group">
						<option value="">---{LANG.user_group}---</option>
						<!-- BEGIN: user_group -->
						<option value="{GROUPS.value}" {GROUPS.selected}>{GROUPS.text}</option>
						<!-- END: user_group -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="form-group">
					<select class="form-control" name="blood_group">
						<option value="">---{LANG.blood_group}---</option>
						<!-- BEGIN: blood_group -->
						<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
						<!-- END: blood_group -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<select class="form-control" name="gender">
						<option value="">---{LANG.sex}---</option>
						<!-- BEGIN: sex -->
						<option value="{SEX.key}" {SEX.selected}>{SEX.value}</option>
						<!-- END: sex -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<select class="form-control" name="recent_time">
						<option value="">---{LANG.recent_time}---</option>
						<!-- BEGIN: recent_time -->
						<option value="{R_TIME.value}" {R_TIME.selected}>{R_TIME.text}</option>
						<!-- END: recent_time -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<select name="province" class="form-control" id="province">
						<option value="0">---{LANG.province_c}---</option>
						<!-- BEGIN: province -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-5">
				<div class="form-group">
					<select name="district" class="form-control" id="district">
						<option value="">---{LANG.district_c}---</option>
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="form-group">
					<select name="ward" class="form-control" id="ward">

					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-2">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="search" value="{LANG.search}">
				</div>
			</div>
		</div>
	</form>
</div>

<p class="pull-left">
	<span>{LANG.total_member}</span>
</p>
<p class="pull-right">
	<a href="{BASE_URL}&export=1" target="_blank" class="btn btn-success btn-xs">{LANG.export}</a>
</p>
<div class="clearfix">&nbsp;</div>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col width="50" />
			<col />
			<col width="150" />
			<col width="130" span="4" />
			<col />
			<col width="70" />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center">{LANG.no}</th>
				<th>{LANG.last_name}</th>
				<th>{LANG.first_name}</th>
				<th>{LANG.birthday}</th>
				<th class="text-center">{LANG.sex}</th>
				<th>{LANG.tel}</th>
				<th class="text-center">{LANG.blood_group}</th>
				<th>{LANG.organize}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">{DATA.no}</td>
				<td>{DATA.last_name}</td>
				<td><a href="{DATA.link}" target="_blank" title="{DATA.first_name}">{DATA.first_name}</a></td>
				<td>{DATA.birthday}</td>
				<td class="text-center">{DATA.gender}</td>
				<td>{DATA.phone}</td>
				<td class="text-center text-uppercase">{DATA.blood_group}</td>
				<td>{DATA.organize}</td>
				<td class="text-center"><a href="{DATA.edit_url}"><em class="fa fa-edit fa-lg" title="{GLANG.edit}">&nbsp;</em></a> <a href="javascript:void(0)" id="{DATA.id}" class="del" title="{GLANG.delete}"><em class="fa fa-trash-o fa-lg">&nbsp;</em></a></td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>

<!-- BEGIN: generate_page -->
<div class="text-center">{PAGE}</div>
<!-- END: generate_page -->

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#province, #district, #ward").select2();

		get_district( '{SEARCH.district}' );

		$("#province").change(function(){
			get_district( '{SEARCH.district}' );
		});

		$("#district").change(function(){
			get_ward( '{SEARCH.ward}' );
		});
	});

	function get_district( sl_district )
	{
		var provinceid1 = $("#province").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_district=1&provinceid=' + provinceid1 + '&sl_district=' + sl_district + '&c_district=1', function(res) {
			$("#district").html( res );
			$("#district").select2();
			get_ward( '{SEARCH.ward}' );
		});
	}

	function get_ward( sl_ward )
	{
		var districtid = $("#district").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_ward=1&districtid=' + districtid + '&sl_ward=' + sl_ward + '&c_ward=1', function(res) {
			$("#ward").html( res );
			$("#ward").select2();
		});
	}

	$('.del').click(function(){
		if (confirm(nv_is_del_confirm[0])) {
			var id = $(this).attr('id');
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(), 'del=1&id=' + id, function(res) {
				var r_split = res.split('_');
				if (r_split[0] != 'OK') {
					alert(nv_is_del_confirm[2]);
				}
				else
				{
					window.location.href = window.location.href;
				}
				return;
			});
		}
	});
</script>

<!-- END: main -->