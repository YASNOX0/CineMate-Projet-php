<?php
session_start();

require_once('functions/Access.php');
require_once('Database/CRUDS/fUsersCrud.php');

$signInUsername = isset($_POST['sign_in_username']) ? $_POST['sign_in_username'] : "";
$signInPassword = isset($_POST['sign_in_password']) ? $_POST['sign_in_password'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$signUpUsername = isset($_POST['sign_up_username']) ? $_POST['sign_up_username'] : "";
$signUpPassword = isset($_POST['sign_up_password']) ? $_POST['sign_up_password'] : "";
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : "";
$age = isset($_POST['age']) ? $_POST['age'] : 0;

if (empty($_SESSION['state'])) {
    if (isset($_POST['sign-in'])) {
        if (!(empty($signInUsername) && empty($signInPassword))) {
            if (checkIfUserExists($signInUsername, $signInPassword)) {
                $_SESSION['username'] = $signInUsername;
                $_SESSION['state'] = true;
                session_write_close();
                header("Location: userInfos.php");
            } else {
                $signInMsg = "Username or password incorrect !!! , please re-enter your informations or sign up if you don't have an account";
            }
        }
    }
} else {
    header("Location: userInfos.php");
}

if (isset($_POST['sign-up'])) {
    if (!(empty($signUpUsername) && empty($email) && empty($signUpPassword) && empty($confirm_password) && $age == 0)) {
        if ($confirm_password === $signUpPassword) {
            if (!checkIfUserExists($signUpUsername, $signUpPassword)) {
                createUser(new User($signUpUsername, $signUpPassword,  $email, $age, "https://robohash.org/" . $signUpUsername));
                setcookie("username", $signUpUsername, time() + 86400, "/");
                setcookie("password", $signUpPassword, time() + 86400, "/");
                header("Location: log_reg.php");
            } else {
                $signUpMsg = "User already registered !!!";
            }
        } else {
            $incorrectPasswordMsg = "Incorrect password !!!";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in || Sign up from</title>
    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!--Box icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css stylesheet -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/log_reg.css">
    <script src="js/test.js" defer></script>
</head>

<body>
    <div id="bg"></div>
    <header>
        <a href="#" class="logo">
            <i class='bx bxs-movie'></i>CineMate
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!--Menu-->
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php">Movies</a></li>
            <li><a href="index.php">Coming</a></li>
            <li><a href="index.php">NewsLetteer</a></li>
        </ul>
        <a href="#" class="btn">
            Sign in <i class='bx bxs-user'></i>
        </a>
    </header>
    <section>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h1>Create Account</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your email for registration</span>
                    <span class="error-msg"><?php echo isset($signUpMsg) ? $signUpMsg : ""; ?></span>
                    <div class="infield">
                        <input type="text" placeholder="Username" name="sign_up_username" required />
                    </div>
                    <div class="infield">
                        <input type="number" min="7" max="100" placeholder="Age" name="age" required />
                    </div>
                    <div class="infield">
                        <input type="email" placeholder="Email" name="email" required />
                    </div>
                    <div class="infield">
                        <input type="password" placeholder="Password" name="sign_up_password" required />
                    </div>
                    <div class="infield">
                        <input type="password" placeholder="Confirm Password" name="confirm_password" required />
                        <span class="error-msg">
                            <?php
                            if (isset($incorrectPasswordMsg)) {
                                echo $incorrectPasswordMsg;
                                sleep(60);
                            } else {
                                echo "";
                            }
                            ?>
                        </span>
                    </div>
                    <input type="submit" class="log-reg-btn" id="sign-up" name="sign-up" value="Sign Up">
                </form>
            </div>

            //? Sign in
            <div class="form-container sign-in-container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <h1>Sign in</h1>
                    <div class="social-container">
                        <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                        <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <span>or use your account</span>
                    <span class="error-msg"><?php echo isset($signInMsg) ? $signInMsg : ""; ?></span>
                    <div class="infield">
                        <input type="text" placeholder="Username" name="sign_in_username" value="<?php echo isset($_COOKIE["username"]) ? $_COOKIE["username"] : ""; ?>" required />
                    </div>
                    <div class="infield">
                        <input type="password" placeholder="Password" name="sign_in_password" value="<?php echo isset($_COOKIE["password"]) ? $_COOKIE["password"] : ""; ?>" required />
                    </div>
                    <a href="#" class="forgot">Forgot your password?</a>
                    <input type="submit" class="log-reg-btn" id="sign-in" name="sign-in" value="Sign In">
                </form>
            </div>
            <div class="overlay-container" id="overlayCon">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please login with your personal info</p>
                        <button>Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal details and start journey with us</p>
                        <button>Sign Up</button>
                    </div>
                </div>
                <button id="overlayBtn"></button>
            </div>
        </div>
    </section>



    <!-- js code -->
    <script>
        const container = document.getElementById('container');
        const overlayCon = document.getElementById('overlayCon');
        const overlayBtn = document.getElementById('overlayBtn');

        overlayBtn.addEventListener('click', () => {
            container.classList.toggle('right-panel-active');

            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame(() => {
                overlayBtn.classList.add('btnScaled');
            })
        });
    </script>

</body>

</html>