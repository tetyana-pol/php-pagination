<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="css/css.css">
	<title>Блог</title>
	
</head>
<body>
<?php
include('load/db_connect.php');
?>
   <div id="heard">
		<ul id="top-header">
		<li><a href="">Головна</a></li>
		<li><a href="load/create.php">Створити пост</a></li>
	</ul>
</div>
<div id="content">
		
		<?php
			$sql='set charset utf8';
			$pdo->query($sql);
			$sql='select count(*) as count from post';
			$statemant=$pdo->query($sql); 
			$row=$statemant->fetch();
			$posts=$row["count"]; 
	        session_start();
/*   Panigation */
 

// число повідомлень на сторінці  
			$num = 3;  
  
			$page = $_GET['page'];  
			
// загальна кількість записів  
			$total = ceil($posts  / $num) ;  

			if(empty($page) or $page < 0) $page = 1;  
			if($page > $total) $page = $total;  

			$start = $page * $num - $num;  
 
			
			$sql="SELECT * FROM post order by date_time desc LIMIT ".$start.", 3"; 
			$result=$pdo->prepare($sql);
			
			$result->execute();   
			              
 
			$postrow = $result->fetchall();  
			 
			foreach($postrow as $row)  
			{  
			
			echo 
			'<p>'.$row["date_time"].'</p> 
			<p><strong><a href="load/content.php">'.$row["title"].'</a></strong></p> 
			<p>'.$row["post_short"].'</p>';  
			$_SESSION['id']=$row["id"];
			}  
 
			if ($page != 1) $pervpage = '<a href= index.php?page=1><<</a>  
                               <a href= index.php?page='. ($page - 1) .'><</a> ';  
 
			if ($page != $total) $nextpage = ' <a href= index.php?page='. ($page + 1) .'>></a>  
                                   <a href= index.php?page=' .$total. '>>></a>';  

			if($page - 2 > 0) $page2left = ' <a href= index.php?page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';  
			if($page - 1 > 0) $page1left = '<a href= index.php?page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';  
			if($page + 2 <= $total) $page2right = ' | <a href= index.php?page='. ($page + 2) .'>'. ($page + 2) .'</a>';  
			if($page + 1 <= $total) $page1right = ' | <a href= index.php?page='. ($page + 1) .'>'. ($page + 1) .'</a>';

			echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;  

?>

</div>
<div id="sidebar">
<img src="images/sunrise.jpg" width="155" height="150"/>
	
</div>
<div id="footer">
	<?php
	include ('load/footer.php');
	?>
</div>
</body>
</html>