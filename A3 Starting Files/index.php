<?php

/*******w******** 
    
    Name:
    Date:
    Description:

 ****************/

require('connect.php');
 // SQL is written as a String.
 $query = "SELECT * FROM my_blog ORDER BY date DESC LIMIT 5";

 // A PDO::Statement is prepared from the query.
 $statement = $db->prepare($query);

 // Execution on the DB server is delayed until we execute().
 $statement->execute(); 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Welcome to my Blog!</title>
</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->

        <div id="wrapper">
            <div id="header">
                <h1><a href="index.php">God's Eyes - Index</a></h1>
            </div>
            <ul id="menu">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="post.php">New Post</a></li>
            </ul>
            <div id="all_blogs">
                <div class="blog_post">
                     <?php while($row = $statement->fetch()):
                        ?>
                     <h2><a href="show.php?id=<?= $row['id'];?>"><?= $row['title'] ?></a></h2>
                    <p>
                        <small>
                        <?= date("F d, Y, h:i a", strtotime($row['date'])) ?>

                            <a href="edit.php?id=<?= $row['id'];?>">edit</a>
                        </small>
                    </p>
                    <div class="blog_content">
                    <?= $row['content'] ?> </div>
             <?php endwhile ?>
                   
                </div>
                
            </div>
            <div id="footer">
                Copywrong 2024 - No Rights Reserved
            </div>
        </div>
        
    </body>

</html>