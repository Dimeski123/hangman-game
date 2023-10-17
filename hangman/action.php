<?php

session_start();

    require_once 'db.php';
    $db = new Database();

    $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";


    //Register
    if(isset($_POST['action']) && $_POST['action'] == "register") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $pwForSave = password_hash($password, PASSWORD_DEFAULT);
        $activeUser = $db->findUserByUsername($username);
        $score = 0;

        if(empty($username) || empty($password) || empty($name)){
            echo "empty";
        }
        if (!$activeUser){
            $db->registerPlayer($username, $pwForSave, $name);
        }else{
            echo "failed";
        }
    }

    if(isset($_POST['action']) && $_POST['action'] == "login"){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $player = $db->loginPlayer($username, $password);
        if ($player){
            $_SESSION['player'] = $player;
            echo json_encode($player);
        } else if (!$player){
            echo false;
        }
    }

    if(isset($_POST['action']) && $_POST['action'] == "logout") {
        session_destroy();
        echo "loggedOut";
        exit;
    }
    if(isset($_POST['action']) && $_POST['action'] == "selectDifficulty") {
        $difficulty = $_POST['difficulty'];
        $_SESSION['words']['level'] = $difficulty;
        $word = $db->getWords($difficulty);
        $rand = rand(0, count($word) -1);
        $output ='';

        if ($word){
            $_SESSION['words'] = $word[$rand];
            $length = strlen($_SESSION['words']['word']);
            $output .='<a href="game.php"><button type="submit" class="reset" value="Restart">Restart</button> </a>
        <div class="hangman-container">
        <h1>'.$_SESSION['words']['assoc'].'</h1>
        
        <div class="letters-display">';
            for ($j = 0; $j < $length; $j++) {
                if ($_SESSION['words']['word'][$j] === " ") {
                    $output .= '<div class="letter_guess_space"></div>';
                }else {
                    $output .= '<div class="letter_guess"></div>';
                }
            }
            $correctWord = $_SESSION['words']['word'];
            $_SESSION['words']['word'] = str_replace(' ', '',$_SESSION['words']['word']);

        $output .='</div><img id="hangman-img" src="images/main.png" alt="hangman">
        <div class="letters">';
            $letterLentgh = strlen($letters) - 1;
            for ($i =0; $i<=$letterLentgh; $i++){
                $output .= '<button type="button" class="kp" value="' . $letters[$i] . '">' . $letters[$i] . '</button>';
            }
            $output .='
            
        </div>
        </div>
        
        
       <script>
            let difficulty = '.json_encode($difficulty).'
            console.log(difficulty);
            let images = ["main.png","head.png", "body.png", "hand1.png", "hand2.png", "leg1.png", "leg2.png"];
            let wrongGuessCounter = 0;
            $(".kp").on("click", function () {
                let val = this.value;
                const letterGuesses = document.querySelectorAll(".letter_guess");
                let word ='.json_encode($_SESSION['words']['word']).'.toUpperCase();
                
                let isCorrect = false;
                
                this.innerHTML = "";
        for (let i = 0; i < letterGuesses.length; i++) {
            if (letterGuesses[i].innerHTML === "" && val === word[i]) {
                letterGuesses[i].innerHTML = val;
                isCorrect = true;
            }
        }
       
        if (!isCorrect) {
            wrongGuessCounter++;
            if (wrongGuessCounter < images.length) {
                document.getElementById("hangman-img").src = "images/" + images[wrongGuessCounter];
                if (wrongGuessCounter === images.length - 1) {
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "scoreUpdateLose"},
                        success: function (response) {
                            Swal.fire({
                                title: "Game Over",
                                html: "You lost 10 points! The word was<br> '.$correctWord.'",
                                icon: "error"
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = "game.php";
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            }
        } else {
            let allLettersGuessed = true;
            for (let i = 0; i < letterGuesses.length; i++) {
                if (letterGuesses[i].innerHTML === "") {
                    allLettersGuessed = false;
                    break;
                }
            }
            
            if (allLettersGuessed) {
                if (difficulty === "easy"){
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "scoreUpdateEasy"},
                        success: function (response) {
                            console.log(difficulty);
                            Swal.fire({
                                title: "Congratulations!",
                                text: "You earned 5 points!",
                                icon: "success"
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = "game.php";
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }else if (difficulty === "medium"){
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "scoreUpdateMedium"},
                        success: function (response) {
                            console.log(difficulty);
                            Swal.fire({
                                title: "Congratulations!",
                                text: "You earned 10 points!",
                                icon: "success"
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = "game.php";
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }else if(difficulty === "hard"){
                    $.ajax({
                        url: "action.php",
                        type: "POST",
                        data: {action: "scoreUpdateHard"},
                        success: function (response) {
                            console.log(difficulty);
                            Swal.fire({
                                title: "Congratulations!",
                                text: "You earned 15 points!",
                                icon: "success"
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    window.location.href = "game.php";
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            }
        }
    });
        </script>';

        } else if (!$word){
            echo false;
        }
        echo $output;
    }
if(isset($_POST['action']) && $_POST['action'] == "scoreUpdateEasy") {
    $username = $_SESSION['player']['username'];
    $oldscore = $db->getScore($username);
    $score = $oldscore + 5;
    $db->updateScore($score, $username);
    $_SESSION['player']['score'] = $score;
    echo $score;
}
if(isset($_POST['action']) && $_POST['action'] == "scoreUpdateMedium") {
    $username = $_SESSION['player']['username'];
    $oldscore = $db->getScore($username);
    $score = $oldscore + 10;
    $db->updateScore($score, $username);
    $_SESSION['player']['score'] = $score;
    echo $score;
}
if(isset($_POST['action']) && $_POST['action'] == "scoreUpdateHard") {
    $username = $_SESSION['player']['username'];
    $oldscore = $db->getScore($username);
    $score = $oldscore + 15;
    $db->updateScore($score, $username);
    $_SESSION['player']['score'] = $score;
    echo $score;
}
if(isset($_POST['action']) && $_POST['action'] == "scoreUpdateLose") {
    $username = $_SESSION['player']['username'];
    $oldscore = $db->getScore($username);
    $score = $oldscore - 10;
    if ($score <=0){
        $score = 0;
    }
    $db->updateScore($score, $username);
    $_SESSION['player']['score'] = $score;
    echo $score;
}
if(isset($_POST['action']) && $_POST['action'] == "viewLeaderboard") {
    $data = $db->getPlayers();
    $output = '';
    $output .= '
    <table>
        <thead class="thead-table">
            <tr>
                <th class="position">Position</th>
                <th class="username">Username</th>
                <th class="score">Score</th>
            </tr>
        </thead>
        <tbody>';
    $i = 0;
    foreach ($data as $row){
        $i++;
        $output .= '<tr>
                        <td class="position">'.$i.'</td>
                        <td class="username">'.$row['username'].'</td>
                        <td class="score">'.$row['score'].'</td>
                    </tr>';
    }

    $output .= '</tbody></table>';
    echo $output;
}


?>