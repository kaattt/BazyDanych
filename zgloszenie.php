<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pl">
<head>

  <meta charset="UTF-8">
  <title>Przepisy siostry Katarzyny</title>

  <link rel="stylesheet" href="fontello.css" />
  <link rel="stylesheet" href="style.css" />
  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Pacifico|Marck+Script|Crafty+Girls&
    subset=latin,latin-ext' rel='stylesheet' type='text/css' />

</head>
<body>
  

  <div class="container">
    <div class="header">
      <a href="index.php"><h1>Przepisy siostry Katarzyny <i class="icon-birthday"></i></h1></a>
    </div>
    <div id="menu">
      <ul class="menuList">
        <li><a href="wyszukaj.php"><i class="icon-ok"></i>Wyszukaj przepis</a></li>
        <li><a href="dodaj.php"><i class="icon-ok" ></i>Utwórz własny</a></li>
      </ul>
    </div>
    <div id="main">
      <img src="background.png">
      <div class="title"></div>
      <div class="tresc">
  

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

 // INSERT INTO produkty(nazwa) VALUES('jajko');

$query1 = "INSERT INTO uzytkownicy(nazwa) VALUES('$uzytkownik_filtr')";

$result1 = pg_query($query1) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result1)) {
   
           $result1 = pg_query($query1) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result1) echo "OK";
        else echo "Nie OK";
      }

$query2 = "INSERT into przepisy (nazwa,przepis,id_uzyt, data) values (
  '$nazwa_filtr', 
  '$tresc_filtr',
  (select id_uzyt from uzytkownicy where nazwa='$uzytkownik_filtr'), 'now()')";

$result2 = pg_query($query2) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result2)) {
   
           $result2 = pg_query($query2) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result2) echo "OK";
        else echo "Nie OK";
      }

$query3 = "INSERT INTO polaczenie(id_prod, id_przep) VALUES(
  (SELECT id_prod FROM produkty where id_prod = '$skladniki_filtr'), 
  (SELECT id_przep FROM przepisy where nazwa = '$nazwa_filtr'))";

$result3 = pg_query($query3) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result3)) {
   
           $result3 = pg_query($query3) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      if($result3) echo "OK";
        else echo "Nie OK";
      }
      

pg_free_result($result1);
pg_free_result($result2);
pg_free_result($result3);

?>

      <h3>Dziękujemy za Dodanie przepisu!</h3>

      <p>Twoje dane:</p>
      <ul>
      <li>Użytkownik: <b><?= trim($_POST["uzytkownik"]); ?></b></li>
      <li>Nazwa przepisu: <b><?= trim($_POST["nazwa"]); ?></b></li>
      <li>Treść przepisu: <b><?= trim($_POST["tresc"]); ?></b></li>

<?php 
$produkt = $_POST["skladniki"];
$query = 'SELECT nazwa FROM produkty WHERE id_prod='. $produkt.'';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
        echo "<li>Skladniki: <b> " . $line[0] ."</b>";

//        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
}

pg_free_result($result);

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

      </div>
      <div class="toplista">
        <i class="icon-star-empty"></i> Toplista
        <ul id="topPrzepisy">
<?php
$query = 'SELECT nazwa FROM przepisy limit 10 ';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

  if(!$result or pg_num_rows($result)==0){
        echo "Brak przepisu ";
  } else {
      while ($line = pg_fetch_row($result)) {
        echo "<li>" .$line[0] . "</li> ";
          }
  }

 pg_free_result($result);
  // Zamknięcie połączenia
 pg_close($db);

?>
        </ul>
      </div>
    </div>
    <div style="clear:both;"></div>
  </div>

</body>
</html>