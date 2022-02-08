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
		<title>Exercitiu 6.a)</title>
	</head>
	<body>
		<h1>6.a) Sa se gaseasca numele persoanelor cu intarzierea cea mai mare in restituirea cartilor imprumutate si valoarea in numar de zile a intarzierii.</h1>
		<?php
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
			$query = 'CALL Ex6a()';
			$result = mysqli_query($dsn, $query);
			// verifica daca rezultatul este in regula
			if (!$result)
				die('Interogare gresita :'.mysqli_error($dsn));
			// se obtine numarul tuplelor returnate
			$num_results = mysqli_num_rows($result);
			// se afiseaza fiecare tupla returnata
			echo '<table style = "width:100%; background-color: #F8F8FF;">
			<tr>
				<th>NUME</th>
				<th>NR_ZILE</th>
			</tr>';
			for ($i=0; $i <$num_results; $i++)
			{
				$row = mysqli_fetch_assoc($result);
				echo '<tr><td>'.htmlspecialchars(stripslashes($row['nume'])).'</td>';
				echo '<td>'.stripslashes($row['zile']).'</td>';
			}
			echo '</table>';
			// deconectarea de la BD
			mysqli_close($dsn);
		?>
		<a href="index.html" style="cursor:default;">
		<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a>
	</body>
</html>
