<?php
/**
* @version	$Id$
* @package	Joomla
* @subpackage	ClubManagement-Member
* @copyright	Copyright (c) 2012 Norbert K�min. All rights reserved.
* @license	http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE
* @author	Norbert Kuemin
* @authorEmail	momo_102@bluemail.ch
*/
defined('_JEXEC') or die; // no direct access
$FieldPerLine=4;
$Line=5;
$details = false;
$EOL = "\n";

function getImageDir($imageDir) {
	if (!empty($imageDir)) {
		if (substr($imageDir,-1) != DIRECTORY_SEPARATOR) {
			$imageDir = $imageDir.DIRECTORY_SEPARATOR;
		}
		if (substr(JURI::root(),-1) == DIRECTORY_SEPARATOR) {
			if (substr($imageDir,0,1) == DIRECTORY_SEPARATOR) {
				$imageDir = JURI::root().substr($imageDir,1);
			} else {
				$imageDir = JURI::root().$imageDir;
			}
		} else {
			if (substr($imageDir,0,1) == DIRECTORY_SEPARATOR) {
				$imageDir = JURI::root().$imageDir;
			} else {
				$imageDir = JURI::root().DIRECTORY_SEPARATOR.$imageDir;
			}
		}
	}
	return $imageDir;
}

if ($this->paramsMenuEntry->get('detail_enable') != '0') {
	$details = true;
	$curi = JFactory::getURI();
	$uri = JURI::getInstance( $curi->toString() );
	$uri->setVar('layout','detail');
	$uri->setVar('tmpl','component');
	$uri->setVar('Itemid','');
	$uri->setVar('view','person');
}
// Get columns
$cols = array();
for ($i=1;$i<=20;$i++) {
	$field = 'column_'.$i;
	$cols[] = $this->paramsMenuEntry->get($field );
}
$colcount = count($cols);
// Display
$cssText = '';
switch ($this->paramsMenuEntry->get('border_type')) {
	case 'row':
		$cssText .= '.cmTableBorder { border-top-style:solid; border-width:1px; }'.$EOL;
		break;
	case 'grid':
		$cssText .= '.cmTableBorder { border-style:solid; border-width:1px; }'.$EOL;
		break;
	default:
		$cssText .= '.cmTableBorder {  }'.$EOL;
		break;
}
$cssText .= '.cmTableCellTextAlign { text-align: '.$this->paramsMenuEntry->get('textalign').'; }'.$EOL;
$imgSize = intval($this->paramsMenuEntry->get('image_size_value'));
if ($imgSize > 0) {
	if (($this->paramsMenuEntry->get('image_size_uom') == '%') && ($imgSize >100)) { $imgSize = 100; }
	$cssText .= '.cmTableImage { width: '.$imgSize.$this->paramsMenuEntry->get('image_size_uom').'; height: auto; }'.$EOL;
} else {
	$cssText .= '.cmTableImage { }'.$EOL;
}
$doc = JFactory::getDocument();
$doc->addStyleDeclaration($cssText);
$imageDir = getImageDir($this->paramsComponent->get('image_dir'));
if ($details) {
	JHTML::_('behavior.modal');
}
if ($this->paramsMenuEntry->get('table_center') == '1') echo '<center>'.$EOL;
if ($this->items) {
	JLoader::register('SelectionHelper', JPATH_COMPONENT_ADMINISTRATOR.'/helpers/selection.php', true);
	$memberTypes = SelectionHelper::getSelection('member_types');
	foreach($this->items as $item) {
		$row = (array) $item;
		$lines = array();
		$imageCol = $this->paramsMenuEntry->get('column_image');
		if ($imageCol != '') {
			$image = $row[$imageCol];
		}
		for($i=0;$i<$Line;$i++) {
			$lines[$i] = '';
			for($j=0;$j<$FieldPerLine;$j++) {
				$colnr = $i*$FieldPerLine+$j;
				$field = $cols[$colnr];
				$data = '';
				if (($field == 'member_type') && !empty($memberTypes[$row[$field]])) {
					$data = $memberTypes[$row[$field]];
				} else {
					if (isset($row[$field])) { $data = $row[$field]; }
				}

				if (strlen($data) > 0) {
					if ($lines[$i]) { $lines[$i] .= " "; }
					if ($details && ($this->paramsMenuEntry->get( 'detail_column_link' ) == $field) && ($data != "")) {
						$data = '<a href="'.$uri->toString().'" class="modal" rel="{handler: \'iframe\', size: {x: '.$this->paramsMenuComponent->get('detail_width').', y: '.$this->paramsComponent->get('detail_height').'}}">'.$data.'</a>';
					}
					$lines[$i] .= $data;
					$lines[$i] = trim($lines[$i]);
				}
			}
			if ($details && ($this->paramsMenuEntry->get('detail_column_link') == '') && ($data != '')) {
				$lines[$i] = '<a href="'.$uri->toString().'" class="modal" rel="{handler: \'iframe\', size: {x: '.$this->paramsComponent->get('detail_width').', y: '.$this->paramsComponent->get('detail_height').'}}">'.$lines[$i].'</a>';
			}
		}
		echo '<table class="cmTableBorder">'.$EOL;
		switch ($this->paramsMenuEntry->get('picpos')) {
			case 'right': //picture on the right side
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				break;
			case 'top': //picture on the top
				echo '<tr valign="top">'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				break;
			case 'bottom': //picture on the bottom
				echo '<tr valign="top">'.$EOL;
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				echo '<tr valign="top">'.$EOL;
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '</tr>'.$EOL;
				break;
			case 'left': //picture on the left side
			default:
				echo '<tr valign="top">';
				if ($image) {
					echo '<td class="cmTableCellTextAlign"><img src="'.$imageDir.$image.'" class="cmTableImage"></td>'.$EOL;
				}
				echo '<td class="cmTableCellTextAlign">';
				for($i=0;$i<$Line;$i++) {
					if (strlen($lines[$i]) > 0) {
						echo $lines[$i].'<br />';
					}
				}
				echo '</td>'.$EOL;
				echo '</tr>'.$EOL;
				break;
		}
		echo '</table>'.$EOL;
		echo '<p/>'.$EOL;
	}
}
if ($this->paramsMenuEntry->get( "table_center") == "1") echo "</center>\n";
?>
