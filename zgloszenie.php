<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Zgłoszenie</title>
</head>
<body>
<?php
  if (isset($_POST["submit"])) {

    if (empty($_POST["uzytkownik"]) || 
      empty($_POST["nazwa"]) || 
      empty($_POST["tresc"]) || 
      empty($_POST["skladniki"])) {

      echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola!</p>";

      echo "<form action = \"dodaj.php\">
<button>Wróc do formularza</button>
</form>";

    } else {
?>

      <?php $uzytkownik_filtr = addslashes(trim($_POST['uzytkownik'])); 
            $nazwa_filtr = addslashes(trim($_POST['nazwa'])); 
            $tresc_filtr = addslashes(trim($_POST['tresc'])); 
            $skladniki_filtr = addslashes(trim($_POST['skladniki'])); 


      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
//perform the insert using pg_query
//      $result = pg_query($db, "INSERT INTO przepisy(nazwa, przepis) 
//                  VALUES(\'" . $nazwa . "\', \'" . $tresc . "\');");
      



 // INSERT INTO produkty(nazwa) VALUES('jajko');

$query1 = "INSERT INTO uzytkownicy(nazwa) VALUES('$uzytkownik_filtr')";
$query2 = "INSERT into przepisy (nazwa,przepis,id_uzyt) values (
  '$nazwa_filtr', 
  '$tresc_filtr',
  (select id_uzyt from uzytkownicy where nazwa='$uzytkownik_filtr'))";
$query3 = "INSERT INTO polaczenie(id_prod, id_przep) VALUES(
  (SELECT id_prod FROM produkty where nazwa = '$skladniki_filtr'), 
  (SELECT id_przep FROM przepisy where nazwa = '$nazwa_filtr'))";
//$query4 = "INSERT INTO produkty(nazwa) VALUES((SELECT nazwa FROM produkty WHERE id_prod=
//  '$skladniki_filtr'))";

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

$result3 = pg_query($query3) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result3)) {
   
           $result3 = pg_query($query3) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result3) echo "OK";
        else echo "Nie OK";
      }
      
//$result4 = pg_query($query4) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
// while ($line = pg_fetch_row($result4)) {
   
//           $result4 = pg_query($query4) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 //     if($result4) echo "OK";
 //       else echo "Nie OK";
 //     }
 // Zwolnienie zasobów wyniku zapytania
pg_free_result($result1);
pg_free_result($result2);
pg_free_result($result3);
//pg_free_result($result4);
// Zamknięcie połączenia
pg_close($db); 
?>

      <h3>Dziękujemy za Dodanie przepisu!</h3>

      <p>Twoje dane:</p>
      <ul>
      <li>Użytkownik: <b><?= trim($_POST["uzytkownik"]); ?></b></li>
      <li>Nazwa przepisu: <b><?= trim($_POST["nazwa"]); ?></b></li>
      <li>Treść przepisu: <b><?= trim($_POST["tresc"]); ?></b></li>

<?php 

      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

//       if($db)
//         echo "Polaczono ...</br>";
//       else
//         echo "Nie mozna sie polaczyc</br>";

$produkt = $_POST["skladniki"];

$query = 'SELECT nazwa FROM produkty WHERE id_prod='. $produkt.'';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
        echo "<li>Skladniki: <b> " . $line[0] ."</b>";

//        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
}


// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);
// Zamknięcie połączenia
pg_close($db)

 
?>

    
      </ul>

<?php

    }

  } else {

    // Jeśli użytkownik dostał się na tę stronę w sposób inny niż przez formularz

    // zostaje przekierowany do formularza zgłoszenia

    header("Location: index.html");

  }

?>
<form action = "index.html">
<button>Wróc na stronę główną</button>
</form>
</body>

</html>