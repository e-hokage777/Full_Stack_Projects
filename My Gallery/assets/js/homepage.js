// *********************** SELECTORS *********************** //
// user menu selectors
const userButton = document.getElementById("user-button");
const closeUserMenuButton = document.querySelector(".close-user-menu");
const userMenu = document.querySelector(".user-menu");

// gallery menu selectors
const galleryMenuButton = document.getElementById("gallery-menu-button");
const galleryMenu = document.querySelector(".gallery-menu");
const galleryMenuCloseButton = document.querySelector(".close-gallery-menu");
const addToGalleryButton = document.querySelector(".add-to-gallery");

// gallery forms
const addToGalleryForm = document.getElementById("upload-form");
const itemDeleteForms = document.querySelectorAll(".gallery-item-delete-form");

// gallery item selectors
const galleryImgContainers = document.querySelectorAll(".gallery-img-container");

// art display 
const artDisplay = document.getElementById("art-display");





// *********************** EVENT LISTENERS ***********************//
//user menu event listeners
userButton.addEventListener("click", openUserMenu);
closeUserMenuButton.addEventListener("click", closeUserMenu);

// gallery menu event listeners
galleryMenuButton.addEventListener("click", openGalleryMenu);
galleryMenuCloseButton.addEventListener("click", closeGalleryMenu);
addToGalleryButton.addEventListener("click", showUploadForm);

// add to gallery form event listener
addToGalleryForm.addEventListener("submit", addToGallery);
// stopping the click event from propagating to element's container
addToGalleryForm.addEventListener("click", (event) => {event.stopPropagation();});

// adding event listeners to item delete forms
itemDeleteForms.forEach(function(form){
  form.addEventListener("submit", deleteGalleryItem);
});


// adding event listener to gallery image container
galleryImgContainers.forEach(function(galleryImgContainer){
  galleryImgContainer.addEventListener("click", expandArt);
});

// event listener to art display
artDisplay.addEventListener("click", function (event) {
  if(event.target.id === "art-display"){
    this.classList.remove("active");
  }
});



// *********************** FUNCTIONS ***********************//
// user menu functions
function openUserMenu(event){
    userMenu.classList.add("open");
}
function closeUserMenu(event){
    userMenu.classList.remove("open");
}

//gallery menu functions
function openGalleryMenu(event){
    galleryMenu.classList.add("open");
}
function closeGalleryMenu(event){
    galleryMenu.classList.remove("open");
}
function showUploadForm(event){
    document.querySelector(".full-screen-container").classList.add("active");
}

// function to upload to gallery
function addToGallery(event){
    event.preventDefault();
    let formData = new FormData(event.target);
    request("../user_operations/add_to_gallery.php", formData, (response) => {
        removeMessages(); // removing all messages
        console.log(response);
        response = JSON.parse(response);

        if(response.length !== 0){
            for(let error of response){
                upload_warn(error);
            }
        }
        else{
            displaySuccessMessage(".success-field");
            window.location.reload();
        }
    })
}

/**
 * function to return warnings when trying to send verification email
 * @param errorcode a warning error code
 * @return null
 */
 function upload_warn(errorCode) {
    let errorFieldId = null;
    let message = null;
  
    switch (errorCode) {
      case 1:
        message = "Invalid CSRF token";
        errorFieldId = "general-error";
        break;
      case 2:
        message = "No file selected";
        errorFieldId = "general-error";
        break;
      case 3:
        message = "No file selected"; // occurs when $_FILES["filename"]["error"] === 4
        errorFieldId = "general-error";
        break;
      case 4:
        message = "File size too large, file must be under 10MB";
        errorFieldId = "general-error";
        break;
      case 5:
        message =
          "Invalid file type, file must be a png or jpeg";
        errorFieldId = "general-error";
        break;
      case 6:
        message = "user not found in database, please contact support";
        errorFieldId = "general-error";
        break;
      case 7:
        message =
          "Error saving file in storage, please contact support";
        errorFieldId = "general-error";
        break;
      case 8:
        message =
          "Error saving art information in database";
        errorFieldId = "general-error";
        break;
      default:
        message = "An unexpected error occured, please contact support";
        errorFieldId = "general-error";
    }
  
    displayError(message, errorFieldId);
  }


/**
 * function to delete gallery item
 * @return null
 */
function deleteGalleryItem(event){
  event.preventDefault();
  let formData = new FormData(event.target);
  request("../user_operations/delete_gallery_item.php", formData, (response)=>{
    console.log(response);
    response = parseInt(response);

    if(response === 0){
      window.location.reload();
    }
  });
}

/**
 * function to expand gallery art item
 * @param event the click event
 * @return null
 */
function expandArt(event){
  let image = this.querySelector("img");
  let title = this.parentElement.querySelector(".art-title").innerText;
  let desc = this.parentElement.querySelector(".art-desc").innerText;

  let artDisplayImg = artDisplay.querySelector("img");
  let artDisplayTitle = artDisplay.querySelector(".title");
  let artDisplayDesc = artDisplay.querySelector(".desc");

  artDisplayImg.src = image.src;
  artDisplayTitle.innerText = title;
  artDisplayDesc.innerText = desc;

  artDisplay.classList.add("active");
}
