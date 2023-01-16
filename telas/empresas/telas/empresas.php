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
#definindo duas variáveis Globais para navegação 'dentro da aplicação'.
global $sair;
global $menu;
$sair=1; # Esta variável contabiliza a quantidade de cliques que se faz navegando pelo sistema.
# printf("$sair<br>\n");
iniciapagina("empresas","MED-Abertura","Abertura");
printf("Este sistema faz o Gerenciamento de dados da Tabela Exemplo para Referência.<br>\n");
printf("O menu apresentado acima apresenta as funcionalidades do sistema.<br><br>\n");
printf("São apresentadas as funcionalidades:<br>\n");
printf("<table>\n");
printf(" <tr><td><u>Incluir</u></td><td>-</td><td>PA que coleta dados (em campos de um formulário) e grava em uma tabela.</td></tr>\n"); # <icog>&#x1f7a5;</icog>
printf(" <tr><td><u>Alterar</u></td><td>-</td><td>PA que permite escolher um registro de uma tabela e executar a alteração de valores do mesmo registro.</td></tr>\n"); # <icog>&#x1f589;</icog>
printf(" <tr><td><u>Excluir</u></td><td>-</td><td>PA que permite escolher um registro de uma tabela e excluir a linha escolhida da tabela.</td></tr>\n"); # <icog>&#x1f7ac;</icog>
printf(" <tr><td><u>Consultar</u></td><td>-</td><td>PA que permite escolher um registro de uma tabela e mostra os dados dos registro escolhido.</td></tr>\n"); # <icog>&#x1f50d;&#xfe0e;</icog>
printf(" <tr><td><u>Listar</u> </td><td>-</td><td>PA que permite escolher dados e ordenação para emitir uma listagem de dados da tabela.</td></tr>\n"); # <icog>&#x1f5a8;</icog>
printf(" <tr><td colspan='3'>Além destas funcionalidades, em cada ação estão disponíveis as ações</td><tr>\n"); 
printf(" <tr><td><u>Inc|Con|Alt|Exc|Lst</td><td>-</td><td>Confirma a ação da funcionalidade em execução.</td></tr>\n"); # <icog>&#x1f5f9;</icog>
printf(" <tr><td><u>Limpar</u></td><td>-</td><td>Executa o 'reset' dos campos do Formulário.</td></tr>\n"); # <icog>&#x2b6e;</icog>
printf(" <tr><td><u>Voltar</u></td><td>-</td><td>Retorna uma tela na navegação das funcionalidades</td></tr>\n"); # <icog>&#x2397;</icog>
printf(" <tr><td><u>Entrada</u></td><td>-</td><td>Retorna para a Página de Entrada (Esta página)</td></tr>\n"); # <icog>&#x1f3e0;&#xfe0e;</icog>
printf(" <tr><td><u>Sair</u></td><td>-</td><td>Salta para 'fora' do Sistema</td></tr>\n"); # <icog>&#x2348;</icog>
printf("</table>\n");
printf("Este sistema foi desenvolvido por: JMH (Escreva aqui Seu Nome e Sua Matrícula)\n");
# Aqui vem a chamada para função que termina a página
terminapagina("Médicos","Abertura","medicos.php");
?>
