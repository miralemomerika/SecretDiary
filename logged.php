<?php

    session_start();
    $diaryContent = "";

    $link = mysqli_connect("localhost", "root", "", "realdiary");
    if (mysqli_connect_error()) {
        die("There was a problem while connecting to database.");
    }

    if (array_key_exists("id", $_COOKIE)) {
        $_SESSION['id'] = $_COOKIE['id'];
    }

    if (array_key_exists("id", $_SESSION)) {
        $query = "SELECT `diary` FROM `users` WHERE id = ".mysqli_real_escape_string($link, $_SESSION['id'])." LIMIT 1";

        $results = mysqli_query($link, $query);

        $row = mysqli_fetch_array($results);

        $diaryContent = $row['diary'];
    } else {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel="stylesheet" href="logged-style.css">

    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Secret Diary</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand navbar-nav mr-auto" href="logged.php">Secret Diary</a>
    <form class="form-inline my-2 my-lg-0">
        <a href="index.php?logout=1">
      <button class="btn btn-outline-success my-2 my-sm-0" type="button">Logout</button>
      </a>
    </form>
</nav>

<div class="container-fluid">

    <textarea id="diary" class="form-control" name="diary"><?php echo $diaryContent; ?></textarea>

</div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
        <script src="logged-app.js"></script>

</body>

</html>