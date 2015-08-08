<?php
// ---------------------------------------------------------------------------
// Leitor de arquivos SQL por Alfred Reinold Baudisch<alfred_baudisch@hotmail.com>
// Copyright � 2003, 2004 AuriumSoft - www.auriumsoft.com.br
// ---------------------------------------------------------------------------
// This library is free software; you can redistribute it and/or
// modify it under the terms of the GNU Lesser General Public
// License as published by the Free Software Foundation; either
// version 2.1 of the License, or (at your option) any later version.
// 
// This library is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
// Lesser General Public License for more details.
// 
// You should have received a copy of the GNU Lesser General Public
// License along with this library; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
// ---------------------------------------------------------------------------

/**
* Executa arquivos SQL imprimindo mensagens de erros, nomes de tabelas criadas, etc..
* Para qualquer tipo de banco de dados, bastando somente alterar a fun��o de query e erro
*
* @since Mar 15, 2004
* @version 1.1
* @author Alfred Reinold Baudisch<alfred_baudisch@hotmail.com>
*/
class leitor_sql {
    /**
    * Onde s�o armazenadas as mensagens de erro
    * @var array $erros
    */
    var $erros;

    /**
    * Contagem de cl�usulas SQL Insert
    * @var array $foi
    */
    var $foi;

    /**
    * Construtor. Aqui onde tudo ocorre
    *
    * @param string $arquivo_sql Nome do arquivo com as instru��es SQL
    * @since Mar 15, 2004
    * @access public
    */
    function leitor_sql($arquivo_sql)
    {
        /**
        * Inicializa as vari�veis de contagem e erros.
        * Isso reseta as mesmas caso a fun��o seja chamada mais de uma vez na mesma p�gina,
        * evitando a impress�o das mesmas mensagens repetidamente
        */
        $this->foi = $this->erros = array();

        // Verifica se arquivo existe
        if(!file_exists($arquivo_sql))
        {
            echo "O arquivo <B>" . $arquivo_sql . "</B> � inexistente!";
            exit;
        }

        /**
        * Importa o arquivo SQL para um array
        */
        $conteudo = file($arquivo_sql);

        /**
        * Inicializa vari�veis a se usar nas formata��es e limpezas
        */
        $i = 0;
        $dados = array();

        /**
        * Formata��es e limpezas
        */
        foreach($conteudo as $linha){
            // Remove espa�os em branco nas "bordas"
            $linha = trim($linha);

            // Caso for linha em branco ou linha com coment�rio, "pula" a mesma
            if(empty($linha) || (substr($linha, 0, 1) == '#')){
                continue;
            }    

            // Adiciona quebra de linha e instru��es da mesma
			$dados[$i] = (!isset($dados[$i]) ? "\n" . $linha : $dados[$i] . "\n" . $linha);
            
            /**
            * Encontrado um ";" no final da linha, ent�o, instru��o encerrada.
            * Pula para o pr�ximo �ndice do array
            */
            if(substr(rtrim($linha), -1, 1) == ';'){
                ++$i;
            }
        }

        if(!sizeof($dados)) {
            echo "Nenhuma instru��o SQL encontrada!";
            exit;
        } else {
            echo "<font face=\"Verdana\" size=2>";
        }

        /**
        * Executa as instru��es SQL
        */
        foreach($dados as $atual)
        {
            // Limpa os ";"
            $atual = substr($atual, 0, strlen($atual) - 1);

            /**
            * Pega nome da tabela criada
            * $resultado[1] conter� o nome da mesma
            */
            if(preg_match("/CREATE TABLE (\S+)/i", $atual, $resultado))
            {
                $this->limpa_acento($resultado[1]);
                echo "- Criando tabela <B>" . $resultado[1] . "</B>: ";
                $this->executa_consulta($atual, "<font color=\"green\">OK!</font><BR>", "<font color=\"red\">ERRO!</font><BR>");
            }
            /**
            * Pega o nome da tabela onde dados foram inseridos
            * $resultado[1] conter� o nome da mesma
            */
            elseif(preg_match("/INSERT INTO (\S+)/i", $atual, $resultado))
            {
                $this->limpa_acento($resultado[1]);
                $this->executa_consulta($atual, false, false, $resultado[1]);
            }
            /**
            * Comandos DROP TABLE
            */
            elseif(preg_match("/DROP TABLE (IF EXISTS )?(\S+)/i", $atual, $resultado))
            {
                $this->limpa_acento($resultado[2]);
                $this->executa_consulta($atual, "- Tabela <B>" . $resultado[2] . "</B> exclu�da com sucesso<br>");
            }
            /**
            * Comandos DROP DATABASE
            */
            elseif(preg_match("/DROP DATABASE (IF EXISTS )?(\S+)/i", $atual, $resultado))
            {
                $this->limpa_acento($resultado[2]);
                $this->executa_consulta($atual, "- Banco de dados <B>" . $resultado[2] . "</B> exclu�do com sucesso<br>");
            }
            /**
            * CREATE DATABASE
            */
            elseif(preg_match("/CREATE DATABASE (\S+)/i", $atual, $resultado))
            {
                $this->limpa_acento($resultado[1]);
                echo "- Criando banco de dados <B>" . $resultado[1] . "</B>: ";
                $this->executa_consulta($atual, "<font color=\"green\">OK!</font><BR>", "<font color=\"red\">ERRO!</font><BR>");
            }
        }
        
        /**
        * Imprime as inser��es
        */
        if(sizeof($this->foi))
        {
            foreach($this->foi as $tabela => $total)
            {
                echo "- " . $total . " linha";

                if($total > 1)
                {
                    echo "s";
                }

                echo " inserida";

                if($total > 1)
                {
                    echo "s";
                }

                echo " na tabela <B>" .  $tabela . "</B><br>";
            }
        }
        
        /**
        * Imprime erros, caso ocorridos
        */
        if(sizeof($this->erros))
        {
            $total = sizeof($this->erros);
            echo "<BR>Ocorre";
            
            if($total > 1)
            {
                echo "ram";
            }
            else
            {
                echo "u";
            }            
            echo " " . $total . " erro";            
            if($total > 1)
            {
                echo "s";
            }            
            echo ":<font size=1><br>";

            foreach($this->erros as $linha => $erro)
            {
                echo "<li>Cl�usula SQL: <font color=\"green\">" . $linha . "</font><li>Erro: <font color=\"red\">" . $erro . "</font><br><BR>";
            }

            echo "</font>";
        }

        echo "</font>";
    }

    /**
    * Executa consulta SQL e imprime as mensagens
    *
    * @param string $sql
    * @param string $msg_ok
    * @param string $msg_erro
    * @param string $insert Nome da tabela de um comando SQL Insert
    * @since Mar 15, 2004
    * @access private
    */
    function executa_consulta($sql, $msg_ok = false, $msg_erro = false, $insert = false)
    {
        if($this->query_sql($sql))
        {
            if($insert)
            {
                $this->foi[$insert]++;
            }

            if($msg_ok)
            {
                echo $msg_ok;
            }
        }
        else
        {
            if($msg_erro)
            {
                echo $msg_erro;
            }

            $this->erros[$sql] = $this->erro_sql();
        }
    }

    /**
    * Limpa os acentos dos nomes das tabelas, ex: `tabela`
    *
    * @param string &$dados
    * @since Mar 15, 2004
    * @access private
    */
    function limpa_acento(&$dados)
    {
        // In�cio da string
        $dados = preg_replace("/^\`/i", "", $dados);
        // Final da string
        $dados = preg_replace("/\`$/i", "", $dados);
    }
    
    /**
    * Executa a query SQL.
    * Para usar outro tipo de banco de dados, somente alterar a fun��o.
    *
    * @param string $sql
    * @since Mar 15, 2004
    * @access private
    */
    function query_sql($sql)
    {
        if(@mysql_query($sql))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
    * Mostra a mensagem de erro ocorrida
    * Para usar outro tipo de banco de dados, somente alterar a fun��o.
    *
    * @since Mar 15, 2004
    * @access private
    */
    function erro_sql()
    {
        return mysql_error();
    }
}
?>