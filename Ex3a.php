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
        <title>Exercitiu 3.a)</title>
    </head>
    <body>
        <?php
		// creare variabile cu nume scurte
		$criteriu=$_POST['criteriu'];
		$criteriu= trim($criteriu);
		if (!$criteriu)
		{
			echo '<h1>Nu ati introdus criteriul de cautare. Va rog sa incercati din nou.</h1>';
			echo '<center><a href="Ex3a_form.html" style="cursor:default;">
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
		echo '<h1>3.a) Sa se gaseasca detaliile persoanelor cu numar de telefon ce contine "'.$criteriu.'", ordonat crescator dupa adresa.</h1>';
        $query = "SELECT * FROM Persoana WHERE telefon LIKE '%".$criteriu."%' ORDER BY adresa;";
        $result = mysqli_query($dsn, $query);
        // verifica daca rezultatul este in regula
        if (!$result)
        	die('Interogare gresita :'.mysqli_error($dsn));
        // se obţine numarul tuplelor returnate
        $num_results = mysqli_num_rows($result);
		if($num_results != 0)
		{
			echo '<table style = "width:100%; background-color: #F8F8FF;">
			<tr>
			<th>ID</th>
			<th>NUME</th>
			<th>TELEFON</th>
			<th>ADRESA</th>
			</tr>';
			// se afiseaza fiecare tupla returnata
			for ($i=0; $i <$num_results; $i++)
			{
				$row = mysqli_fetch_assoc($result);
				echo '<tr><td>'.stripslashes($row['id_pers']).'</td>';
				echo '<td>'.htmlspecialchars(stripslashes($row['nume'])).'</td>';
				echo '<td>'.stripslashes($row['telefon']).'</td>';
				echo '<td>'.htmlspecialchars(stripslashes($row['adresa'])).'</td>';
			}
			echo '</table>';
		}
		else
			echo '<h1>Nu s-au gasit rezultate pentru criteriul de cautare "'.$criteriu.'". Va rog sa incercati din nou.</h1>';
        // deconectarea de la BD
        mysqli_close($dsn);
        ?>
		<a href="Ex3a_form.html" style="cursor:default;">
		<img src="back.png" style="width:75px; height:75px; margin-top:0.5%;"></a>
    </body>
</html>
