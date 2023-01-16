<?php
########################################################################################################################################################
# Programa..> PA Recursivo
# Descrição.> Desenvolvimento de PA em PHP, usando a função de ambiente ISSET() e os comandos de desvio condicional: IF () THEN...ELSE e SWITCH...CASE.
# Autor.....> JMH
# Observação> O código final será disponibilizado no repositório de códigos do site da disciplina
#             Referencia boa para estudo do PHP: http://www.php.net
# Criacao...> 2022-10-17
# Alteração.> 2022-10-20 - Incorporação dos PA das turmas da tarde e noite para postagem no repositório.
########################################################################################################################################################
# Para inserir um comentário em PHP pode-se usar: //,  /* - */ e #
# Estes são simbolos para comentários em PHP herdados das linguagens (#-Shell-UNIX e PERL e // /*-*/ da linguagem C).

# O PHP  tem cerca de 90 'funções de ambiente'
# A função ISSET() verifica a existência de valor em variáveis (ou vetores) retornando TRUE ou FALSE.
# Pode-se usar o ISSET() com um comando de desvio condicional para ver se existe valor dentro
# de um 'vetor de ambiente'.  Estas variáveis de ambiente tem seu nome começando com '$_'.
# já conhecemos: $_POST[], $_GET[] e $_REQUEST[]

# Este próximo comando de desvio determina 'qual bloco de programação' será executado.

# if ( ISSET($_REQUEST['bloco']) )
# { # 
#   $bloco=$_REQUEST['bloco'];
# }
# else
# { # Execução do PA pela primeira vez. $bloco receberá 1
#   $bloco=1;
# }
# o comando IF anterior pode ser trocado por um operador ternário na forma:
$bloco= ( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;


# iniciando as tags da página
printf("<html>\n<head>\n<title>PA-Rec   </title>\n</head>\n<body>\n");
switch (TRUE)
{
  case ( $bloco==1 ):
  { # bloco #1 - Aqui vamos montar um form 'passando o valor de bloco para 2'
    printf("<form action='recursivo.php' method='POST'>\n");
    # Este form DEVE ter um campo 'oculto' que rece o valor 2 e nome 'bloco' para o PA poder ser recursivo.
    # Sendo assim...:
    printf("<input type='hidden' name='bloco' value='2'>\n");
    printf("ID do Médico;dico:<input type='text' name='idempresa' size='40' maxlength='120'><br>\n");
    printf("Nome da empresa;dico:<input type='text' name='txnomeusual' size='40' maxlength='120'><br>\n");
    printf("Razão Social;dico:<input type='text' name='txrazaosocial' size='40' maxlength='120'><br>\n");
    # A TAG <button> permite que um form tenha mais de um botão 'submit' recebendo valores diferentes na mesma posição do vetor que lê a STD.
    printf("<button name='btenvio' value='1'>Enviar dados</button>");
    printf("<button name='btenvio' value='2'>Tratar dados</button>");
    printf("</form>\n");
    break;
  }
  case ( $bloco==2 ):
  { # bloco #2 - Aqui vamos 'ler' os dados digitados nos campos do form do 'case 1'
    printf("<pre>");
    print_r($_REQUEST);
    printf("</pre>");
    break;
  }

}
# terminando as tags da página
printf("</body>\n</html>\n");
?>