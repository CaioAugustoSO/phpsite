<?php
###############################################################################################################################################################
# Programa..> medicosincluir.php - PA Recursivo de coleta e inclusão de dados na tabela MEDICOS da base de dados
# Descrição.> Desenvolvimento de PA em PHP, usa a função ISSET() e comandos de desvio condicional IF{}ELSE{}, SWITCH{CASE(){}...}  e WHILE(){}.
#             Este PA monta um form para entrada de dados que serão gravados na tabela médicos. No segundo case desenvolve um tratamento de transação.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
#             Um Guia (resumo) de comandos SQL está disponível em:
#             https://www.fatecourinhos.edu.br/disciplinas/ilp540/exercprojs/projeto2-php/exfnts/2022.2-Guia(curto)SQL.sql
# Criacao...> 2022-10-31
# Alteração.> 2022-10-31 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
#             2022-11-12 - Ajustes no cabeçalho do PA
###############################################################################################################################################################
# referenciando todos os arquivos de funções.
require("../fncs/catalogo.php");
require("./empresasfuncoes.php");
# o comando IF anterior pode ser trocado por um operador ternário na forma:
$bloco= ( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
# A variável $sair é passada entre TODOS os forms para contabilizar os 'clicks' de avanço em uma
# funcionalidade e serve montar o botão de volta para entrada e o botão de sair do sistema.
$sair=$_REQUEST['sair']+1;
$entrada=$_REQUEST['sair'];
# $bloco for 3 e a ação for Listar a tela deve ser emitida em branco
iniciapagina("empresas","empresaslistar","Listar");
switch (TRUE)
{
  case ( $bloco==1 ):
  { # Monta um form permitindo a escolha da ordem de dados e valores para seleção de linhas da tabela referencia para emissão da listagem.
    printf(" <form action='./empresaslistar.php' method='post'>\n");
    printf("  <input type='hidden' name='bloco' value=2>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table>\n");
    printf("   <tr><td colspan=2>Escolha a <negrito>ordem</negrito> como os dados serão exibidos no relatório:</td></tr>\n");
    printf("   <tr><td>Código da empresa.:</td><td>(<input type='radio' name='ordem' value='idempresa'>)</td></tr>\n");
    printf("   <tr><td>Nome da empresa...:</td><td>(<input type='radio' name='ordem' value='txnomeusual' checked>)</td></tr>\n");
    printf("   <tr><td colspan=2>Escolha valores para selação de <negrito>dados</negrito> do relatório:</td></tr>\n");
    printf("   <tr><td>Escolha um setordeatuacao:</td><td>");
    $cmdsql="SELECT idsetordeatuacao,txnomesetordeatuacao from setoresdeatuacao order by txnomesetordeatuacao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='setordeatuacaoid'>");
    printf("<option value='TODAS'>Todas</option>");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[idsetordeatuacao]'>$reg[txnomesetordeatuacao]-($reg[idsetordeatuacao])</option>");
    }
    printf("<select>\n");
    printf("</td></tr>\n");
    $dtini="1901-01-01";
    $dtfim=date("Y-m-d");
    printf("<tr><td>Intervalo de datas de cadastro:</td><td><input type='date' name='dtcadini' value='$dtini'> até <input type='date' name='dtcadfim' value='$dtfim'></td></tr>");
    printf("   <tr><td></td><td>");
    printf("<button class='button' type='reset'>Limpar</button><button class='button' type='button' onclick='history.go(-1)'>Voltar</button><button class='button' type='submit'>Listar</button>\n");
    printf("</td></tr>\n");
    printf("  </table>\n");
    printf(" </form>\n");
    break;
  }
  case ( $bloco==2 || $bloco==3 ):
  { # Tendo os valores de ordem e dados para seleção, monta o comando SQL que pesquisa os dados na tabela referencia.
    # Processa a junção de medicos com instituicaoensino, logradouros (L1=moradia e L2=clinica) e especiaidadesmedicas.
    # Tendo os dados, formata a tabela de apresentação e para cada valor de $bloco monta um form.
    # Se $bloco==2 o form é recursivo e executa o form em nova aba do navegador para o bloco 3.
    # Se $bloco==3 o PA executa a chamada da função de impressão do Navegador/Windows
    # Depois monta a tabela com os dados e a seguir um form permitindo que a listagem seja exibida para impressão em uma nova aba.
    $selecao=" WHERE (M.dtcadempresa between '$_REQUEST[dtcadini]' and '$_REQUEST[dtcadfim]')";
    $selecao=( $_REQUEST['setordeatuacaoid']!='TODAS' ) ? $selecao." AND M.setordeatuacaoid='$_REQUEST[setordeatuacaoid]'" : $selecao ;
    $cmdsql="SELECT M.*, I.txnomesetordeatuacao,L1.txnomelogradouro 
    AS txnomelogradouro FROM empresas AS M LEFT JOIN setoresdeatuacao AS I ON M.setordeatuacaoid = I.idsetordeatuacao LEFT JOIN logradouros AS L1 ON M.logradouroid = L1.idlogradouro ".$selecao." ORDER BY $_REQUEST[ordem]";
    # Se form preciso conferir o comando anterior (SQL) retire o comentário da linha seguinte, grave o arquivo e exeute novamente a funcionalidade LISTAR
    # printf("<hr>$cmdsql<hr>\n"); # As tags <hr> aparecem para melhorar a visualização do comando na tela.
    $execsql=mysqli_query($link,$cmdsql);
    # SE o bloco de execução for 2, então o menu DEVE aparecer no topo da tela.
    # ($bloco==2) ? montamenu("Listar","$sair") : "";
    printf("<br>\n");
    printf("<table border=1 style=' border-collapse: collapse; '>\n");
    # As duas próximas linhas da tabela montam o 'cabeçalho' da listagem.
    printf(" <tr bgcolor='lightblue'><td valign=top rowspan=2>Cod.</td>\n");
    printf("     <td valign=top rowspan=2>Nome:</td>\n");
    printf("     <td valign=top rowspan=2>CRM</td>\n");
    printf("     <td valign=top rowspan=2>Especialidade</td>\n");
    printf("     <td valign=top colspan=4>Moradia</td>\n");
    printf(" <tr bgcolor='lightblue'><td valign=top>Logr.</td>\n");
    printf("     <td valign=top>Complemento</td>\n");
    printf("     <td valign=top>CEP</td>\n");
    printf("     <td valign=top>Dt. Cad.</td>\n");
	  $corlinha="White";
    while ( $le=mysqli_fetch_array($execsql) )
    {
      printf("<tr bgcolor=$corlinha><td>$le[idempresa]</td>\n");
      printf("   <td valign=top>$le[txnomeusual]</td>\n");
      printf("   <td valign=top>$le[txrazaosocial]</td>\n");
      printf("   <td valign=top>$le[txnomesetordeatuacao]-($le[setordeatuacaoid])</td>\n");
      printf("   <td valign=top>$le[txnomelogradouro]-($le[logradouroid])</td>\n");
      printf("   <td valign=top>$le[txcomplemento]</td>\n");
      printf("   <td valign=top>$le[nucepempresa]</td>\n");
      printf("   <td valign=top>$le[dtcadempresa]</td></tr>\n");
      $corlinha=( $corlinha=="White" ) ? "Navajowhite" : "White";
    }
    printf("</table>\n");
    if ( $bloco==2 )
    {
      # montagem do form apresentado no final do BLOCO 2 deve-se 'passar para o BLOCO 3' todos os parâmetros que foram usados na montagem da listagem.
      printf("<form action='./empresaslistar.php' method='POST' target='_NEW'>\n");
      printf(" <input type='hidden' name='bloco' value=3>\n");
      printf(" <input type='hidden' name='sair' value='$sair'>\n");
      # Aqui estão os parâmentros usados na formatação da Listagem
      # DEVEM SER repassados em modo oculto para o processamento do bloco 3 (IMPRIMIR)
      printf(" <input type='hidden' name='setordeatuacaoid' value=$_REQUEST[setordeatuacaoid]>\n");
      printf(" <input type='hidden' name='dtcadini' value=$_REQUEST[dtcadini]>\n");
      printf(" <input type='hidden' name='dtcadfim' value=$_REQUEST[dtcadfim]>\n");
      printf(" <input type='hidden' name='ordem' value=$_REQUEST[ordem]>\n");
      # botoes($paravolta,$paramenu,$limpar,$acao)
      printf("<button type='button' onclick='history.go(-1)'>Voltar</button>\n");
      printf("<button type='button' onclick='history.go(-$entrada)'>Entrada</button>\n");
      printf("<button type='submit'>Imprimir</button></td></tr>\n");
      printf("</form>\n");
    }
    else
    {
      printf("<hr>\n<button type='submit' onclick='window.print();'>Imprimir</button> - Corte a folha na linha acima.\n");
    }
    break;
  }
}
terminapagina("Médicos","Listar","empresaslistar.php");

?>