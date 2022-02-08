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
		<title>Exercitiu 4.a)</title>
	</head>
	<body>
		<?php
			// creare variabile cu nume scurte
			$criteriu=$_POST['criteriu'];
			$criteriu= trim($criteriu);
			if (!$criteriu)
			{
				echo '<h1>Nu ati introdus criteriul de cautare. Va rog sa incercati din nou.</h1>';
				echo '<center><a href="Ex4a_form.html" style="cursor:default;">
				<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a></center>;';
				exit;
			}
			if (!get_magic_quotes_gpc())
				$criteriu = addslashes($criteriu);
			// se precizeaza ca se foloseste PEAR DB
			require_once('PEAR.php');
			$host = 'localhost';
			$user = 'UrsacheVlad';
			$pass = file_get_contents("C:/xampp/htdocs/pass.txt");
			$db_name = 'final';
			// se stabileste sirul pentru conexiune universala sau DSN
			$dsn= new mysqli($host, $user, $pass, $db_name);
			if ($dsn->connect_error)
				die('Eroare la conectare:'. $dsn->connect_error);
			// se emite interogarea
			if($criteriu == 1)
				echo '<h1>4.a) Sa se gaseasca numele, adresa și numarul de telefon pentru persoanele ce au depasit termenul de restituire cu mai mult de "'.$criteriu.'" zi.</h1>';
			else if($criteriu % 10 > 1 && $criteriu % 10 < 20)
				echo '<h1>4.a) Sa se gaseasca numele, adresa și numarul de telefon pentru persoanele ce au depasit termenul de restituire cu mai mult de "'.$criteriu.'" zile.</h1>';
			else
				echo '<h1>4.a) Sa se gaseasca numele, adresa și numarul de telefon pentru persoanele ce au depasit termenul de restituire cu mai mult de "'.$criteriu.'" de zile.</h1>';
			$query = "SELECT DISTINCT Persoana.nume, Persoana.adresa, Persoana.telefon FROM Persoana JOIN Imprumut ON Persoana.id_pers = Imprumut.id_imp WHERE(SYSDATE() - Imprumut.datai > Imprumut.nr_zile + ".$criteriu." AND Imprumut.datar IS NULL) OR (Imprumut.datar - Imprumut.datai > Imprumut.nr_zile + ".$criteriu." AND Imprumut.datar IS NOT NULL);";
			$result = mysqli_query($dsn, $query);
			// verifica daca rezultatul este in regula
			if (!$result)
				die('Interogare gresita :'.mysqli_error($dsn));
			// se obtine numarul tuplelor returnate
			$num_results = mysqli_num_rows($result);
			if($num_results != 0 && $criteriu > 0)
			{
				echo '<table style = "width:100%; background-color: #F8F8FF;">
				<tr>
				 <th>NUME</th>
				 <th>ADRESA</th>
				 <th>TELEFON</th>
				</tr>';
				// se afiseaza fiecare tupla returnata
				for ($i=0; $i <$num_results; $i++)
				{
					$row = mysqli_fetch_assoc($result);
					echo '<tr><td>'.htmlspecialchars(stripslashes($row['nume'])).'</td>';
					echo '<td>'.htmlspecialchars(stripslashes($row['adresa'])).'</td>';
					echo '<td>'.stripslashes($row['telefon']).'</td>';
				}
				echo '</table>';
			}
			else
				echo '<h1>Nu s-au gasit rezultate pentru criteriul de cautare "'.$criteriu.'". Va rog sa incercati din nou.</h1>';
			// deconectarea de la BD
			mysqli_close($dsn);
		?>
		<a href="Ex4a_form.html" style="cursor:default;">
		<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a>
	</body>
</html>
