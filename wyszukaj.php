<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <title>Przepisy Katarzyny</title>

    <link rel="stylesheet" href="fontello.css" />
    <link rel="stylesheet" href="style.css" />
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic|Pacifico|Marck+Script|Crafty+Girls&subset=latin,latin-ext' rel='stylesheet' type='text/css' />

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


<h3>Co masz w lodówce?</h3>

<form action="wyswietlony.php" method=POST>
<select name="skladniki" size="10" multiple="multiple">

<?php //connection
    //error_reporting(0);

        $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());

       if($db)
         echo "Polaczono ...<br/>";
       else
         echo "Nie mozna sie polaczyc<br/>";


//function sql_validate_value(&$var) {
//       if(is_array($var)){
//               array_walk($var, 'sql_validate_value');
//       } else {
#               $var = stripslashes($var);
#                $var = htmlspecialchars($var, ENT_QUOTES);
#                $var = pg_escape_string($var);
#        }
#        return $var;
#}

#array_walk($_GET, 'sql_validate_value');
#array_walk($_POST, 'sql_validate_value');
#
#function unhtmlspecialchars( $string ) {
#        $string = str_replace ( '&amp;', '&', $string );
#        $string = str_replace ( '&#039;', '\'', $string );
#        $string = str_replace ( '&quot;', '\"', $string );
#        $string = str_replace ( '&lt;', '<', $string );
#        $string = str_replace ( '&gt;', '>', $string );
#        return $string;
#}

$query = 'SELECT id_prod, nazwa FROM produkty ORDER BY nazwa';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
   
        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
        //echo "\t\t<td>$col_value</td>\n";

}

// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);


?>

</select>
<input type="submit">
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