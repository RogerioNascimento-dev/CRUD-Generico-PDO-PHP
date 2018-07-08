<?php
#Importando a classe
require "db.class.php";

#--|Criando novo registro com o método save da classe|--#

#Definindo e setando os valores no array com os campos e valores que serão salvos na tabela
$data 				= array();
$data['name']		= 'Manoel Virgulino da Silva alterado';
$data['username']	= 'manoelvirgu@gmail.com';
$data['office']		= 'Analista de Sistemas';
$data['genre']		= 'M';
$data['password']	= md5('1111');

#Definindo tabela que irá salvar os dados #
$table = 'cap_users';

#Chamando o método que irá salvar os dados no banco e guardando o retorno na variável $ret #
$ret = DB::save($table,$data,6);
/*
Observações:
1 - O nome da posição do array tem que ser identico ao campo na tabela que vc quer setar o valor.
2 - Se o ultimo parametro for 0 um novo registro será adicionado a tabela
3 - Se o ultimo parametro for um id existente na tabela o metodo irá fazer um update no registro
4 - Ou seja o médodo save serve tanto para criação quanto para atualização.
5 - O retorno do método é um array com as posições error_number,error_info,affected_rows e new_id em caso de criação de um novo registro.
6 - error_number será 0 em caso de sucesso e 1 em caso de falha
7 - error_info será "Dados salvo com sucesso ás (hora atual)" em caso de sucesso e o detalhe do erro em caso de falha
8 - affected_rows retorna o numero de linhas afetadas na tabela
9 - new_id o id do registro que acabou de ser criado
*/