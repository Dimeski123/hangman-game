<?php

session_start();
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Hangman</title>
        <link rel="stylesheet" href="styles.css">
        <script src="app.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <script src="https://kit.fontawesome.com/cbfa582d0a.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav>
            <h1>Hangman</h1>
        </nav>

        <form class="login-form">
            <fieldset class="login-header">
                <h1>Login</h1>
                <p>In order to be able to follow your score you need to be logged in</p>
                <p>Don't have account yet? <a href="register.php">Create an account</a> </p>
                <hr style="width: 50%; height: 1px;color: black; border: 0; border-top: 1px solid rgba(0,0,0,.1);">
            </fieldset>
            <fieldset class="login-content">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">

            </fieldset>

            <fieldset class="login-btn">
                <input type="submit" value="Log In" id="loginUser" />
            </fieldset>
            <fieldset class="login-guest">
                <p>You can also join without logging in, but your score can not be followed.</p>
                <p><a href="game.php">Continue as guest</a></p>
            </fieldset>
        </form>
        <hr>
        <div class="leaderboard">
            <h1>Leaderboard</h1>
            <div id="table-leaderboard">

            </div>
        </div>


        <!-- /////////////////////////////////////////// -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <!-- Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>


        <script>
            $(document).ready(function () {
                $('#loginUser').click(function (e){
                    e.preventDefault();
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: $(".login-form").serialize() + "&action=login",
                        success: function (response) {
                            if (response !== false && response !== "") {
                                const res = JSON.parse(response);
                                Swal.fire({
                                    title: `Welcome ${res.name}`,
                                    icon: 'success'
                                }).then(function (result){
                                    if (result.isConfirmed){
                                        window.location.href = "game.php";
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Wrong Username or Password',
                                    icon: 'error'
                                });
                            }
                            $(".login-form")[0].reset();
                        }
                    });
                });
                showLeaderboard();
                function showLeaderboard() {
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "viewLeaderboard"},
                        success: function (response) {
                            //console.log(response);
                            $("#table-leaderboard").html(response);
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText); // Print any error response from the server
                        }
                    });
                }

            });
        </script>

    </body>
</html>