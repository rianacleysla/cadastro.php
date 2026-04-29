<html>
	<head>
		<title>Login</title>
	</head>
        <style>
			body{
				background-color: #0a1f44;
				font-family: "Times New Roman", Times, serif;
				margin: 0;
				padding: 0;
				display: flex;
				justify-content: center;
				align-items: center;
				height: 100vh;
				flex-direction: column;
			}

			h1{
				color: #d4af37;
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

			table{
				width: 100%;
			}

			td{
				color: #d4af37;
				padding-top: 10px;
			}

			input{
				width: 100%;
				padding: 10px;
				margin-top: 5px;
				border: 1px solid #d4af37;
				border-radius: 5px;
				outline:invert;
				background-color: #f5f5f5;
			}

			input:focus{
				border-color: gold;
			}

			button{
				margin-top: 15px;
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

			.botoes{
				display: flex;
				gap: 10px;
				margin-top: 15px;
			}

			.botoes button{
				flex: 1;
			}
		</style>
	<body>
		<h1>LOGIN DO USUÁRIO</h1>
		<form method="post" action="">
		<table>
			<tr>
				<td>Usuário:</td>
				<td><input name="usuario" size="15" type="text" autocomplete="off"></td>
			</tr>
			<tr>
				<td>Senha:</td>
				<td><input name="senha" size="15" type="password" autocomplete="off"></td>
			</tr>
		</table>
		<br>
		<button type="submit" name="Confirmar" >LOGIN</button>
		<button type="submit" name="Voltar" >CADASTRO</button>
		</form>
	</body>
</html>

<?php

    if (isset($_POST['Confirmar'])):

    include "conexao.php";

    $senha=filter_input(INPUT_POST,'senha', FILTER_DEFAULT);

    $usuario=filter_input(INPUT_POST,'usuario', FILTER_DEFAULT);
    
    $sql=mysqli_query($conexao, "SELECT * FROM usuarios WHERE email_ou_telefone_ou_cpf = '$usuario' LIMIT 1");
    
    $status=0;

    while($l=mysqli_fetch_array($sql))
    {
        $senha_crip=$l['senha'];

        if(password_verify($senha, $senha_crip))
        {
            header("location:Cadastrar.php");
        } else{
            echo "<span style='color:red;'>Você não tem permissão para o cadastro!</span>";
        }
    }


    endif;
    
    if (isset($_POST['Voltar'])):
    
    header("Location:Cadastrar.php");

    endif;

?>