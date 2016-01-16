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
        <a href="index.html"><h1>Przepisy siostry Katarzyny <i class="icon-birthday"></i></h1></a>
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
<?php

if (isset($_POST["skladniki"])){

       $con='host=localhost dbname=przepisy user=kasia password=tajne';
        $db=pg_connect($con) or die('Nie mozna nawiazac polaczenia: ' . pg_last_error());
       //if($db)
       //  echo "Polaczono ...<br/>";
       //else
       //  echo "Nie mozna sie polaczyc<br/>";
  $skladnik1 = $_POST['skladniki'];
  $query = 'SELECT prze.nazwa FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= '. $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep;';
  $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());


  if(!$result or pg_num_rows($result)==0){
        echo " Brak przepisu ";
  } else {
   
    while ($line = pg_fetch_row($result)) {
   
        echo  $line[0] ;
      }    
  }

  ?>
  
  </form>
  </div>
      <div class="tresc">

  <h3>Treść przepisu:</h3>
  <form>
  <?php 

  $query = 'SELECT prze.przepis FROM przepisy prze, produkty pro, polaczenie p WHERE pro.id_prod= ' . $skladnik1 . ' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep; ';
  $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

  if(!$result or pg_num_rows($result)==0){
        echo "Brak przepisu ";
  } else {
      while ($line = pg_fetch_row($result)) {
        echo "<h5>" .$line[0] . "</h5> ";
          }
  }

  ?>
  </form>


  <?php //connection
       
  $query = 'SELECT u.nazwa from przepisy prze, produkty pro, polaczenie p, uzytkownicy u WHERE pro.id_prod= '. $skladnik1 .' AND p.id_prod=pro.id_prod AND p.id_przep = prze.id_przep AND prze.id_uzyt = u.id_uzyt';
  $result = pg_query($query) or die('Nieprawidłowe zapytanie: ' . pg_last_error());

  if(!$result or pg_num_rows($result)==0){
        echo "  ";
  } else {
    while ($line = pg_fetch_row($result)) {
   
        echo "<h5>Autor: ". $line[0]." </h5>" ;

        echo"</br><form action=\"edytuj.php\" method=POST >";
        echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">
              Kliknij, aby edytować</button></form>";

        echo"<form action=\"historia.php\" method=POST >";
        echo "<button name=\"skladniki\"  value=\"" . $skladnik1 . "\">
              Kliknij, aby zobaczyć historię zmian tego przepisu</button></br></form>";
      }
  }
  // Zwolnienie zasobów wyniku zapytania
  pg_free_result($result);
  // Zamknięcie połączenia
  pg_close($db);
} else {

 echo "<p style=\"color:red\">Wybierz chociaż jeden składnik</p>";

      echo "<form action = \"wyszukaj.php\">
      <button>Wróc do formularza</button>
      </form>";

}
?>
  
<a href="wyszukaj.php" >Wróć</a>

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

</fieldset>
</body></html>
