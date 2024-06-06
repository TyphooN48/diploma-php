async function showPopup(popupType, id) {
    let formData = new FormData();
    switch (popupType) {
        case 'deleteHall':
            formData.append('hallID', id);
            break
        case 'addFilmInGid':
            formData.append('filmID', id);
            break
        case 'addHallBtn':
            popupType = 'addHall'
            break
        case 'addFilmBtn':
            popupType = 'addFilm'
            break
    }
    formData.append('type', popupType);
    let response = await fetch('/api/popup.php', {
        method: 'POST',
        body: formData
    })
    let result = await response.json()

    if (result.status) {
        document.body.insertAdjacentHTML("afterbegin", result.data);
        const buttonClose = document.querySelector('.popup__dismiss');
        buttonClose.addEventListener('click', popupClose);
        const buttonCancel = document.querySelector('.conf-step__button-regular');
        buttonCancel.addEventListener('click', popupClose);
        if (popupType == 'addHall') {
            const buttonAdd = document.querySelector('.conf-step__button-accent');
            buttonAdd.addEventListener('click', addHall);
        }
        if (popupType == 'deleteHall') {
            const buttonAdd = document.querySelector('.conf-step__button-accent');
            buttonAdd.addEventListener('click', deleteHall);
        }
        if (popupType == 'addFilm') {
            const buttonAdd = document.querySelector('.conf-step__button-accent');
            buttonAdd.addEventListener('click', addFilm);
        }
        if (popupType == 'addFilmInGid') {
            const buttonAdd = document.querySelector('.conf-step__button-accent');
            buttonAdd.addEventListener('click', setFilmGrid);
        }
    } else {
        console.log(result.data)
    }
}

function popupClose() {
    const popup = document.querySelector('.popup');
    popup.classList.toggle('active');
    popup.remove();
}

const showPopupButton = ['addHallBtn', 'addFilmBtn']

showPopupButton.forEach(btn => {
    document.getElementById(btn).addEventListener('click', (e) => {
        showPopup(btn, null)
    })
})