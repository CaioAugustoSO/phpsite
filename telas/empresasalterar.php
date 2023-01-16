<?php
###############################################################################################################################################################
# Programa..> PA Altera um registro escolhido em uma tabela de um banco de dados
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
#             Um Guia (resumo) de comandos SQL está disponível em:
#             https://www.fatecourinhos.edu.br/disciplinas/ilp540/exercprojs/projeto2-php/exfnts/2022.2-Guia(curto)SQL.sql
# Criacao...> 2022-11-10
# Alteração.> 2022-11-10 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
###############################################################################################################################################################
# referenciando todos os arquivos de funções.
require("../fncs/catalogo.php");
require("./empresasfuncoes.php");

#
# Existem dois modos de referenciar arq. externos em PHP.
# include(caminho/arq) e require(caminho/arq).
# Usando o INCLUDE, SE o subprograma referenciado apresentar problema de execução o PA Principal retoma a execução
# Usando o REQUIRE, SE o subprograma referenciado apresentar problema de execução o PA é interrompido também.
#
# Verificando o bloco que será executado recursivamente
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$entrada=$_REQUEST['sair'];

# iniciando a emissão das TAGs que vão montar uma página HTML que vai 'retornar' ao servidor de página.
iniciapagina("empresas",TRUE,"aterar","Alterar");
switch (TRUE)
{
  case ( $bloco==1 ):
  { # Executando a função que monta a picklist dentro de um form.
    # O valor 'C' deve ser indicado para a função saber que tem que retornar para o <tab>consultar.php
    picklist('A');
    break;
  }
  case ( $bloco==2 ):
  { # Aqui vamos montar um form com os dados já preenchidos do registro que está sendo feita a alteração
    $cmdsql="SELECT * FROM empresas WHERE idempresa='$_REQUEST[idempresa]'";
    $reg=mysqli_fetch_array(mysqli_query($link,$cmdsql));
    # Cada campo do form deve receber um atributo que 'escrever' no campo um valor.
    # Este valor será o que está escrito no vetor $reg[] na posição correspondente ao nome do campo.
    printf("<form action='empresasalterar.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("<table>\n"); # A tabela medicos tem estes campos:
    printf(" <input type='hidden' name='idempresa' value='$_REQUEST[idempresa]'>");
    printf("<tr><td>Nome da empresa:</td><td><input type='text' name='txnomeusual' value='$reg[txnomeusual]' size='40' maxlength='200'></td></tr>\n");
    printf("<tr><td>Razão social:</td><td><input type='text' value='$reg[txrazaosocial]' name='txrazaosocial'></td></tr>\n"); # censo médico 2020 indica 502475 médicos no BR.
    printf("<tr><td>Setor de atuacao:</td><td>");
    # o campo a seguir terá indicado por uma picklist
    $cmdsql="SELECT idsetordeatuacao,txnomesetordeatuacao FROM setoresdeatuacao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='setordeatuacaoid'>\n");
    while ( $le=mysqli_fetch_array($execcmd) )
    { # este laço deve exibir a tag >option>...</option>
        $selected=($reg['setordeatuacaoid']==$le['idsetordeatuacao']) ? " selected" : "";
        printf("<option value='$le[idsetordeatuacao]'$selected>$le[txnomesetordeatuacao]-($le[idsetordeatuacao])</option>\n");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # montando a linha da tabela com a picklist para pegar o código da instituicoesdeensino onde o médico se formou
    printf("<tr><td>Local da empresa:</td><td>");
    # o campo a seguir terá indicado por uma picklist
    $cmdsql="SELECT idlogradouro, txnomelogradouro from logradouros";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='logradouroid'>\n");
    while ( $le=mysqli_fetch_array($execcmd) )
    { # este laço deve exibir a tag >option>...</option>
        $selected=($reg['logradouroid']==$le['idlogradouro']) ? " selected" : "";
        printf("<option value='$le[idlogradouro]'$selected>$le[txnomelogradouro]-($le[idlogradouro])</option>\n");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # montando a linha da tabela que separa os dados de logradouro de moradia do médico
    printf("<tr><td colspan='2'><hr></td></tr>\n");
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td>Complemento</td><td><input type='text' value='$reg[txcomplemento]' name='txcomplemento' size='40' maxlength='80'></td></tr>\n");
    printf("<tr><td>Cep empresa</td><td><input type='text' value='$reg[nucepempresa]' name='nucepempresa' size='8' maxlength='8'> (só números) </td></tr>\n");
    printf("<tr><td colspan='2'><hr></td></tr>\n");
    printf("<tr><td>Cadastrado:</td><td><input type='date' value='$reg[dtcadempresa]' name='dtcadempresa'></td></tr>\n");
    printf("<tr><td></td><td><button class='nav' type='reset'>Limpar</button>");
    printf("                 <button class='nav' onclick='history.go(-1)'>Voltar</button>");
  
    printf("                 <button class='nav' type='submit'>Alterar</button>");
    printf("<button class='nav' type='button' onclick='history.go(-$entrada)'>Entrada</button>\n");; # <icog>&#x2397;</icog>
    printf("             </td></tr>\n");
    printf("</table>\n");
    printf("</form>\n");
    break;
  }
  case ($bloco==3):
  { # Tratamento da TRANSAÇÃO
    printf("Tratamento da Transação<br>");
    $cmdsql="UPDATE empresas SET idempresa='$_REQUEST[idempresa]',
                                txnomeusual         = '$_REQUEST[txnomeusual]',
                                txrazaosocial        = '$_REQUEST[txrazaosocial]',
                                logradouroid                = '$_REQUEST[logradouroid]',
                                txcomplemento           = '$_REQUEST[txcomplemento]',
                                nucepempresa= '$_REQUEST[nucepempresa]',
                                setordeatuacaoid  = '$_REQUEST[setordeatuacaoid]',
                                dtcadempresa = '$_REQUEST[dtcadempresa]',
                                nucepempresa       = '$_REQUEST[nucepempresa]'
                                 WHERE idempresa='$_REQUEST[idempresa]'";
     #printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
    # No SGBD MariaDB uma transação é controlada com uso de arquivos de LOGS DE COMANDOS.
    # para o SEGBD 'usar' estes arquivos, ele precisa ser avisado que a transação vai começar e ser
    # INICIADA, CONCLUIDA ou CANCELADA
    $tentativa=TRUE;
    while ( $tentativa )
    {
      # Avisando o inicio:
      mysqli_query($link,"START TRANSACTION");
      mysqli_query($link,$cmdsql);
      # no php o texto do erro vem na função _error() e o numero do erro vem na função _errno()
      if ( mysqli_errno($link)==0 )
      { # SEM ERRO! SE NÃO deu ERRO ... então a transação deve ser CONCLUIDA (E não mais tentada).
        # Concluindo a transação
        mysqli_query($link,"COMMIT");
        # 'destentar' a transação
        $mostra=TRUE;
        $tentativa=FALSE;
      }
      else
      {
        $mostra=FALSE;
        if ( mysqli_errno($link)==1213 ) # Este é o numero do erro DEADLOCK
        { # Se deu erro na tentativa de executar o comando... e o erro for um DEADLOCK, então
          # deve-se cancelar a transação e a seguir reinicia-la.
          # CANCELANDO a transação
          mysqli_query($link,"ROLLBACK");
          # 'destentar' a transação
          $tentativa=TRUE;
        }
        else
        { # Se DEU erro e não foi DEADLOCK... a transação deve ser CANCELADA e NÃO dever ser reiniciada
          # CANCELANDO a transação
          $mens=mysqli_errno($link)." - ".mysqli_error($link);
          mysqli_query($link,"ROLLBACK");
          # 'destentar' a transação
          $tentativa=FALSE;
        }
      }
    }
    if ( $mostra )
    { # Transação acabou com sucesso
      printf("Alteração feita com sucesso!<br>\n");
      veregistro("$_REQUEST[idempresa]");
    }
    else
    {
      printf("Erro! $mens<br>\n");
    }
    printf("<button class='button' type='button' onclick='history.go(-2)'>Escolher</button>\n"); # <icog>&#x2397;</icog>
    printf("<button class='button' type='button' onclick='history.go(-3)'>Sair</button>\n"); # <icog>&#x2397;</icog>
    break;
  }
}
terminapagina("Médicos","Alterar","empresasalterar.php");
?>
