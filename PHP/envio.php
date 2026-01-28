<?php

// Código para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carrega o autoload do composer
require __DIR__ . '/../vendor/autoload.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta as informações do formulário
    // e armazena em variáveis
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['e-mail'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    // Cria variáveis com os formatos do corpo do e-mail
    // Cria o formato do corpo do e-mail em HTML
    $htmlContent = "
        <h2>Novo Contato do Site</h2>
        <p><strong>Nome:</strong> {$nome}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Telefone:</strong> {$telefone}</p>
        <p><strong>Endereço:</strong> {$endereco}</p>
        <h3>Mensagem:</h3>
        <p>{$mensagem}</p>
    ";

    // Cria o corpo do e-mail usando o padrão criado acima
    $plainContent = "
        Novo Contato do Site
        Nome: {$nome}
        Email: {$email}
        Telefone: {$telefone}
        Endereço: {$endereco}
        
        Mensagem:
        {$mensagem}
    ";

    // Comandos da API da SendGrid
    
    // Cria um novo e-mail para ser enviado
    $mail = new \SendGrid\Mail\Mail(); 
    // Define qual o e-mail rementente
    $mail->setFrom("aleftelles@live.com", "Dr Diego de Almeida");
    // Define o assunto do e-mail
    $mail->setSubject("Novo contato de: {$nome}");
    // Define o endereço de e-mail para onde as informações serão enviadas
    $mail->addTo("projexads@gmail.com", "Teste");
    // Usa a variável o texto do e-mail
    $mail->addContent("text/plain", $plainContent);
    // Usa o formato do HTML
    $mail->addContent("text/html", $htmlContent);

    // Verificando se a chave da API é válida
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    // Define os redirecionamentos após o envio do formulário
    // para a própria página, independente de sucesso ou erro
    try {
        $response = $sendgrid->send($mail);
        header('Location: /Final/contato.html?success=1');
    } catch (Exception $e) {
        header('Location: /Final/contato.html?error=1');
        echo = "Formulário não enviado"
    }
}
?>