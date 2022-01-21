<html>
<style>
	body
	{
		background-image:url("wallpaper.jpg");
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-size:cover;
	}
	
	h1
	{
		color:#FF5722;
		text-align:center;
		font-size:30px;
		font-family:Verdana;
	}
	
	th
	{
		color: #FF5722;
	}
	
	table, td
	{
		border: 2px solid black;
	}
</style>
	
    <head>
        <title>Exercitiu 6.b)</title>
    </head>
    <body>
        <h1>6.b) Sa se gasească numarul de pagini minim, mediu și maxim pentru fiecare gen.</h1>
        <?php
            // se precizează că se foloseşte PEAR DB
            require_once('PEAR.php');
			$host = 'localhost';
            $user = 'UrsacheVlad';
			$pass = file_get_contents("C:/xampp/htdocs/pass.txt");
            $db_name = 'final';
            // se stabileşte şirul pentru conexiune universală sau DSN
			$dsn= new mysqli($host, $user, $pass, $db_name);
            // conectare la BD
            if ($dsn->connect_error)
			{
				die('Eroare la conectare:'. $dsn->connect_error);
			}
            // se emite interogarea
            $query = 'CALL Ex6b()';
            $result = mysqli_query($dsn, $query);
            // verifică dacă rezultatul este în regulă
            if (!$result)
            {
				die('Interogare gresita :'.mysqli_error($dsn));
            }
            // se obţine numărul tuplelor returnate
            $num_results = mysqli_num_rows($result);
            // se afişează fiecare tuplă returnată
			echo '<table style = "width:100%; background-color: #F8F8FF;">
			<tr>
			 <th>MIN(NR_PAGINI)</th>
			 <th>AVG(NR_PAGINI)</th>
			 <th>MAX(NR_PAGINI)</th>
			 <th>GEN</th>
			</tr>';
			for ($i=0; $i <$num_results; $i++)
			{
				$row = mysqli_fetch_assoc($result);
				echo '<tr><td>'.stripslashes($row['MIN(nr_pagini)']).'</td>';
				echo '<td>'.stripslashes($row['ROUND(AVG(nr_pagini),2)']).'</td>';
				echo '<td>'.stripslashes($row['MAX(nr_pagini)']).'</td>';
				echo '<td>'.htmlspecialchars(stripslashes($row['gen'])).'</td>';
			}
			echo '</table>';
            // deconectarea de la BD
            mysqli_close($dsn);
            ?>
		<a href="index.html" style="cursor:default;">
		<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a>
    </body>
</html>