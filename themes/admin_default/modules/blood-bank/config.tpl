<!-- BEGIN: main -->
<form action="" method="post">
	<div class="panel panel-default">
		<div class="panel-heading">
			{LANG.config}
		</div>
		<table class="table">
			<colgroup>
				<col class="w200" />
			</colgroup>
			<tr>
				<td><strong>{LANG.config_per_page}</strong></td>
				<td>
					<div class="row">
						<div class="col-xs-3">
							<input type="number" name="per_page" class="form-control" value="{DATA.per_page}" />
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td><strong>{LANG.config_group_view_member}</strong></td>
				<td>
					<div class="row">
						<div class="col-xs-24">
							<!-- BEGIN: groups_view_member -->
							<label class="show"><input name="groups_view_member[]" value="{GROUPS_VIEW.key}" type="checkbox"{GROUPS_VIEW.checked} /> {GROUPS_VIEW.title}</label>
							<!-- END: groups_view_member -->
						</div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<input type="submit" class="btn btn-primary" value="{LANG.save}" name="savesetting" />
</form>
<!-- BEGIN: main -->