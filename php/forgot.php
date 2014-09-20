<?php
include("connect.php");
include("formvalidation.php");
$email = $_GET['email'];
$row = mysql_fetch_array(mysql_query("SELECT user_id, name, email FROM users WHERE email = '$email'"));
if($row['user_id']) {
	$password = mysql_fetch_array(mysql_query("SELECT password from password WHERE user_id = '$row[user_id]'"));
	$code = md5($password['password'].$row['email'].date("Y-m-d"));
	$link = "poddarri.5gbfree.com/emailpasswordchange.php?action=resetpassword&uid=$row[user_id]&code=$code";
	$subject = "Instructions to Reset Your LifeWin Password";
	$message = "
			<table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"font-family:'Helvetica Neue',arial,sans-serif\">
				<tbody><tr>
					<td><img src=\"http://poddarri.5gbfree.com/email-templates/images/spacer.gif\" border=\"0\" width=\"1\" height=\"20\" style=\"width:1px;min-height:20px;margin:0px\"></td>
				</tr>
				<tr>
					<td height=\"38\">
						<img src=\"http://poddarri.5gbfree.com/email-templates/images/lifewin-logo.png\" border=\"0\" width=\"150\" height=\"38\" alt=\"Otixo... bringing the clouds to you.\" style=\"width:150px;min-height:38px;margin:0px 0px\">
					</td>
				</tr>
				<tr>
					<td><img src=\"http:/poddarri.5gbfree.com/email-templates/images/spacer.gif\" border=\"0\" width=\"1\" height=\"15\" style=\"width:1px;min-height:15px;margin:0px\"></td>
				</tr>
			</tbody></table>
<table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#fafafa\" style=\"font-family:'Helvetica Neue',arial,sans-serif;background-color:#fafafa;border-right:1px solid #cccccc;border-left:1px solid #cccccc;border-top:1px solid #cccccc;border-top-left-radius:5px;border-top-right-radius:5px\">
	<tbody><tr>
		<td valign=\"top\" width=\"356\" style=\"padding:38px 60px 5px 60px\">

<h1 style=\"margin:0px;color:#ee2b74;font-size:24px;font-weight:normal\">Dear ".$row[name].",</h1>

<p style=\"margin:1em 0em;color:#555555;font-size:14px;line-height:20px\">A request was made to reset the password for your LifeWin account.</p>

<p style=\"margin:1em 0em;color:#555555;font-size:14px;line-height:20px\">You can reset your password by clicking on the link below. If
you did not want to reset your password, you can ignore this email and the link will expire tommorow.</p>

<p style=\"margin:1.5em 0em 1em 0em;color:#555555;font-size:14px;line-height:20px\">
	<a href=\"".$link."\" style=\"color:white;text-decoration:none\" target=\"_blank\">
		</a></p><table cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#3aa2aa\" style=\"font-family:'Helvetica Neue',arial,sans-serif;background-color:#3aa2aa\">
			<tbody><tr>
				<td height=\"35\" width=\"20\" background=\"http://poddarri.5gbfree.com/email-templates/images/button-left.png\" style=\"background-image:url(http://poddarri.5gbfree.com/email-templates/images/button-left.png')\">&nbsp;</td>
				<td height=\"35\" width=\"20\" valign=\"middle\" background=\"http://poddarri.5gbfree.com/email-templates/images/button-center.png\" style=\"background-image:url('http://poddarri.5gbfree.com/email-templates/images/button-center.png')\"><a href=\"".$link."\" style=\"white-space:nowrap;font-size:14px;color:white;text-decoration:none;line-height:35px\" target=\"_blank\">Reset my password</a></td>
				<td height=\"35\" width=\"20\" background=\"http://poddarri.5gbfree.com/email-templates/images/button-right.png\" style=\"background-image:url('http://poddarri.5gbfree.com/email-templates/images/button-right.png')\">&nbsp;</td>
			</tr>
		</tbody></table><a href=\"".$link."\" target=\"_blank\">
	</a>
<p></p>	

<p style=\"margin:1em 0em;color:#555555;font-size:14px;line-height:20px\">Thanks,<br>The LifeWin Team</p>

		</td>
	</tr>
</tbody></table>
			<table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#fafafa\" style=\"background-color:#fafafa\">
				<tbody><tr>
					<td height=\"46\">
						<img src=\"http://poddarri.5gbfree.com/email-templates/images/separator-grey-grey.png\" width=\"600\" height=\"46\" style=\"display:block;width:600px;min-height:46px\">
					</td>
				</tr>
			</tbody></table>	

			<table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#fafafa\" style=\"font-family:'Helvetica Neue',arial,sans-serif;background-color:#fafafa;border-right:1px solid #cccccc;border-bottom:1px solid #cccccc;border-left:1px solid #cccccc;border-bottom-right-radius:5px;border-bottom-left-radius:5px\">
				<tbody><tr>
					<td colspan=\"3\" style=\"padding:18px 60px 23px 60px\">
						<p style=\"margin:0em 0em;color:#555555;font-size:14px;font-weight:bold;line-height:20px\">Contact us and stay in touch:</p>
					</td>
				</tr>
				<tr>
					<td style=\"padding:0px 0px 10px 60px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-home.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"http://lifew.in/\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">lifew.in</a></p></td>
					<td style=\"padding:0px 30px 10px 30px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-email.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"mailto:support@lifew.in\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">support@lifew.in</a></p></td>
					<td style=\"padding:0px 60px 10px 0px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-wordpress.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"http://lifew.in/blog\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">blog.lifew.in</a></p></td>
				</tr><tr>
				</tr><tr>
					<td style=\"padding:0px 0px 0px 60px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-twitter.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"https://twitter.com/lifewin\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">twitter.com/lifewin</a></p></td>
					<td style=\"padding:0px 30px 0px 30px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-facebook.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"http://www.facebook.com/lifewin\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">facebook.com/lifewin</a></p></td>
					<td style=\"padding:0px 60px 0px 0px\"><p style=\"margin:0em;font-size:12px;line-height:18px\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/icon-assistly.png\" width=\"21\" height=\"20\" style=\"vertical-align:middle;width:21px;min-height:20px\"><a href=\"http://lifewin.desk.com/\" style=\"color:#2b8a91;text-decoration:none\" target=\"_blank\">lifewin.desk.com</a></p></td>
				</tr><tr>
				</tr><tr>
					<td colspan=\"3\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/spacer.gif\" border=\"0\" width=\"1\" height=\"30\" style=\"width:1px;min-height:30px;margin:0px\"></td>
				</tr>
				
			</tbody></table>
			<table width=\"600\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"font-family:'Helvetica Neue',arial,sans-serif\">
				<tbody><tr>
					<td colspan=\"3\"><img src=\"http://poddarri.5gbfree.com/email-templates/images/spacer.gif\" border=\"0\" width=\"1\" height=\"30\" style=\"width:1px;min-height:30px;margin:0px\"></td>
				</tr>
				<tr>
					<td width=\"229\">
						<img src=\"http://poddarri.5gbfree.com/email-templates/images/footer-logo.png\" border=\"0\" width=\"72\" height=\"19\" align=\"right\" style=\"display:block;width:72px;min-height:19px\" alt=\"LifeWin Logo\">
					</td>
					<td width=\"21\"></td>
					<td align=\"left\" style=\"color:#999999;font-size:10px\">
						Copyright © 2014, TasksWin, Inc.
					</td>
				</tr>
				<tr>
					<td colspan=\"3\"><img src=\http://poddarri.5gbfree.com/email-templates/images/spacer.gif\" border=\"0\" width=\"1\" height=\"30\" style=\"width:1px;min-height:30px;margin:0px\"></td>
				</tr>				
			</tbody></table>";
	$headers  = "From: noreply@borebandar.com\r\n"; 
    	$headers .= "Content-type: text/html\r\n"; 
	mail($row[email],$subject,$message, $headers);
	echo "Check your Email for the password reset link.";
}
else
	echo "User not found in our database.";
?>