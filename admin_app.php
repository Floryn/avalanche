<?php

if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

if(isset($_POST['create'])){
	if(isset($_POST['key']) && $_POST['fieldname']){
		$sql->db_Insert("wowapp_application", "'', '".$tp->toDB($_POST['key'])."', '".$tp->toDB($_POST['fieldname'])."', '".$_POST['type']."', '".$tp->toDB($_POST['value'])."'") or die(mysql_error());
		$message = "Your field has been created successfully!";
	}else{
		$message = "You need to define a question and a fieldname in order for your field to be created.";
	}
}

if (isset($message)) {
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$text = "<div style='text-align:center'>
<form method='post' action='".e_SELF."'>
<table style='width:90%' class='fborder'>
	<tr>
		<td class='fcaption'>Question</td>
		<td class='fcaption'>Field Name</td>
		<td class='fcaption'>Field Type</td>
		<td class='fcaption'>Field Values</td>
	</tr>
	<tr>
		<td class='forumheader3'>
			<input type='text' name='key' class='tbox' />
		</td>
		<td class='forumheader3'>
			<input type='text' name='fieldname' class='tbox' />
		</td>
		<td class='forumheader3'>
			<select name='type' class='tbox'>
			<option value='textbox'>Text Box</option>
			<option value='textarea'>Text Area</option>
			<option value='radio'>Radio Button</option>
			<option value='checkbox'>Checkbox</option>
			<option value='dropdown'>Drop Down</option>
			</select>
		</td>
		<td class='forumheader3'>
			<input type='text' name='value' class='tbox' />
		</td>
	</tr>
	<tr>
		<td class='forumheader2'><i>The question you wish to ask the applicant.</i></td>
		<td class='forumheader2'><i>A name for the field being created. Usually a short word, lower case, without spaces.</i></td>
		<td class='forumheader2'><i>The type of field to use. Simple questions should use text boxes, long answers should use textareas, multipe choice questions should use radio boxes or drop downs, and multiple-select choices should use checkboxes.</i></td>
		<td class='forumheader2'><i>The value(s) inside the field types. If you select radio button, checkbox, or drop down; split your choices with a comma.</i></td>
	</tr>
	<tr>
		<td colspan='4' style='text-align:center' class='forumheader'>
			<input class='button' type='submit' name='create' value='Create Field' />
			<input type='reset' class='button' value='Reset' />
		</td>
	</tr>
</table>
</form>
</div>";

$ns->tablerender("Configure WoW Guild Applcation: Application Information", $text);

$text2 = "<div style='text-align:center'>";

if($sql->db_Count("wowapp_application", "(*)") == 0){
	$text2 .= "No fields have been created at this time.";
}else{
	$sql->db_Select("wowapp_application", "*") or die(mysql_error());
	$text2 .= "
	<table style='width:90%' class='fborder'>
	<tr>
		<td class='fcaption'>Question</td>
		<td class='fcaption'>Field Name</td>
		<td class='fcaption'>Field Type</td>
		<td class='fcaption'>Field Values</td>
		<td class='fcaption'>&nbsp;</td>
	</tr>";

	while($row = $sql->db_Fetch()){
		$text2 .= "
		<tr>
			<td class='forumheader3'>".$row['wa_key']."</td>
			<td class='forumheader3'>".$row['wa_fieldname']."</td>
			<td class='forumheader3'>".$row['wa_type']."</td>
			<td class='forumheader3'>".$row['wa_value']."</td>
			<td class='forumheader3'><a href='#'>".ADMIN_EDIT_ICON."</a> <a href='#'>".ADMIN_DELETE_ICON."</a></td>
		</tr>";
	}

	$text2 .= "</table>";
}

$text2 .= "</div>";

$ns->tablerender("Configure WoW Guild Applcation: Created Fields", $text2);

require_once(e_ADMIN."footer.php");

?>