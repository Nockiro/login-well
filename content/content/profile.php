<style type="text/css">
table {
	text-align: inherit;
}
</style>
<div class="content">

	<h3>Profil</h3>
	<hr/>
	<table>
		<tr>
			<td>
				<label for="username">Username:</label>
			</td>
			<td>
				<input name="username" value="<?php echo $_SESSION['username']; ?>" size="50" maxlength="#50">
			</td>
		</tr>
		<tr>
			<td>
				<label for="password">Passwort:</label>
			</td>
			<td>
				<input name="password" type="password" value="somepass" size="50" maxlength="#50">
			</td>
		</tr>
		<tr>
			<td>
				<label for="password">Email:</label>
			</td>
			<td>
				<input name="password" type="email" value="<?php echo $_SESSION['email']; ?>" size="50" maxlength="#50">
			</td>
		</tr>
	</table>
	<input type="button" value="&Auml;nderungen &uuml;bernehmen" />
	<a href="/index.php?cp=account_deletion">
		<input type="button" value="Account l&ouml;schen" />
	</a>
</div>