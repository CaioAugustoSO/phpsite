<?php
########################################################################################################################################################
# Programa..> PA Recursivo consultando uma tabela em uma base de dados
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
# Criacao...> 2022-10-17
# Alteração.> 2022-10-20 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
########################################################################################################################################################
require("../fncs/catalogo.php");
require("./empresasfuncoes.php");
$sair = 1;

# o comando IF anterior pode ser trocado por um operador ternário na forma:
$bloco= ( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
$sair=$_REQUEST['sair']+1;
$entrada=$_REQUEST['sair'];

# Estabelecendo a conexão do PA com a Base de Dados
# Depois que acontece a conexão pode-se executar comandos de leitura nas tabelas da Base de Dados.
# Um Guia (resumo) de comandos SQL está disponível em:
# https://www.fatecourinhos.edu.br/disciplinas/ilp540/exercprojs/projeto2-php/exfnts/2022.2-Guia(curto)SQL.sql
# iniciando as tags da página
iniciapagina("empresas","consultar","Consultar");
switch (TRUE)
{
  case ( $bloco==1 ):
  {  
    picklist('C');
    break;
  }
  case ( $bloco==2 ):
  {    
    veregistro("$_REQUEST[idempresa]");
    printf("<button class='nav' type='button' onclick='history.go(-1)'>Voltar</button>\n"); # <icog>&#x2397;</icog>
    printf("<button class='nav' type='button' onclick='history.go(-$entrada)'>Entrada</button>\n"); # <icog>&#x2397;</icog>
    break;
  }
}
# terminando as tags da página
terminapagina("Empresas","Consultar","empresasconsulta.php");
?>