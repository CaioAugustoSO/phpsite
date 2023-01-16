<?php
#####################################################################################################################################################
# Programa..> PA Catalogo de funções
# Descrição.> Repositório de funções desenvolvidas para os sistemas de gerenciamento de dados das tabelas da base de dados MariaDB
#             dos alunos da disciplina ILP540-T de 2022.2 da FATEC  de Ourinhos
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
# Criacao...> 2022-11-03
# Alteração.> 2022-11-03 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.-
#####################################################################################################################################################
function conectamariadb($servidor,$usuario,$senha,$base)
{ # Recebe....> $servidor - Nome do Servidor de dados
  #             $usuario - Nome do usuário do servidor
  #             $senha - senha de acesso do usuário no servidor (ou na base de dados do servidor)
  #             $base - Nome da base de dados onde atua o usuário
  # Descrição.> Globaliza uma variavel que recebe o número da conexão determinada pelo SGBD
  # A variável que recebe o número da conexão deve ser uma variável GLOBAL.
  global $link;
  # Estabelecendo a conexão com BD
  $link=mysqli_connect($servidor,$usuario,$senha,$base); # esta função retorna o número de conexão.
}
function iniciapagina($tabela,$fundo,$titulo,$acao)
{ # Recebe....> $tabela - Nome da Tabela com dados gerenciados pelo PA que aciona a função.
  #             $titulo - Título da página que será exibida na TAG <title>...</titlte>
  # Descrição.> Emite as TAGs iniciais de uma página HTML com os valores recebidos na 'chamada' da função.
  global $sair;
  printf("<html>\n");
  printf(" <head>\n");
  printf("  <title>$titulo</title>\n");
  printf("<link rel='stylesheet' type='text/css' href='./$tabela.css'>\n");
  printf(" </head>\n");
  printf($fundo ? " <body class='$acao'>\n" : " <body>\n");
  global $bloco;
  $corpodapagina=( $acao!="Listar" or $bloco<3 ) ? "<body class='$acao'>" : "<body class='Imprimir'>" ;
  printf(" $corpodapagina\n");
  if ( $acao!="Listar" or $bloco<3 )
  { # a variável $bloco deve ser globalizada e comparada com '3'.
    printf("  <div class='$acao'>\n");
    printf("   <div class='menu'>\n");
    printf("    <form action='' method='POST'>\n");
    printf("     <input type='hidden' name='sair' value='$sair'>\n");
    printf("     <bold>Empresas</bold>:\n");
    printf("     <button class='ins' type='submit' formaction='./".$tabela."incluir.php'  >Incluir</button>\n"); # <icom>&#x1f7a5;</icom>
    printf("     <button class='alt' type='submit' formaction='./".$tabela."alterar.php'  >Alterar</button>\n"); # <icom>&#x1f589;</icom>
    printf("     <button class='exc' type='submit' formaction='./".$tabela."excluir.php'  >Excluir</button>\n"); # <icom>&#x1f7ac;</icom>
    printf("     <button class='con' type='submit' formaction='./".$tabela."consultar.php'>Consultar</button>\n"); # <icom>&#x1f50d;&#xfe0e;</icom>
    printf("     <button class='lst' type='submit' formaction='./".$tabela."listar.php'   >Listar</button>\n"); # <icom>&#x1f5a8;</icom>
    printf("     <button class='nav' type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # <icom>&#x2348;</icom>
    printf("    </form>\n");
    printf("   </div>\n");
    printf("   <bold>$acao</bold><hr>\n");
    printf("  </div>\n<br><br><br>\n");
  }
}
function terminapagina($tabela,$acao,$arqprg)
{ # Recebe....> $tabela - Nome da Tabela com dados gerenciados pelo PA que 'aciona' a função
  #             $acao - Ação executada peloa PA
  #             $arqprg - Nome do Arquivo onde o PA está escrito
  # Descrição.> Emite as TAGs de finalização da página com os valores recebidos na chamada da função.
  # terminando a página 'HTML'
  printf("<hr>$tabela - $acao - &copy; FATEC 4&ordm; ADS 2022.2 - $arqprg\n");
  printf("</body>\n</html>");
}
####################
# Execução da função com os valores passados no PA-catalogo.php... Portanto... no PA principal NÃO PRECISAMOS FAZER A CONEXÃO
conectamariadb("localhost","root","","ilp540");
?>
