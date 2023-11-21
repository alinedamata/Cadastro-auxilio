<?php
//CONEXAO COM O BANCO 

include('conexaoPDO.php');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


    <title>Auxílio Ambieltal</title>
</head>
<body>
    

<div class="beneficios">

    <div class="img-beneficios">
        <img src="./assets/pandemia 1.svg" alt="" srcset="">
    </div>

    <div class="text">
        <h2>Auxílio Emergencial </h2>
        <p> Requisitos para envio dos Dados:</p>

        <ul>
            <li>Apenas um cadastro por pessoa.</li>
            <li>Está ciente de todos os requisitos solicitados no edital</li>

        </ul>

    </div>
</div>

<div class="inscricao">
    <div class="overlay-inscricao"></div>
    <p>Cadastre-se para  <br> receber o auxilio <br> emergencial</p>
    <a type="button" class="btn btn-primary" href="#planos">Fazer inscrição</a>
</div>

<div class="dados" id="planos">

    <h3>Formulário de Cadastro</h3>
    <span>Preencha seus dados</span>

    <div class="form">

        <div class="container">
            <form  method="post" class="formulario" id="form-create"  action="salvar.php" enctype="multipart/form-data">    
                    <label for="nome">NOME </label>
                    <input type="text" name="nome" placeholder="Digite seu nome completo" onkeypress="return ApenasLetras(event,this);"  class=" nome validar">
                  
                    <label for="">CPF</label>
                    <input type="text" id="cpf" name="cpf" class="cpf validar" id="campo_cpf" placeholder="Digite o seu CPF" 
                    minlength="14" 
                    maxlength="14"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                    

                    <label for="">FUNÇÃO </label>
                    <input type="text"  name="funcao"  placeholder="Informe o seu cargo" class = "funcao validar" >
              
                    <label for="">DATA DE NASCIMENTO </label>
                    <input type="date" name="datanasc" class="idade validar"  max="9999-12-31" >
                    
                    <label for="">ENDEREÇO </label>
                    <input type="text" name="endereco"  placeholder="Digite seu endereço"  class ="endereco validar" >


                    <label for="cidade">CIDADE</label>
                    <select name="cidade" id="cidade" class="cidade validar">
                        <option value="" disabled selected>Selecine o seu municipio</option>
                        <?php
                            $cid = $pdo->prepare("SELECT * FROM municipio ORDER BY nome_municipio ASC");
                            $cid->execute();
                        ?>
                        <?php foreach($cid as $cid){ ?>
                        <option value="<?php echo $cid['nome_municipio'] ?>"><?php echo $cid['nome_municipio'] ?></option>

                        <?php
                            }
                        ?>

                    </select>

                    <label >COMPROVANTE DE RESIDENCIA </label>
                    <input  class= "arquivo" type="file" name="arquivo" accept=".pdf,image/png,image/jpeg"  id="file_upload"   >

                    <!-- <button type="submit">Cadastrar</button> -->
                    <button type="submit" id="button" style="display: flex; align-items: center; justify-content: center">
                        <span style="margin-right: 8px">Cadastrar</span>
                        <div class="loader" hidden id="loader"></div>
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>



</body>
<script src='js/validacao.js'></script>
<!-- <script src='js/form.js'></script> -->
<script src='salvar.js'></script>
</html>