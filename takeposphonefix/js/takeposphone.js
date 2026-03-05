/* TakePOS Phone Fix - Override LoadPlacesList after page ready */
$(document).ready(function () {
	if (typeof LoadPlacesList !== "undefined") {
		window.LoadPlacesList = function () {
			$("#phonediv1").load("/custom/takeposphonefix/ajax/places.php");
		};
	}
});
