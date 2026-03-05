<?php
/* TakePOS Phone Fix - Places list with occupation status */

if (!defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');
if (!defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');
if (!defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');
if (!defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');
if (!defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');

require '../../../main.inc.php';

if (empty($user->rights->takepos->run)) {
	accessforbidden();
}

$terminal = (int) $_SESSION['takeposterminal'];

// Single query: fetch all places with occupation status via correlated subquery
$sql = "SELECT t.rowid, t.label,";
$sql .= " (SELECT COUNT(fd.rowid) FROM ".MAIN_DB_PREFIX."facturedet fd";
$sql .= " INNER JOIN ".MAIN_DB_PREFIX."facture f ON fd.fk_facture = f.rowid";
$sql .= " WHERE f.ref = CONCAT('(PROV-POS".$db->escape($terminal)."-', t.rowid, ')')) AS line_count";
$sql .= " FROM ".MAIN_DB_PREFIX."takepos_floor_tables t ORDER BY CAST(t.label AS UNSIGNED), t.label";
$resql = $db->query($sql);

if (!$resql) {
	print 'Error';
	$db->close();
	return;
}

print '<div class="places-grid">';
while ($row = $db->fetch_array($resql)) {
	$occupied = ($row['line_count'] > 0) ? ' place-occupied' : '';
	$labelHtml = htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8');
	$labelJs = htmlspecialchars(addslashes($row['label']), ENT_QUOTES, 'UTF-8');

	print '<div class="place-tile'.$occupied.'" onclick="LoadPlace(\''.$labelJs.'\')">';
	print '<span class="place-label">'.$labelHtml.'</span>';
	print '</div>'."\n";
}
print '</div>';

$db->free($resql);
$db->close();
