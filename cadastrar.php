<html>
<head>
<title>Cadastro de Usuários</title>

<style>

body{
    background-color:#0b1f3a;
    font-family:Arial, Helvetica, sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    margin:0;
}

.container{
    background:#13294b;
    padding:40px;
    border-radius:10px;
    width:320px;
    box-shadow:0 0 20px rgba(0,0,0,0.5);
    border:2px solid #c9a227;
}

h2{
    color:#c9a227;
    text-align:center;
    margin-bottom:25px;
}

label{
    color:white;
    font-size:14px;
}

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:20px;
    border:none;
    border-radius:5px;
    outline:none;
}

input:focus{
    border:2px solid #c9a227;
}

button{
    width:100%;
    padding:12px;
    background:#c9a227;
    border:none;
    border-radius:5px;
    color:#0b1f3a;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#e0b93d;
}

.mensagem{
    color:white;
    text-align:center;
    margin-top:15px;
}

</style>

</head>

<body>

<div class="container">

<h2>Cadastro</h2>

<form method="post" action="">

<label>E-mail, Telefone ou CPF:</label>
<input name="email_ou_telefone_ou_cpf" type="text">

<label>Senha:</label>
<input type="password" name="senha">

<button type="submit" name="inserir">Cadastrar</button>

</form>

<div class="mensagem">

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

    $sql = mysqli_query($conexao,
    "INSERT INTO emails (email_ou_telefone_ou_cpf, senha)
    VALUES ('$valor', '$senha_crip')");

    if($sql){
        echo "Cadastro realizado com sucesso!";
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

</div>

</div>

</body>
</html>