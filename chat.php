<?
set_include_path(get_include_path() . PATH_SEPARATOR . 'class');
include 'session_saveable.class.php';
include 'talker.class.php';
include 'talk.class.php'  ;
include 'chat.class.php'  ;
include 'lib.inc.php'     ;

date_default_timezone_set("Europe/Vilnius");

session_start();

?> 

<?
if(isset($_GET['say'])) {
	$talker = Talker::load(); //talker is from local
	$sid = end_default_context();
	start_global_context();
	$chat   = Chat::load();   //chat is from global
	$chat->say($_POST['chat']['words'], $talker);
	$chat->save();
	end_global_context();
	start_default_context($sid);
}
?>

<?  if(isset($_GET['chat'])) { ?>
<html>
<head>
	<meta http-equiv="refresh" content="1">
</head>
<body>
<?
	$talker = Talker::load(); //talker is from local
	$sid = end_default_context();
	start_global_context();//go to server scope
	$chat   = Chat::load();
	$talks  = &$chat->talks(); 
	end_global_context();
	start_default_context($sid);//return to original scope
?> 
<table style="position: absolute; bottom:0">
<caption>Chat</caption>
<tbody>
<? foreach($talks as $talk) { ?> 
	<tr><td><?= so(date("H:i:s", $talk->when())) ?><td><i><?= so($chat->talker($talk->talker_sid())->nickname()) ?> says:</i> <u><?= so($talk->text()) ?></u>
<? } ?>
</tbody>
</table>

</body>
</html>
<? } ?>

<?
if(isset($_GET['set_nickname']) && isset($_POST['talker']['nickname'])) {
	$talker = Talker::load();
	$talker->setNickname($_POST['talker']['nickname']);
	$talker->setSid(session_id());
	$talker->save();
	header("Location: ?box");
}
?>

<?
if(isset($_GET['drop'])) { ?>
<? drop(); ?>
You are now logged out of the chat. If you want to continue <b>reload the page</b>.
<? } ?> 

<? if(isset($_GET['box'])) { 
	$talker = Talker::load();
	if(NULL != $talker->nickname()) {
		echo 'Your nickname is <i>'.so($talker->nickname()).'</i>
<form method="post" action="?say&box" >
	<input type="text" name="chat[words]" id="box" />
	<input type="submit" value="Say!" />
	<a href="?drop">logout</a>
</form><script type="text/javascript">document.getElementById("box").focus();</script>';
	} else {
		//show talker set nickname form
		$talker = Talker::load();
		echo '
<form method="post" action="?set_nickname">
	<label for="talker_nickname">Nickname</label>
	<input type="text" name="talker[nickname]" id="talker_nickname" value="'.so($talker->nickname()).'" />
	<input type="submit" value="Set" />
</form>';
	}
?>

<? } ?> 

<? if(isset($_GET['footer'])) { ?>
	<html>
		<head>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		</head>
		<body>
<p class="small">2013 <a href="mailto:mzilenas@gmail.com">Marius Žilėnas</a> *** Reload the page with <i>&lt;CTRL+R&gt;</i></p>
	</body>
	</html>
<? } ?>
