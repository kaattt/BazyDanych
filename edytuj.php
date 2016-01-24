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
				<li><a href="dodaj.php"><i class="icon-ok" ></i>Utwórz własny</a></li>
			</ul>
		</div>
		<div id="main">
			<img src="background.png">
			<div class="title">

<form action="poedycji.php" method=POST>
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

function udate($format, $utimestamp = null)
{
    if (is_null($utimestamp))
        $utimestamp = microtime(true);

    $timestamp = floor($utimestamp);
    $milliseconds = round(($utimestamp - $timestamp) * 1000000);

    return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
}

$data = udate('Y-m-d H:i:s.u'); // 19:40:56.78128


//echo $data;

while ($line = pg_fetch_row($result)) {
   
        echo  $line[0] ;
        echo '<input type="hidden" value="'. $line[0].'" name="nazwa" />';
        echo '<input type="hidden" value="'. $data .'" name="data" />';
      }

?>
	
</div>
			<div class="tresc">
<h3>Treść starego przepisu:</h3>

<?php 

$query = 'SELECT prze.przepis FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= ' . $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep; ';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

if(!$result or pg_num_rows($result)==0){
        echo "Brak przepisu";
} else {
      while ($line = pg_fetch_row($result)) {
        echo  $line[0];
          }
}
// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

?>


<h3>Treść nowego przepisu:</h3>
	<textarea name="tresc" cols="50" rows="10"></textarea>

<h4>Przepis edytował użytkownik:</h4>
	<input type="text" name="uzytkownik" size="25"/>

<?php    
     echo "<button type=\"submit\" name=\"skladniki\"  value=\"" . $skladnik1 . "\">
     		Wyślij</button>";
?>

</br>

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



</body>
</html>


