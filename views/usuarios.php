<div class="section_top">
    Área do Usuário
</div>
<div class="container">
    <form method="POST">
        <?php foreach($loggedUserInfo as $i): ?>
            <div class="user_area">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Nome:</label>
                        <input type="text" class="form-control form-control-sm" name="name" value="<?php echo $i['name']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>E-mail:</label>
                        <input type="email" class="form-control form-control-sm" name="email" value="<?php echo $i['email']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>Senha:</label>
                        <input type="password" class="form-control form-control-sm" name="password" value="<?php echo $i['password']; ?>">
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-sm-8">
                        <label for="endereco">Endereço:</label>
                        <input type="text" class="form-control form-control-sm" name="endereco" value="<?php echo $i['endereco']; ?>">
                    </div>
                    <div class="col-sm-4">
                        <label>Telefone:</label>
                        <input type="text" class="form-control form-control-sm" name="telefone" value="<?php echo $i['telefone']; ?>">
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-sm-12">
                        <label for="obs">Observações:</label>
                        <textarea class="form-control form-control-sm" name="obs" style="height: 180px; resize: none"><?php echo $i['obs']; ?></textarea>
                    </div>
                </div>
                <input type="submit" class="btn btn-success" value="Salvar">
            </div>
        <?php endforeach; ?>
    </form>
</div>