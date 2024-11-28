# Biometric Authentication for Moodle Quiz

This plugin integrates biometric authentication to restrict access to quizzes.

## Installation
1. Copy the `mybiometricauth` folder to `mod/quiz/accessrule/`.
2. Navigate to Site Administration > Notifications to complete the installation.

## Configuration
Go to Site Administration > Plugins > Quiz Access Rules > Biometric Authentication and configure:
- API URL
- API Key
- API User and Password

## Usage
1. Enable the rule in the quiz settings.
2. Users must validate their biometrics before accessing the quiz.

1. Estrutura Geral dos Arquivos
Aqui está o resumo dos arquivos principais e suas conexões:

PHP:
accessrule.php: Declara a regra de acesso ao quiz.
settings.php: Configurações do plugin para entrada de dados da API.
validate.php: Endpoint para validação com a API SERPRO.
version.php: Define a versão do plugin.
Mustache Templates:

biometric_modal.mustache: Interface para o modal de validação biométrica.
JavaScript:

biometrics.min.js: Gerencia a interação do modal, webcam e envio de dados para validação.
CSS (se necessário):

Adicionar estilos para o modal ou ajustar elementos do frontend.
Linguagens:

Arquivo lang (en, pt_br, etc.) para strings como títulos e mensagens.
2. Conexões Específicas e Requisitos
Aqui está a análise detalhada das conexões entre os arquivos:

Modal e Inicialização (Frontend):
Requisição de Inicialização no Quiz:
Certifique-se de que o arquivo biometrics.min.js é incluído corretamente no quiz usando o método adequado (add_requirements em accessrule.php):
php
Copiar código
$PAGE->requires->js_call_amd('mod_quiz/accessrule_mybiometricauth/biometrics', 'init');
Mustache Template (biometric_modal.mustache):
O modal deve estar conectado ao JS (biometrics.min.js) para interatividade.
A chamada para inicializar o modal deve ocorrer corretamente ao carregar o quiz.
Chamada de Validação (Backend)
Arquivo validate.php:
Este arquivo é crucial para receber os dados da imagem e CPF enviados pelo JS e validar com a API SERPRO.
Deve ser acessível via URL pública no Moodle:
php
Copiar código
$apiUrl = new moodle_url('/mod/quiz/accessrule/mybiometricauth/validate.php');
Deve validar os dados e retornar JSON com o resultado:
php
Copiar código
header('Content-Type: application/json');
echo json_encode(['match' => true]); // ou false, dependendo da validação.
Conexão com a API SERPRO:
Os métodos getTokenSerpro e getBiometriaSerpro precisam ser corretamente chamados em validate.php.
Certifique-se de que as credenciais da API são carregadas do banco de dados ou do arquivo de configuração.
Configurações do Plugin (Admin)
settings.php:

Deve incluir configurações para armazenar os seguintes dados:
URL da API.
Token da API.
Chave da API.
Usuário e senha da API.
Esses dados devem ser salvos no banco de dados (config_plugins do Moodle) e recuperados em validate.php.

3. Ajustes Potenciais
Configuração de Permissões
Verifique se o usuário tem permissões adequadas para acessar o quiz, e se o plugin de regra está devidamente aplicado.
Mensagens de Erro no Frontend
Adicionar mensagens de erro claras para casos como:
Webcam não disponível.
CPF inválido.
Erro ao conectar com a API SERPRO.
Logs e Auditoria
Adicionar logs para capturar eventos importantes, como:
Falha ao capturar imagem.
Tentativa de validação com a API.
Respostas da API.
4. Teste Completo da Estrutura
Verifique se os seguintes fluxos estão funcionando:
O modal é exibido corretamente ao tentar iniciar o quiz.
A webcam é inicializada e a imagem é capturada com sucesso.
A validação do CPF e da imagem com a API ocorre sem erros.
Após a validação bem-sucedida, o acesso ao quiz é concedido.