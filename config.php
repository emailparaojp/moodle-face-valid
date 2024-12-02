<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mariadb';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'gabelitech';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'root';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'http://localhost/moodle';
$CFG->dataroot  = __DIR__ . '/../moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;
defined('EXTERNAL_SERVICE_CLIENT_ID')  || define('EXTERNAL_SERVICE_CLIENT_ID', 'seu_client_id');
defined('EXTERNAL_SERVICE_CLIENT_SECRET') || define('EXTERNAL_SERVICE_CLIENT_SECRET', 'sua_chave_bearer');
require_once(__DIR__ . '/lib/setup.php');
if (!function_exists('curl_init')) {
    throw new Exception('cURL não está habilitado. Habilite para continuar.');
}

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
