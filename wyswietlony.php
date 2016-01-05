<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
</head>
<body>
<fieldset>

<h3>Nazwa przepisu:</h3>

<form>

<?php //connection

        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";

$query = 'SELECT nazwa FROM przepisy';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
//$result = 0;

if(!$result or pg_num_rows($result)==0){
        echo "<input type=\"text\" name=\"przepis\" size=\"50\" value= \" Brak przepisu \" readonly=\"readonly\"/>";
} else {

    while ($line = pg_fetch_row($result)) {
   
        echo "<input type=\"text\" name=\"przepis\" size=\"50\" value= \"" . $line[0] .  "\" readonly=\"readonly\"/>";
      }    
}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

// Zamknięcie połączenia
pg_close($dbconn)

?>
	
</form>



<h3>Treść przepisu:</h3>

<form>


<?php //connection

        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";

$query = 'SELECT przepis FROM przepisy';
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


<h4>Przepis stwożył użytkownik:</h4>

<form>

<?php //connection

        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";

$query = 'SELECT nazwa FROM uzytkownicy';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
//$result = 0;

if(!$result or pg_num_rows($result)==0){
        echo "<input type=\"text\" name=\"przepis\" size=\"25\" readonly=\"readonly\"/>";
} else {

    while ($line = pg_fetch_row($result)) {
   
        echo "<input type=\"text\" name=\"przepis\" size=\"25\" value= \"" . $line[0] .  "\" readonly=\"readonly\"/>";
      }
}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

// Zamknięcie połączenia
pg_close($dbconn)

?>
	
</form>


<a href='edytuj.php'>Kliknij, aby edytować</a></br>

<a href='historia.php'>Kliknij, aby zobaczyć historię zmian tego przepisu</a></br>

<a href='wyszukaj.php'>Wróć</a>

</fieldset>
</body></html>