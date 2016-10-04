<?php

require "includes/includes.php";
//require "index.php";


$database = new BlogPost;
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

error_reporting(E_ERROR | E_PARSE);
$database -> query("SELECT * FROM blog_posts");
$rows = $database -> resultset();
//print_r($rows);

if(@$_POST['delete_id']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM blog_posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}

if(@$post['update']){
    $id = $post['id'];
    $username = $post["username"];
    $title = $post["title"];
    $post = $post["post"];
    $database->query("UPDATE blog_posts SET username = :username, title = :title, post = :post WHERE id = :id");
    $database->bind("username", $username);
    $database->bind(":title",$title);
    $database->bind(":post", $post);
    $database->bind(":id", $id);
    $database ->execute();
}

if ($_POST['submit']) {
    $username = $post["username"];
    $title = $post["title"];
    $post = $post["post"];

    $database->query("INSERT INTO blog_posts (username, title, post) VALUES(:username, :title, :post)");
    $database->bind(":username", $username);
    $database->bind(":title",$title);
    $database->bind(":post", $post);
    $database ->execute();
}

$database->query('SELECT * FROM blog_posts');
$rows = $database->resultset();

$date = new DateTime();

//Not sure if needed
//$Tags = new Tags();
//$Tags->query('SELECT * FROM blog_posts');
//$rows = $Tags->resultset();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="includes/styles.css" type="text/css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <title>The Open Blog</title>
</head>

<body id="body">

<div class="jumbotron">

<div id="titletop">
<h1>The Open Blog</h1>
</div>

<div class="container">
<div class="row">
<form method="post" id="blogCreator" action="<?php $_SERVER['PHP_SELF']; ?>">

    <div class="col-sm-3">
    <label id="author">Author Name</label><br />
    <input type="text" name="username" placeholder="Add Author..."/><br/><br/>
    </div>

    <div class="col-sm-3">
    <label id="title">Tag</label><br />
    <input type="text" name="title" placeholder="Add a Tag..."/><br/><br/>
    </div>

    <div class="col-sm-5">
    <label id="post">Post</label><br/>
    <textarea rows="4" cols="50" name="post" placeholder="Create a Post..."></textarea><br/><br/>
    </div>

    <div id="submit_button"class="col-sm-1">
    <input type="submit" id="submit" name="submit" value="Submit"/>
    </div>

</form>
</div>
</div>
</div>
<div id="full_post">
<div id="blogPosts" class="container">
    <h1 id="posts_title">Posts</h1>

    <?php

    foreach($rows as $row) {

    ?>
        <div id="blogPosts">
            <div class="col-sm-2">
            <p>Written by: <?php echo $row['username'];?></p>
            </div>
            <div class="col-sm-2">
            <p>Posted on: <?php echo $date->format('m/d/Y');?></p>
            </div>
            <div class="col-sm-2">
            <p>Topic Tag: <?php echo $row['title'];?></p>
            </div>
            <div class="col-sm-5">
            <p><?php echo $row['post'];?></p>
            </div>
            <div class="col-sm-1">
            <form id="delete_button" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="delete_id" value="<?php echo $row['id'];?>">
                <input type="submit" name="delete" value="Delete">
            </form>
        </div>
        </div>

    <?php } ?>

</div>
</div>
</div>
<footer id="row-footerr" class="row-footer" align="center">
    <div class="container">
        <div class="row row-footer">
            <div>
                <h5>Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Most Popular Posts</a></li>
                    <li><a href="#">Customer Support</a></li>
                </ul>
            </div>
                <div class="nav navbar-nav" align=center">
                    <a class="btn btn-social-icon btn-google-plus" href="http://google.com/+"><i class="fa fa-google-plus"></i></a>
                    <a class="btn btn-social-icon btn-facebook" href="http://www.facebook.com/profile.php?id="><i class="fa fa-facebook"></i></a>
                    <a class="btn btn-social-icon btn-linkedin" href="http://www.linkedin.com/in/"><i class="fa fa-linkedin"></i></a>
                    <a class="btn btn-social-icon btn-twitter" href="http://twitter.com/"><i class="fa fa-twitter"></i></a>
                    <a class="btn btn-social-icon btn-youtube" href="http://youtube.com/"><i class="fa fa-youtube"></i></a>
                    <a class="btn btn-social-icon" href="mailto:"><i class="fa fa-envelope-o"></i></a>
                </div>
            <div class="col-xs-12">
                <p style="padding:10px;"></p>
                <p align=center>© Copyright 2016 The Open Blog</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>