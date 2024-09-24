import "@popperjs/core";
import "bootstrap";
import "./bootstrap.js";
import "./styles/app.scss";

document.addEventListener("DOMContentLoaded", function () {
	var deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
	deleteButtons.forEach(function (button) {
		button.addEventListener("click", function () {
			var form = document.getElementById("deleteForm");
			form.action = button.getAttribute("data-bs-target");
		});
	});
});
