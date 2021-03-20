<?php

    session_start();

    $error = "";
    $success = "";

    if (array_key_exists("logout", $_GET)) {
        unset($_SESSION["id"]);
        setcookie("id", "", time() + 60*60);
        $_COOKIE['id'] = "";
    } elseif (array_key_exists("id", $_SESSION) or array_key_exists("id", $_COOKIE)) {
        header("Location: logged.php");
    }

    $link = mysqli_connect("localhost", "root", "", "realdiary");
    if (mysqli_connect_error()) {
        die("There was a problem while connecting to database.");
    }

    if (array_key_exists("submit", $_POST)) {
        if ($_POST['email'] == '') {
            $error .=  "<p>Email address is required!</p>";
        }
        if ($_POST['password'] == '') {
            $error .= "<p>Password is required!</p>";
        }
        if (array_key_exists("passwordConfirm", $_POST)) {
            if ($_POST['password'] !== $_POST['passwordConfirm']) {
                $error .= " ".$_POST['password']." === ".$_POST['passwordConfirm']." ";
            }
        }
        if ($error != "") {
            $error = "<div class='alert alert-danger' role='alert'>There were problems with your form: <br>".$error."</div>";
        } else {
            if ($_POST['signup'] == '1') {
                $query = "SELECT *
                      FROM `users`
                      WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' 
                      LIMIT 1";
                $results = mysqli_query($link, $query);

                if (mysqli_num_rows($results)) {
                    $error = "<div class='alert alert-warning' role='alert'>That user already exists - try logging in.</div>";
                } else {
                    $query = "INSERT INTO `users` (`email`, `password`)
                          VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', 
                          '".password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT)."')";
                    if (!mysqli_query($link, $query)) {
                        $error =  "Could not sign you up - try again later.";
                    } else {
                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {
                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                        }

                        header("Location: logged.php");
                    }
                }
            } elseif ($_POST['signup'] == '0') {
                $query = "SELECT *
                      FROM `users`
                      WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' 
                      LIMIT 1";

                $results = mysqli_query($link, $query);

                $row = mysqli_fetch_array($results);

                if (isset($row)) {
                    if (password_verify(
                        mysqli_real_escape_string($link, $_POST['password']),
                        $row["password"]
                    )) {
                        $_SESSION['id'] = $row['id'];

                        if ($_POST['stayLoggedIn'] == '1') {
                            setcookie("id", $row['id'], time() + 60*60*24*365);
                        }
            
                        header("Location: logged.php");
                    } else {
                        $error = "<div class='alert alert-danger' role='alert'>Your login information is incorrect!</div>";
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Secret Diary</title>
</head>

<body>

    <div class="shadow">

        <div class="container">

            <h1>Secret Diary</h1>
            <p class="u-tittle">Store your toughts permanently and securely.</p>
            <p class="w-message">Log in using your username and password.</p>

            <div class="form-container">
            <div id="notification"><?php echo $error.$success; ?></div>
                <form method="POST">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                        placeholder="Your Email" name="email" data-toggle="tooltip" data-placement="right" title="Email is required!">
                        <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group" id="passwordDiv">
                        <input type="password" class="form-control" id="password"
                        placeholder="Password" name="password" data-toggle="tooltip" data-placement="right" title="Password is required!">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="cbstay" name="stayLoggedIn">
                        <label class="form-check-label" for="exampleCheck1">Stay logged in</label>
                    </div>
                    <input type='hidden' name='signup' value='0' id="signup">
                    <button type="submit" class="btn btn-success" name="submit" id="submit">Log in!</button>
                </form>

                <div class="switch">Sign up</div>
            </div>
        </div>

    </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
        <script src="app.js"></script>

</body>

</html>