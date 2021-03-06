<!DOCTYPE html>
<html>
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
        <!--li><a href="dodaj.php"><i class="icon-ok" ></i>Utwórz własny</a></li-->
      </ul>
    </div>
    <div id="main">
      <img src="background.png">
      <div class="title"></div>
      <div class="tresc">

<h4>Wprowadź nazwę użytkownika:</h4>

<form action='zgloszenie.php' method=POST>
  <input type="text" name="uzytkownik" size="25"/>


  <h4>Wprowadź nazwę przepisu:</h4>

   <input type="text" name="nazwa" size="50">

  <h4>Wprowadź treść przepisu:</h4>

  <textarea name="tresc" cols="50" rows="10"></textarea>

  <h4>Co jest głównym skladnikiem przepisu?</h4>

  <select name="skladniki" size="10" multiple="multiple">

<?php 
      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
//if($db)
//         echo "Polaczono ...</br>";
//       else
//         echo "Nie mozna sie polaczyc</br>";
$query = 'SELECT * FROM produkty ORDER BY nazwa';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
while ($line = pg_fetch_row($result)) {
   
        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
}
// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

 
?>

</select>
    <input type="submit" value="Wyślij" name="submit"/>
</form>
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

</body></html>
