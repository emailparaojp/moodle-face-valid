<?php
$capabilities = array(
    'local/cfc:manage' => array(
        'riskbitmask' => RISK_CONFIG,
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        ),
    ),
    // Capacidade para usuários que podem ver uma tela específica de usuários
    'local/emprcfcesa:viewuserpage' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'teacher' => CAP_ALLOW,  // Você pode atribuir isso ao professor ou outro papel
            'editingteacher' => CAP_ALLOW,
        ),
    ),
);