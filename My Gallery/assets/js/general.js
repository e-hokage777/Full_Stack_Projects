/**************************************** MORE GENERAL FUNCTIONS  ******************************************/
// function to make a request
function request(url, data, callback, method = "post") {
  let xttp = new XMLHttpRequest();
  // creating a loader
  const loader = document.createElement("div");
  loader.innerText = "Please wait";
  loader.classList.add("loader_half_circles");
  document.body.append(loader);
  xttp.open(method, url);
  xttp.onreadystatechange = function () {
    if (xttp.readyState === 4 && xttp.status === 200) {
      callback(xttp.response);
    }

    loader.remove();
  };
  xttp.send(data);
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

/**************************************** COMPONENT SPECIFIC STYLES  ******************************************/
// SELECTORS
const fullScreenContainer = document.querySelector(".full-screen-container");

// EVENT LISTENERS
if (fullScreenContainer) {
  fullScreenContainer.addEventListener("click", function (event) {
    this.classList.remove("active");
  });
}
