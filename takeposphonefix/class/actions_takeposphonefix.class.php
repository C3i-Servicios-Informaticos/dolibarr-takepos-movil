<?php
/* TakePOS Phone Fix - Hook to inject JS override on phone page */

class ActionsTakeposphonefix
{
	public $resprints = '';
	public $error = '';
	public $errors = array();

	/**
	 * Hook on completeTakePosInvoiceHeader - inject JS to override LoadPlacesList
	 */
	public function completeTakePosInvoiceHeader($parameters, &$object, &$action, $hookmanager)
	{
		$mobilepage = GETPOST('mobilepage', 'alpha');
		if ($mobilepage == 'invoice') {
			$url = dol_buildpath('/takeposphonefix/ajax/places.php', 1);
			$this->resprints = '<script>
				if (typeof window._phonefixLoaded === "undefined") {
					window._phonefixLoaded = true;
					// Override LoadPlacesList to use custom places grid
					window.LoadPlacesList = function() {
						$("#phonediv1").load("'.dol_escape_js($url).'");
					};
					// Add back button when viewing products
					var _origLoadProducts = window.LoadProducts;
					window.LoadProducts = function(idcat) {
						_origLoadProducts(idcat);
						setTimeout(function() {
							var hdr = $("#phonediv1 tr.liste_titre td.linecoldescription");
							if (hdr.length && !hdr.find(".phonefix-back").length) {
								hdr.append("<span class=\"phonefix-back\" onclick=\"LoadCats();\">\u25C0 VOLVER</span>");
							}
						}, 300);
					};
					// Guard buttons: dismiss keyboard instead of acting when input is focused
					["TakeposPrintingOrder","LoadCats","Exit"].forEach(function(fn) {
						var orig = window[fn];
						if (typeof orig === "function") {
							window[fn] = function() {
								try {
									var el = document.activeElement;
									if (el && (el.tagName === "INPUT" || el.tagName === "TEXTAREA")) {
										el.blur();
										return;
									}
								} catch(e) {}
								orig.apply(this, arguments);
							};
						}
					});
				}
			</script>';
		}
		return 0;
	}
}
