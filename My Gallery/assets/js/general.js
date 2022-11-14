// function to make a request
function request(url, data, callback, method="post"){
    let xttp = new XMLHttpRequest();
    xttp.open(method, url);
    xttp.onreadystatechange = function(){
        if(xttp.readyState === 4 && xttp.status === 200){
            callback(xttp.response);
        }
    }
    xttp.send(data);
}