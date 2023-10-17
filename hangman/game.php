<?php

    session_start();


?>

<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Hangman</title>
        <link rel="stylesheet" href="styles.css">
        <script src="app.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <link href="https://cdn.datatables.net/v/bs4/dt-1.13.6/datatables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <script src="https://kit.fontawesome.com/cbfa582d0a.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav>
        <h1>Hangman</h1>
    </nav>
    <div class="logout-container">

        <a href="index.php"><div class="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
        </div></a>

    </div>


    <div class="welcome-difficulty-container">
        <div class="welcome">
            <h2>Hello </h2>
            <h2><?php
                if (isset($_SESSION['player'])){
                    echo($_SESSION['player']['name']);
                }else{
                    $_SESSION['player']['name'] = "Guest";
                    echo $_SESSION['player']['name'];
                }
                ?></h2>
        </div>
        <div class="difficulty">
            <p>Choose your preffered difficulty:</p>
            <select id="difficulty" name="difficulty">
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
            <button type="button" class="select-difficulty">Select</button>
        </div>
    </div>
    <div class="score-container">
        <h2>Score: <?php
            if (isset($_SESSION['player']) && isset($_SESSION['player']['score'])) {
                echo $_SESSION['player']['score'];
            } else {
                echo "0";
            }
            ?></h2>


    </div>

    <div id="display-hangman">

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
            $(".logout").on("click", function () {
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {action: "logout"}, // Send a logout action to action.php
                    success: function (response) {
                        window.location.href = "Index.php";
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $(".select-difficulty").on("click", function () {
                var selectedDifficulty = $("#difficulty").val(); // Get selected difficulty value
                $.ajax({
                    url: "action.php",
                    type: "POST",
                    data: {action: "selectDifficulty", difficulty: selectedDifficulty},
                    success: function (response) {
                        $("#display-hangman").html(response);
                        $(".difficulty").hide();
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

        })
    </script>

    </body>
</html>