
<!--
	ooooo        ooooo     ooo oooo    oooo ooooo
	`888'        `888'     `8' `888   .8P'  `888'
	 888          888       8   888  d8'     888
	 888          888       8   88888[       888
	 888          888       8   888`88b.     888
	 888       o  `88.    .8'   888  `88b.   888
	o888ooooood8    `YbodP'    o888o  o888o o888o
-->
<?php
    session_start();
    session_destroy();
    header('Location: index.php');
    exit();
?>