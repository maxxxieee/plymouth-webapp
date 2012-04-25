{box title = "Form Undergraduate Studies" size = "16"}
	<h3>Submissions</h3>
	<table class="grid">
		<tr>
			<td>ID</td>
			<td>Student Full Name</td>		
			<td>Form Type</td>
			<td>Date Submitted</td>
			{foreach from=$undergrad item=ug}
				</tr><tr>
					<td><a href="{$PHP.BASE_URL}/transfer-credit/view/form.ug-approval?submission_id={$ug.id}&student_pidm={$ug.student_pidm}&type=ugs">{$ug.id}</a></td>
					<td>{$ug.fullname}</td>		
					<td>{$ug.form_type}</td>		
					<td>{$ug.date_submitted}</td>		
			{/foreach}
		</tr>
	</table>
{/box}
{box title = "Responses" size = "16"}
	<table class="grid">
		<tr>
			<td>ID</td>
			<td>Status</td>	
			<td>Name</td>
			<td>Assigned to Group</td>		
			<td>Notes</td>		
			<td>Approval Signed Date</td>		
			{foreach from=$responses item=resp}
			</tr><tr>
				<td>{$resp.id}</td>
				<td>{$resp.status}</td>
				<td>{$advisor_name}</td>		
				<td>{$resp.assigned_to_group}</td>		
				<td>{$resp.notes}</td>		
				<td>{$resp.approval_signed_date}</td>	
			{/foreach}
		</tr>
	</table>
{/box}