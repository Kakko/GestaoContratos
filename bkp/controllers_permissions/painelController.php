<?php
class painelController extends Controller {

    public function index() {
        $data = array();
        $licitacoes = new Licitacoes();

        $data['info'] = $licitacoes->allLicPanel();
        $this->loadView('painel', $data);
    }
}