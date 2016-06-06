<?php
	session_start();
	session_set_cookie_params(3600);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="stil.css">
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
		<script src="adminPanel.js" type="text/javascript"></script>
		<script src="validacijaVijesti.js" type="text/javascript"></script>
		<title>Vijesti | GoCA</title>
	</head>
	<body onload="hideLoginForm();">
		
		<?php
			
			if (isset($_REQUEST["vijest-autor"]) && isset($_REQUEST["vijest-naslov"]) && isset($_REQUEST["vijest-ukratko"]) && isset($_REQUEST["vijest-sadrzaj"])) {
				if (strlen($_REQUEST["vijest-autor"]) > 0 && strlen($_REQUEST["vijest-naslov"]) > 0 && strlen($_REQUEST["vijest-ukratko"]) > 0 && strlen($_REQUEST["vijest-sadrzaj"]) > 0) {
					$novavijest = htmlentities($_REQUEST["vijest-autor"], ENT_QUOTES, 'UTF-8').",".date("Y-m-d h:m:s").",".htmlentities($_REQUEST["vijest-naslov"], ENT_QUOTES, 'UTF-8').",".htmlentities($_REQUEST["vijest-ukratko"], ENT_QUOTES, 'UTF-8').htmlentities($_REQUEST["vijest-sadrzaj"], ENT_QUOTES, 'UTF-8')."\n";
					file_put_contents("uneseneVijesti.txt", $novavijest, FILE_APPEND);
				}
			}
			
			$prijava = '<div id="prijava">
							<input type="button" id="dugmePrijava" value="PRIJAVA" onclick="showLoginForm()">
							<form method="POST" action="index.php" id="prijavaforma">
								<label for="korisnickoime">korisničko ime: </label><input type="text" id="korisnickoime" name="korisnickoime">
								<label for="lozinka">lozinka: </label><input type="password" id="lozinka" name="lozinka">
								<input type="submit" value="prijavi se">
							</form>
						</div>';
			$panellink = '<div id="panel-link"><a href="#panel" onclick="showPanel(); return false;">Prikaži administratorski panel</a></div>';
			$panel = '<div id="panel">
							<h3>+ DODAJ VIJEST</h3>
							<div id="panel-opcije">
								<form action="index.php" id="vijest-forma" method="POST">
									
									<label for="vijest-autor">Autor vijesti:</label>
									<input type="text" id="vijest-autor" name="vijest-autor" onblur="provjeriAutora()"><br>
									
									<label for="vijest-kod-drzave">Dvoslovni kôd države autora:</label>
									<input type="text" id="vijest-kod-drzave" name="vijest-kod-drzave" onblur="provjeriKod(); provjeriKodTelefon();"><br>
									
									<label for="vijest-telefon-autora">Broj telefona autora: <small>(FORMAT: +CCC.NNNNNN)</small> </label>
									<input type="text" id="vijest-telefon-autora" name="vijest-telefon-autora" onblur="provjeriTelefon(); provjeriKodTelefon();"><br>
									
									<label for="vijest-naslov">Naslov vijesti:</label>
									<input type="text" id="vijest-naslov" name="vijest-naslov" onblur="provjeriNaslov()"><br>
									
									<label for="vijest-ukratko">Kratak isječak vijesti:</label>
									<textarea rows="4" cols="30" id="vijest-ukratko" name="vijest-ukratko" onblur="provjeriUkratko()"></textarea><br>
									
									<label for="vijest-sadrzaj">Sadržaj vijesti:</label>
									<textarea rows="4" cols="50" id="vijest-sadrzaj" name="vijest-sadrzaj" onblur="provjeriSadrzaj()"></textarea><br>

									<label for="zabrana-komentarisanja">Zabraniti komentarisanje? </label>
									<input type="radio" name="zabrana-komentarisanja" value="male"><br>

									<button type="button" onclick="validacijaVijesti();">Dodaj</button>
								
								</form>
							</div>
						</div>';
			if (isset($_REQUEST['odjava'])) {
				session_unset();
			}
			if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
				echo '<div id="prijava">
							<form method="POST" action="index.php" id="odjavaforma">
								Prijavljeni ste kao: <b>'.htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8').'</b>
								<input type="submit" name="odjava" value="ODJAVI SE">
							</form>
					  </div>';
				echo $panel.'<hr>';
			}
			else if (isset($_REQUEST['korisnickoime']) && isset($_REQUEST['lozinka'])) {
				
				$connection = new PDO("mysql:dbname=goca;host=localhost;charset=utf8", "goca", "goca");
			    $query = $connection->prepare("SELECT korisnik, lozinka FROM korisnici WHERE korisnik=?");
			   	$query->execute(array($_REQUEST['korisnickoime']));
			    $match = $query->fetch(PDO::FETCH_ASSOC);
			    if (!$match || (md5($_REQUEST['lozinka']) != $match['lozinka'])) {
			    	echo '<div id="greskaprijava"><b>Greška:</b> Korisnički podaci nevalidni!</div>';
					echo $prijava;
			    }
			    else {
					$_SESSION['username'] = $_REQUEST['korisnickoime'];
				    $_SESSION['password'] = $_REQUEST['lozinka'];
					echo '<div id="prijava">
								<form method="POST" action="index.php" id="odjavaforma">
									Prijavljeni ste kao: <b>'.htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8').'</b>
									<input type="submit" name="odjava" value="ODJAVI SE">
								</form>
					  		</div>';
					$query = $connection->prepare("SELECT admin FROM korisnici WHERE korisnik=?");
					$query->execute(array($_SESSION['username']));
					$result = $query->fetchColumn();
					if ($result == 1) {
						echo $panel;
					}
				}
				
				/*$korisnickoime = htmlspecialchars($_REQUEST['korisnickoime'], ENT_QUOTES, 'UTF-8');
				$lozinka = htmlspecialchars($_REQUEST['lozinka'], ENT_QUOTES, 'UTF-8');
				$read = fopen('adminData.txt','r');
				if ($korisnickoime != substr(fgets($read), 0, -2) || md5($lozinka) != fgets($read)) {
					echo '<div id="greskaprijava"><b>Greška:</b> Korisnički podaci nevalidni!</div>';
					echo $prijava;
					fclose($read);
				}
			    else {
					$_SESSION['username'] = $_REQUEST['korisnickoime'];
				    $_SESSION['password'] = $_REQUEST['lozinka'];
					fclose($read);
					echo '<div id="prijava">
								<form method="POST" action="index.php" id="odjavaforma">
									Prijavljeni ste kao: <b>'.htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8').'</b>
									<input type="submit" name="odjava" value="ODJAVI SE">
								</form>
					  		</div>';
					echo $panel.'<hr>';
				}*/
			}
			else {
				echo $prijava;
			}
?>
		<div id="zaglavlje">
			<div class="prvi-blok">
				<p id="logotip"><br><br><br>GoCA</p>
			</div>
		</div>
		
		<nav id="meni">
			<div class="meni-stavka">
				<ul>
					<li><a href="index.php"><p>VIJESTI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="telefonski-brojevi.php"><p>TELEFONSKI BROJEVI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>					
					<li><a href="linkovi.php"><p>LINKOVI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="kontakt.php"><p>KONTAKT</p></a></li>
				</ul>
			</div>
		</nav>
		
		<div id="sadrzaj">
<?php			
			$connection = new PDO("mysql:dbname=goca;host=localhost;charset=utf8", "goca", "goca");
	$connection->exec("set names utf8");
	$query = $connection->query("SELECT * FROM vijesti ORDER BY datum DESC");
	if (!$query) {
			        	$error = $connection->errorInfo();
			        	print "SQL greška: ".$error[2];
			        	exit();
	}
	foreach ($query as $news) {
		$commentscount = $connection->query("SELECT COUNT(*) FROM komentari WHERE vijest=".$news['id']."");
		$count = $commentscount->fetchColumn();
		echo '<div class="novost">
				<div class="news-text">
					<small class="datum_vrijeme_novosti">
						'.date("d.m.Y. h:i:s", strtotime($news['datum'])).' / Autor: '.$news['autor'].' / Komentari ('.$count.')
						</small>
					<h2 class="naslov_novosti">'.$news['naslov'].'</h2>
				<p class="tekst-novosti">'.$news['tekst'].' ';
		if ($news['detaljnije'] != "") {
			echo '<a href="#clanak'.$news['id'].'" onclick="return changeHash("#clanak'.$news['id'].'"); return false;">Detaljnije...</a>
				</p>
				<p class="detaljnije" hidden>'.$news['detaljnije'].'</p>';
		}
		echo '</div></div>';
	}

	?>		
			<!--<div id="novost-1" class="novost">
				<small class="datum-i-vrijeme-novosti">4. septembar 2015, 9:30 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Obilježena godišnjica od tragične smrti pet rudara u jami Raspotočje</h2>
				<p class="tekst-novosti">Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami 
					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše 
					bh. novinska agencija Patria.<br><br>Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju 
					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno.
				</p>
			</div>
			<div id="novost-2" class="novost">
				<small class="datum-i-vrijeme-novosti">5. septembar 2015, 4:37 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Visočki predstavnik na Sarajevo Youth Film festivalu je film “Mašta”, TV Furda produkcije</h2>
				<p class="tekst-novosti">Nakon što je naš portal, prije gotovo dva mjeseca, premijerno promovirao film “Mašta”, najnoviji 
					projekat mlade visočke produkcije TV Furda, ovog puta čast nam je obavijestiti javnost da je ovaj film ušao u 
					konkurenciju za glavnu nagradu Sarajevo Youth Film Festivala.
				</p>
			</div>
			<div id="novost-3" class="novost">
				<small class="datum-i-vrijeme-novosti">5. septembar 2015, 4:39 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Prva liga FBiH: Trećeplasirana Bosna gostuje kod devetoplasirane Zvijezde</h2>
				<p class="tekst-novosti">Nakon pobjede u prošlom kolu na domaćem terenu NK Bosna u petom kolu Prve lige FBiH gostuje 
					kod ekipe NK Zvijezda. Bit će to duel trećeplasirane i devetoplasirane ekipe na tabeli. Bosna na ovo gostovanje 
					putuje sa 9 bodova i gol razlikom 6:2, dok je ekipa Zvijezde iz četiri prethodna kola osvojila 5 bodova uz 
					negativnu gol razliku 3:4.
				</p>
			</div>-->
		
		
		</div>
	</body>
</html>