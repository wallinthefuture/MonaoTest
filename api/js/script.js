document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");
    const button = document.querySelector("button")

    async function ajaxSend(formData) {

        let response = await fetch("create_user.php", { // файл-обработчик
            method: "POST", headers: {
                "Content-Type": "application/json", // отправляемые данные
            }, body: JSON.stringify(formData)
        })
        if (response.ok) {
            window.location.replace("http://localhost/MongoTest/api/auth.html");
        }
        let result = response.json();
        result.then(message => {
            const errorMessage = document.createElement('div');
            errorMessage.classList.add('error__message');
            errorMessage.innerHTML = `
        <div class = "modal__title">${message["message"]}</div>
    `
            button.insertAdjacentElement('beforebegin', errorMessage);
        });
    }

    forms.forEach((item) => {
        bindpostData(item);
    });

    function bindpostData(form) {

        form.addEventListener("submit", function (e) {
            const errorMessage = document.querySelector('.error__message');
            if(errorMessage){
                errorMessage.remove();
            }
            e.preventDefault();

            let formData = new FormData(this);
            formData = Object.fromEntries(formData);
            ajaxSend(formData).then(response => {

            });
        })
    }

});