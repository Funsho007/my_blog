<?php

/*******w******** 
    
    Name:
    Date:
    Description:

 ****************/

require('connect.php');
require('authenticate.php');

if ($_POST && !empty($_POST['title']) && !empty($_POST['content'])) {
    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

 //  Build the parameterized SQL query and bind to the above sanitized values.
 $query = "INSERT INTO my_blog (title, content, date) VALUES (:title, :content, CURRENT_TIMESTAMP)";
 $statement = $db->prepare($query);

 //  Bind values to the parameters
 $statement->bindValue(':title', $title);
 $statement->bindValue(':content', $content);


        
        // Execute the INSERT.
        $statement->execute();
        
        header("Location: index.php?id=" . $id); 
        exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>My Blog Post!</title>
</head>

<body>
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - New Post</a></h1>
        </div>
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php" class="active">New Post</a></li>
        </ul>
        <div id="all_blogs">
            <form action="post.php" method="post">
                <fieldset>
                    <legend>New Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"></textarea>
                    </p>
                    <p>
                        <input type="submit" name="command" value="Create" />
                    </p>
                </fieldset>
            </form>
        </div>
        <div id="footer">
            Copywrong 2024 - No Rights Reserved
        </div>
    </div>
</body>

</html>