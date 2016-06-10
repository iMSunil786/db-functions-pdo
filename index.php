<?php require 'db.php';

	$db=new DB();
 		
 		// echo $db->insert('users',
 		// 					[
 		// 					'username'=>'new',
 		// 					'email'=>'newsa@gmail11.com',
 		// 					'password'=>md5('123456'),
 		// 					'mobile'=>'876655432',
 		// 					'status' =>'1',
 		// 					'added_on' =>date('Y-m-d H:i:s'),
 		// 					'last_modified_on' =>date('Y-m-d H:i:s'),
 		// 					]) ;
		$results=$db->update('users','1',['username'=>'new','mobile'=>'55432'],'user_id'); 
		// //update($table,$id,$fields[],$column='id')
		 // users is table name
		// $results=$db->table('users')->get();
		 echo "<pre>";
			var_dump($results); // fetch a data 
	    echo "</pre>";
	 
	  // $results=$db->table('users')->where('user_id','1')->whereAnd('status','1')
		 //  ->whereAnd('email','ulhas@gmail.com')
		 //  ->get();  //
		 // echo "<pre>";
			// var_dump($results); // fetch a data 
	  //   echo "</pre>";

		// exit;
		// foreach ($results as $key => $value) {
		// 	 var_dump($value->user_id,$value->username);
		// }

 exit;