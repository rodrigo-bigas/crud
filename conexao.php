<?php
//CONFIGURAÇÕES GERAIS
$servidor="localhost";
$usuario="root";
$senha="";
$banco="primeiro_banco";

//CONEXÃO
$pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario, $senha);

//FUNÇÃO PARA LIMPAR ENTRADAS
function limparPost($dado){
    //A função trim() é usada para remover quaisquer espaços em branco no início 
    //e no final da string.
    $dado = trim($dado);
    //A função stripslashes() é usada para remover as barras invertidas 
    //adicionadas a caracteres especiais em uma string.
    $dado = stripslashes($dado);
    //A função htmlspecialchars() é usada para converter caracteres especiais 
    //em entidades HTML.
    $dado = htmlspecialchars($dado);
    return $dado;
}
?>