<?php
########################################################################################################################################################
# Programa..> PA Recursivo consultando uma tabela em uma base de dados
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
# Criacao...> 2022-10-31
# Alteração.> 2022-10-31 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
########################################################################################################################################################
# o comando IF anterior pode ser trocado por um operador ternário na forma:
require("../fncs/catalogo.php");
require("./empresasfuncoes.php");
$bloco= ( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
$sair=$_REQUEST['sair']+1;

$entrada=$_REQUEST['sair'];

# Estabelecendo a conexão do PA com a Base de Dados
# Depois que acontece a conexão pode-se executar comandos de leitura nas tabelas da Base de Dados.
# Um Guia (resumo) de comandos SQL está disponível em:
# https://www.fatecourinhos.edu.br/disciplinas/ilp540/exercprojs/projeto2-php/exfnts/2022.2-Guia(curto)SQL.sql
# iniciando as tags da página
iniciapagina("empresas",TRUE,"Excluir","Excluir");
switch (TRUE)
{
  case ( $bloco==1 ):
  { 
    picklist("E");
    break;
  }
  case ( $bloco==2 ):
  {
    veregistro("$_REQUEST[idempresa]");
    # criando o form que fica 'em volta' da tabela que apresenta os dados para confirmação da exclusão.
    printf("<form action='empresasexcluir.php' method='POST'>\n");
    # Este form DEVE ter um campo 'oculto' que rece o valor 2 e nome 'bloco' para o PA poder ser recursivo.
    # Sendo assim...:
    printf("<input  type='hidden' name='bloco' value='3'>\n");
    printf("  <button class='botao' onclick='history.go(-1)'>Voltar</button>"); # <icog>&#x2397;</icog>
    printf("  <button class='botao' type='submit' name='btenvio' value='2'>Excluir</button>\n"); # <icog>&#x1f7ac;</icog>
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("</form>\n");

    printf("\n");
    break;
  }
  case ( $bloco==3 ):
  { # Tratamento da "TRANSAÇÃO" - Segmento de código de ATUALIZA a tabela no BD. (I,A,E)
    printf("Tratamento da Transação<br>");
    $cmdsql="DELETE FROM empresas WHERE idempresa='$_REQUEST[idempresa]'";
    # printf("$cmdsql\n"); # deixe este comando sem comentario para 'ver' o comando SQL em tmepo de execução.
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
      printf("Exclusão feita com sucesso!\n");
    }
    else
    {
      printf("Erro! $mens<br>\n");
    }
    # botoes($paravolta,$paramenu,$limpar,$acao)
    printf("<button class='nav' type='button' onclick='history.go(-$entrada)'>Entrada</button>\n");;
    break;
  }
}
# terminando as tags da página
terminapagina("Empresas","Exlcuir","empresasexcluir.php");
?>