<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

<style type="text/css">
	.red{
		color: red
	}
</style>

<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->

<!-- BEGIN: success -->
<div class="alert alert-info">{LANG.success}</div>
<!-- END: success -->

<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="" method="post">
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.fullname}</strong> <span class="red">*</span></label>
				<div class="col-sm-9 col-md-9">
					<input type="text" name="last_name" value="{USER.last_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.last_name}" />
				</div>
				<div class="col-sm-9 col-md-9">
					<input type="text" name="first_name" id="first_name" value="{USER.first_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.first_name}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.birthday}</strong> <span class="red">*</span></label>
				<div class="col-sm-7 col-md-7">
					<div class="input-group">
						<input type="text" class="form-control" id="birthday" name="birthday" value="{USER.birthday}" readonly="readonly" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="birthday-btn"> <em class="fa fa-calendar fa-fix">&nbsp;</em></button>
						</span>
					</div>
				</div>
				<label class="col-sm-3 col-md-3 text-right"><strong>{LANG.sex}</strong></label>
				<div class="col-sm-8 col-md-8">
					<select class="form-control" name="gender">
						<!-- BEGIN: sex -->
						<option value="{SEX.key}" {SEX.selected}>{SEX.value}</option>
						<!-- END: sex -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.tel}</strong></label>
				<div class="col-sm-18 col-md-18">
					<input type="text" name="phone" value="{DATA.phone}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.identity_card}</strong> <span class="red">*</span></label>
				<div class="col-sm-18 col-md-18">
					<input type="text" name="identity_card" value="{DATA.identity_card}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.blood_group}</strong> <span class="red">*</span></label>
				<div class="col-sm-9 col-md-9">
					<select class="form-control" name="blood_group">
						<!-- BEGIN: blood_group -->
						<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
						<!-- END: blood_group -->
					</select>
				</div>
				<div class="col-sm-9 col-md-9">
					<label class="control-label"><input type="checkbox" value="1" name="rh_" {DATA.rh_} />{LANG.rh_}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.width} (cm)</strong></label>
				<div class="col-sm-6 col-md-6">
					<input type="text" name="width" value="{DATA.width}" class="form-control" />
				</div>
				<label class="col-sm-3 col-md-3 control-label"><strong>{LANG.weight}</strong></label>
				<div class="col-sm-8 col-md-8">
					<input type="text" name="weight" value="{DATA.weight}" class="form-control" />
				</div>
				<div class="col-sm-1">
					<span>kg</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.recent_time}</strong></label>
				<div class="col-sm-6 col-md-6">
					<div class="input-group">
						<input type="text" class="form-control" id="recent_time" name="recent_time" value="{DATA.recent_time}" readonly="readonly">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="recent_time-btn"> <em class="fa fa-calendar fa-fix">&nbsp;</em></button>
						</span>
					</div>
				</div>
				<label class="col-sm-3 col-md-3 control-label"><strong>{LANG.platelet}</strong></label>
				<div class="col-sm-9 col-md-9">
					<select class="form-control" name="platelet">
						<!-- BEGIN: platelet -->
						<option value="{PLA.key}" {PLA.selected}>{PLA.value}</option>
						<!-- END: platelet -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.organize}</strong></label>
				<div class="col-sm-6 col-md-6">
					<select class="form-control" name="organizetype">
						<option value="">---{LANG.organize_type_c}---</option>
						<!-- BEGIN: organizetype -->
						<option value="{ORGTYPE.key}" {ORGTYPE.selected}>{ORGTYPE.value}</option>
						<!-- END: organizetype -->
					</select>
				</div>
				<div class="col-sm-12 col-md-12">
					<input type="text" name="organize" value="{DATA.organize}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.resident}</strong></label>
				<div class="col-sm-6 col-md-6">
					<select name="province1" class="form-control province" id="province1">
						<!-- BEGIN: province1 -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province1 -->
					</select>
				</div>
				<div class="col-sm-6 col-md-6">
					<select name="district1" class="form-control district" id="district1">

					</select>
				</div>
				<div class="col-sm-6 col-md-6">
					<select name="ward1" class="form-control ward" id="ward1">

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.temporarily}</strong></label>
				<div class="col-sm-6 col-md-6">
					<select name="province2" class="form-control province" id="province2">
						<!-- BEGIN: province2 -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province2 -->
					</select>
				</div>
				<div class="col-sm-6 col-md-6">
					<select name="district2" class="form-control district" id="district2">

					</select>
				</div>
				<div class="col-sm-6 col-md-6">
					<select name="ward2" class="form-control ward" id="ward2">

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label">&nbsp;</label>
				<div class="col-sm-18 col-md-18">
					<input type="text" class="form-control" name="temporarily_s" value="{DATA.temporarily_s}" placeholder="{LANG.stress}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label"><strong>{LANG.captcha}</strong></label>
				<div class="col-sm-18 col-md-18">
					<input type="text" maxlength="6" value="" id="fcode_iavim" name="fcode" class="form-control pull-left" style="width: 50%; margin-right: 5px" />
					<img height="22" src="{NV_BASE_SITEURL}index.php?scaptcha=captcha&t={NV_CURRENTTIME}" alt="{LANG.captcha}" id="vimg" class="captchaImg" />
					&nbsp;<em class="fa fa-pointer fa-refresh fa-lg" onclick="change_captcha('#fcode_iavim');">&nbsp;</em>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-6 col-md-6 control-label">&nbsp;</label>
				<div class="col-sm-18 col-md-18">
					<input type="submit" name="submit" class="btn btn-primary" value="{LANG.save}" />
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".province").select2();

		$("#recent_time, #birthday").datepicker({
			dateFormat : "dd/mm/yy",
			changeMonth : true,
			changeYear : true,
			showOtherMonths : true,
			showOn : 'focus',
			yearRange: "-50:+0",
			defaultDate:"-22y-m-d"
		});
		$('#birthday-btn').click(function(){
			$("#birthday").datepicker('show');
		});
		$('#recent_time-btn').click(function(){
			$("#recent_time").datepicker('show');
		});

		get_district1( '{DATA.resident_d}' );
		get_district2( '{DATA.temporarily_d}' );

		$("#province1").change(function(){
			get_district1( '{DATA.resident_d}' );
		});

		$("#district1").change(function(){
			get_ward1( '{DATA.resident_w}' );
		});

		$("#province2").change(function(){
			get_district2( '{DATA.temporarily_d}' );
		});

		$("#district2").change(function(){
			get_ward2( '{DATA.temporarily_w}' );
		});
	});

	function get_district1( sl_district )
	{
		var provinceid1 = $("#province1").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_district=1&provinceid=' + provinceid1 + '&sl_district=' + sl_district, function(res) {
			$("#district1").html( res );
			$("#district1").select2();
			get_ward1( '{DATA.resident_w}' );
		});
	}

	function get_ward1( sl_ward )
	{
		var districtid = $("#district1").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_ward=1&districtid=' + districtid + '&sl_ward=' + sl_ward, function(res) {
			$("#ward1").html( res );
			$("#ward1").select2();
		});
	}

	function get_district2( sl_district )
	{
		var provinceid2 = $("#province2").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_district=1&provinceid=' + provinceid2 + '&sl_district=' + sl_district, function(res) {
			$("#district2").html( res );
			get_ward2( '{DATA.temporarily_w}' );
		});
	}

	function get_ward2( sl_ward )
	{
		var districtid = $("#district2").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_ward=1&districtid=' + districtid + '&sl_ward=' + sl_ward, function(res) {
			$("#ward2").html( res );
			$("#ward2").select2();
		});
	}
</script>
<!-- END: main -->