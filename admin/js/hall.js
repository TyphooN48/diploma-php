const buttonsDelHall = Array.from(document.querySelectorAll('.conf-step__button-trash'))

async function deleteHall(e) {
    e.preventDefault()
    const formHall = document.getElementById('deleteHall')
    const errP = document.getElementById('errText')

    let response = await fetch('/api/delete_hall.php', {
        method: 'POST',
        body: new FormData(formHall)
    })
    let result = await response.json()

    if (result.status) {
        errP.style.display = 'none'
        errP.innerText = ''
        popupClose()
        location.reload()
    } else {
        errP.style.display = 'block'
        errP.innerText = result.mess
    }
}

async function addHall(e) {
    e.preventDefault()
    const formHall = document.getElementById('addHall')
    const errP = document.getElementById('errText')

    let response = await fetch('/api/add_hall.php', {
        method: 'POST',
        body: new FormData(formHall)
    })
    let result = await response.json()

    if (result.status) {
        errP.style.display = 'none'
        errP.innerText = ''
        popupClose()
        location.reload()
    } else {
        errP.style.display = 'block'
        errP.innerText = result.mess
    }
}

buttonsDelHall.forEach(buttonDelHall =>
    buttonDelHall.addEventListener('click', (e) => dellHall(e)))

async function dellHall(event) {
    showPopup('deleteHall', event.target.dataset.idhall)
}