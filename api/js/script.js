document.addEventListener("DOMContentLoaded", () => {

    const ajaxSend = (formData) => {
        fetch("create_user.php", { // файл-обработчик
            method: "POST",
            headers: {
                "Content-Type": "application/json", // отправляемые данные
            },
            body: JSON.stringify(formData)
        }).then(response => response.json())
            .then(messages=>alert(messages['message']))
            .catch(error => console.error(error))
    };

    if (document.getElementsByTagName("form")) {
        const forms = document.getElementsByTagName("form");

        for (let i = 0; i < forms.length; i++) {
            forms[i].addEventListener("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData = Object.fromEntries(formData);
                console.log(formData);
                ajaxSend(formData);
            });
        };
    }
});