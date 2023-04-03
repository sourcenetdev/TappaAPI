<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-10-09 11:35:34 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:35:34 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 221
ERROR - 2021-10-09 11:37:06 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Undefined array key 0 C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:37:06 --> Severity: Warning --> Trying to access array offset on value of type null C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\helpers\MY_form_helper.php 222
ERROR - 2021-10-09 11:39:29 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:39:55 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:40:59 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:46:51 --> Severity: Warning --> Undefined array key "import_types" C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\models\Csvimport_model.php 156
ERROR - 2021-10-09 11:46:51 --> Query error: Table 'kcms_v7base.it' doesn't exist - Invalid query: SELECT `c`.`id`, `c`.`slug`, `c`.`name`, `c`.`file`, `it`.`import_type_description`, `c`.`processed`, `c`.`active`, `c`.`deleted`, `c`.`createdate`, `c`.`moddate`
FROM `kcms_csvimport` `c`
LEFT JOIN `it` ON `it`.`import_type` = `c`.`import_type`
WHERE `id` = '2'
AND `c`.`active` = 'Yes'
AND `c`.`processed` = 'No'
ERROR - 2021-10-09 11:47:34 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `c`.`id`, `c`.`slug`, `c`.`name`, `c`.`file`, `it`.`import_type_description`, `c`.`processed`, `c`.`active`, `c`.`deleted`, `c`.`createdate`, `c`.`moddate`
FROM `kcms_csvimport` `c`
LEFT JOIN `kcms_askgogo_import_type` `it` ON `it`.`import_type` = `c`.`import_type`
WHERE `id` = '2'
AND `c`.`active` = 'Yes'
AND `c`.`processed` = 'No'
ERROR - 2021-10-09 11:48:25 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:48:32 --> Could not find the language line "csvimport_delete_warn"
ERROR - 2021-10-09 11:48:33 --> Query error: Unknown column 'it.import_type_description' in 'field list' - Invalid query: SELECT `c`.`id`, `c`.`slug`, `c`.`name`, `c`.`file`, `it`.`import_type_description`, `c`.`processed`, `c`.`active`, `c`.`createdate` AS `created`, `c`.`moddate` AS `modified`
FROM `kcms_csvimport` `c`
 LIMIT 25
ERROR - 2021-10-09 11:49:18 --> Severity: error --> Exception: Call to undefined method Csvimport_model::get_all_import_types() C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\controllers\Csvimport.php 245
ERROR - 2021-10-09 11:52:39 --> Severity: Warning --> Undefined array key "import_types" C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\models\Csvimport_model.php 255
ERROR - 2021-10-09 11:52:39 --> Severity: Warning --> Undefined variable $not_processed C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\models\Csvimport_model.php 259
ERROR - 2021-10-09 11:52:39 --> Query error: Table 'kcms_v7base.it' doesn't exist - Invalid query: SELECT `it`.`id`, `it`.`import_type`, `it`.`import_type_description`, `it`.`active`, `it`.`deleted`, `it`.`create_date`, `it`.`modified_date`
FROM `it`
WHERE `it`.`active` = 'Yes'
ERROR - 2021-10-09 11:52:55 --> Severity: Warning --> Undefined variable $not_processed C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\models\Csvimport_model.php 259
ERROR - 2021-10-09 11:52:55 --> Severity: Warning --> Undefined variable $import_types_map C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\controllers\Csvimport.php 261
ERROR - 2021-10-09 11:53:09 --> Severity: Warning --> Undefined variable $import_types_map C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\csvimport\controllers\Csvimport.php 261
ERROR - 2021-10-09 12:01:55 --> Severity: Warning --> Undefined array key "import_type_name" C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\core\controllers\Core.php 318
ERROR - 2021-10-09 12:01:55 --> Severity: Warning --> Undefined array key "import_type_name" C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\core\controllers\Core.php 318
ERROR - 2021-10-09 12:01:55 --> Severity: Warning --> Undefined array key "import_type_name" C:\Users\kobus\OneDrive - Impero Consulting\htdocs\kcms_base\application\modules\core\controllers\Core.php 318
