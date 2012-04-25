{box title = "Advisor Form Approval" size = "12"}
	<h3>Advisees that need approval</h3>
	<table class="grid">
		<tr>
			<td>ID</td>
			<td>Student Full Name</td>		
			<td>Form Type</td>
			<td>Date Submitted</td>
			{foreach from=$advisees item=adv}
				</tr><tr>
					<td><a href="{$PHP.BASE_URL}/transfer-credit/view/advisor-approval?id={$adv.id}">{$adv.id}</a></td>
					<td>{$adv.fullname}</td>		
					<td>{$adv.form_type}</td>		
					<td>{$adv.date_submitted}</td>		
			{/foreach}
		</tr>
	</table>
{/box}