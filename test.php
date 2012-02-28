<?php
	date_default_timezone_set('America/New_York'); 

	$mongoDB = new Mongo();
	$database = $mongoDB->selectDB("example");
	$collection = $database->createCollection('TestCollection');
	$newDoc = array(
		"author"=>"Bob",
		"subject"=>"Not Much",
		"created"=> new MongoDate(strtotime(Date("m-d-y h:i:s"))),
		"comments"=>array()
			);

	//$collection->insert($newDoc);
	//$collection->remove(array("_id" => new MongoID('4f4ce1f6fa864adc4a000000')));

	//$collection->update(array("author"=>"Bob"), array('$set'=>array("created"=>new MongoDate())));

	//array( "_id" => new MongoID('4f4cd6d078abc07352076ce6'))
	$doc = $collection->find();

	foreach ($doc as $obj) {
	  echo($obj['_id'] . '<br>');
	  echo($obj['author'] . '<br>');
	  echo($obj['subject'] . '<br>');
	  echo($obj['created'] . '<br>');
	  echo(Date('d-M-y h:i:s', $obj['created']->sec) . '<br>');
	  if(isset($obj['comments']))
	  	print_r($obj['comments']);

	  echo('<hr>');
	}


?>	