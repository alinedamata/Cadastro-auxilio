<?php 
// -------CONEXAO-------
try {
    $pdo = new PDO('mysql:host=localhost;dbname=usuarios', 'root','123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $erro) {
    echo 'erro ao conectar com o banco';
    // sweetAlert("Erro!", "Link inválido ou fora do prazo de validade.", "error");
}

?>