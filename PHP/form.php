<?php

// Debug de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carregando autoload do composer
require __DIR__ . '/../vendor/autoload.php';

// Cria variáveis e pega as informações do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['e-mail'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    // Cria mais duas variáveis com textos para o corpo do e-mail
    // Ambas usam as variáveis criadas acima

    // Pimeiro um texto em formato HTML para ser colocado no corpo do email
    $htmlContent = "
        <h2>Novo Contato do Site</h2>
        <p><strong>Nome:</strong> {$nome}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Telefone:</strong> {$telefone}</p>
        <p><strong>Endereço:</strong> {$endereco}</p>
        <h3>Mensagem:</h3>
        <p>{$mensagem}</p>
    ";

    // E depois um texto simples
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

    // Cria um e-mail para ser enviado
    $mail = new \SendGrid\Mail\Mail();
    // Define o remetente
    $mail->setFrom("aleftelles@live.com", "Dr Diego de Almeida");
    // Deine o assunto do e-mail
    $mail->setSubject("Novo contato de: {$nome}");
    // Define o destinatário
    $mail->addTo("dr.diegodealmeida@gmail.com", "Teste");
    // Define o corpo do e-mail com o que já foi criado acima
    $mail->addContent("text/plain", $plainContent);
    $mail->addContent("text/html", $htmlContent);

    // Verifica a chave da API (que está determinada em um arquivo .env na raiz do projeto)
    $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
    // Define o redirecionamento da página
    // Primeiro em caso de sucesso de envio
    try {
        $response = $sendgrid->send($mail);
        header('Location: /Final/contato.html?success=1');
        // E depois em caso de fracasso
    } catch (Exception $e) {
        header('Location: /Final/contato.html?error=1');
    }
}
?>