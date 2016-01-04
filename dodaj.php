<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
</head>
<body>

<fieldset>

<h3>Wprowadź nazwę użytkownika:</h3>

<form action="dodaj.php">
	<input type="text" name="przepis" size="25"/>
</form>



<h3>Wprowadź nazwę przepisu:</h3>

<form action="dodaj.php" >
	<input type="text" name="przepis" size="50"/>
</form>



<h3>Wprowadź treść przepisu:</h3>

<form action="dodaj.php">
	<textarea name="tresc" cols="100" rows="20"></textarea>
</form>



<form action="dodaj.php">
<h3>Jakich składników, użyłeś w swoim przepisie?</h3>
<h5>aby wybrac więcej składników, przytrzymaj klawisz Ctrl</h5>

<select name="skladniki" size="10" multiple="multiple">



<?php //connection

        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       if($db)
         echo "Polaczono ...<br/>";
       else
         echo "Nie mozna sie polaczyc<br/>";

$query = 'SELECT id, nazwa FROM produkty ORDER BY nazwa';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
   
        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
      

}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

// Zamknięcie połączenia
pg_close($dbconn)

?>

</select>

</form>

<input type="submit" onclick="alert('Dziękujemy za dodanie przepisu!')" >


</fieldset>


</body></html>