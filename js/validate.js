var correct = document.getElementById('correct');
var pcorrect = document.getElementById('pcorrect');
var acorrect = document.getElementById('acorrect');
var pincorrect = document.getElementById('pincorrect');
var regcorrect = document.getElementById('regcorrect');
var regemailcorrect = document.getElementById('regemailcorrect');
var regemail1correct = document.getElementById('regemail1correct');
var pwcorrect = document.getElementById('pwcorrect');
var cpwcorrect = document.getElementById('cpwcorrect');
var nameError = document.getElementById('name-error');
var regnameError = document.getElementById('regname-error');
var regemailError = document.getElementById('regemail-error');
var regemail1Error = document.getElementById('regemail1-error');
var emailError = document.getElementById('email-error');
var phoneError = document.getElementById('phone-error');
var passwordError = document.getElementById('password-error');
var confirmpasswordError = document.getElementById('confirmpassword-error');
var subjectError = document.getElementById('subject-error');
var messageError = document.getElementById('message-error');
var addressError = document.getElementById('address-error');
var pinError = document.getElementById('pin-error');
var submitError = document.getElementById('submit-error');

var password_expression = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-])/;

var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

function validateName() {
    var name = document.getElementById('name').value;
    if (name.length == 0) {
        nameError.innerHTML = 'Name is required.';
        correct.innerHTML = '';
        return false;
    }

    if (!name.match(/^[a-zA-Z]+ [a-zA-Z]+$/)) {
        nameError.innerHTML = 'Please enter your full name (first and last name only). No digits are allowed.';
        correct.innerHTML = '';
        return false;
    }


    correct.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    nameError.innerHTML = '';
    return true;
}

function validateRegName() {

    var regname = document.getElementById('regname').value;

    if (regname.length == 0) {
        regnameError.innerHTML = 'Name is required.';
        regcorrect.innerHTML = '';
        return false;
    }

    if (!regname.match(/^[a-zA-Z]+ [a-zA-Z]+$/)) {
        regnameError.innerHTML = 'Please enter your full name (first and last name only). No digits are allowed.';
        regcorrect.innerHTML = '';
        return false;
    }

    regcorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    regnameError.innerHTML = '';
    return true;
}


function validatePassword() {
    var pw = document.getElementById("regpassword").value;
    //check empty password field  
    if (pw == "") {
        passwordError.innerHTML = 'Please enter a password.';
        pwcorrect.innerHTML = '';
        return false;
    }

    //minimum password length validation  
    if (pw.length < 8) {
        passwordError.innerHTML = 'Password length must be atleast 8 characters.';
        pwcorrect.innerHTML = '';
        return false;

    }

    //maximum length of password validation  
    if (pw.length > 15) {
        passwordError.innerHTML = 'Password length must not exceed 15 characters.';
        pwcorrect.innerHTML = '';
        return false;

    }
    pwcorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    passwordError.innerHTML = '';
    return true;




}

function matchPassword() {
    var pw = document.getElementById("regpassword").value;
    var pw2 = document.getElementById("confirmpassword").value;

    if (pw2 == "") {
        confirmpasswordError.innerHTML = 'Please enter the same password to confirm.';
        cpwcorrect.innerHTML = '';
        return false;
    }
    if (pw != pw2) {
        confirmpasswordError.innerHTML = 'Passwords do not match.';
        cpwcorrect.innerHTML = '';
        return false;
    }
    cpwcorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    confirmpasswordError.innerHTML = '';
    return true;

}

function validatePhone() {
    var phone = document.getElementById('phone').value;
    if (phone.length == 0) {
        phoneError.innerHTML = 'Phone number is required.';
        pcorrect.innerHTML = '';
        return false;
    }
    if (phone.length != 10) {
        phoneError.innerHTML = 'Phone number should have 10 digits.';
        pcorrect.innerHTML = '';
        return false;
    }
    if (!phone.match(/^[0-9]{10}$/)) {
        phoneError.innerHTML = 'Only digits please.';
        pcorrect.innerHTML = '';
        return false;
    }
    pcorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    phoneError.innerHTML = '';
    return true;

}

function validateEmail() {
    var email = document.getElementById('email').value;
    if (email.length == 0) {
        emailError.innerHTML = 'Email-id is required.';
        correct.innerHTML = '';
        return false;
    }
    if (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3})+$/)) {
        emailError.innerHTML = 'Email-id is invalid.';
        correct.innerHTML = '';
        return false;
    }
    if (!filter.test(email)) {
        emailError.innerHTML = 'Email-id is invalid.';
        correct.innerHTML = '';
        return false;
    }
    correct.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    emailError.innerHTML = '';
    return true;

}

function validateRegEmail1() {
    var regemail = document.getElementById('regemail1').value;
    if (regemail1.length == 0) {
        regemail1Error.innerHTML = 'Email-id is required.';
        regemail1correct.innerHTML = '';
        return false;
    }
    if (!regemail1.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3})+$/)) {
        regemail1Error.innerHTML = 'Email-id is invalid.';
        regemail1correct.innerHTML = '';
        return false;
    }
    if (!filter.test(regemail1)) {
        regemail1Error.innerHTML = 'Email-id is invalid.';
        regemail1correct.innerHTML = '';
        return false;
    }
    regemail1correct.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    regemail1Error.innerHTML = '';
    return true;

}

function validateRegEmail() {
    var regemail = document.getElementById('regemail').value;
    if (regemail.length == 0) {
        regemailError.innerHTML = 'Email-id is required.';
        regemailcorrect.innerHTML = '';
        return false;
    }
    if (!regemail.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3})+$/)) {
        regemailError.innerHTML = 'Email-id is invalid.';
        regemailcorrect.innerHTML = '';
        return false;
    }
    if (!filter.test(regemail)) {
        regemailError.innerHTML = 'Email-id is invalid.';
        regemailcorrect.innerHTML = '';
        return false;
    }
    regemailcorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    regemailError.innerHTML = '';
    return true;

}

function validateSubject() {
    var subject = document.getElementById('subject').value;
    var required = 10;
    var left = required - subject.length;
    if (subject.length == 0) {
        subjectError.innerHTML = 'Subject is required.';

        return false;
    }
    if (left > 0) {
        subjectError.innerHTML = left + ' more characters required.';
        return false;
    }

    subjectError.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    return true;
}

function validateMessage() {
    var message = document.getElementById('message').value;
    var required = 30;
    var left = required - message.length;
    if (message.length == 0) {
        messageError.innerHTML = 'Message is required.';

        return false;
    }
    if (left > 0) {
        messageError.innerHTML = left + ' more characters required.';
        return false;
    }

    messageError.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    return true;
}

function validateAddress() {
    var address = document.getElementById('address').value;
    var required = 30;
    var left = required - address.length;
    if (address.length == 0) {
        addressError.innerHTML = 'Address is required.';
        acorrect.innerHTML = '';
        return false;
    }
    if (left > 0) {
        addressError.innerHTML = left + ' more characters required. Please enter your full address.';
        acorrect.innerHTML = '';
        return false;
    }
    acorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    addressError.innerHTML = '';
    return true;
}

function validatePincode() {
    var pin = document.getElementById('pincode').value;

    if (pin.length == 0) {
        pinError.innerHTML = 'Pincode is required.';
        pincorrect.innerHTML = '';
        return false;
    }
    if (!pin.match(/^[1-9]{1}[0-9]{2}\s{0,1}[0-9]{3}$/)) {
        pinError.innerHTML = 'Pincode is invalid.';
        pincorrect.innerHTML = '';
        return false;
    }
    pincorrect.innerHTML = '<i class="fa fa-check-circle" aria-hidden="true"></i>';
    pinError.innerHTML = '';
    return true;

}

function validateForm() {

    if (!validateName() || !validateEmail() || !validateMessage()) {
        submitError.style.display = 'block';
        submitError.innerHTML = 'Please correct the displayed errors to submit.';
        setTimeout(function() { submitError.style.display = 'none'; }, 3000);
        return false;
    }
    submitError.innerHTML = window.location.href = "<?= BASE_URL ?>pages/contactmail.php";
    return true;
}

function validateForm2() {

    if (!validateName() || !validateRegEmail() || !validatePhone() || !validateAddress() || !validatePincode()) {
        submitError.style.display = 'block';
        submitError.innerHTML = 'Please correct the displayed errors to submit.';
        setTimeout(function() { submitError.style.display = 'none'; }, 3000);
        return false;
    }
    return true;
}

function validateForm3() {

    if (!validateName() || !validateRegEmail() || !validatePhone() || !validateAddress() || !validatePincode()) {
        submitError.style.display = 'block';
        submitError.innerHTML = 'Please correct the displayed errors to submit.';
        setTimeout(function() { submitError.style.display = 'none'; }, 3000);
        return false;
    }
    submitError.innerHTML = window.location.href = "<?= BASE_URL ?>pages/updateaddress.php";
    return true;
}

function validateForm4() {

    if (!validateName() || !validateRegEmail() || !validatePhone() || !validateAddress() || !validatePincode()) {
        submitError.style.display = 'block';
        submitError.innerHTML = 'Please correct the displayed errors to submit.';
        setTimeout(function() { submitError.style.display = 'none'; }, 3000);
        return false;
    }
    submitError.innerHTML = window.location.href = "<?= BASE_URL ?>pages/addaddress.php";
    return true;
}