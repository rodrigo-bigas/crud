<?php
    //TESTA A CONEXÃO   
    require('db/conexao.php'); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        h1{
            text-align: center;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        th, td{
            padding:10px;
            text-align: center;
            border: 1px solid #ccc;
        }
        .oculto{
            display: none;
        }
    </style>
</head>
<body>
    <h1>Cadastro de Clientes</h1>
    <form id="form-salva" method="post">
        <label>Nome:</label>
        <input type="text" name="nome" placeholder="Digite seu nome" required><br><br>
        <label>Endereço:</label>
        <input type="text" name="endereco" placeholder="Digite seu endereço" required><br><br>
        <label>Cidade:</label>
        <input type="text" name="cidade" placeholder="Digite sua cidade" required><br><br>
        <label>Estado:</label>
        <input type="text" name="estado" placeholder="Digite seu estado" required><br><br>
        <label>E-mail:</label>
        <input type="email" name="email" placeholder="Digite seu email" required><br><br>
        <label>Telefone:</label>
        <input type="text" name="fone" placeholder="Digite seu telefone" required><br><br>
        <button type="submit" name="salvar">Salvar</button>
    </form><br>
    <!-- FORMULÁRIO PARA ATUALIZAÇÃO -->
    <form class="oculto" id="form-atualiza" method="post">
        <input type="hidden" id="id-editado" name="id-editado" placeholder="ID" required><br><br>
        <input type="text" id="nome-editado" name="nome-editado" placeholder="Editar nome" required><br><br>
        <input type="text" id="endereco-editado" name="endereco-editado" placeholder="Editar endereço" required><br><br>
        <input type="text" id="cidade-editado" name="cidade-editado" placeholder="Editar cidade" required><br><br>
        <input type="text" id="estado-editado" name="estado-editado" placeholder="Editar estado" required><br><br>
        <input type="email" id="email-editado" name="email-editado" placeholder="Editar email" required><br><br>
        <input type="text" id="fone-editado" name="fone-editado" placeholder="Editar telefone" required><br><br>
        <button type="submit" name="atualizar">Atualizar</button>
        <button type="button" id="cancelar" name="cancelar">Cancelar</button>
    </form><br>
    <!-- FORMULÁRIO PARA DELETAR -->
    <form class="oculto" id="form-deleta" method="post">
        <input type="hidden" id="id-deleta" name="id-deleta"><br><br>
        <input type="hidden" id="nome-deleta" name="nome-deleta"><br><br>
        <input type="hidden" id="endereco-deleta" name="endereco-deleta"><br><br>
        <input type="hidden" id="cidade-deleta" name="cidade-deleta"><br><br>
        <input type="hidden" id="estado-deleta" name="estado-deleta"><br><br>
        <input type="hidden" id="email-deleta" name="email-deleta"><br><br>
        <input type="hidden" id="fone-deleta" name="fone-deleta"><br><br>
        <b>Tem certeza que quer deletar usuário cliente <span id="cliente"></span>?</b>
        <button type="submit" name="deletar">Confirmar</button>
        <button type="button" id="cancelar-deleta" name="cancelar-deleta">Cancelar</button>
    </form><br>
    <?php
        //VALIDAÇÃO DE ENTRADA DE DADOS
        if(isset($_POST['salvar']) && isset($_POST['nome']) && isset($_POST['endereco'])
        && isset($_POST['cidade']) && isset($_POST['estado']) && isset($_POST['email'])
        && isset($_POST['fone'])){
            $nome = limparPost($_POST['nome']);
            $endereco = limparPost($_POST['endereco']);
            $cidade = limparPost($_POST['cidade']);
            $estado = limparPost($_POST['estado']);
            $email = limparPost($_POST['email']);
            $fone = limparPost($_POST['fone']);
            $data = date('d-m-Y');
    
            //VALIDAÇÃO DE CAMPO VAZIO
            if($nome == "" || $nome == null){
                echo "<b style='color:red'>Nome não pode ser vazio</b>";
                //SAI DO SISTEMA
                exit();
            }
            if($email == "" || $email == null){
                echo "<b style='color:red'>E-mail não pode ser vazio</b>";
                exit();
            }
    
            //VERIFICA SE O NOME ESTÁ CORRETO
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
                echo "<b style='color:red'>Somente permitidos letras e espaços em branco para o nome</b>";
                exit();
            }
        //INSERE OS DADOS NO BANCO
        $sql = $pdo->prepare("INSERT INTO clientes VALUES(null, ?,?,?,?,?,?,?)");
        //EXECUTA A INSERÇÃO
        $sql -> execute(array($nome, $endereco, $cidade, $estado, $email, $fone, $data));
        echo "<p style='color:green;text-align: center;'><b>Cliente inserido com sucesso!</b></p>";
        }
    ?>

    <?php
        //PROCESSO DE ATUALIZAÇÃO
        if(isset($_POST['atualizar']) && isset($_POST['id-editado']) 
        && isset($_POST['nome-editado']) && isset($_POST['endereco-editado']) 
        && isset($_POST['cidade-editado']) && isset($_POST['estado-editado']) 
        && isset($_POST['email-editado']) && isset($_POST['fone-editado'])){

            $id = limparPost($_POST['id-editado']);
            $nome = limparPost($_POST['nome-editado']);
            $endereco = limparPost($_POST['endereco-editado']);
            $cidade = limparPost($_POST['cidade-editado']);
            $estado = limparPost($_POST['estado-editado']);
            $email = limparPost($_POST['email-editado']);
            $fone = limparPost($_POST['fone-editado']);

        //COMANDO PARA ATUALIZAR OS DADOS DA TABELA
        $sql = $pdo->prepare("UPDATE clientes SET nome=?, endereco=?, cidade=?, estado=?, email=?, fone=? WHERE id=?");
        $sql -> execute(array($nome, $endereco, $cidade, $estado, $email, $fone, $id ));

        //ATUALIZADO TANTOS REGISTROS
        echo "<p style='color:green;text-align: center;'><b>Atualizado com sucesso!</b></p>";
        }
    ?>
        
    <?php
        //PROCESSO PARA DELETAR
        if(isset($_POST['deletar']) && isset($_POST['id-deleta']) 
        && isset($_POST['nome-deleta']) && isset($_POST['endereco-deleta']) 
        && isset($_POST['cidade-deleta']) && isset($_POST['estado-deleta']) 
        && isset($_POST['email-deleta']) && isset($_POST['fone-deleta']) ){

            $id = limparPost($_POST['id-deleta']);
            $nome = limparPost($_POST['nome-deleta']);
            $endereco = limparPost($_POST['endereco-deleta']);
            $cidade = limparPost($_POST['cidade-deleta']);
            $estado = limparPost($_POST['estado-deleta']);
            $email = limparPost($_POST['email-deleta']); 
            $fone = limparPost($_POST['fone-deleta']);  

        //COMANDO PARA DELETAR
        $sql = $pdo->prepare("DELETE FROM clientes WHERE id=? AND nome=? AND endereco=? 
        AND cidade=? AND estado=? AND email=? AND fone=?");
        $sql -> execute(array($id, $nome, $endereco, $cidade, $estado, $email, $fone));

        echo "<p style='color:green;text-align: center;'><b>Deletado com sucesso!</b></p>";
        }
    ?>

    <?php
      //SELECIONAR DADOS DA TABELA
      $sql = $pdo->prepare("SELECT * FROM clientes");
      $sql -> execute();
      //PEGA OS DADOS DA TABELA E ARMAZENA EM UM ARRAY
      $dados = $sql->fetchALL();
    ?>
    <?php
        //SE TIVER REGISTRO NO BANCO, CRIA A TABELA
        if(count($dados) > 0){
            echo " <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Endereco</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>E-mail</th>
            <th>Fone</th>
            <!-- CABEÇALHO DO LINK ATUALIZAR -->
            <th>Ações</th>
        </tr>";
        
        //ACRESCENTA OS DADOS NA TABELA
        foreach($dados as $chave => $valor){
            echo "<tr>
                    <td>".$valor['id']."</td>
                    <td>".$valor['nome']."</td>
                    <td>".$valor['endereco']."</td>
                    <td>".$valor['cidade']."</td>
                    <td>".$valor['estado']."</td>
                    <td>".$valor['email']."</td>
                    <td>".$valor['fone']."</td>
                    <!-- ATRIBUINDO OS DADOS PARA O LINK ATUALIZAR -->
                    <td><a href='#' class='btn-atualizar' data-id='".$valor['id']."' 
                    data-nome='".$valor['nome']."' data-endereco='".$valor['endereco']."' 
                    data-cidade='".$valor['cidade']."' data-estado='".$valor['estado']."' 
                    data-email='".$valor['email']."' data-fone='".$valor['fone']."' >Atualizar</a> | 
                    <a href='#' class='btn-deletar' data-id='".$valor['id']."' 
                    data-nome='".$valor['nome']."' data-endereco='".$valor['endereco']."' 
                    data-cidade='".$valor['cidade']."' data-estado='".$valor['estado']."' 
                    data-email='".$valor['email']."' data-fone='".$valor['fone']."' >Deletar</a></td>
                </tr>";
        }
        echo "</table>"; 

        }else{
            echo "<p>Nenhum cliente cadastrado!</p>";
        }
    ?>
    
    <!-- REFERENCIA A BIBLIOTECA JQUERY  -->
    <script src="js/jquery-3.6.4.js"></script>
    <!-- QUANDO CLICAR NO LINK ATUALIZAR -->
    <script>
        // CHAMA A CLASSE btn-atualizar COM O MÉTODO CLICK DO MOUSE
        $(".btn-atualizar").click(function(){
            // PEGANDO O VALOR DO LINK QUE FOI CLICADO E ARMAZENA NAS VARIÁVEIS
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var endereco = $(this).attr('data-endereco');
            var cidade = $(this).attr('data-cidade');
            var estado = $(this).attr('data-estado');
            var email = $(this).attr('data-email');
            var fone = $(this).attr('data-fone');
  
            $('#form-atualiza').removeClass('oculto');
            $('#form-deleta').addClass('oculto');
            $('#form-salva').addClass('oculto');

            // ATRIBUINDO OS VALORES AS VARIÁVEIS E MOSTRANDO NOS CAMPOS
            $("#id-editado").val(id);
            $("#nome-editado").val(nome);
            $("#endereco-editado").val(endereco);
            $("#cidade-editado").val(cidade);
            $("#estado-editado").val(estado);
            $("#email-editado").val(email);
            $("#fone-editado").val(fone);
        });

        $(".btn-deletar").click(function(){
            // PEGANDO O VALOR DO LINK QUE FOI CLICADO E ARMAZENA NAS VARIÁVEIS
            var id = $(this).attr('data-id');
            var nome = $(this).attr('data-nome');
            var endereco = $(this).attr('data-endereco');
            var cidade = $(this).attr('data-cidade');
            var estado = $(this).attr('data-estado');
            var email = $(this).attr('data-email');
            var fone = $(this).attr('data-fone');

            $('#form-atualiza').addClass('oculto');
            $('#form-salva').addClass('oculto');
            $('#form-deleta').removeClass('oculto');

            $("#id-deleta").val(id);
            $("#nome-deleta").val(nome);
            $("#endereco-deleta").val(endereco);
            $("#cidade-deleta").val(cidade);
            $("#estado-deleta").val(estado);
            $("#email-deleta").val(email);
            $("#fone-deleta").val(fone);
            $("#cliente").html(nome);
        });

        $('#cancelar').click(function(){
            $('#form-atualiza').addClass('oculto');
            $('#form-salva').removeClass('oculto');
            $('#form-deleta').addClass('oculto');
        });

        $('#cancelar-deleta').click(function(){
            $('#form-atualiza').addClass('oculto');
            $('#form-salva').removeClass('oculto');
            $('#form-deleta').addClass('oculto');
        });
    </script>
</body>
</html>