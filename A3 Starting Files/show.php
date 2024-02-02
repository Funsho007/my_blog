<?php
require('connect.php');

// UPDATE quote if author, content and id are present in POST.
if ($_POST && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Build the parameterized SQL query and bind to the above sanitized values.
    $query     = "UPDATE my_blog SET author = :author, content = :content WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // Execute the INSERT.
    $statement->execute();

    // Redirect after update.
    header("Location: update.php?id={$id}");
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
    <title>PDO Update</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - kk</a></h1>
        </div>
        <ul id="menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="create.php">New Post</a></li>
        </ul>
        <div id="all_blogs">
            <div class="blog_post">
                <h2><?php echo $title;?></a></h2>
                <p>
                    <small>
                        February 1, 2024, 6:39 pm -
                        <a href="edit.php?id=<?php echo $_GET['id'];?>">edit</a>
                    </small>
                </p>
                <div class="blog_content">
                <?php echo $content;  ?> </div>
            </div>
        </div>
        <div id="footer">
            Copywrong 2024 - No Rights Reserved
        </div>
    </div>
</body>

</html>