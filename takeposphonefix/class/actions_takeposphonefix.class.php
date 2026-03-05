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
					window.LoadPlacesList = function() {
						$("#phonediv1").load("'.dol_escape_js($url).'");
					};
					var _origOrder = window.TakeposPrintingOrder;
					window.TakeposPrintingOrder = function() {
						var el = document.activeElement;
						if (el && (el.tagName === "INPUT" || el.tagName === "TEXTAREA")) {
							el.blur();
							return;
						}
						_origOrder.apply(this, arguments);
					};
				}
			</script>';
		}
		return 0;
	}
}
