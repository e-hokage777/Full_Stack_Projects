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



// *********************** EVENT LISTENERS ***********************//
//user menu event listeners
userButton.addEventListener("click", openUserMenu);
closeUserMenuButton.addEventListener("click", closeUserMenu);

// gallery menu event listeners
galleryMenuButton.addEventListener("click", openGalleryMenu);
galleryMenuCloseButton.addEventListener("click", closeGalleryMenu);
addToGalleryButton.addEventListener("click", showUploadForm);




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