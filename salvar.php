<?php
//CONEXAO COM O BANCO 

include('conexaoPDO.php');

//VARIAVEIS 

$cpf = isset($_POST['cpf'])?$_POST['cpf']: "";
//Tire as tags HTML e PHP de uma string
//Retira espaço no início e final de uma string
//Substitua todas as ocorrências da sequência de pesquisa com a sequência de substituição
$cpfSemMascara = trim(strip_tags(str_replace("-", "",str_replace(".", "",$cpf))));
$datanasc = trim(strip_tags(isset($_POST['datanasc'])?$_POST['datanasc']: "")); 
$nome = trim(strip_tags(isset($_POST["nome"])?$_POST["nome"]: "")) ;
$funcao = trim(strip_tags(isset($_POST['funcao'])?$_POST['funcao']: "")); 
$endereco = trim(strip_tags(isset($_POST['endereco'])?$_POST['endereco']: "")); 
$cidade = trim(strip_tags(isset($_POST['cidade'])?$_POST['cidade']: ""));

// VALIDA CPF

function validaCPF($cpf = false) { 
    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}


//BUSCA USUÁRIOS COM O CPF INFORMADO 
$consulta_cpf = "SELECT * FROM usuario where cpf = '$cpfSemMascara' ";
$sql_query = $pdo->query($consulta_cpf) or die('Falha na execução do código SQL');

//
$erro = false;

//CALCULA A IDADE DO USUÁRIO
function calcularIdade($data){
    $idade = 0;
    //converte para o formato data
    $data_nascimento = date('Y-m-d', strtotime($data));
       //separa a string transformando em array
       $data = explode("-",$data_nascimento);
       $anoNasc    = $data[0];
       $mesNasc    = $data[1];
       $diaNasc    = $data[2];
    
       $anoAtual   = date("Y");
       $mesAtual   = date("m");
       $diaAtual   = date("d");
    
       $idade      = $anoAtual - $anoNasc;
       if ($mesAtual < $mesNasc){
           $idade -= 1;
       } elseif ( ($mesAtual == $mesNasc) && ($diaAtual <= $diaNasc) ){
           $idade -= 1;
       }
    
    return $idade;
}


//VERIFICAR CAMPOS EM BRANCO
if(empty($nome) || empty($funcao) || empty($cpfSemMascara) || empty($datanasc) || empty($endereco) || empty($cidade)){
    $erro = true;
}

//CPF 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!validaCPF($cpf)) {
        $erro = true;  
        $response['mensagem'] = 'Informe um CPF válido';
        $response['status'] =  http_response_code(412);
        echo json_encode($response);
        die(); 
    }elseif($sql_query->rowCount() > 0){
        $erro = true;  
        $response['mensagem'] = 'CPF já cadastrado';
        $response['status'] =  http_response_code(412);
        echo json_encode($response);
        die(); 
        }else{
            $cpfSemMascara = str_replace("-", "",str_replace(".", "",$cpf));
        }
}
// IDADE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(calcularIdade($datanasc) < 26){
        $erro = true;  
        $response['mensagem']  = 'Idade menor que 26 anos';
        $response['status'] =  http_response_code(412);
        echo json_encode($response);
        die(); 
        // exit();
     } else{  
       $datanasc = $_POST["datanasc"];  
   } 
}

//UPLOAD DO ARQUIVO



//UPLOAD DO ARQUIVO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_FILES['arquivo'])){
        $arquivo = $_FILES['arquivo'];
    
        $pasta = "arquivos/";
        $nomeArquivo = $arquivo['name'];
        $novoNomeArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

        if(strstr('.jpg;.png;.pdf', $extensao)){
            $path = $pasta . $novoNomeArquivo . '.' . $extensao;
            $deu_certo = move_uploaded_file($arquivo['tmp_name'],$path);
        }else{
            $erro = true;  
            $response['mensagem']  = 'Escolha um arquivo do tipo : PDF, JPG OU PNG';
            $response['status'] =  http_response_code(412);
            echo json_encode($response);
            die(); 
        }
    }
}

if(!$erro){
    validaCPF();
    if($deu_certo){
        $pdo->query("INSERT INTO usuario(nome,cpf,funcao,dataNascimento,endereco,cidade,path) VALUES ('$nome','$cpfSemMascara', '$funcao', '$datanasc','$endereco', '$cidade', '$path')") or die ($pdo->error);                
    echo "Usuário cadastrado com sucesso!";
    
}else{
    $erro = true;  
    $response['mensagem']  = 'Erro ao cadastrar usuário';
    $response['status'] =  http_response_code(412);
    echo json_encode($response);
    die(); 
}
}

    // $pdo->query("INSERT INTO usuario(nome,cpf,funcao,dataNascimento,endereco,cidade) VALUES ('$nome','$cpf', '$funcao', '$datanasc','$endereco', '$cidade')");
    // echo "<p>Usuário cadastrado com sucesso!<p>";
?>