<?php
/* Copyright (C) 2024  TakePOS Phone Fix module
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 */

require_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

class modTakePosPhoneFix extends DolibarrModules
{
	public function __construct($db)
	{
		global $langs, $conf;

		$this->db = $db;

		$this->numero = 500100;
		$this->rights_class = 'takeposphonefix';
		$this->family = "portal";
		$this->module_position = '90';
		$this->name = preg_replace('/^mod/i', '', get_class($this));
		$this->description = "Fixes TakePOS phone layout so the invoice list scrolls independently and categories/products stay visible.";
		$this->descriptionlong = "Applies a flexbox layout to the TakePOS phone page. The invoice area (top) is capped at 35% of the screen and scrolls internally, while the categories/products area (bottom) always remains accessible without scrolling the whole page. Also highlights occupied places in red.";
		$this->editor_name = '';
		$this->editor_url = '';
		$this->version = '1.1.0';
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		$this->picto = 'takepos@takepos';

		$this->module_parts = array(
			'css' => array('/takeposphonefix/css/takeposphone_override.css'),
			'hooks' => array(
				'data' => array('takeposinvoice'),
				'entity' => '0',
			),
		);

		$this->dirs = array();
		$this->config_page_url = array();
		$this->hidden = false;
		$this->depends = array('modTakePos');
		$this->requiredby = array();
		$this->conflictwith = array();
		$this->langfiles = array();
		$this->const = array();
		$this->tabs = array();
		$this->dictionaries = array();
		$this->boxes = array();
		$this->cronjobs = array();
		$this->rights = array();
		$this->menu = array();
	}

	public function init($options = '')
	{
		$result = $this->_load_tables('/takeposphonefix/sql/');
		if ($result < 0) return -1;
		return $this->_init(array(), $options);
	}

	public function remove($options = '')
	{
		return $this->_remove(array(), $options);
	}
}
