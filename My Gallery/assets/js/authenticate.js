/** This script handles user authentication **/

// SELECTORS
const signupForm = document.getElementById("signup-form");
const loginForm = document.getElementById("login-form");
const verificationForm = document.getElementById("verification-form");

// EVENT LISTENERS
if (signupForm) {
  signupForm.addEventListener("submit", register);
}
if (loginForm) {
  loginForm.addEventListener("submit", login);
}
if (verificationForm) {
  verificationForm.addEventListener("submit", sendVerificationEmail);
}

/**
 * function to register user
 * @param event a submit event of the form element
 */
function register(event) {
  event.preventDefault();
  let formData = new FormData(event.target);
  request("../authenticate/register_user.php", formData, function (response) {
    removeMessages(); // removing all messages
    response = JSON.parse(response);
    if (response.length !== 0) {
      response.forEach(function (errorCode) {
        warn(errorCode);
      });
    } else {
      displaySuccessMessage(".success-field");
    }
  });
}

/**
 * function to handle error codes received from register requst
 * @param errorCode int list of registration error codes
 */
function warn(errorCode) {
  let formField = null;
  let errorFieldId = null;
  let message = null;

  switch (errorCode) {
    case 1:
      message = "Invalid CSRF token";
      errorFieldId = "general-error";
      break;
    case 2:
      message = "Username invalid. Username can contain only letters";
      errorFieldId = "username-error-field";
      formField = "input[name='username']";
      break;
    case 3:
      message = "Email invalid. Email must be of the format example@domain.com";
      errorFieldId = "email-error-field";
      formField = "input[name='email']";
      break;
    case 4:
      message = "Email domain does not exist";
      errorFieldId = "email-error-field";
      formField = "input[name='email']";
      break;
    case 5:
      message =
        "Password must be more done 8 characters and must contain at least of, a lowercase letter, an uppercase letter, a number and a special character";
      errorFieldId = "password-error-field";
      formField = "input[name='password']";
      break;
    case 6:
      message = "Passwords must match";
      errorFieldId = "confirm-password-error-field";
      formField = "input[name='confirm-password']";
      break;
    case 7:
      message = "Email given is already being used";
      errorFieldId = "email-error-field";
      formField = "input[name='email']";
      break;
    case 8:
      message = "An unexpected error occured, please contact support";
      errorFieldId = "general-error";
      break;
    case 9:
      message = "No such email address exists";
      errorFieldId = "general-error";
      break;
    case 10:
      message = "Account is already active";
      errorFieldId = "general-error";
      break;
    case 11:
      message =
        "Maximum limit for account verification requests per day reached, Please try again after 24 hours";
      errorFieldId = "general-error";
      break;
    case 12:
      message = "Error making request, please contact support";
      errorFieldId = "general-error";
      break;
    case 13:
      message =
        "Error sending verification email to email account, please contact support";
      errorFieldId = "general-error";
      break;
    default:
      message = "An unexpected error occured, please contact support";
      errorFieldId = "general-error";
  }

  displayError(message, errorFieldId);

  if (formField) {
    formInputShake(formField);
  }
}

/**
 * function to display errors to user
 * @param string message the error message
 * @param string id the id of the element to display errors message in
 * @param string inputField the input field where the error occured
 */
function displayError(message, id, html = false) {
  let errorField = document.getElementById(id);
  if (html) {
    errorField.innerHTML = message;
  } else {
    errorField.innerText = message;
  }

  errorField.style.display = "block";
}

/**
 * function to shake form input field with error
 * @param string selector Selector for form field to be passed into querySelector function
 * @return null
 */
function formInputShake(selector) {
  document.querySelector(selector).classList.add("field-shake");
  document
    .querySelector(selector)
    .addEventListener("animationend", function (event) {
      this.classList.remove("field-shake");
    });
}

/**
 * function to remove all messages and shaking class from form input fields
 * @return null
 */
function removeMessages() {
  let errorFields = document.querySelectorAll(".error-field");
  errorFields.forEach(function (errorField) {
    errorField.style.display = "none";
  });

  document.querySelectorAll(".success-field").forEach(function (element) {
    element.style.display = "none";
  });
}

/**
 * function to display success message
 * @param string selector. Selector for element that displays success message
 * @return null
 */
function displaySuccessMessage(selector) {
  document.querySelector(selector).style.display = "block";
}

/**
 * function to send verification email to user's email account
 * @param event|sumbit_event
 * @return null
 */
function sendVerificationEmail(event) {
  event.preventDefault();
  let formData = new FormData(event.target);
  request("../authenticate/verify_user.php", formData, function (response) {
    removeMessages(); // removing all messages
    console.log(response);
    response = JSON.parse(response);
    if (response !== 0) {
      verification_warn(response);
    } else {
      displaySuccessMessage(".success-field");
    }
  });
}

/**
 * function to return warnings when trying to send verification email
 * @param errorcode a warning error code
 * @return null
 */
function verification_warn(errorCode) {
  let errorFieldId = null;
  let message = null;

  switch (errorCode) {
    case 1:
      message = "Invalid CSRF token";
      errorFieldId = "general-error";
      break;
    case 2:
      message = "Please enter a valid email address";
      errorFieldId = "general-error";
      break;
    case 3:
      message = "No such email address exists";
      errorFieldId = "general-error";
      break;
    case 4:
      message = "Account is already active";
      errorFieldId = "general-error";
      break;
    case 5:
      message =
        "Maximum limit for account verification requests per day reached, Please try again after 24 hours";
      errorFieldId = "general-error";
      break;
    case 6:
      message = "Error making request, please contact support";
      errorFieldId = "general-error";
      break;
    case 7:
      message =
        "Error sending verification email to email account, please contact support";
      errorFieldId = "general-error";
      break;
    default:
      message = "An unexpected error occured, please contact support";
      errorFieldId = "general-error";
  }

  displayError(message, errorFieldId);
}

/**
 * function to log user in
 * @param event a submit event
 * @return null
 */
function login(event) {
  event.preventDefault();
  let formData = new FormData(event.target);
  request("../authenticate/log_user_in.php", formData, (response) => {
    removeMessages();
    response = JSON.parse(response);

    if (response.length !== 0) {
      login_warn(response);
    } else {
      displaySuccessMessage(".success-field");
      window.location.assign("./homepage.php");
    }
  });
}

/**
 * function to handle error codes received from register requst
 * @param errorCode int list of registration error codes
 */
function login_warn(errorCodes) {
  // switch (errorCode) {
  //   case 1:
  //     message = "Invalid CSRF token";
  //     errorFieldId = "general-error";
  //     break;
  //   case 2:
  //     message = "Email invalid. Email must be of the format example@domain.com";
  //     errorFieldId = "email-error-field";
  //     formField = "input[name='email']";
  //     break;
  //   case 3:
  //     message = "Email domain does not exist";
  //     errorFieldId = "email-error-field";
  //     formField = "input[name='email']";
  //     break;
  //   case 4:
  //     message =
  //       "Incorrect password";
  //     errorFieldId = "password-error-field";
  //     formField = "input[name='password']";
  //     break;
  //   case 5:
  //     message = "No account with given email exists";
  //     errorFieldId = "email-error-field";
  //     formField = "input[name='email']";
  //     break;
  //   case 6:
  //     message = "Invalid password";
  //     errorFieldId = "password-error-field";
  //     formField = "input[name='password']";
  //     break;
  //   case 7:
  //     message = "Account Inactive";
  //     errorFieldId = "general-error";
  //     break;
  //   default:
  //     message = "An unexpected error occured, please contact support";
  //     errorFieldId = "general-error";
  // }
  console.log(errorCodes);
  if (errorCodes[0] === 7) {
    displayError(
      "Account not verified, click <a target='_blank' href='verify_account.php'>here</a> to verify account",
      "general-error",
      true
    );
  } else {
    displayError("Invalid username or password", "general-error");
  }

  formInputShake("input[name='email']");
  formInputShake("input[name='password']");
}
