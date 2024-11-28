<?php
require_once("$CFG->libdir/formslib.php");

class cfc_form extends moodleform {
    
    // Define o formulário
    public function definition() {
        global $DB;
        $mform = $this->_form; // Instância do formulário

          // Campo oculto para ID (para edição)
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        // Campo 'Nome'
        $mform->addElement('text', 'nome', get_string('name', 'local_cfc'));
        $mform->setType('nome', PARAM_TEXT); // Tipo de dados
        $mform->addRule('nome', null, 'required', null, 'client');

        // Campo 'Razão Social'
        $mform->addElement('text', 'razaosocial', get_string('razaosocial', 'local_cfc'));
        $mform->setType('razaosocial', PARAM_TEXT);
        $mform->addRule('razaosocial', null, 'required', null, 'client');

        // Campo 'CNPJ'
        $mform->addElement('text', 'cnpj', get_string('cnpj', 'local_cfc'));
        $mform->setType('cnpj', PARAM_TEXT);
        $mform->addRule('cnpj', null, 'required', null, 'client');

        // Campo 'Gestor'
        $mform->addElement('text', 'gestor', get_string('gestor', 'local_cfc'));
        $mform->setType('gestor', PARAM_RAW);

        // Campo 'Gestor'
        $mform->addElement('text', 'fundo', get_string('cor', 'local_cfc'));
        $mform->setType('fundo', PARAM_RAW);

         // Novo campo de upload de imagem para logo
        $mform->addElement('filepicker', 'logo', get_string('logo', 'local_cfc'), null, array('accepted_types' => array('.png', '.jpg', '.jpeg')));
       

          


        // Botões de Envio
        $this->add_action_buttons(true, get_string('submit', 'local_cfc'));
    }
    // Função para carregar dados no formulário
    public function set_data($defaultvalues) {
        global $USER;

        $context = context_user::instance($USER->id); // Pode ser ajustado conforme o contexto do seu plugin
        $itemid = $defaultvalues->id; // O ID do registro salvo

        // Preparar o arquivo para o filepicker
        $draftitemid = file_get_submitted_draft_itemid('logo');
        file_prepare_draft_area(
            $draftitemid,
            $context->id,
            'local_cfc',
            'logo',
            $itemid,
            array('subdirs' => false, 'maxfiles' => 1)
        );

        // Atribuir o draftitemid ao campo logo
        $defaultvalues->logo = $draftitemid;

        parent::set_data($defaultvalues); // Chama o método original para garantir que outros dados sejam configurados
    }
   
}