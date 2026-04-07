<?php
// config/openai.php (Adaptado para Google Gemini)

return [
    // Sua chave do Google AI Studio
    'api_key' => getenv('GEMINI_API_KEY') ?: 'AIzaSyDkFHmzupOlkBIsltc_in-_Kh5uiuDhuvA',
    
    // MODELO IDEAL:
    // 'gemini-1.5-flash' -> Recomendado para análise financeira rápida e baixo custo.
    // 'gemini-1.5-pro'   -> Use se os relatórios forem extremamente longos ou complexos.
    'model' => 'gemini-3-flash-preview',
    
    // TEMPERATURA (0.0 a 2.0):
    // Para finanças, 0.7 é um bom equilíbrio. 
    // Se quiser respostas estritamente baseadas em números e menos "conversadas", baixe para 0.3.
    'temperature' => 0.7,
    
    // TOKENS (Janela de Resposta):
    // 300 tokens é pouco para um consultor (dá cerca de 200 palavras). 
    // Para um relatório detalhado com dicas, o ideal é entre 800 e 1500.
    'max_tokens' => 2048,
    
    // TIMEOUT:
    // O Gemini processa volumes grandes de dados. 30s é seguro, 
    // mas se enviar PDFs ou listas gigantes, considere 60s.
    'timeout' => 60
];