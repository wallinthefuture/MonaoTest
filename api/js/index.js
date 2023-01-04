fetch("check_auth.php").then(response=>{
    if(!response.ok){
        window.location.href="http://localhost/MongoTest/api/auth.html";
    }
})
