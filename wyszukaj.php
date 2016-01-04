<!DOCTYPE html>
<html><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
</head>
<body>
<fieldset>
<h3>Jakie składniki masz w lodówce?</h3>
<h5>aby wybrac więcej składników, przytrzymaj klawisz Ctrl</h5>

<form action="wyswietlony.php" method="post">
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

$query = 'SELECT id, nazwa FROM produkty ORDER BY nazwa';
$result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

while ($line = pg_fetch_row($result)) {
   
        echo "<option value= " . $line[0] . " > " . $line[1] . "</option>\n"; 
        //echo "\t\t<td>$col_value</td>\n";

}



#$dostepne_film = pg_query($db,'SELECT  FROM film ORDER BY tytul ;');
#if(!$dostepne_film or pg_num_rows($dostepne_film)==0){
#        echo 'Brak filmów';
#} else {
#        $dostepne_film = pg_fetch_all($dostepne_film);
#        for ($i=0; $i<count($dostepne_film); $i++){
#                print( '<a href="film.php?film='.$dostepne_film[$i]['id_film'] .'">'.  $dostepne_film[$i]['tytul'] .'</a><br/>' );
#        }
#        echo'</center>';
#}


// Zwolnienie zasobów wyniku zapytania
pg_free_result($result);

// Zamknięcie połączenia
pg_close($dbconn)
?>




</select>
<input type="submit">
</form>


</fieldset>
</body></html>