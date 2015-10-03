<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

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
				<label class="col-sm-3 control-label"><strong>{LANG.fullname}</strong> <span class="red">*</span></label>
				<div class="col-sm-11">
					<input type="text" name="last_name" value="{DATA.last_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.last_name}" />
				</div>
				<div class="col-sm-10">
					<input type="text" name="first_name" id="first_name" value="{DATA.first_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.first_name}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.userid}</strong></label>
				<div class="col-sm-10">
					<input type="hidden" name="username" id="username" value="{DATA.username}" />
					<select name="userid" id="userid" class="form-control">
						<option value="{DATA.userid}">{DATA.username}</option>
					</select>
				</div>
				<label class="col-sm-1 control-label"><strong>Email</strong></label>
				<div class="col-sm-10">
					<input type="text" name="email" value="{DATA.email}" class="form-control"  />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.birthday}</strong> <span class="red">*</span></label>
				<div class="col-sm-8">
					<div class="input-group">
						<input type="text" class="form-control" id="birthday" name="birthday" value="{DATA.birthday}" readonly="readonly">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="birthday-btn"> <em class="fa fa-calendar fa-fix">&nbsp;</em></button>
						</span>
					</div>
				</div>
				<label class="col-sm-3 control-label"><strong>{LANG.sex}</strong></label>
				<div class="col-sm-10">
					<select class="form-control" name="gender">
						<!-- BEGIN: sex -->
						<option value="{SEX.key}" {SEX.selected}>{SEX.value}</option>
						<!-- END: sex -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.tel}</strong></label>
				<div class="col-sm-21">
					<input type="text" name="phone" value="{DATA.phone}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.identity_card}</strong> <span class="red">*</span></label>
				<div class="col-sm-21">
					<input type="text" name="identity_card" value="{DATA.identity_card}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.blood_group}</strong> <span class="red">*</span></label>
				<div class="col-sm-11">
					<select class="form-control" name="blood_group" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
						<!-- BEGIN: blood_group -->
						<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
						<!-- END: blood_group -->
					</select>
				</div>
				<div class="col-sm-10">
					<label class="control-label"><input type="checkbox" value="1" name="rh_" {DATA.rh_} />{LANG.rh_}</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.width}</strong></label>
				<div class="col-sm-7">
					<input type="text" name="width" value="{DATA.width}" class="form-control" />
				</div>
				<label class="col-sm-3 control-label"><strong>{LANG.weight}</strong></label>
				<div class="col-sm-10">
					<input type="text" name="weight" value="{DATA.weight}" class="form-control" />
				</div>
				<div class="col-sm-1">
					<span>kg</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.recent_time}</strong></label>
				<div class="col-sm-7">
					<div class="input-group">
						<input type="text" class="form-control" id="recent_time" name="recent_time" value="{DATA.recent_time}" readonly="readonly">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="recent_time-btn"> <em class="fa fa-calendar fa-fix">&nbsp;</em></button>
						</span>
					</div>
				</div>
				<label class="col-sm-3 control-label"><strong>{LANG.platelet}</strong></label>
				<div class="col-sm-11">
					<select class="form-control" name="platelet">
						<!-- BEGIN: platelet -->
						<option value="{PLA.key}" {PLA.selected}>{PLA.value}</option>
						<!-- END: platelet -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.organize}</strong></label>
				<div class="col-sm-7">
					<select class="form-control" name="organizetype">
						<option value="">---{LANG.organize_type_c}---</option>
						<!-- BEGIN: organizetype -->
						<option value="{ORGTYPE.key}" {ORGTYPE.selected}>{ORGTYPE.value}</option>
						<!-- END: organizetype -->
					</select>
				</div>
				<div class="col-sm-14">
					<input type="text" name="organize" value="{DATA.organize}" class="form-control" placeholder="{LANG.organize_name}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.resident}</strong></label>
				<div class="col-sm-7">
					<select name="province1" class="form-control province" id="province1">
						<!-- BEGIN: province1 -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province1 -->
					</select>
				</div>
				<div class="col-sm-7">
					<select name="district1" class="form-control district" id="district1">

					</select>
				</div>
				<div class="col-sm-7">
					<select name="ward1" class="form-control ward" id="ward1">

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label"><strong>{LANG.temporarily}</strong></label>
				<div class="col-sm-7">
					<select name="province2" class="form-control province" id="province2">
						<!-- BEGIN: province2 -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province2 -->
					</select>
				</div>
				<div class="col-sm-7">
					<select name="district2" class="form-control district" id="district2">

					</select>
				</div>
				<div class="col-sm-7">
					<select name="ward2" class="form-control ward" id="ward2">

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-21">
					<input type="text" class="form-control" name="temporarily_s" value="{DATA.temporarily_s}" placeholder="{LANG.stress}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">&nbsp;</label>
				<div class="col-sm-21">
					<input type="submit" name="submit" class="btn btn-primary" value="{LANG.save}" />
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$(".province").select2();

		$("#userid").select2({
			language: "vi",
			ajax: {
		    url: script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&get_user_json=1',
		    	dataType: 'json',
		    	delay: 250,
		    	data: function (params) {
		      		return {
		      			q: params.term, // search term
		      			page: params.page
		      		};
		      	},
		    	processResults: function (data, params) {
		    		params.page = params.page || 1;
		    		return {
		    			results: data,
		    			pagination: {
		    				more: (params.page * 30) < data.total_count
		    			}
		    		};
		    	},
			cache: true
			},
			escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			minimumInputLength: 3,
			templateResult: formatRepo, // omitted for brevity, see the source of this page
			templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
		});

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

	function formatRepo (repo) {
		if (repo.loading) return repo.text;

		var markup = '<div class="clearfix">' +
    	'<div class="col-sm-19">' + repo.username + '</div>' +
	    '<div clas="col-sm-5"><span class="show text-right">' + repo.fullname + '</span></div>' +
	    '</div>';
		markup += '</div></div>';
		return markup;
	}

	function formatRepoSelection (repo) {
		$('#username').val( repo.username );
  		return repo.username || repo.text;
  	}

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

	function open_browse_us() {
		nv_open_browse('{NV_BASE_ADMINURL}index.php?' + nv_name_variable + '=users&' + nv_fc_variable + '=getuserid&area=userid', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no');
	}
</script>
<!-- END: main -->