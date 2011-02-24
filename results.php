<?php

require_once("../../class2.php");
require_once(e_PLUGIN."wowapp/class.php");
require_once(HEADERF);

$text = "This file is for testing purposes only. It will more than likely not be in the final release. The purpose of this file is to display the
results of the answers submitted on the apply.php page. If you notice anything wonky with the displaying of answers based on the questions,
please report the error to me. Creating complex applications and answering them in complex ways will help make this phase go by quickly.
<br /><br />
Below are the results of all submitted applications:

<table style='width:90%' class='fborder'>
<tr>
<td style='width:10%' class='fcaption'>userid</td>
<td style='width:40%' class='fcaption'>question</td>
<td style='width:50%' class='fcaption'>answer(s)</td>
</tr>";

$sql->db_Select("wowapp_request", "*");
while($row = $sql->db_Fetch()){

	$question = provokeQuestion($row['wa_qid']);
	$type = provokeQuestion($row['wa_qid'], "type");
	$values = provokeQuestion($row['wa_qid'], "value");

	if($type == "radio"){
		$values = explode(",", $values);
		$answer = $values[$row['wa_value']];

	}else if($type == "dropdown"){
		$values = explode(",", $values);
		$answer = $values[$row['wa_value']];

	}else if($type == "checkbox"){
		//$values = explode(",", $values);
		$checked = explode(",", $row['wa_value']);
		$answer = $checked[0];

	}else{
		$answer = $row['wa_value'];
	}

	$text .= "<tr>
	<td class='forumheader3'>".$row['wa_uid']."</td>
	<td class='forumheader3'>".$question."</td>
	<td class='forumheader3'>".$answer."</td>
	</tr>";
}

$text .= "</table>";

$ns->tablerender("Application Results", $text);
	
require_once(FOOTERF);
?>