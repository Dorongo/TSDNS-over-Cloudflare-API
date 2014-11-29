<?
include("config.php");
error_reporting(0);
?>

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
	<form class="uk-form" action="index.php?p=success" method="POST">
<fieldset>
        <legend>Teamspeak 3 TSDNS System</legend>
			<div class="row">
		<div class="col-xs-6"><div class="form-group has-error has-feedback"><input type="text" class="form-control" placeholder="Name not available" name="subname"></div></div>
			<div class="uk-form-row"><div class="col-xs-6"><select name="select" class="form-control"><option>.<? echo $domain; ?></option></select></div></div></div><br>
        	<div class="uk-form-row"><input type="text" class="form-control" placeholder="IP Adresse" name="ip"></div><br>
        	<div class="uk-form-row"><input type="text" class="form-control" placeholder="Port" name="port"></div>
			<br><center>
        <div class="uk-form-row">
        	<input type="hidden" name="do" value="insert">
        	<button type="submit" value="Create Channel" class="btn btn-default">Create TSDNS</button>
		</div>
		</center>
    </fieldset>
</form>

<script type="application/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="application/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="application/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.js"></script>