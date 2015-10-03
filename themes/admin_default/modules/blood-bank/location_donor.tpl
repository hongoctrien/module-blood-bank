<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">

<!-- BEGIN: view -->
<div class="well">
	<form action="{NV_BASE_ADMINURL}index.php" method="get">
		<input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
		<div class="row">
			<div class="col-xs-24 col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" value="{SEARCH.q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
				</div>
			</div>
			<div class="col-xs-24 col-md-6">
				<div class="form-group">
					<select class="form-control" name="type_id">
						<option value=""> ---{LANG.location_type_c}--- </option>
						<!-- BEGIN: select_type_id_search -->
						<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
						<!-- END: select_type_id_search -->
					</select>
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
			<thead>
				<tr>
					<th class="w50 text-center">{LANG.number}</th>
					<th>{LANG.title}</th>
					<th class="w250">{LANG.type_id}</th>
					<th class="w100 text-center">{LANG.active}</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="5">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"> {VIEW.number} </td>
					<td> {VIEW.title} </td>
					<td> {VIEW.type_id} </td>
					<td class="text-center">
					<input type="checkbox" name="status" id="change_status_{VIEW.id}" value="{VIEW.id}" {CHECK} onclick="nv_change_status({VIEW.id});" />
					</td>
					<td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i><a href="{VIEW.link_edit}#edit">{GLANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em><a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{GLANG.delete}</a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">
	{ERROR}
</div>
<!-- END: error -->
<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<input type="hidden" name="id" value="{ROW.id}" />
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.title}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-20">
					<input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.type_id}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-20">
					<select class="form-control" name="type_id">
						<option value=""> ---{LANG.location_type_c}--- </option>
						<!-- BEGIN: select_type_id -->
						<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
						<!-- END: select_type_id -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.description}</strong></label>
				<div class="col-sm-20">
					<textarea class="form-control" style="height:100px;" cols="75" rows="5" name="description">{ROW.description}</textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.province}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-10">
					<select name="province" class="form-control" id="province" style="width: 100%">
						<!-- BEGIN: province -->
						<option value="{PROVINCE.provinceid}" {PROVINCE.selected}>{PROVINCE.name}</option>
						<!-- END: province -->
					</select>
				</div>
				<div class="col-sm-10">
					<select name="district" class="form-control" id="district" style="width: 100%">

					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.extend}</strong></label>
				<div class="col-sm-20">
					<input class="form-control" type="text" name="extend" value="{ROW.extend}" placeholder="{LANG.stress}" />
				</div>
			</div>
			<div class="form-group" style="text-align: center">
				<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript">
	//<![CDATA[
	$(document).ready(function() {
		$("#province").select2();

		get_district('{ROW.district}');

		$("#province").change(function() {
			get_district('{ROW.district}');
		});
	});

	function get_district(sl_district) {
		var provinceid = $("#province").val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_district=1&provinceid=' + provinceid + '&sl_district=' + sl_district, function(res) {
			$("#district").html(res);
			$("#district").select2();
		});
	}

	function nv_change_status(id) {
		var new_status = $('#change_status_' + id).is(':checked') ? true : false;
		if (confirm(nv_is_change_act_confirm[0])) {
			var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=location_donor&nocache=' + new Date().getTime(), 'change_status=1&id=' + id, function(res) {
				var r_split = res.split('_');
				if (r_split[0] != 'OK') {
					alert(nv_is_change_act_confirm[2]);
				}
			});
		} else {
			$('#change_status_' + id).prop('checked', new_status ? false : true);
		}
		return;
	}

	//]]>
</script>
<!-- END: main -->