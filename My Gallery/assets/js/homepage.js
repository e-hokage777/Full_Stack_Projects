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

// add to gallery form
const addToGalleryForm = document.getElementById("upload-form");



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
        console.log(response);
    })
}