<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<fieldset>

<h3>Nazwa przepisu:</h3>

<form>

<?php //connection

$skladnik1=$_POST['skladniki'];
        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";

$query = 'SELECT prze.nazwa FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= '. $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep;';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
   
        echo "<input type=\"text\" name=\"przepis\" size=\"50\" value= \"" . $line[0] .  "\" readonly=\"readonly\"/>";
      

}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

// Zamknięcie połączenia
pg_close($dbconn)

?>
	
</form>

<h3>Treść starego przepisu:</h3>

<form>

<?php //connection
        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";
$query = 'SELECT prze.przepis FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= ' . $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep; ';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
//$result = 0;
if(!$result or pg_num_rows($result)==0){
        echo " <textarea name=\"tresc\" cols=\"100\" rows=\"20\" readonly=\"readonly\"> Brak przepisu </textarea> ";
} else {
      while ($line = pg_fetch_row($result)) {
        echo " <textarea name=\"tresc\" cols=\"100\" rows=\"20\" readonly=\"readonly\">" . $line[0] . "</textarea> ";
          }
}
// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);
// Zamknięcie połączenia
pg_close($dbconn)
?>
	
</form>



<h3>Treść nowego przepisu:</h3>

<form action="dodaj.php">
	<textarea name="tresc" cols="100" rows="20"></textarea>
</form>


<h4>Przepis edytował użytkownik:</h4>

<form action="dodaj.php">
	<input type="text" name="przepis" size="25"/>
</form>


<form action="index.html">
	<input type="submit" onclick="alert('Dziękujemy za edycję przepisu!')" >
</form>
</br>
<a href='wyswietlony.php'>Wróć</a>

</fieldset>

</body>
</html>


