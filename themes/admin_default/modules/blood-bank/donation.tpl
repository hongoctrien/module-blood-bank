<!-- BEGIN: main -->

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
				<col span="3" />
				<col class="w100" />
				<col class="w150" span="3" />
			</colgroup>
			<thead>
				<tr>
					<th>{LANG.title}</th>
					<th>{LANG.organ_id}</th>
					<th>{LANG.donor_id}</th>
					<th class="text-center"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.join_n}">{LANG.join}</a></th>
					<th>{LANG.start_time}</th>
					<th>{LANG.end_time}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="6">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td> {VIEW.title} </td>
					<td> {VIEW.organ_id} </td>
					<td> {VIEW.donor_id} </td>
					<td class="text-center"> {VIEW.num_blood_donor} </td>
					<td> {VIEW.start_time} </td>
					<td> {VIEW.end_time} </td>
					<td class="text-center"><a href="{VIEW.link_blood_donor}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.donor_list}"><em class="fa fa-street-view fa-lg">&nbsp;</em></a>&nbsp;&nbsp;<a href="{VIEW.link_edit}#edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.edit}"><i class="fa fa-edit fa-lg">&nbsp;</i></a>&nbsp;&nbsp;<a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);" data-toggle="tooltip" data-placement="top" title="" data-original-title="{LANG.delete}"><em class="fa fa-trash-o fa-lg">&nbsp;</em></a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.theme.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.css" rel="stylesheet" />
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.css" rel="stylesheet" />

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
				<label class="col-sm-4 control-label"><strong>{LANG.organ_id}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-20">
					<select class="form-control" name="organ_id" id="organ_id">
						<option value=""> ---{LANG.organ_id_c}--- </option>
						<!-- BEGIN: select_organ_id -->
						<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
						<!-- END: select_organ_id -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.donor_id}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-20">
					<select class="form-control" name="donor_id" id="donor_id">
						<option value=""> ---{LANG.donor_id_c}--- </option>
						<!-- BEGIN: select_donor_id -->
						<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
						<!-- END: select_donor_id -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.time}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" class="form-control" name="start_time" id="start_time" value="{ROW.start_time}" readonly="readonly" placeholder="{LANG.start_time}">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="start_time-btn">
								<em class="fa fa-calendar fa-fix">&nbsp;</em>
							</button> </span>
					</div>
				</div>
				<div class="col-sm-10">
					<div class="input-group">
						<input type="text" class="form-control" name="end_time" id="end_time" value="{ROW.end_time}" readonly="readonly" placeholder="{LANG.end_time}">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="end_time-btn">
								<em class="fa fa-calendar fa-fix">&nbsp;</em>
							</button> </span>
					</div>
				</div>
			</div>
			<div class="form-group" style="text-align: center">
				<input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.menu.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>

<script type="text/javascript">
	//<![CDATA[

	$(document).ready(function() {
		$("#organ_id, #donor_id").select2();
	});

	$("#start_time,#end_time").datepicker({
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		changeYear : true,
		showOtherMonths : true,
		showOn : 'focus'
	});
	$('#start_time-btn').click(function(){
		$("#start_time").datepicker('show');
	});
	$('#end_time-btn').click(function(){
		$("#end_time").datepicker('show');
	});
	//]]>
</script>
<!-- END: main -->