<?php
<<<<<<< HEAD
	echo $_POST['query'];	
	$mqServer = '192.168.1.105';
	$mQQ = 'sqlQ';
	$oneTimeKey = uniqid();
=======
	
	$mqServer = '192.168.1.120';
	$mQQ = 'sqlQ'
	$oneTimeKey = uniq()
>>>>>>> Authentication-change
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPStreamConnection;
	use PhpAmqLib\Message\AMQPMessage;
	$conn = new AMQPStreamConnection($mqServer, 5672, 'guest', 'guest');
	$channel = $conn->channel();
	$echo $_POST['query'];
	$msg = new AMQPMessage($oneTimeKey . ' ' . $_POST['query']);
	
	$channel->basic_publish(msg, '', $mQQ);
	
	$channel->queue_declare($oneTimeKey,false,false,false,false);
	
	$callback = function($msg) {
		echo $msg->body;
	};
	$channel->basic_consume($oneTimeKey, '', false, true, false, false, $callback);
	
	while(count($channel->callbacks)){
		$channel->wait();
	}
	
	
?>
