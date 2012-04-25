{box title = "Student Form Submission" size = "8"}
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
			</tr><tr><strong>
				<td>Institution: {$institution}</td>
				{foreach from=$meta_records item=val}
			</tr><tr>
				<td>{$val.meta_name}: {$val.meta_value}</td>
			</strong></tr>
			{/foreach}
		</table>
{/box}
<form action='{$PHP.BASE_URL}/transfer-credit/submit/advisor-approval' method="POST" class="{$form->classes()}">
	{box title = "Advisor Form Approval" size = "8"}
	<ul>
		{$form->status_key->as_li()}
		{$form->notes->as_li()}
	</ul>
	{/box}

	{box size=16}
		<p class="center" style="font-size: 1.5em;"><input type="submit" value="Submit Application"></p>
	{/box}

</form>
