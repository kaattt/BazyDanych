<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Przepisy siostry Katarzyny</title>

  <link rel="stylesheet" href="fontello.css" />
  <link rel="stylesheet" href="style.css" />
  <!-- Google Fonts -->
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Pacifico|Marck+Script|Crafty+Girls&subset=latin,latin-ext' rel='stylesheet' type='text/css' />

</head>
<body>

<div class="container">
    <div class="header">
      <a href="index.html"><h1>Przepisy siostry Katarzyny <i class="icon-birthday"></i></h1></a>
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

  <h4>Jakich składników, użyłeś w swoim przepisie?</h4>
  <h5>aby wybrac więcej składników, przytrzymaj klawisz Ctrl</h5>

  <select name="skladniki" size="10" multiple="multiple">

<?php 
      $con='host=localhost dbname=przepisy user=kasia password=tajne';
      $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
//if($db)
//         echo "Polaczono ...</br>";
//       else
//         echo "Nie mozna sie polaczyc</br>";
$query = 'SELECT id_prod, nazwa FROM produkty ORDER BY nazwa';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());
while ($line = pg_fetch_row($result)) {
   
        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
}
// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);
// Zamknięcie połączenia
pg_close($db)
 
?>

</select>
    <input type="submit" value="Wyślij" name="submit"/>
</form>
</div>
      <div class="toplista">
        <i class="icon-star-empty"></i> Toplista
        <ul id="topPrzepisy">
          <li>Naleśniki Marieci</li>
          <li>Placek od Grażyny</li>
          <li>Zupa z Gównem</li>
          <li>Sałatka jeżynowa na słono</li>
          <li>Sałatka jarzynowa na słodko</li>
          <li>Kot w sosie własnym</li>
          <li>Kotlet z psa (pomielony razem z budą)</li>
          <li>All in One czyli mix z lodówki po świętach</li>
        </ul>
      </div>
    </div>
    <div style="clear:both;"></div>
  </div>

</body></html>
