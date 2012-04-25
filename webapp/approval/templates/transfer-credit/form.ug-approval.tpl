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
				{foreach from=$metavalues item=val}
			</tr><tr>
				<td>{$val.meta_name}: {$val.meta_value}</td>
			</strong></tr>
			{/foreach}
		</table>
{/box}
{box title = "Undergraduate Studies Form Approval" size = "8"}
	<form action="{$PHP.BASE_URL}/transfer-credit/submit/ug-approval" method="POST">
		<input type="hidden" name="submission_id" value="{$submission_id}" />
		<input type="hidden" name="type" value="ugs" />
		<table class="grid">
			<tr>
				<td>Please enter your selection using the drop down box:  <select name="status_key" size="1">
					{html_options options=$statuses}
					</select>
				</td>
			</tr><tr>
				<td>Notes/comments:  <textarea name="notes" rows="5" cols="50"></textarea></td>
			</tr><tr>
				<td>Please select department Chair using the drop down box:  <select name="chair" size="1">
					{html_options options=$chairs}
					</select>
				</td>
			</tr><tr>
				<td><input type="submit" name="submit" value="Submit" /></td>
			</tr>
		</table>
	</form>
{/box}