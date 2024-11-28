<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    // Criando a categoria principal "Gerenciamento de Empresas"
    $ADMIN->add('localplugins', new admin_category('local_cfc_management', get_string('managementheading', 'local_cfc')));

    // ============================
    // Link externo para "Usuários"
    // ============================

    $ADMIN->add('local_cfc_management', new admin_externalpage(
        'local_cfc_empresas',
        get_string('cfcs', 'local_cfc'),
        new moodle_url('/local/cfc/index.php', array('section' => 'local_cfc')), // URL interna do Moodle
        'moodle/site:config' // Permissão necessária (geralmente apenas administradores)
    ));

    // ============================
    // Link externo para "Funções"
    // ============================

   /* $ADMIN->add('local_cfc_management', new admin_externalpage(
        'local_cfc_users',
        get_string('credits', 'local_cfc'),
        new moodle_url('/local/cfc/store.php', array('section' => 'local_cfc')), // URL interna do Moodle
        'moodle/site:config' // Permissão necessária (somente administradores)
    ));*/
    // ============================ 
    // ============================

  /*  $ADMIN->add('local_cfc_management', new admin_externalpage(
        'local_cfc_product',
        get_string('productmanager', 'local_cfc'),
        new moodle_url('/local/cfc/product.php', array('section' => 'local_cfc')), // URL interna do Moodle
        'moodle/site:config' // Permissão necessária (somente administradores)
    ));*/
}