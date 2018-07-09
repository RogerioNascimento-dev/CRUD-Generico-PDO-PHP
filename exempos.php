<?php
#Importando a classe
require "db.class.php";

#--|Criando novo registro com o método save da classe|--#

#Definindo e setando os valores no array com os campos e valores que serão salvos na tabela
$data 				    = array();
$data['name']		  = 'Manoel Virgulino da Silva alterado';
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




#--|Atualizando um registro com o método update da classe|--#

#Definindo e setando os valores no array com os campos e valores que serão atualizados na tabela
$data      				= array();
$data['name']		  = 'Manoel Virgulino da Silva atualizado';
$data['username']	= 'manoelvirgu@gmail.com';
$data['office']		= 'Analista de Sistemas alterado';
$data['genre']		= 'F';


#Definindo tabela que irá atualizar os dados #
$table = 'cap_users';

#Chamando o método que irá salvar os dados no banco e guardando o retorno na variável $ret #
$ret = DB::update($table,$data,'6,5,4', 'genre = "F"');

/*
Observações:
1 - O exemplo acima irá fazer uma atualização em cascata em nos registros com os ids 6,5,4 e que o genre seja = "F"
2 - O terceiro parametro do método update é o id que irá ser atualizado ou em caso de atualização multipla passar os ids separado por virgula.
3 - o quarto parametro do método é a clausula where ou seja o update pode ser feito passando apenas os ids ou passando a clausula where ou os dois.
4 - O retorno do método é um array com as posições error_number,error_info,affected_rows.
5 - error_number será 0 em caso de sucesso e 1 em caso de falha
6 - error_info será "Dados atualizados com sucesso ás (hora atual)" em caso de sucesso e o detalhe do erro em caso de falha.
7 - affected_rows retorna o numero de linhas afetadas na tabela.
*/



#--|Excluindo registros com o método delete da classe|--#

#Definindo tabela que o registro será excluido #
$table = 'cap_users';

$ret = DB::delete($table,'6,5,4', 'genre = "F"');

/*
Observações:
1 - O exemplo acima irá excluir em cascata os registros com os ids 6,5,4 e que o genre seja = "F"
2 - O terceiro parametro do método delete é o(s) id(s) que serão excluidos ou em caso de exclusão multipla passar os ids separado por virgula.
3 - o quarto parametro do método é a clausula where ou seja o delete pode ser feito passando apenas os ids ou passando a clausula where ou os dois.
4 - O retorno do método é um array com as posições error_number,error_info,affected_rows.
5 - error_number será 0 em caso de sucesso e 1 em caso de falha
6 - error_info será "Dados excluidos com sucesso ás (hora atual)" em caso de sucesso e o detalhe do erro em caso de falha.
7 - affected_rows retorna o numero de linhas afetadas na tabela.
*/
