<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<fieldset>

<h3>Nazwa przepisu:</h3>

<form action="dodaj.php" >
	<input type="text" name="przepis" size="50" disabled="disabled"/>
</form>


<h3>Treść przepisu:</h3>

<form action="dodaj.php">
	<textarea name="tresc" cols="100" rows="20"></textarea>
</form>


<h4>Przepis edytował użytkownik:</h4>

<form action="dodaj.php">
	<input type="text" name="przepis" size="25"/>
</form>



<input type="submit" onclick="alert('Dziękujemy za edycję przepisu!')" >

</form>
</fieldset>

</body>
</html>


