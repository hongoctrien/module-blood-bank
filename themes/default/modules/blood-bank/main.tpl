<!-- BEGIN: main -->
<div class="well">
	<form action="{NV_BASE_SITEURL}index.php" method="get">
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />

		<div class="row">
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<input class="form-control" type="text" value="{SEARCH.keywords}" name="keywords" placeholder="{LANG.keywords}">
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<select class="form-control" name="blood_group">
						<option value="">---{LANG.blood_group_ch}---</option>
						<!-- BEGIN: blood_group -->
						<option value="{BLOOD.key}" {BLOOD.selected}>{BLOOD.value}</option>
						<!-- END: blood_group -->
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="search" value="{LANG.search}">
				</div>
			</div>
		</div>
	</form>
</div>

<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col width="50" />
			<col span="2" />
			<col width="100" span="2" />
		</colgroup>
		<thead>
			<tr>
				<th class="text-center">{LANG.no}</th>
				<th>{LANG.first_name}</th>
				<th>{LANG.last_name}</th>
				<th>{LANG.birthday}</th>
				<th class="text-center">{LANG.sex}</th>
				<th>{LANG.organize}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">{DATA.no}</td>
				<td>{DATA.last_name}</td>
				<td><a href="{DATA.link}" title="{DATA.first_name}">{DATA.first_name}</a></td>
				<td>{DATA.birthday}</td>
				<td class="text-center">{DATA.gender}</td>
				<td>{DATA.organize}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>

<!-- BEGIN: generate_page -->
<div class="text-center">{PAGE}</div>
<!-- END: generate_page -->

<!-- END: main -->