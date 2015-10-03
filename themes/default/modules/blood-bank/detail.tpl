<!-- BEGIN: main -->
<h2>{LANG.DATA_info}</h2>
<div class="row m-bottom">
	<div class="col-md-6 text-center">
		<img src="{DATA.photo}" alt="{DATA.fullname}" class="img-thumbnail m-bottom"/><br />
		{LANG.img_size_title}
	</div>
	<div class="col-md-18">
		<ul class="nv-list-item xsm">
			<li><em class="fa fa-chevron-right ">&nbsp;</em> {LANG.fullname}: <strong>{DATA.last_name} {DATA.first_name}</strong></li>
			<li><em class="fa fa-chevron-right ">&nbsp;</em> {LANG.birthday}: <strong>{DATA.birthday}</strong></li>
			<li><em class="fa fa-chevron-right ">&nbsp;</em> {LANG.sex}: <strong>{DATA.gender}</strong></li>
			<li><em class="fa fa-chevron-right ">&nbsp;</em> {LANG.organize}: <strong>{DATA.organize}</strong></li>
			<li><em class="fa fa-chevron-right ">&nbsp;</em> {LANG.blood_group}: <strong>{DATA.blood_group}</strong></li>
		</ul>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<col width="200" />
		<tbody>
			<!-- BEGIN: email -->
			<tr>
				<th>Email</th>
				<td><a href="mailto:{DATA.email}" title="Send mail to {DATA.email}">{DATA.email}</a></td>
			</tr>
			<!-- END: email -->
			<!-- BEGIN: phone -->
			<tr>
				<th>{LANG.tel}</th>
				<td>{DATA.phone}</td>
			</tr>
			<!-- END: phone -->
			<!-- BEGIN: identity_card -->
			<tr>
				<th>{LANG.identity_card}</th>
				<td>{DATA.identity_card}</td>
			</tr>
			<!-- END: identity_card -->
			<!-- BEGIN: width -->
			<tr>
				<th>{LANG.width}</th>
				<td>{DATA.width}m</td>
			</tr>
			<!-- END: width -->
			<!-- BEGIN: weight -->
			<tr>
				<th>{LANG.weight}</th>
				<td>{DATA.weight}kg</td>
			</tr>
			<!-- END: weight -->
			<!-- BEGIN: recent_time -->
			<tr>
				<th>{LANG.recent_time}</th>
				<td>{DATA.recent_time}</td>
			</tr>
			<!-- END: recent_time -->
			<tr>
				<th>{LANG.resident}</th>
				<td>{DATA.resident.ward}, {DATA.resident.district}, {DATA.resident.province}</td>
			</tr>
			<tr>
				<th>{LANG.temporarily}</th>
				<td>{DATA.temporarily.ward}, {DATA.temporarily.district}, {DATA.temporarily.province}</td>
			</tr>
		</tbody>
	</table>
</div>

<!-- BEGIN: history -->
<div class="table-responsive">
	<table class="table table-bordered table-striped">
		<caption>{LANG.history}</caption>
		<thead>
			<tr>
				<th>{LANG.time}</th>
				<th>{LANG.card_code}</th>
				<th>{LANG.dose} (ml)</th>
				<th>{LANG.weight} (kg)</th>
				<th>{LANG.pulse}</th>
				<th>{LANG.blood_pressure}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td>{HISTORY.time}</td>
				<td>{HISTORY.card_code}</td>
				<td>{HISTORY.dose}</td>
				<td>{HISTORY.weight}</td>
				<td>{HISTORY.pulse}</td>
				<td>{HISTORY.blood_pressure}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: history -->

<!-- END: main -->