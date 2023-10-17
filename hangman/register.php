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

        <form class="reg-form">

            <fieldset class="login-header">
                <a href="index.php"><div class="exit-btn">
                    <i class="fa-solid fa-x"></i>
                </div></a>
                <h1>Register</h1>
                <p>In order to be able to follow your score please create an account</p>
                <hr style="width: 50%; height: 1px;color: black; border: 0; border-top: 1px solid rgba(0,0,0,.1);">
            </fieldset>
            <fieldset class="login-content">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="8">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>


            </fieldset>

            <fieldset class="login-btn">
                <input type="submit" value="Register" id="register" />
            </fieldset>
            <fieldset class="login-guest">
                <p>You can also join without logging in, but your score can not be followed.</p>
                <p><a href="#">Continue as guest</a></p>
            </fieldset>
        </form>

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

                $('#register').click(function (e){
                    e.preventDefault();
                    console.log("Tuka sme");
                    if($(".reg-form")[0].checkValidity()){
                        e.preventDefault();
                        $.ajax({
                            url:"action.php",
                            type:"POST",
                            data: $(".reg-form").serialize()+"&action=register",
                            success:function (response){
                                if (response === "empty") {
                                    Swal.fire({
                                        title: 'Please Insert every field!',
                                        icon: 'error'
                                    })
                                }else {
                                    if (response === "failed") {
                                        console.log("Email exists");
                                        Swal.fire({
                                            title: 'The Username is already taken',
                                            icon: 'error'
                                        })
                                    }else{

                                        Swal.fire({
                                            title: 'Succesfull registration',
                                            icon: 'success'
                                        }).then(function (result){
                                            if (result.isConfirmed){
                                                window.location.href = "index.php";
                                            }
                                        });
                                    }
                                }

                                $(".reg-form")[0].reset();
                            }
                        });
                    }
                });

            });
        </script>
    </body>
</html>