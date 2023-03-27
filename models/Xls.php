<?php class Xls extends Model {


    private $db_host;
    private $db_port;
    private $db_name;
    private $db_user;
    private $db_pass;

    public function conex_stur($empresa){
        $sql = $this->db->prepare("SELECT db_name, db_host, db_port, db_user, db_pass FROM cad_empresas WHERE name = :empresa");
        $sql->bindValue(":empresa", $empresa);
        $sql->execute();

        if($sql->rowCount() > 0){
            $dados_empresa = $sql->fetch(PDO::FETCH_ASSOC);

        }

        $this->db_host = $dados_empresa['db_host'];
        $this->db_port = $dados_empresa['db_port'];
        $this->db_name = $dados_empresa['db_name'];
        $this->db_user = $dados_empresa['db_user'];
        $this->db_pass = $dados_empresa['db_pass'];
    }

    public function rel_status($empresa, $codtipo, $situacao) {
        $data = array();

        $this->conex_stur($empresa);
        $stur = $this->conexao_stur($this->db_name, $this->db_host, $this->db_user, $this->db_pass);

        $sql = $stur->prepare("SELECT CODCLI, NOMCLI, CGCCPF, ECLIENTE.CODTIPO, SITUACAO, DESCRTIPO FROM ECLIENTE LEFT JOIN ETIPOCLI ON (ECLIENTE.CODTIPO = ETIPOCLI.CODTIPO) WHERE situacao = :situacao AND codtipo = :codtipo");
        $sql->bindValue(":situacao", $situacao);
        $sql->bindValue(":codtipo", $codtipo);
        $sql->execute();

        $data = $sql->fetchAll(PDO::FETCH_ASSOC);

        print_r($codtipo);
        exit;

            ob_start(); ?>
            <table class="table table-striped table-hover table-sm" id="table_dados_cliente">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Nome do Cliente</th>
                        <th>CNPJ / CPF</th>
                        <th>Tipo</th>
                        <th>Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $dado): ?>
                        <tr>
                            <td><?php echo $dado['CODCLI']; ?></td>
                            <td><?php echo utf8_encode($dado['NOMCLI']); ?></td>
                            <td><?php echo $dado['CGCCPF']; ?></td>
                            <td><?php echo $dado['DESCRTIPO']; ?></td>
                            <td><?php if($dado['SITUACAO'] == 'T'){
                                    echo 'Ativo';
                                } else {
                                    echo 'Inativo';
                                }; ?> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
            $rel_status = ob_get_contents();
            ob_end_clean();

        return $rel_status;
    }
}