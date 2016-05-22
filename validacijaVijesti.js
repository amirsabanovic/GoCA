var brojGresaka1 = 0, brojGresaka2 = 0, brojGresaka3 = 0, brojGresaka4 = 0, brojGresaka5 = 0, brojGresaka6 = 0;

function validacijaVijesti() {
	if (!provjeriAutora() || !provjeriKod() || !provjeriTelefon() || !provjeriNaslov() || !provjeriUkratko() || !provjeriSadrzaj()) {
		alert('Uneseni podaci nisu validni!');
		return false;
	}
	else {
        document.getElementById("vijest-forma").submit();
		//return true;
	}
}
function provjeriAutora() {
    var panel = document.getElementById("panel");
	var autor = document.getElementById("vijest-autor").value;
	if (autor.length == 0) {
		panel.style.backgroundColor = "red";
        brojGresaka1 = 1;
        return false;
	}
    else {
        if (brojGresaka1 == 1)
            brojGresaka1 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
    return true;
}

function provjeriKod() {
    var panel = document.getElementById("panel");
	var kod = document.getElementById("vijest-kod-drzave").value;
    if (kod.length != 2) {
        panel.style.backgroundColor = "red";
        brojGresaka2 = 1;
		return false;
	}
    else {
        if (brojGresaka2 == 1)
            brojGresaka2 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
	return true;
}

function provjeriTelefon() {
    var panel = document.getElementById("panel");
    var telefon = document.getElementById("vijest-telefon-autora").value;
    var telefonRegEx = /^\+[0-9]{1,3}\.[0-9]{4,14}(?:x.+)?$/;
    if (telefonRegEx.test(telefon) == false || telefon.length == 0) {
        panel.style.backgroundColor = "red";
        brojGresaka3 = 1;
		return false;
	}
    else {
        if (brojGresaka3 == 1)
            brojGresaka3 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
	return true;
}

function provjeriNaslov() {
    var panel = document.getElementById("panel");
	var naslov = document.getElementById("vijest-naslov").value;
	if (naslov.length == 0) {
        panel.style.backgroundColor = "red";
        brojGresaka4 = 1;
		return false;
	}
    else {
        if (brojGresaka4 == 1)
            brojGresaka4 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
	return true;
}

function provjeriUkratko() {
    var panel = document.getElementById("panel");
	var ukratko = document.getElementById("vijest-ukratko").value;
	if (ukratko.length == 0) {
        panel.style.backgroundColor = "red";
        brojGresaka5 = 1;
		return false;
	}
    else {
        if (brojGresaka5 == 1)
            brojGresaka5 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
	return true;
}

function provjeriSadrzaj() {
    var panel = document.getElementById("panel");
	var sadrzaj = document.getElementById("vijest-sadrzaj").value;
	if (sadrzaj.length == 0) {
        panel.style.backgroundColor = "red";
        brojGresaka6 = 1;
		return false;
	}
    else {
        if (brojGresaka6 == 1)
            brojGresaka6 = 0;
    }
    if (brojGresaka1 == 0 && brojGresaka2 == 0 && brojGresaka3 == 0 && brojGresaka4 == 0 && brojGresaka5 == 0 && brojGresaka6 == 0) {
        panel.style.backgroundColor = "lightslategray";
    }
	return true;
}

function provjeriKodTelefon() {
	OK = true;
	var kod = document.getElementById("vijest-kod-drzave").value;
    var telefon = document.getElementById("vijest-telefon-autora").value;
    var panel = document.getElementById("panel");
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
            var response = JSON.parse(ajax.responseText);
            var countrycode = response[0].callingCodes;
            var mycountrycode = telefon.substring(telefon.lastIndexOf("+") + 1, telefon.lastIndexOf("."));
			if (kod.length > 0 && telefon.length > 0) {
                if (countrycode == mycountrycode) {
				    panel.style.backgroundColor = "lightslategray";
				    OK = true;
			    }
                else {
                    panel.style.backgroundColor = "red";
                    OK = false;
                }
            }
		}
	}
	ajax.open("GET", "https://restcountries.eu/rest/v1/alpha?codes=" + kod, true);
	ajax.send();
}