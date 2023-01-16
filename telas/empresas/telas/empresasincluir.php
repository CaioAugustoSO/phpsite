<?php
########################################################################################################################################################
# Programa..> PA Recursivo de coleta e inclusão de dados na tabela MEDICOS da base de dados
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
#             Um Guia (resumo) de comandos SQL está disponível em:
#             https://www.fatecourinhos.edu.br/disciplinas/ilp540/exercprojs/projeto2-php/exfnts/2022.2-Guia(curto)SQL.sql
# Criacao...> 2022-10-31
# Alteração.> 2022-10-31 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
########################################################################################################################################################
# referenciando todos os arquivos de funções.
require("../fncs/catalogo.php");
require("./empresasfuncoes.php");
# o comando IF anterior pode ser trocado por um operador ternário na forma:
$bloco= ( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
$sair=$_REQUEST['sair']+1;
$entrada=$_REQUEST['sair'];

# iniciando as tags da página
iniciapagina("empresas","Incluir","Incluir");
switch (TRUE)
{
  case ($bloco==1):
  { # Neste 'case' monta-se o formulário para inclusão
    printf("<form action='empresasincluir.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='2'>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("<table>\n"); # A tabela medicos tem estes campos:
    printf("<tr><td colspan=2>O campo do código da empresa terá valor preenchido pelo sistema e exibido no final da inclusão.</td></tr>\n");
    printf("<tr><td>Nome da empresa:</td><td><input type='text' name='txnomeusual' size='40' maxlength='200'></td></tr>\n");
    printf("<tr><td>Razão Social:</td><td><input type='text' name='txrazaosocial'></td></tr>\n"); # censo médico 2020 indica 502475 médicos no BR.
    printf("<tr><td>Setor de atuacao:</td><td>");
    # o campo a seguir terá indicado por uma picklist
    $cmdsql="SELECT idsetordeatuacao,txnomesetordeatuacao FROM setoresdeatuacao";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='setordeatuacaoid'>\n");
    while ( $le=mysqli_fetch_array($execcmd) )
    { # este laço deve exibir a tag >option>...</option>
      printf("<option value='$le[idsetordeatuacao]'>$le[txnomesetordeatuacao]-($le[idsetordeatuacao])</option>\n");
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
      printf("<option value='$le[idlogradouro]'>$le[txnomelogradouro]-($le[idlogradouro])</option>\n");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # montando a linha da tabela que separa os dados de logradouro de moradia do médico
    printf("<tr><td colspan='2'><hr></td></tr>\n");
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td>Complemento</td><td><input type='text' name='txcomplemento' size='40' maxlength='80'></td></tr>\n");
    printf("<tr><td>Cep empresa</td><td><input type='text' name='nucepempresa' size='8' maxlength='8'> (só números) </td></tr>\n");
    printf("<tr><td colspan='2'><hr></td></tr>\n");
    printf("<tr><td>Cadastrado:</td><td><input type='date' name='dtcadempresa'></td></tr>\n");
    printf("<tr><td></td><td><button onclick='history.go(-1)'>Voltar</button>
                             <button type='reset'>Limpar</button>
                             <button type='submit'>Incluir</button></td></tr>\n");
    printf("</table>\n");
    printf("</form>\n");
    break;
  }
  case ($bloco==2):
  { # Tratamento da Transação (incluir)
    #printf("Tratamento da Transação<br>");
    # No SGBD MariaDB uma transação é controlada com uso de arquivos de LOGS DE COMANDOS.
    # para o SEGBD 'usar' estes arquivos, ele precisa ser avisado que a transação vai começar e ser
    # INICIADA, CONCLUIDA ou CANCELADA
    $tentativa=TRUE;
    while ( $tentativa )
    {
      # Avisando o inicio:
      mysqli_query($link,"START TRANSACTION");
      $cmdsql="select max(idempresa)+1 as vmax from empresas";
      # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
      $execcmd=mysqli_query($link,$cmdsql);
      $valormax=mysqli_fetch_array($execcmd);
      $proxcp=($valormax['vmax'] == NULL ) ? 1 : $valormax['vmax'];
      # Montando o comando INSERT
      $cmdsql="INSERT INTO empresas (idempresa,
      txnomeusual,
      txrazaosocial,
      logradouroid,
      txcomplemento,
      nucepempresa,
      setordeatuacaoid,
      dtcadempresa)
                      VALUES ('$proxcp',
                              '$_REQUEST[txnomeusual]',
                              '$_REQUEST[txrazaosocial]',
                              '$_REQUEST[logradouroid]',
                              '$_REQUEST[txcomplemento]',
                              '$_REQUEST[nucepempresa]',
                              '$_REQUEST[setordeatuacaoid]',
                              '$_REQUEST[dtcadempresa]')";
      # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
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
      printf("Inclusão feita com sucesso!<br>\n");
      veregistro($proxcp);
    }
    else
    {
      printf("Erro! $mens<br>\n");
    }
    printf("<button class='nav' type='button' onclick='history.go(-$entrada)'>Entrada</button>\n"); # <icog>&#x2397;</icog>
    break;
  }
}
terminapagina("Empresas","Incluir","empresasincluir.php");
?>