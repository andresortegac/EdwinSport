console.log("JS cargado correctamente");

document.getElementById("passwordForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let pass = document.getElementById("passwordInput").value;
    let errorMsg = document.getElementById("errorMsg");
    let modalContent = document.querySelector(".modal-content");

    errorMsg.classList.add("d-none");

    if (pass === "admin123") {
        closeModalAndRedirect("/login");
    }
    else if (pass === "user123") {
        closeModalAndRedirect("/usuario-panel");
    }
    else {
        errorMsg.classList.remove("d-none");

        modalContent.classList.remove("shake");
        void modalContent.offsetWidth;
        modalContent.classList.add("shake");
    }
});

function closeModalAndRedirect(url) {
    let modal = document.querySelector(".modal-content");

    modal.classList.add("fade-out");

    setTimeout(() => {
        let bsModal = bootstrap.Modal.getInstance(document.getElementById("passwordModal"));
        bsModal.hide();

        setTimeout(() => {
            window.location.href = url;
        }, 300);

    }, 300);
}
