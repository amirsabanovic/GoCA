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
		<title>Vijesti | GoCA</title>
	</head>
	<body onload="hideLoginForm();">
		
		<?php
			
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
							<h3>ADMINISTRATORSKI PANEL</h3>
							<div id="panel-opcije">
								<input type="button" onclick="izlistajVijesti()" value="VIJESTI">
								<input type="button" onclick="izlistajKomentare()" value="KOMENTARI">
								<input type="button" onclick="izlistajKorisnike()" value="KORISNICI">
							</div>
							<div id="panel-lista"></div>
							<div id="panel-forma"></div>
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
				$korisnickoime = htmlspecialchars($_REQUEST['korisnickoime'], ENT_QUOTES, 'UTF-8');
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
				}
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
					<li><a href="telefonski-brojevi.html"><p>TELEFONSKI BROJEVI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>					
					<li><a href="linkovi.html"><p>LINKOVI</p></a></li>
				</ul>
			</div>
			<div class="meni-stavka">
				<ul>
					<li><a href="kontakt.html"><p>KONTAKT</p></a></li>
				</ul>
			</div>
		</nav>
		
		<div id="sadrzaj">
			<!--<div id="novost-1" class="novost">
				<small class="datum-i-vrijeme-novosti">4. septembar 2015, 9:30 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Obilježena godišnjica od tragične smrti pet rudara u jami Raspotočje</h2>
				<p class="tekst-novosti">Danas je u organizaciji RMU Zenica obilježena prva godišnjica pogibije pet rudara u jami 
					Raspotočje kada su usljed gorskog udara u jami ostala zarobljena 34 rudara u septembru 2014. godine, piše 
					bh. novinska agencija Patria.<br><br>Nažalost za pet rudara Fejzu Isakovića, Mehemeda Dizdarevića, Mehmedaliju 
					Halilovića, Fahira Halača i Hajrudin Bradarca bilo je prekasno. <a href="#detaljnije">Detaljnije...</a>
				</p>
			</div>
			<div id="novost-2" class="novost">
				<small class="datum-i-vrijeme-novosti">5. septembar 2015, 4:37 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Visočki predstavnik na Sarajevo Youth Film festivalu je film “Mašta”, TV Furda produkcije</h2>
				<img src="slike/masta.jpg" class="news-image" alt="Mašta">
				<p class="tekst-novosti">Nakon što je naš portal, prije gotovo dva mjeseca, premijerno promovirao film “Mašta”, najnoviji 
					projekat mlade visočke produkcije TV Furda, ovog puta čast nam je obavijestiti javnost da je ovaj film ušao u 
					konkurenciju za glavnu nagradu Sarajevo Youth Film Festivala. <a href="#detaljnije">Detaljnije...</a>
				</p>
			</div>
			<div id="novost-3" class="novost">
				<small class="datum-i-vrijeme-novosti">5. septembar 2015, 4:39 / Amir Šabanović</small>
				<h2 class="naslov-novosti">Prva liga FBiH: Trećeplasirana Bosna gostuje kod devetoplasirane Zvijezde</h2>
				<p class="tekst-novosti">Nakon pobjede u prošlom kolu na domaćem terenu NK Bosna u petom kolu Prve lige FBiH gostuje 
					kod ekipe NK Zvijezda. Bit će to duel trećeplasirane i devetoplasirane ekipe na tabeli. Bosna na ovo gostovanje 
					putuje sa 9 bodova i gol razlikom 6:2, dok je ekipa Zvijezde iz četiri prethodna kola osvojila 5 bodova uz 
					negativnu gol razliku 3:4. <a href="#detaljnije">Detaljnije...</a>
				</p>
			</div>-->
		</div>
	</body>
</html>