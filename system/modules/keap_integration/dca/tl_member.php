<?

/**
 * Bright Cloud Studio's Keap Integration
 *
 * @copyright  2022 Bright Cloud Studio
 * @package    keap_integration
 * @license    GNU/LGPL
 * @filesource
 */

/* Add fields to tl_user */
$GLOBALS['TL_DCA']['tl_member']['fields']['state'] = array
(
  'sorting'                 => true,
  'inputType'               => 'select',
  'options'                 => array('Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'),
  'eval'                    => array('includeBlankOption'=>true, 'feEditable'=>true, 'feViewable'=>true, 'feGroup'=>'address', 'tl_class'=>'w50'),
  'sql'                     => "varchar(64) NOT NULL default ''"
);
