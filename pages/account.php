<?php include __DIR__ . '/../partials-front/menu.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/login_register.php';
?>

<!--alert messages start-->
<?php echo $alert;
?>

<div class="form">
    <div class="form-container sign-in-form">
        <div class="form-box sign-in-box">
            <h2>Log in</h2>
            <form action="" method="POST" action="<?= BASE_URL ?>pages/login_register.php">
                <div class="field">
                    <i class="uil uil-at"></i>
                    <input type="email" id="email" placeholder="Email Id"name="emailid" onkeyup="validateEmail()">
                    <span id="correct"></span>

                </div>
               <div class="msg"> <span id="email-error"></span></div>
                <div class="field">
                    <i class="uil uil-lock-alt"></i>
                    <input type="password" id="password" class='password-input' placeholder="Password"  required name="password">
                    <div class="eye-btn"><i class="uil uil-eye-slash"></i></div>

                </div>
         
                <div class="forgot-link">
                    <a href="<?= BASE_URL ?>pages/resetpassword.php">Forgot your password?</a>
                </div>
                 <input class="submit-btn" type="submit" value="Log in" name="login">
            </form>
        </div>
        <div class="imgBox sign-in-imgBox">
            <div class="sliding-link">
                <p>Don't have an account?</p>
                <span class="sign-up-btn">Sign Up!</span>
            </div>
            <img src="<?= BASE_URL ?>images/login.png" alt="">
        </div>
    </div>
    <div class="form-container sign-up-form">
        <div class="imgBox sign-up-imgBox">
            <div class="sliding-link">
                <p>Already have an account?</p>
                <span class="sign-in-btn">Log in!</span>
            </div>
            <img src="<?= BASE_URL ?>images/register.png" alt="">
        </div>
        <div class="form-box sign-up-box">
            <h2>Sign up!</h2>
            <form action="" method="POST" action="<?= BASE_URL ?>pages/login_register.php">
                <div class="field">
                    <i class="uil uil-user"></i>
                    <input type="text" placeholder="Full Name" id="regname" name="fullname" onkeyup="validateRegName()">
                    <span id="regcorrect"></span>
                </div>
                <div  class="msg"><span id="regname-error"></span></div>
                <div class="field">
                    <i class="uil uil-at"></i>
                    <input type="email" id="regemail" placeholder="Email Id" name="emailid" onkeyup="validateRegEmail1()">
                    <span id="regemail1correct"></span>
                </div>
               <div class="msg"> <span id="regemail1-error"></span></div>
               
                <div class="field">
                    <i class="uil uil-lock-alt"></i>
                    <input type="password" id="regpassword" placeholder="Password" name="password"  onkeyup="validatePassword()">
                    <span id="pwcorrect"></span>
                </div>
                <div class="msg"><span id="password-error"></span></div>
                <div class="field">
                    <i class="uil uil-lock-access"></i>
                    <input type="password" id="confirmpassword" placeholder="Confirm Password"  name="confirmpassword" onkeyup="matchPassword()">
                    <span id="cpwcorrect"></span>
                </div>
              <div class="msg">  <span id="confirmpassword-error"></span></div>
                <input class='submit-btn' type="submit" value="Sign up" name="register">
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!---JS for Toggle Menu-->

<script src="<?= BASE_URL ?>js/validate.js"></script>
<script>
    //input fields
    const textInputs = document.querySelectorAll("input");

    textInputs.forEach(textInput => {
        textInput.addEventListener("focus", () => {
            let parent = textInput.parentNode;
            parent.classList.add("active");
        });

        textInput.addEventListener("blur", () => {
            let parent = textInput.parentNode;
            parent.classList.remove("active");
        });
    });
    //password show/hide
    const passwordInput = document.querySelector(".password-input");
    const eyeBtn = document.querySelector(".eye-btn");

    eyeBtn.addEventListener("click", () => {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeBtn.innerHTML = "<i class='uil uil-eye'></i>";
        } else {
            passwordInput.type = "password";
            eyeBtn.innerHTML = "<i class='uil uil-eye-slash'></i>";
        }
    })
    //sliding between sign-in and sign-out form
    const signUpBtn = document.querySelector(".sign-up-btn");
    const signInBtn = document.querySelector(".sign-in-btn");
    const signUpForm = document.querySelector(".sign-up-form");
    const signInForm = document.querySelector(".sign-in-form");

    signUpBtn.addEventListener("click", () => {
        signInForm.classList.add("hide");
        signUpForm.classList.add("show");
        signInForm.classList.remove("show");
    });

    signInBtn.addEventListener("click", () => {
        signInForm.classList.remove("hide");
        signUpForm.classList.remove("show");
        signInForm.classList.add("show");
    });
</script>

<?php include __DIR__ . '/../partials-front/footer.php'; ?>