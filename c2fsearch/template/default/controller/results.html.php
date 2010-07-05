You searched for:<br />
Location: {$sLocation}<br />
Faith: {$sFaith}<br />
<hr />
That is <br />
city:{$sCity}<br />
state:{$sState}<br />
zip:{$sZip}<br />
string:{$sString}
<br />
Members:
<ul>
{foreach from=$aRows item=aUser}
	<li>{$aUser.full_name}</li>
{/foreach}
</ul>

