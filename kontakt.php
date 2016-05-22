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
        <script src="validacijaForme.js" type="text/javascript"></script>
		<script src="adminPanel.js" type="text/javascript"></script>
		<script src="validacijaVijesti.js" type="text/javascript"></script>
		<title>Kontakt \\ GoCA</title>
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
									<textarea rows="4" cols="50" id="vijest-sadrzaj" name="vijest-sadrzaj" onblur="provjeriSadrzaj()"></textarea>
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
			<div class="prvi-blok"></div>
			<div id="logotip">GoCA</div>
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
			<form id="forma" name="forma" action="kontakt.html" method="post" onsubmit="validacijaForme(); return false;">				
				
				<div class="stavka_forme">
					<label for="imeiprezime">Ime i prezime: </label><br>
					<input type="text" id="imeiprezime" name="imeiprezime" size="30" onblur="provjeriImeIPrezime()">
					
				</div>
				<div class="stavka_forme">
					<label for="email">Email: </label><br>
					<input type="text" id="email" name="email" size="30" onblur="provjeriEmail()">
				</div>
				<div class="stavka_forme">
					<label for="email_potvrda">Potvrdi email: </label><br>
					<input type="text" id="email_potvrda" name="email_potvrda" size="30" onblur="crossValidirajEmail()">
				</div>
				<div class="stavka_forme">
					<label for="telefon">Telefon (Npr. 123456789):</label><br>
					<input type="text" id="telefon" name="telefon" size="30" onblur="provjeriTelefon()">
				</div>
				<div class="stavka_forme">
					<label for="komentar">Komentar: </label><br>
					<textarea id="komentar" name="komentar" rows="10" cols="40" onblur="provjeriKomentar()"></textarea>
				</div>
				<input type="submit" id="posalji" name="posalji" value="Pošalji">
			</form>
		</div>
	</body>
</html>