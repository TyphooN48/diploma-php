async function showPopup(popupType) {
    let formData = new FormData();
    formData.append('type', popupType);
    let response = await fetch('/api/popup.php', {
        method: 'POST',
        body: formData
    })
    let result = await response.json()

    if(result.status) {
        document.body.insertAdjacentHTML("afterbegin", result.data);
        const buttonClose = document.querySelector('.popup__dismiss');
        buttonClose.addEventListener('click', popupClose);
        const buttonCancel = document.querySelector('.conf-step__button-regular');
        buttonCancel.addEventListener('click', popupClose);
    } else {
        console.log(result.data)
    }
}

function popupClose() {
    const popup = document.querySelector('.popup');
    popup.classList.toggle('active');
    popup.remove();
}

const showPopupButton = ['addHall']

showPopupButton.forEach(btn => {
    document.getElementById(btn).addEventListener('click', (e) => {showPopup(btn)})
})