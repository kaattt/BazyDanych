<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Zgłoszenie edycji</title>
</head>
<body>
<?php
if (empty($_POST["uzytkownik"]) || 
      empty($_POST["tresc"])) {

      $skladnik1=$_POST['skladniki'];

      echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola!</p>";
      echo"</br><form action=\"edytuj.php\" method=POST >";
      echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">Wróć</button></form>";    

    } else {
?>

      <?php $uzytkownik_filtr = addslashes(trim($_POST['uzytkownik'])); 
            $tresc_filtr = addslashes(trim($_POST['tresc'])); 
            $nazwa_filtr = addslashes(trim($_POST['nazwa']));
  
      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
//perform the insert using pg_query
//      $result = pg_query($db, "INSERT INTO przepisy(nazwa, przepis) 
//                  VALUES(\'" . $nazwa . "\', \'" . $tresc . "\');");
      

 // INSERT INTO produkty(nazwa) VALUES('jajko');

$query1 = "INSERT INTO uzytkownicy(nazwa) VALUES('$uzytkownik_filtr')";
$query2 = "UPDATE przepisy SET przepis = '$tresc_filtr',
  id_uzyt = (select id_uzyt from uzytkownicy where nazwa='$uzytkownik_filtr')
  WHERE nazwa = '$nazwa_filtr'";

$result1 = pg_query($query1) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result1)) {
   
           $result1 = pg_query($query1) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result1) echo "OK";
        else echo "Nie OK";
      }

$result2 = pg_query($query2) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result2)) {
   
           $result2 = pg_query($query2) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result2) echo "OK";
        else echo "Nie OK";
      }

      

 // Zwolnienie zasobów wyniku zapytania
pg_free_result($result1);
pg_free_result($result2);
// Zamknięcie połączenia
pg_close($db); 

?>

      <h3>Dziękujemy za edycję przepisu!</h3>

      <p>Twoje dane:</p>
      <ul>
      <li>Użytkownik: <b><?= trim($_POST["uzytkownik"]); ?></b></li>
      <li>Nazwa przepisu: <b><?= trim($_POST["nazwa"]); ?></b></li>
      <li>Treść przepisu: <b><?= trim($_POST["tresc"]); ?></b></li>
      </ul>

<?php

    }


?>
<form action = "index.html">
<button>Wróc na stronę główną</button>
</form>
</body>

</html>