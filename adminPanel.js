function showLoginForm() {
	if (document.getElementById("prijavaforma").style.display == "none") {
		document.getElementById("prijavaforma").style.display = "block";
		document.getElementById("dugmePrijava").value = "SAKRIJ";
	}
	else {
		document.getElementById("prijavaforma").style.display = "none";
		document.getElementById("dugmePrijava").value = "PRIJAVA";
	}
}

function hideLoginForm() {
	document.getElementById("prijavaforma").style.display = "none";
}

function showPanel() {
	if (document.getElementById("panel-link").innerHTML == '<a href="#panel" onclick="showPanel()">Prikaži administratorski panel</a>') {
		document.getElementById("panel-link").innerHTML = '<a href="#panel" onclick="showPanel()">Sakrij administratorski panel</a>';
		document.getElementById("panel").style.display = "block";
	}
	else {
		document.getElementById("panel-link").innerHTML = '<a href="#panel" onclick="showPanel()">Prikaži administratorski panel</a>';
		document.getElementById("panel").style.display = "none";
	}
}