<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
</head>
<body>
<fieldset>

<h3>Nazwa przepisu:</h3>

<form action="dodaj.php" >
	<input type="text" name="przepis" size="50" readonly="readonly"/>
</form>



<h3>Treść przepisu:</h3>

<form action="dodaj.php">
	<textarea name="tresc" cols="100" rows="20" readonly="readonly"></textarea>
</form>


<h4>Przepis stwożył użytkownik:</h4>

<form action="dodaj.php">
	<input type="text" name="przepis" size="25" readonly="readonly"/>
</form>



<form action="edytuj.php">
<h4>Kliknij poniżej, aby edytować</h4>
	<input type="submit">
</form>

</fieldset>
</body></html>