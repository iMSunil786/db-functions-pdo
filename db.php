<?php
 class DB{

	private static $_instance=null;

	private $db,$_error=false;
	public $results;
	public $count;

	private $query='';

	public function __construct(){
		try{

			$dsn='mysql:host=localhost; dbname=ulhasfarm';
			$username='root';
			$pass='password';

			$this->db=new PDO($dsn,$username,$pass);
 
	} catch(PDOExeption $e){
		die($e->getMessage());
	 

	}  // catch close

}  // __constuct() close

  public function query($sql, $params= array()){
  	// echo $sql; exit;
     	   try {
     			$stm=$this->db-> prepare($sql);
	  		 if($stm){
	  			$x=1;
				if(count($params)){
					//print_r($params);exit;
 					foreach($params as $param){
 						// var_dump($stm->bindValue($x,$param));exit;
					  $stm->bindValue($x,$param);
	  				  $x++;
				  	}
				}// 
 			if( $stm->execute() ){
 				 	$this->results=	$stm->fetchAll(PDO::FETCH_ASSOC);
				  	$this->count=$stm->rowCount(); 
			  	} 


      } // prepare if close
 
			return ['result'=>$this->results,'count'=>$this->count]; 
     			
     		} catch (PDOExeption $e) {
     			echo $e->getMessage();
     		}

     		
}// query close 

	public function insert($table,$fields=array()){
 
		if(count($fields))
			{
				$keys=array_keys($fields);

				$values='';
				$x=1;

				foreach($fields as $field) {
					$values.='?';
				if($x<count($fields)){
				
					 $values.=',';

 				}
				$x++;
		}

		$sql="INSERT INTO {$table} (`".implode('`,`',$keys)."`)VALUES ({$values})";
				// echo $sql; exit;
			//print_r($fields)
		  //;exit;
		if($this->query($sql,$fields)){
			 return true;
			//echo "insert ok" ;
		}
		else{
			return false;
		}

		}

		return false;
		}  //insert() close


		public function error(){
		     return $this->_error;

		  }


		  public function update($table,$id,$fields,$column='id'){ 
			$set='';
			$x=1;
			foreach($fields as $name => $value){
					$set .="{$name}=?";
				if($x < count($fields)){
					$set.=', ';
				}
				$x++;
		 }
			$sql="UPDATE {$table} SET {$set} WHERE {$column}={$id}";
			 //echo $sql;exit;
			//print_r($fields);exit;
		if( $this->query($sql,$fields)	){
			return true;
 		}
		return false;

	}//update() close

	public function action ($action,$table,$where=array()){
			if(count($where)==3){
			$operators=array('=','>','<','>=','<=' );
			$field      =$where[0];
			$operator   =$where[1];
			$value      =$where[2];

			if(in_array($operator, $operators)){
			$sql="{$action} FROM {$table} WHERE {$field} {$operator} ? ";
				//echo $sql ;exit;
			if($this->query($sql,array($value))){
				//echo 1 ;exit;
				return $this->query($sql,array($value));
			        }
			     
			     }// in_array() close

			 }// count if close

		return $this;
}//action close

	// public function get($table,$where){
	// 	return $this->action('SELECT *',$table,$where);
 // 	} //get() close

	public function delete($table,$where){
		return $this->action('DELETE',$table,$where);
	}

	public function dump($mixed = null) {
		echo '<pre>';
			var_dump($mixed);
		echo '</pre>';
		exit;
		return null;
	}

  
	public function where($field, $value){
		$args = func_get_args();
	 	$arg=[];
	 	$operator='=';
		if(count($args)==3 ){
			foreach ($args as $key => $value) {
				 	$arg[]=$value;
			}

			$this->query.=" WHERE {$arg[0]} {$arg[1]} '{$arg[2]}' ";
			return $this;
		} else{

			
		}
		if(count($args)==2 ){
			foreach ($args as $key => $value) {
				 	$arg[]=$value;
			}
			 $this->query.="     WHERE   {$arg[0]} {$operator} '{$arg[1]}'   ";
  		 	 return $this;
		}
 			   		 
	}

	public function whereAnd($field, $value){
		$args = func_get_args();
	 	$arg=[];
	 	$operator='=';
		if(count($args)==3 ){
			foreach ($args as $key => $value) {
				 	$arg[]=$value;
			}

			$this->query.="  AND  {$arg[0]} {$arg[1]} '{$arg[2]}' ";
			return $this;
		} else{

			
		}
		if(count($args)==2 ){
			foreach ($args as $key => $value) {
				 	$arg[]=$value;
			}

			 $this->query.=" AND  {$arg[0]} {$operator}  '{$arg[1]}'  ";
  		 	 
  		 	 return $this;
		}
 			   		 
}










	public function table($table ){ 
	 
	 	 $this->query.= "SELECT * FROM {$table}";
		 return $this; 

	}
	public function get( )
	{	
	 	  
	 	$stm=$this->db-> prepare( $this->query );
	 	 if( $stm->execute() ){
 			return	$stm->fetchAll(PDO::FETCH_OBJ);
		  } 
	}

	public function count()
	  {		
		  // echo "SELECT *  FROM users WHERE user_id =1 AND STATUS ='1' AND email =  'ulhas@gmail.com'  "; 
		  // echo "<br>";
		  // echo $this->query ;exit;
	 	$stm=$this->db->prepare( $this->query );
	 	 
	 	 if( $stm->execute() )	{
			$stm->execute();
			$count = $stm->fetchAll( ); 
			return count($count);
		  } 
	}

}

?>
