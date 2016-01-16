<!DOCTYPE html>
<html><head>

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
      <div class="title">
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

while ($line = pg_fetch_row($result)) {
   
        echo  $line[0] ;
        echo '<input type="hidden" value="'. $line[0].'" name="nazwa" />';
      }

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);
?>
	

</div>
      <div class="tresc">


<h3>Treść przepisu:</h3>

<form>


<?php 
$query = 'SELECT zmiana, h.id_hist FROM historia h, produkty pro, polaczenie pol WHERE 
  pro.id_prod='. $skladnik1 .' AND h.id_przep=pol.id_przep AND pro.id_prod=pol.id_prod ;';

$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
      if (count($line[1])==1){
      	echo $line[0] ;
      } else {
        echo $line[1] . $line[0] . "</br>";
      }

}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

?>

	
</form>


<h4>Autor:</h4>

<form>

<?php 

$query = 'SELECT u.nazwa FROM historia h, produkty pro, polaczenie p, uzytkownicy u WHERE
 pro.id_prod= '. $skladnik1 .' AND h.id_uzyt = u.id_uzyt AND pro.id_prod=p.id_prod AND p.id_przep=h.id_przep ;';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
   
        echo  $line[0] . " " ;
    }

?>
	
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

</fieldset>
</body></html>