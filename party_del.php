<?
require("include/top.php");

if ($SESSION_LEVEL=='administrator' || $SESSION_LEVEL=='moderator'):

if ($id && $action=='delete')
{
	$query = "update prods set party=1024 WHERE party=$id";
	mysql_query($query);
	$query = "DELETE FROM partylinks WHERE party=$id";
	mysql_query($query);
	$query = "DELETE FROM parties WHERE id=$id LIMIT 1";
	mysql_query($query);
	
	print("party $id deleted<br />\n");

  logGloperatorAction("party_del",$id);
}

?>

<p>DOUBLE CHECK THAT YOU'RE DELETING THE RIGHT PARTY NUMBER BEFORE CLICKING!</p>
<p>THE LOBSTER WILL EAT YOUR CHILDREN IF YOU DONT!!</p>
<p>THIS IS THE ONE AND ONLY WARNING!!!</p>
<p>DOUBLE CHECK THE NUMBER!!!</p>

<form action="<?=basename($SCRIPT_FILENAME)?>" method="post">
party ID
<input type="text" name="id">
<input type="submit" name="action" value="delete">
</form>

<? else: ?>

<p>aiiiiiii tio cookie, esta es una pagina mui peligrosa!!</p>

<form action="login.php" method="post">
<table cellspacing="1" cellpadding="2" class="box">
 <tr bgcolor="#446688">
  <td nowrap align="center">
   <input type="text" name="login" value="SceneID" size="15" maxlength="16" onfocus="this.value=''">
   <input type="password" name="password" value="password" size="15" onfocus="javascript:if(this.value=='password') this.value='';"><br />
  </td>
 </tr>
 <tr>
  <td bgcolor="#6688AA" align="right">
   <input type="image" src="gfx/submit.gif">
  </td>
 </tr>
</table>
</form>

<? endif; ?>
<br />
<? require("include/bottom.php"); ?>
