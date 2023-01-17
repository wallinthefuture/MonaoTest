document.addEventListener("DOMContentLoaded", () => {

    const button = document.querySelector("button");

    fetch("check_auth.php").then(response => {
        if (!response.ok) {
            window.location.href = "../../api/auth.html";
        } else {
            response.json().then(name => {
                const Message = document.createElement('div');
                Message.innerHTML = `
        <div >Hello ${name}</div>
    `
                button.insertAdjacentElement('beforebegin', Message);
            });
        }
    })

    button.addEventListener("click", function (e) {
        fetch("logout.php").then(response => {
            if (response.ok) {
                window.location.href = "../../api/auth.html"
            }
        })
    })

})