<?php
// cron/auto_gerar_insights.php

// Define os caminhos base
define('BASE_PATH', dirname(__DIR__, 2));
define('APP', BASE_PATH . '/app');

/**
 * AMIGO DO BOLSO - GERADOR DE INSIGHTS SEMANAIS (CRON)
 * Execução sugerida: Todo domingo às 20h ou quando desejar atualizar as dicas.
 */

// 1. Carrega o Core e Configurações
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Model.php';
require_once BASE_PATH . '/app/core/Controller.php';

// 2. Carrega a Controller que contém a lógica da IA
require_once BASE_PATH . '/app/controllers/RelatoriosController.php';

// 3. Carrega as Models necessárias
require_once BASE_PATH . '/app/models/NotificationModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/CategoryModel.php';
require_once BASE_PATH . '/app/models/CreditCardInvoiceModel.php';

// 4. Carrega o Autoload do Composer (Para Gemini/OpenAI)
require_once BASE_PATH . '/vendor/autoload.php';

// Inicia as classes
$relatorios = new RelatoriosController();
$notificationModel = new NotificationModel();
$db = Database::getInstance()->getConnection();

echo "--- Geração de Insights IA (Otimizada por Grupo) ---" . PHP_EOL;

// 1. Busca todos os grupos ativos (removido o filtro 'status' conforme conversado)
$sqlGroups = "SELECT id, owner_id FROM `groups` ORDER BY id DESC";
$grupos = $db->query($sqlGroups)->fetchAll(PDO::FETCH_ASSOC);

if (empty($grupos)) {
    echo "⚠️ Nenhum grupo encontrado na tabela 'groups'." . PHP_EOL;
    exit;
}

echo "Total de grupos encontrados: " . count($grupos) . PHP_EOL;

foreach ($grupos as $grupo) {
    try {
        echo "Processando Grupo {$grupo['id']}... ";

        // 2. Busca todos os membros do grupo
        $stmt = $db->prepare("SELECT user_id FROM group_members WHERE group_id = ?");
        $stmt->execute([$grupo['id']]);
        $membros = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($membros)) {
            echo "⚠️ Grupo sem membros. Pulando." . PHP_EOL;
            continue;
        }

        // 3. Configura o contexto (Sessão simulada para a Controller)
        $_SESSION['current_group_id'] = $grupo['id'];
        $_SESSION['user_id'] = $grupo['owner_id'];

        // 4. Chama a IA (Uma vez por grupo para economizar tokens)
        $dicas = $relatorios->obterArrayDeDicasIA($grupo['id']);

        // Plano B: Backup caso a IA falhe ou não retorne 7 itens
        if (empty($dicas) || !is_array($dicas) || count($dicas) < 7) {
            echo "⚠️ IA incompleta. Usando Backup... ";
            $dicas = [
                "Planejar seus gastos hoje é garantir a tranquilidade de amanhã! 💡",
                "Dica: Revise suas assinaturas e veja o que você não usa mais. 💰",
                "O segredo da riqueza não é ganhar mais, é gastar com inteligência. 📊",
                "Já registrou suas comprinhas de hoje? O Amigo do Bolso está de olho! 📝",
                "Evite compras por impulso! Espere 24h para decidir se realmente precisa. 🛒",
                "Ter uma reserva de emergência é dormir com tranquilidade. ✨",
                "Organizar as contas hoje evita dores de cabeça amanhã! 🛡️"
            ];
        }

        // 5. Distribui as pílulas para cada membro
        foreach ($membros as $userId) {
            
            // ✅ CORREÇÃO: Limpa todos os agendamentos que ainda não foram enviados (sent = 0)
            // Isso impede que dicas antigas (inclusive as que você mudou para 'hoje') fiquem duplicadas
            $notificationModel->clearFutureInsights($userId);

            foreach ($dicas as $index => $texto) {
                // ✅ AJUSTE DE DATA:
                // Index 0 (Dia 1) -> Agendado para HOJE (+0 days)
                // Index 1 (Dia 2) -> Agendado para AMANHÃ (+1 day) ... e assim por diante.
                $dataAgendada = date('Y-m-d', strtotime("+" . ($index) . " days"));

                $textoLimpo = str_replace(['[', ']', '"', '*', 'DIA ' . ($index + 1) . ':'], '', trim($texto));

                // Salva na tabela scheduled_insights
                $notificationModel->scheduleInsight($userId, trim($textoLimpo), $dataAgendada);
            }
        }

        echo "✅ Sucesso! (" . count($membros) . " membros atualizados)" . PHP_EOL;

        // Limpa contexto
        unset($_SESSION['current_group_id'], $_SESSION['user_id']);

    } catch (Exception $e) {
        error_log("[CRON INSIGHTS] Erro no Grupo {$grupo['id']}: " . $e->getMessage());
        echo "❌ Erro: " . $e->getMessage() . PHP_EOL;
    }
}

echo "--- Processamento Finalizado: " . date('d/m/Y H:i:s') . " ---" . PHP_EOL;