<?php

error_reporting(E_ALL);

set_time_limit(120);


function start_database() {
	$db_pid = exec("../bin/mongod --dbpath ../data/db >dbout 2>&1 & echo $!");
	file_put_contents("dbpid", $db_pid, LOCK_EX);
}

function start_309() {
	$node309_pid = intval(file_get_contents("node309_pid"));
	$node309_pid = exec("./node/bin/node ../What-To-Eat/bin/www >node309out 2>&1 & echo $!");
	file_put_contents("node309_pid", $node309_pid, LOCK_EX);
}

function node_dispatch() {
	echo 'redirecting...';
	$node309_pid = intval(file_get_contents("node309_pid"));
	if($node309_pid === 0) {
		start_database();
		start_309();
	}
	header("Location: http://309.lesterlyu.com");
	die();

}

node_dispatch();