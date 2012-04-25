{box title = "Form Department Chair" size = "16"}
	<h3>Submissions</h3>
	<table class="grid">
		<tr>
			<td>ID</td>
			<td>Student Full Name</td>		
			<td>Form Type</td>
			<td>Date Submitted</td>
			{foreach from=$chairs item=ch}
				</tr><tr>
					<td><a href="{$PHP.BASE_URL}/transfer-credit/view/form.chair-approval?submission_id={$ch.id}&student_pidm={$ch.student_pidm}&type=chair">{$ch.id}</a></td>
					<td>{$ch.fullname}</td>		
					<td>{$ch.form_type}</td>		
					<td>{$ch.date_submitted}</td>		
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