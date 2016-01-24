<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="pl">
<head>
  
  <meta charset="UTF-8">
  <title>Przepisy Katarzyny</title>

  <link rel="stylesheet" href="fontello.css" />
  <link rel="stylesheet" href="style.css" />
  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Pacifico|Marck+Script|Crafty+Girls&subset=latin,latin-ext' rel='stylesheet' type='text/css' />

</head>


<body>
  

  <div class="container">
    <div class="header">
        <a href="index.php"><h1>Przepisy Katarzyny <i class="icon-birthday"></i></h1></a>
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
if (empty($_POST["uzytkownik"]) || 
      empty($_POST["tresc"])) {

      $skladnik1=$_POST['skladniki'];

      echo "<p style=\"color:red\">Musisz wypełnić wszystkie pola!</p>";
      echo"</br><form action=\"edytuj.php\" method=POST >";
      echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">Wróć</button></form>";    

    } else {
 $uzytkownik_filtr = addslashes(trim($_POST['uzytkownik'])); 
            $tresc_filtr = addslashes(trim($_POST['tresc'])); 
            $nazwa_filtr = addslashes(trim($_POST['nazwa']));
  
      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
//perform the insert using pg_query
//      $result = pg_query($db, "INSERT INTO przepisy(nazwa, przepis) 
//                  VALUES(\'" . $nazwa . "\', \'" . $tresc . "\');");
      

 // INSERT INTO produkty(nazwa) VALUES('jajko');
$skladnik1=$_POST['skladniki'];


$data=$_POST['data'];

$query0 ="SELECT data FROM przepisy WHERE id_przep=
              (SELECT id_przep FROM polaczenie WHERE id_prod = ". $skladnik1 .")
                order by data desc limit 1 ";

$result0 = pg_query($query0) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
 while ($line = pg_fetch_row($result0)) {
       $data_przepis = $line[0] ;

           $result1 = pg_query($query0) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
      //if($result0) echo "OK";
      //  else echo "Nie OK";
      }


if($data_przepis<$data){

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
pg_free_result($result0);
pg_free_result($result1);
pg_free_result($result2);
 

?>

      <h3>Dziękujemy za edycję przepisu!</h3>

      <p>Twoje dane:</p>
      <ul>
      <li>Użytkownik: <b><?= trim($_POST["uzytkownik"]); ?></b></li>
      <li>Nazwa przepisu: <b><?= trim($_POST["nazwa"]); ?></b></li>
      <li>Treść przepisu: <b><?= trim($_POST["tresc"]); ?></b></li>
      </ul>


<?php
} else echo "Niestety nie udało Ci się edytować najnowszego przepisu" ;
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