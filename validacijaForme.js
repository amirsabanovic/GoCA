var brojGresaka1 = 0, brojGresaka2 = 0, brojGresaka3 = 0, brojGresaka4 = 0, brojGresaka5 = 0;
var sadrzaj = document.getElementById("sadrzaj");

function validacijaForme() {
	if (!provjeriImeIPrezime() || !provjeriEmail() || !crossValidirajEmail() || !provjeriTelefon() || !provjeriKomentar()) {
		alert('Uneseni podaci nisu validni!');
		return false;
	}
	else {
		return true;
	}
}
function provjeriImeIPrezime() {
	var imeiprezime = document.getElementById("imeiprezime").value;
    var sadrzaj = document.getElementById("sadrzaj");
	if (imeiprezime.length < 5 || imeiprezime.length > 50) {
		sadrzaj.style.backgroundColor = "red";
        brojGresaka1++;
        return false;
	}
    else {
        if (brojGresaka1 > 0)
            brojGresaka1--;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0) {
        sadrzaj.style.backgroundColor = "white";
    }
    return true;
}

function provjeriEmail() {
	var email = document.getElementById("email").value;
    var sadrzaj = document.getElementById("sadrzaj");
	var emailRegEx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if (!emailRegEx.test(email)) {
        sadrzaj.style.backgroundColor = "red";
        brojGresaka2++;
		return false;
	}
    else {
        if (brojGresaka2 > 0)
            brojGresaka2--;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0) {
        sadrzaj.style.backgroundColor = "white";
    }
	return true;
}

function crossValidirajEmail() {
	var email_potvrda = document.getElementById("email_potvrda").value;
	var email = document.getElementById("email").value;
    var sadrzaj = document.getElementById("sadrzaj");
	if (email_potvrda != email) {
        sadrzaj.style.backgroundColor = "red";
        brojGresaka3++;
		return false;
	}
    else {
        if (brojGresaka3 > 0)
            brojGresaka3--;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0) {
        sadrzaj.style.backgroundColor = "white";
    }
	return true;
}

function provjeriTelefon() {
	var telefon = document.getElementById("telefon").value;
    var sadrzaj = document.getElementById("sadrzaj");
	var telefonRegEx = /\d{9}/;
	if (!telefonRegEx.test(telefon)) {
        sadrzaj.style.backgroundColor = "red";
        brojGresaka5++;
		return false;
	}
    else {
        if (brojGresaka5 > 0)
            brojGresaka5--;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0) {
        sadrzaj.style.backgroundColor = "white";
    }
	return true;
}

function provjeriKomentar() {
	var komentar = document.getElementById("komentar").value;
    var sadrzaj = document.getElementById("sadrzaj");
	if (komentar.length == 0) {
        sadrzaj.style.backgroundColor = "red";
        brojGresaka4++;
		return false;
	}
    else {
        if (brojGresaka4 > 0)
            brojGresaka4--;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0) {
        sadrzaj.style.backgroundColor = "white";
    }
	return true;
}