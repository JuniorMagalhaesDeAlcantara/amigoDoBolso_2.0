<?php

class CategoriasController extends Controller {
    private $categoryModel;
    
    public function __construct() {
        $this->requireLogin();
        $this->categoryModel = new CategoryModel();
    }
    
    public function criar() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
            $icon = filter_input(INPUT_POST, 'icon', FILTER_SANITIZE_STRING) ?: 'default';
            $color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING) ?: '#6c757d';
            
            $this->categoryModel->createCategory($groupId, $name, $type, $icon, $color);
            
            // Retorna JSON se for requisição AJAX
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->json(['success' => true, 'message' => 'Categoria criada!']);
            } else {
                $this->redirect('/transacoes/criar');
            }
        } else {
            $this->view('categorias/criar');
        }
    }
}
