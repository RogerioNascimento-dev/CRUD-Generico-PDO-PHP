<?php
/*															*/
# Autor: 			Rogério de Oliveira Nascimento       	#
# E-mail: 			rogerionascimento.dev@outlook.com.br 	#
# Data:				05/07/2018                           	#
# Versão do php:	7.1.3                                	        #
/*															*/

abstract class DB{
	
	protected static $host	= '127.0.0.1';
	protected static $user	= 'root';
	protected static $pass	= '';
	protected static $db 	= 'lost_and_found_db';


	public static function conect(){	

		try{

			$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$db,self::$user,self::$pass);
			$pdo->exec('SET NAMES utf8');			

		}catch(PDOException $erro){

			echo "Não foi possível conectar ao banco de dados ".$erro;
			$pdo = false;
		}


		return $pdo;
	}#Fim da função conect


	#Função generica de criação e atualização de registros
	public static function save($table, $data, $id = 0) {
		$db 		= self::conect();
		$fields_up 	= '';
		$question  	= 0;
		$return 	= array();

		foreach ($data as $field => $value) {

		    $fields[] = $field;                 //array somente com os campos
		    $fields_up .= $field.' = '.'?, ';   //strnng pronta com os campos para Update 
		    $values[] = $value;                 //array somente com os valores
		    $question ++;                       //contador para repetir ?, no INSERT   

		}#Fim do foreach

		if($id == '0' || $id == ''){
		    #Monta query de insert caso não tenha passado um id.
		    $fields_insert   = implode(", ", $fields); //string com os campos para o insert  
		    $question = substr(str_repeat('?,', $question),0,-1);//repete a quantidade de interrogação necessária para o insert
		    $sql = "INSERT INTO ".$table." (".$fields_insert.") VALUES (".$question.")";     

		}else{

		    #Monta query de update caso seja passado um id.			
		    $values[] = $id;
		    $sql = "UPDATE ".$table." SET ".substr($fields_up,0,-2)." WHERE id = ?";

		}#fim do else

	    $save 	= $db->prepare($sql);
	    $ret 	= $save->execute($values);
	    $error 	= $save->errorInfo();
	    
	   
	   	if($ret){

	   		$return['error_number'] 	= 0;
	    	$return['error_info'] 		= 'Dados salvo com sucesso ás '.date('H:i:s'); 
	    	$return['affected_rows']	= ($save->rowCount())?$save->rowCount().' linhas afetadas':'Nenhuma linha afetada';
	    	
			if(!$id){

				$return['new_id'] 		= $db->lastInsertId();
				
			}
			

	   	}else{

		$return['error_number'] 	= 1;
	    	$return['error_info'] 		= $error[2];   


	   	}
		    
		return $return;

 	}# Fim do método save #


	public static function update($table,$data,$ids = '0',$where = '1=1'){
		$db 			= self::conect();
		$sets			= '';
		$sets_where		= '';
		$values 		= array();		
		$return			= array();
		$query 			= '';


		foreach ($data as $key => $value) {

			$sets 		.= $key.'=?,';
			$values[] 	 = $value;

		}# Fim do foreach #

		$sets = substr($sets,0,-1);

		if($ids){
			$query 	= "UPDATE ".$table." SET ".$sets." WHERE id IN(".$ids.") AND ".$where;
		}else if($where != '1=1'){ #Evita um update geral por engano
			$query 	= "UPDATE ".$table." SET ".$sets." WHERE ".$where;
		}

		$update = $db->prepare($query);					
		$ret 	= $update->execute($values);
		$error 	= $update->errorInfo();	
		

		if($ret){

			$return['error_number'] 	= 0;
			$return['error_info'] 		= 'Dados atualizados com sucesso ás '.date('H:i:s'); 
			$return['affected_rows']	= ($update->rowCount())?$update->rowCount().' linhas afetadas':'Nenhuma linha afetada';

		}else{			

			$return['error_number'] 	= 1;
			$return['error_info'] 		= $error['2'];
		}
		
		return $return;		
		
	}# Fim do método update #



	public static function delete($table,$ids='',$where='1=1'){
		$db 	= self::conect();
		$query 	= '';
		$return	= array();

		if($ids){
			$query = "DELETE FROM ".$table." WHERE id IN(".$ids.") AND ".$where;
		}else if($where != '1=1'){ #Evita um delete geral por engano
			$query = "DELETE FROM ".$table." WHERE ".$where;
		}

		$delete 	= $db->prepare($query);		
		$ret 		= $delete->execute();
		$error 		= $delete->errorInfo();

		if($ret){
			$return['error_number'] 	= 0;
			$return['error_info'] 		= 'Dados excluidos com sucesso ás '.date('H:i:s'); 
			$return['affected_rows']	= ($delete->rowCount())?$delete->rowCount().' linhas afetadas':'Nenhuma linha afetada';
		}else{
			$return['error_number'] 	= 1;
			$return['error_info'] 		= $error['2'];
		}

		return $return;

	}#Fim do método delete



	public static function read($query,$data,$fetchAll = false){

		$db 	= self::conect();
		$return	= array();


		$rows 	= $db->prepare($query);
		if($data):
			$rows->execute($data);
		else:
			$rows->execute();
		endif;

		$error = $rows->errorInfo();

		if($fetchAll){
			$rows = $rows->fetchAll(PDO::FETCH_ASSOC);
		}else{
			$rows = $rows->fetch(PDO::FETCH_ASSOC);
		}

		if(!$error['2']){
			$return = $rows;
		}else{
			$return['error_number'] = 1;
			$return['error_info'] 	= $error['2'];
		}

		return $return;

	}#Fim do método read


}#Fim da classe DB
