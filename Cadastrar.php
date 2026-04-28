<html>
    <head>
        <title>Cadastro</title>
    </head>
        <style>
            body{
                background-color: #0a1f44; /* azul marinho */
                font-family: "Times New Roman", Times, serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                flex-direction: column;
            }

            h2{
                color: #d4af37; /* dourado */
                text-align: center;
                margin-bottom: 20px;
            }

            form{
                background-color: #112b5c;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.5);
                display: flex;
                flex-direction: column;
                width: 300px;
            }

            label{
                color: #d4af37;
                margin-top: 10px;
            }

            input{
                padding: 10px;
                margin-top: 5px;
                border: 1px solid #d4af37;
                border-radius: 5px;
                outline: none;
                background-color: #f5f5f5;
            }

            input:focus{
                border-color: gold;
            }

            button{
                margin-top: 20px;
                padding: 10px;
                background-color: #d4af37;
                color: #0a1f44;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }

            button:hover{
                background-color: #c19b2e;
            }
        </style>
    <body>
        <h2>CADASTRO DE USUÁRIOS</h2>

    <form method="post" action="">
        <label>E-mail, Telefone ou CPF:</label>
        <input name="email_ou_telefone_ou_cpf" type="text">
        <label>Senha:</label>
        <input type="password" name="senha">
        <button type="submit" name="inserir">CADASTRAR</button>
    </form>

<?php

    include "conexao.php";

    function validarCPF($cpf){

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if(strlen($cpf) != 11) return false;
        if(preg_match('/(\d)\1{10}/', $cpf)) return false;
        for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for ($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }
        $digito = ((10 * $soma) % 11) % 10;
        if ($cpf[$t] != $digito) {
            return false;
        }
        }
        return true;
    }

    if(isset($_POST['inserir'])):

    $emailtelcpf = $_POST['email_ou_telefone_ou_cpf'];
    $senha = $_POST['senha'];

    $senhavalida = preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha);
    $emailvalido = filter_var($emailtelcpf, FILTER_VALIDATE_EMAIL);
    $somenteNumeros = preg_replace('/[^0-9]/', '', $emailtelcpf);
    $cpfvalido = validarCPF($somenteNumeros);
    $telefonevalido = (strlen($somenteNumeros) >= 10 && strlen($somenteNumeros) <= 11);

    if(($emailvalido || $telefonevalido || $cpfvalido) && $senhavalida){

    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);

    if($cpfvalido){
        $valor = password_hash($somenteNumeros, PASSWORD_DEFAULT);
    }
    else{
        $valor = $emailtelcpf;
    }

    $sql = mysqli_query($conexao,"INSERT INTO usuarios (email_ou_telefone_ou_cpf, senha)VALUES ('$valor', '$senha_crip')");

    if($sql){
        echo "Cadastro realizado com sucesso!";
        header("Location:Login.php");
    }
    else{
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
    }

    else{

        if(!$senhavalida){
            echo "A senha deve ter no mínimo 8 caracteres, letra maiúscula, minúscula, número e símbolo.";
        }
        else{
            echo "E-mail, telefone ou CPF inválido!";
        }
    }
    endif;
?>
    </body>
</html>