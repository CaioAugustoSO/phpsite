<?php
########################################################################################################################################################
# Programa..> PA Consulta em uma tabela de um banco de dados
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
# Criacao...> 2022-10-20
# Alteração.> 2022-10-20 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
########################################################################################################################################################
function picklist($acao)
{ # Argumentos: $acao - recebe uma letra para indicar qual funcionalidade está executando a função
  #                     pode receber os valores 'C', 'E', 'A'.
  # Globalizando a variável usada para guardar o número da conexão
  global $link;
  global $sair;
  $txtacao=( $acao=='C' ) ? "Consultar" : ( ( $acao=='E' ) ? "Excluir" : "Alterar" ) ;
  # Operador ternário para decidir qual programa será 'chamado' recursivamente
  $prg=( $acao=='C' ) ? "empresasconsultar.php" : ( ( $acao=='E' ) ? "empresasexcluir.php" : "empresasalterar.php" ) ;

  # escrevendo o comando SQL em uma variável
  $cmdsql='select idempresa, txnomeusual from empresas order by idempresa';
  # 'Executando' a variável no SGBD
  $execcmd=mysqli_query($link,$cmdsql);
  # A Função de Ambiente PHP-MariaDB 'mysqli_query()' retorna um vetor estruturado com três partes:
  #   -- Nomes das tabelas, nomes dos campos e endereços dos registros processados no SQL.
  printf("<form action='./$prg' method='POST'>\n");
  # Este form DEVE ter um campo 'oculto' que rece o valor 2 e nome 'bloco' para o PA poder ser recursivo.
  # Sendo assim...:
  printf("<input type='hidden' name='bloco' value='2'>\n");
  printf("  <input type='hidden' name='sair' value='$sair'>\n");
  # Agora escrevemos o inicio da caixa de seleção (daqui em diante referencio este elemento HTML como 'picklist').
  printf("Escolha uma Empresa: <select name='idempresa'>\n");
  # as linhas da picklist serão montadas com a TAG <option>...</option> e devem ser montadas 'lendo' as linhas do comando executado no BD.
  # A PHP dispõe da função mysqli_fetch_arry() que retona em um vetor os dados da linha apontada no primeiro endereço de registro de mysqli_query().
  # então podemos 'repetir' a leitura...
  while ( $rec=mysqli_fetch_array($execcmd) )
  { # neste laço montamos a TAG <option></option>
    printf("<option value='$rec[idempresa]'>$rec[txnomeusual]-($rec[idempresa])</ioption>\n");
  }
  # Agora encerramos a formatação da picklist 'fechando' a TAG <select> e montando os botões do form
  printf("</select>");
  # A TAG <button> permite que um form tenha mais de um botão 'submit' recebendo valores diferentes na mesma posição do vetor que lê a STD.
  printf("<button class='button' type='reset'  name='btreset' >Limpar escolha</button>");
  printf("<button class='button' type='submit' name='btenvio' value='2'>$txtacao</button>");
  printf("</form>\n");
}
function veregistro($idempresa)
{ # Aqui vamos montar uma tabela com os dados do médico escolhido no form do 'bloco 1'
  global $link;
  # A conexão já existe (foi criada 'fora' do SWITCH...CASE).
  # Lendo o registro 'inteiro' da tabela
  # $cmdsql="SELECT * FROM medicos WHERE idmedico='$_REQUEST[idmedico]'";
  # Esse comando lê somente os dados da tabela medicos. A tabela medicos, entretanto, tem ligações com instituicoesdeensino, especialidadesmedicas e logradouros (por 2 campos)
  # SELECT M.*,
  #         I.txnomeinstituicao,
  #         E.txnomeespecmedica,
  #         L1.txnomelogradouro AS txnomelogrmoradia,
  #         L2.txnomelogradouro AS txnomelogrclinica
  #         FROM medicos AS M LEFT JOIN instituicoesdeensino AS I ON M.instituicaodeensinoid=I.idinstituicaodeensino 
  #                           LEFT JOIN especialidadesmedicas AS E ON M.especmedicaid=E.idespecmedica
  #                           LEFT JOIN logradouros AS L1 ON M.logradouromoradiaid=L1.idlogradouro
  #                           LEFT JOIN logradouros AS L2 ON M.logradouroclinicaid=L2.idlogradouro
  # Este é uma junção envolvendo as tabelas ligadas na tabela medicos e projetando campos que podem aparecer na tela de detalhe de registro que será excluído.
  # sendo assim, vamos reformular o comando que consulta os dados na forma
  $cmdsql = "SELECT M.*, I.txnomesetordeatuacao,L1.txnomelogradouro 
  AS txnomelogradouro FROM empresas AS M LEFT JOIN setoresdeatuacao AS I ON M.setordeatuacaoid = I.idsetordeatuacao LEFT JOIN logradouros AS L1 ON M.logradouroid = L1.idlogradouro where idempresa = '$idempresa' order by idempresa";
  // $cmdsql="select * from empresas where idempresa = '$idempresa' order by idempresa";
  # Se quiser conferir o conteúdo desta variável, retire o comentário da linha seguinte:
   printf("$cmdsql<br>\n");
  # Executando o comando e já montando o vetor com o registro lido
  $reg=mysqli_fetch_array(mysqli_query($link,$cmdsql));
  # Montando a apresentação dos dados em uma tabela.
  printf("<table>
            <tr><td>Código</td>          <td> $reg[idempresa]</td></tr>
            <tr><td>Nome</td>            <td> $reg[txnomeusual]</td></tr>
            <tr><td>Razão Social</td>    <td> $reg[txrazaosocial]</td></tr>
            <tr><td>Logradouro</td>      <td> $reg[txnomelogradouro]-($reg[logradouroid])</td></tr>
            <tr><td>Complemento</td>     <td> $reg[txcomplemento]</td></tr>
            <tr><td>CEP</td>             <td> $reg[nucepempresa]</td></tr>
            <tr><td>Setor de atuação</td><td> $reg[txnomesetordeatuacao]-($reg[setordeatuacaoid])</td></tr>
            <tr><td>Data de cadastro</td><td> $reg[dtcadempresa]</td></tr>
         </table>");
}
?>
