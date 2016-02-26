#Começando a trabalhar com lliure


##Instalação
###Dependências
Para você ter o lliure operante, é necessário ter um *web server*, esse por sua vez pode ser local ou remoto (online). Seu web precisa estar com o php 5.3 ou mais recente e o banco mysql.
Quanto as configurações precisamos que em seu server esteja o [mod_rewrite] ativo.

[mod_rewrite]: http://httpd.apache.org/docs/current/mod/mod_rewrite.html
###Download
A versão atual estável do lliure é a **7**, faça o download utilizando o botão abaixo

[![Download][imgdownload]][download]
[imgdownload]: http://lliure.com.br/tools/git_suport/big-download-button.png
[download]: https://github.com/lliure/lliure/archive/7.zip "Faça o download da versão estável"

[clicando aqui]:https://github.com/lliure/lliure-wolf/archive/master.zip
A versão beta do lliure é chamada de wolf você pode fazer o download [clicando aqui], mas lembre essa não é um versão estável e não é garantida a funcionabilidade dos aplicativos

###Instalando
* Extraia o zip, nele você tera um pasta chamada **sistema** cole essa pasta de preferencia na raiz do seu servidor (não há problemas em utilizar em sub pastas).
* Crie um banco de dados com o nome de sejado
* Acesse http://seuservidor.com/sistema, automaticamente você será redirecionado para o opt de instalação, preencha as informações necessárias (Host, Nome do banco, Usuario e senha).

Duas coisas necessárias para ocorrer tudo bem na instalação é que você crie uma pasta chamada **uploads** paralelamente a pasta sistema, e de permição *chmod* **777** a pasta uploads e a pasta **etc** localizada dentro da pasta sistema.

Se tudo ocorrer bem você receberá uma mensagem de sucesso, só reforçando o login e senha padrão são **dev**.


##Afinal de contas o que é o lliure?
###Bem o lliure...
O lliure está classificado com um WAP, isso quer dizer, uma plataforma de aplicações o que pode ser comparado a um sistama operacional on-line.

O lliure também é altamente dependente de seus aplicativos bem como qualquer SO depende de seus programas, e ele fornece api's afim de facilitar o desenvomento de aplicações e também para ajudar na padronização da mesma.

###Estrutura Básica
No lliure você encontra algumas partes são elas *usr*, *opt*, *api* e *app*

>**Usr** é toda a parte do lliure não interativa diretamente, como o próprio core, fontes, bibliotecas de funções complementares..

>**Opt** nesse local encontra-se as aplicações internas do lliure como: login, painel de controle, desktop...

>**Api** são as partes complementares do lliure, usadas por apps e opts, e támbem podem ser usadas em ambientes externos

>**App** nada mais que as aplicações do lliure, e fazer suas aplicações é bem simples

###Requisitos
####Modo de trabalho
####Variaveis do sistema


##Aplicativos (App)
###Instalação
###Desenvolvendo

##Api
###O que são
###Utilização

## ChangeLog 
*7.x (Perdigueiro Português)*

```php
# 7.2 (26/10/2015)
- [bug] - Correções na configuração nos modos de execucao

# 7.1 (06/10/2015)
- [bug] - Correções na API midias

# 7.0 (09/09/2015)
- [update] - Alterado funcionamento da definição de desktop, tema, e execução agora por grupo de usuário
- [bug] - reconhecimento url amiaveis
- [bug] - tratamento de onclient
- [update] - alterações no processamento de urls em thumbs.php
- [bug] - adição de definição de valor padrão em $llconf->execucao
- [update] - suporte para conversão automática de url para comum ou amigavel
- [update] - alterada forma de entrada para apps de desktop, não é apresentado o ?app na url
- [bug] - adicionado strtolower ao método ll_app::setNome para poder entrar valores em maiúsculo
- [update] - Api aplimo reformulado com flexbox
- [update] - instalada como opt o recurso font-awesome
- [update] - instalada fonte como fonte padrão Open Sans
- [update] - na configuração do aplicado no arquivo .ll aceita o grupo que pode acessar o app ex: <seguranca>admin</seguranca>
- [update] - função de conversão de array para objeto adicionado a biblioteca jf
- [update] - Adição das extenções de fontes no .htaccess
- [update] - Alteração na api midias para usar passando menos parametros
- [update] - opt user reformulada aos novos padrões
- [update] - entrada de GET opt adicionada ao sistema
- [update] - Alterado nomenclatura do modo sen_html para onclient, $_ll['sen_html'] foi mantida por compatibilidade
- [update] - Removido arquivo kun_html.php e acoes.php da raiz
- [update] - Atualização em rotinas para inicio de arquivo llconf.ll em utf-8
- [update] - Atualização na função lltoObject() para suporte a utf-8
- [bug] - atualização nos padrões de css class .column
- [bug] - aterando entrada na função jf_insert() de != para !== de 'NULL'
- [bug] - correção na api aplimo referente a montagem do menu superior na função hc_menu()
- [bug] - correção de htmlspecialchars na api Navigi 
- [bug] - ajustada codifição de caracteres nos arquivos kun_html.php e funcoes.js
- [update] - acrescentado os métodos onserver() e onclient() na api aplimo
- [bug] - mensagem de erro em não puxar o método header() na api aplimo
- [bug] - correções, erro ao acessar um banco não existente na api navigi
- [bug] - correções de acessos para arquivos
- [update] - adequação no navigi para receber as classe conforme a denominação das etiquetas
- [update] - criada a função lltoobject() para fazer o carregamento de arquivos ll
- [update] - acrescentada api tags
- [update] - header é requerido nos modos onserver e em sen_html
- [update] - desta versão em diante o lliure tera seu tema alterado conforme a versão corrente
- [update] - api appbar, titulo do app direciona para home do app quando logado como dev ou adm
- [update] - Arquivo thumbs.php alterado com função "Manual" e "Ajustado"
- [update] - updates de funcionamento no jfbox
- [update] - criação da api "mídias"
```
