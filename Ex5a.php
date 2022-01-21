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
        <title>Exercitiu 5.a)</title>
    </head>
    <body>
        <?php
			// creare variabile cu nume scurte
			$criteriu=$_POST['criteriu'];
			$criteriu= trim($criteriu);
			if (!$criteriu)
			{
				echo '<h1>Nu ati introdus criteriul de cautare. Va rog sa incercati din nou.</h1>';
				echo '<center><a href="Ex5a_form.html" style="cursor:default;">
				<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a></center>;';
				exit;
			}
			if (!get_magic_quotes_gpc())
			{
				$criteriu = addslashes($criteriu);
			}
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
			echo '<h1>5.a) Sa se gaseasca detaliile cartilor care au genul cartii cu titlul care contine "'.$criteriu.'".</h1>';
            $query = "SELECT * FROM Carte WHERE gen IN(SELECT gen FROM Carte WHERE titlu LIKE '%".$criteriu."%');";
            $result = mysqli_query($dsn, $query);
            // verifică dacă rezultatul este în regulă
            if (!$result)
            {
				die('Interogare gresita :'.mysqli_error($dsn));
            }
            // se obţine numărul tuplelor returnate
            $num_results = mysqli_num_rows($result);
            if($num_results != 0)
			{
				echo '<table style = "width:100%; background-color: #F8F8FF;">
				<tr>
				 <th>ID_CARTE</th>
				 <th>TITLU</th>
				 <th>NR_PAGINI</th>
				 <th>NR_EXEMPLARE</th>
				 <th>GEN</th>
				 <th>REZUMAT</th>
				</tr>';
				// se afişează fiecare tuplă returnată
				for ($i=0; $i <$num_results; $i++)
				{
					$row = mysqli_fetch_assoc($result);
					echo '<tr><td>'.stripslashes($row['id_carte']).'</td>';
					echo '<td>'.htmlspecialchars(stripslashes($row['titlu'])).'</td>';
					echo '<td>'.stripslashes($row['nr_pagini']).'</td>';
					echo '<td>'.stripslashes($row['nr_exemplare']).'</td>';
					echo '<td>'.htmlspecialchars(stripslashes($row['gen'])).'</td>';
					if(htmlspecialchars(stripslashes($row['rezumat'])) == "")
						echo '<td>-</td>';
					else
						echo '<td>'.htmlspecialchars(stripslashes($row['rezumat'])).'</td>';
				}
				echo '</table>';
			}
			else
				echo '<h1>Nu s-au gasit rezultate pentru criteriul de cautare "'.$criteriu.'". Va rog sa incercati din nou.</h1>';
            // deconectarea de la BD
            mysqli_close($dsn);
            ?>
		<a href="Ex5a_form.html" style="cursor:default;">
		<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a>
    </body>
</html>