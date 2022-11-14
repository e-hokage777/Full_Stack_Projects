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
  request(
    "../authenticate/register_user.php",
    formData,
    function (response) {
      console.log(response);
    }
  );
}
