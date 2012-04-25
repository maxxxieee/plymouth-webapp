{box title = "Transfer Credit Form Submission and Approval" size = "8"}
	<h3>Student Information</h3>
		<table class="grid" >
			<tr>
				<td>Student ID: {$person->id}</td>
			</tr><tr>
				<td>Fullname: {$person->first_name} {$person->last_name} {$person->middle_name}</td>
			</tr><tr>
				<td>Campus Email:
						{foreach from=$person->email.CA item=item}
								{$item->email_address}
						{/foreach}
				</td>
			</tr><tr>
				<td>Mailing Address: 
					<ul>
						{foreach from=$person->address.MA item=item}
							<li>{$item->street_line1}</li>
							<li>{$item->city}, {$item->state_abbr}  {$item->zip}</li>
						{/foreach}
					 </ul>
				</td>
			</tr><tr>
				<td>Campus Hub Suite Number: 
					<ul>
						{foreach from=$person->address.CA item=item}
							<li>{$item->street_line1}</li>
							<li>{$item->city}, {$item->state_abbr}  {$item->zip}</li>
						{/foreach}
					 </ul>
				</td>
			</tr><tr>
				<td>Catalog Used For Graduation: {$person->student->ug.catalog_term_code}</td>
			</tr><tr>
				<td>Major \ Option: 
					<ul>
						{foreach from = $person->student->ug->curriculum.major item = item}
							{foreach from = $item item = major}
								<li>{$major.program} {$major.description} \ 
							{/foreach}
						{/foreach}
						{foreach from = $person->student->ug->curriculum.concentration item = item}
							{foreach from = $item item = concen}
								{$concen.description}</li>
							{/foreach}
						{/foreach}
					<ul>
				</td>
			</tr><tr>
				<td>Minor(s): 
					<ul>
						{foreach from = $person->student->ug->curriculum.minor item = item}
							{foreach from = $item item = minor}
								{if $minor.description}
									<li>{$minor.description}</li>
								{/if}
							{/foreach}
						{/foreach}
					</ul>
				</td>
			</tr></tr>
				<td>Advisor(s): {$advisor_name}</td>
			</tr>
		</table>
{/box}
<form action='{$PHP.BASE_URL}/transfer-credit/submit/submission' method="POST" class="{$form->classes()}">
	{box title = "Transfer Credit Form Submission and Approval" size = "8"}
		<ul>
			{$form->enrolled->as_li()}
			{$form->failed->as_li()}
			{$form->ceeb->as_li()}
			{$form->transfer_course_id->as_li()}
			{$form->transfer_course_title->as_li()}
			{$form->termyear_last_taken->as_li()}
			{$form->numb_transfer_credits->as_li()}
			{$form->semester_quarter_credits->as_li()}
		</ul>
		<input type="hidden" name='status_key' value="awaiting approval" />
		<input type="hidden" name="signed_date" value="{$signed_date}" />
		<input type="hidden" name="type_id" value="1" />
		{foreach from=$person->email.CA item=item}
			<input type="hidden" name="email" value="{$item->email_address}" />
		{/foreach}
	{/box}

	{box size=16}
		<p class="center" style="font-size: 1.5em;"><input type="submit" value="Submit Application"></p>
	{/box}

</form>

