/** This script handles user authentication **/

// SELECTORS
const signupForm = document.querySelector("#signup-form");
const loginForm = document.querySelector("#login-form");

// EVENT LISTENERS
if (signupForm) {
  signupForm.addEventListener("submit", register);
}
if (loginForm) {
  signupForm.addEventListener("submit", login);
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
    if (response.length) {
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
    default:
      message = "An unexpected error occured, please contact support";
      errorFieldId = "general-error";
  }

  displayError(message, errorFieldId, formField);
  formInputShake(formField);
}

/**
 * function to display errors to user
 * @param string message the error message
 * @param string id the id of the element to display errors message in
 * @param string inputField the input field where the error occured
 */
function displayError(message, id, inputField) {
  let errorField = document.getElementById(id);
  errorField.innerText = message;
  errorField.style.display = "block";
}

/**
 * function to shake form input field with error
 * @param string selector Selector for form field to be passed into querySelector function
 * @return null
 */
function formInputShake(selector) {
  document.querySelector(selector).classList.add("field-shake");
  document.querySelector(selector).addEventListener("animationend", function(event){
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

  document.querySelectorAll(".success-field").forEach(function(element){
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
