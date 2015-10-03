<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

<!-- BEGIN: view -->
<div class="well">
	<form action="{NV_BASE_ADMINURL}index.php" method="get">
		<input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
		<div class="row">
			<div class="col-xs-24 col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
				</div>
			</div>
			<div class="col-xs-12 col-md-3">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
				</div>
			</div>
		</div>
	</form>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<colgroup>
				<col class="w50" />
				<col />
				<col class="w150" span="5" />
			</colgroup>
			<thead>
				<tr>
					<th class="text-center">{LANG.number}</th>
					<th>{LANG.fullname}</th>
					<th>{LANG.card_code}</th>
					<th>{LANG.dose} (ml)</th>
					<th>{LANG.weight} (kg)</th>
					<th>{LANG.pulse}</th>
					<th>{LANG.blood_pressure}</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="7">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"> {VIEW.number} </td>
					<td> {VIEW.fullname} </td>
					<td> {VIEW.card_code} </td>
					<td> {VIEW.dose} </td>
					<td> {VIEW.weight} </td>
					<td> {VIEW.pulse} </td>
					<td> {VIEW.blood_pressure} </td>
					<td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i><a href="{VIEW.link_edit}#edit">{GLANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{GLANG.delete}</a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<h3>{LANG.donation_person_add}</h3>
<!-- BEGIN: error -->
<div class="alert alert-warning">
	{ERROR}
</div>
<!-- END: error -->

<div class="alert alert-info" id="div_info" style="display: none">

</div>

<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&donation_id={ROW.donation_id}" method="post" id="frm_donation_person">
			<input type="hidden" name="id" value="{ROW.id}" />
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.identity_card}</strong> <span class="red">*</span></label>
						<div class="col-sm-19">
							<input type="text" name="identity_card" id="identity_card" value="{ROW.member.identity_card}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.fullname}</strong> <span class="red">*</span></label>
						<div class="col-sm-11">
							<input type="text" name="last_name" id="last_name" value="{ROW.member.last_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.last_name}" />
						</div>
						<div class="col-sm-8">
							<input type="text" name="first_name" id="first_name" value="{ROW.member.first_name}" class="form-control" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" placeholder="{LANG.first_name}" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.birthday}</strong> <span class="red">*</span></label>
						<div class="col-sm-19">
							<div class="input-group">
								<input type="text" class="form-control" id="birthday" name="birthday" value="{ROW.member.birthday}" readonly="readonly">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" id="birthday-btn"> <em class="fa fa-calendar fa-fix">&nbsp;</em></button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.sex}</strong></label>
						<div class="col-sm-19">
							<select class="form-control" name="gender" id="gender">
								<!-- BEGIN: sex -->
								<option value="{SEX.key}" {SEX.selected}>{SEX.value}</option>
								<!-- END: sex -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.tel}</strong></label>
						<div class="col-sm-19">
							<input type="text" name="phone" id="phone" value="{ROW.member.phone}" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.blood_group}</strong> <span class="red">*</span></label>
						<div class="col-sm-15">
							<select class="form-control" name="blood_group" id="blood_group" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')">
								<option value="">{LANG.blood_group_ch}</option>
								<!-- BEGIN: blood_group -->
								<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
								<!-- END: blood_group -->
							</select>
						</div>
						<div class="col-sm-4">
							<label class="control-label"><input type="checkbox" value="1" name="rh_" id="rh_" {ck_rh_} />{LANG.rh_}</label>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.card_code}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19">
							<input class="form-control" type="text" name="card_code" id="card_code" value="{ROW.card_code}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.dose}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19">
							<select name="dose" class="form-control">
								<option value="">---{LANG.dose_c}---</option>
								<!-- BEGIN: dose -->
								<option value="{DOSE.key}" {DOSE.selected}>{DOSE.text}</option>
								<!-- END: dose -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.weight}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19">
							<input class="form-control" type="text" name="weight" value="{ROW.weight}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.pulse}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19">
							<input class="form-control" type="text" name="pulse" value="{ROW.pulse}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.blood_pressure}</strong> <span class="red">(*)</span></label>
						<div class="col-sm-19">
							<input class="form-control" type="text" name="blood_pressure" value="{ROW.blood_pressure}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-5 control-label"><strong>{LANG.condition}</strong></label>
						<div class="col-sm-19">
							<input class="form-control" type="text" name="state" id="state" value="{ROW.state}" />
						</div>
					</div>
				</div>
			</div>
			<hr />
			<div class="form-group" style="text-align: center">
				<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.autocomplete.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#birthday").datepicker({
			dateFormat : "dd/mm/yy",
			changeMonth : true,
			changeYear : true,
			showOtherMonths : true,
			showOn : 'focus'
		});
		$('#birthday-btn').click(function(){
			$("#to").datepicker('show');
		});
	});

	$('#identity_card').blur(function(){
		var identity_card = $(this).val();
		var donation_id = '{ROW.donation_id}';
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=donation_person&nocache=' + new Date().getTime(), 'check_identity_card=1&donation_id='+donation_id+'&identity_card=' + identity_card, function(res) {
			var r_split = res.split('_');
			$('#div_info').html( r_split[1] );
			$('#div_info').slideDown();

			if( r_split[0] == 'OK' ){
				$('#last_name, #first_name, #gender, #phone, #blood_group').attr( 'readonly', 'readonly' );
				$('#rh_').attr( 'disabled', 'disabled' );
				$('#card_code').focus();
			}

			return;
		});
	});
</script>

<!-- BEGIN: frm_disabled -->
<script type="text/javascript">
	$('#identity_card, #last_name, #first_name, #gender, #phone, #blood_group').attr( 'readonly', 'readonly' );
	$('#rh_').attr( 'disabled', 'disabled' );
	$('#card_code').focus();
</script>
<!-- END: frm_disabled -->

<!-- END: main -->