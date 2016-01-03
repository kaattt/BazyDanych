<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
</head>
<body>
<fieldset>
<h3>Jakie składniki masz w lodówce?</h3>
<h5>aby wybrac więcej składników, przytrzymaj klawisz Ctrl</h5>

<form action="wyswietlony.php" method="post">
<select name="skladniki" size="10" multiple="multiple">

<?php

$id = 2 ;
$nazwa = marchewka ;

echo "<option value= " . $id . " > " . $nazwa . "</option>"; 

?>

</select>
<input type="submit">
</form>


</fieldset>
</body></html>