<!-- BEGIN: main -->
<form action="{ACTION}" method="get">
	<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
	<div class="form-group">
		<label>{LANG.keywords}</label>
		<input type="text" class="form-control" name="keywords" >
	</div>
	<div class="form-group">
		<label>{LANG.blood_group}</label>
		<select class="form-control" name="blood_group">
			<option value="">---{LANG.blood_group_ch}---</option>
			<!-- BEGIN: blood_group -->
			<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
			<!-- END: blood_group -->
		</select>
	</div>
	<input class="btn btn-primary" type="submit" name="search" value="{LANG.search}">
</form>
<!-- END: main -->