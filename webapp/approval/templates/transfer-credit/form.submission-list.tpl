{box title = "Form Submissions" size = "16"}
	<h3>Submissions</h3>
	<form method="GET" action="{$PHP.BASE_URL}/transfer-credit/view/submission?submission_id={$submission_id}'">
		<table class="grid">
			<tr>
				<td>Full Name</td>
				<td>Form Name</td>
				<td>Initial Signed Date</td>
				<td>Meta ID</td>
				<td>Meta Value</td>		
				{foreach from=$transfercredit item=trans}
					</tr><tr>
						<td>{$trans.fullname}</td>		
						<td>{$trans.form_name}</td>		
						<td>{$trans.initial_signed_date}</td>
						<td>{$trans.meta_id}</td>
						<td>{$trans.meta_value}</td>		
				{/foreach}
				</tr>
			</table>
	</form>
{/box}
{box title = "Responses" size = "16"}
	<form method="GET" action="{$PHP.BASE_URL}/transfer-credit/view/submission?submission_id={$submission_id}'">
		<table class="grid">
			<tr>
				<td>Status</td>	
				<td>Name</td>
				<td>Assigned to Group</td>		
				<td>Notes</td>		
				<td>Approval Signed Date</td>		
			</tr><tr>
				{foreach from=$responses item=resp}
					</tr><tr>
						<td>{$resp.status}</td>
						<td>{$advisor_name}</td>		
						<td>{$resp.assigned_to_group}</td>		
						<td>{$resp.notes}</td>		
						<td>{$resp.approval_signed_date}</td>	
				{/foreach}
			</tr>
		</table>
		<p><input type="submit" name="submit" value="New Submission" /></p>
	</form>
{/box}