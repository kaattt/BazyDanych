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
$skladnik1 = $_POST['skladniki'];
$query = 'SELECT prze.nazwa FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= '. $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep;';
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


<h4>Przepis stwożył użytkownik:</h4>




<?php //connection
        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";
$query = 'select u.nazwa from przepisy prze, produkty pro, polaczenie p, uzytkownicy u where pro.id_prod= '. $skladnik1 .' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep AND prze.id_uzyt = u.id_uzyt';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
//$result = 0;
if(!$result or pg_num_rows($result)==0){
        echo "<form><input type=\"text\" name=\"przepis\" size=\"25\" readonly=\"readonly\"/></form>";
} else {
    while ($line = pg_fetch_row($result)) {
   
        echo "<form/><input type=\"text\" name=\"przepis\" size=\"25\" value= \"" . $line[0] .  "\" readonly=\"readonly\"/></form>";

        echo"</br><form action=\"edytuj.php\" method=POST >";
        echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">Kliknij, aby edytować</a></button></form>";
        echo"<form action=\"historia.php\" method=POST >";
        echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">Kliknij, aby zobaczyć historię zmian tego przepisu</a></button></br></form>";
      }
}
// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);
// Zamknięcie połączenia
pg_close($dbconn)
?>
  

<a href='wyszukaj.php'>Wróć</a>

</fieldset>
</body></html>