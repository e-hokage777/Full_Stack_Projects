// function to make a request
function request(url, data, callback, method="post"){
    let xttp = new XMLHttpRequest();
    // creating a loader
    const loader = document.createElement("div");
    loader.innerText = "Please wait";
    loader.classList.add("loader_half_circles");
    document.body.append(loader);
    xttp.open(method, url);
    xttp.onreadystatechange = function(){
        if(xttp.readyState === 4 && xttp.status === 200){
            callback(xttp.response);
        }

        loader.remove();
    }
    xttp.send(data);
}



/**************************************** COMPONENT SPECIFIC STYLES  ******************************************/
// SELECTORS
const fullScreenContainer = document.querySelector(".full-screen-container");


// EVENT LISTENERS
fullScreenContainer.addEventListener("click", function(event){
    this.classList.remove("active");
});