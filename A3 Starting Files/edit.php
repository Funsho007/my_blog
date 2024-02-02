<?php

/*******w******** 
    
    Name:
    Date:
    Description:

 ****************/

require('connect.php');
require('authenticate.php');

// UPDATE quote if title, content and id are present in POST.
if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query     = "UPDATE my_blog SET title = :title, content = :content WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);


    // Execute the INSERT.
    $statement->execute();

    // Redirect after update.
    header("Location: index.php?id={$id}");
    exit;
} else if (isset($_GET['id'])) { // Retrieve my_blog to be edited, if id GET parameter is in URL.
    // Sanitize the id. Like above but this time from INPUT_GET.
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parametrized SQL query using the filtered id.
    $query = "SELECT * FROM my_blog WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the SELECT and fetch the single row returned.
    $statement->execute();
    $my_blog = $statement->fetch(); 

    $title= $my_blog['title'];
    $content= $my_blog['content'];
} else {
    $id = false; // False if we are not UPDATING or SELECTING.
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>God's Eyes - Edit Post Wootly Grins</title>
    <link rel="stylesheet" href="main.css" type="text/css">

</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">God's Eyes - Edit Post</a></h1>
        </div>
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="post.php">New Post</a></li>
        </ul>
        <div id="all_blogs">
            <form action="edit.php" method="post">
                <fieldset>
                    <legend>Edit Blog Post</legend>
                    <p>
                        <label for="title">Title</label>
                        <input name="title" id="title" value="<?php echo $title;?>" />
                    </p>
                    <p>
                        <label for="content">Content</label>
                        <textarea name="content" id="content"><?php echo $content;  ?> </textarea>
                    </p>
                    <p>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                        <input type="submit" name="command" value="Update" />
                        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
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