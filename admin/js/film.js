const buttonsDelFilm = Array.from(document.querySelectorAll('.conf-step__button-trash'))

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

async function addFilm(e) {
    e.preventDefault()
    const formFilm = document.getElementById('addFilm')
    const errP = document.getElementById('errTextFilm')

    let response = await fetch('/api/add_film.php', {
        method: 'POST',
        body: new FormData(formFilm)
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

function addFilmGrid(e) {
    let filmID
    if (e.target.dataset.filmid)
        filmID = e.target.dataset.filmid
    else
        filmID = e.target.parentElement.dataset.filmid
    showPopup('addFilmInGid', filmID)
}

async function setFilmGrid(e) {
    e.preventDefault()
    const formGrid = document.getElementById('setFilmGrid')
    const errP = document.getElementById('errTextGrid')

    let response = await fetch('/api/add_grid.php', {
        method: 'POST',
        body: new FormData(formGrid)
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

Array.from(document.querySelectorAll('div.conf-step__movie'))
    .forEach(film => {
        film.addEventListener('click', (e) => addFilmGrid(e))
    })

/*buttonsDelHall.forEach(buttonDelHall =>
    buttonDelHall.addEventListener('click', (e) => dellHall(e)))*/

/*async function dellHall(event) {
    showPopup('deleteHall', event.target.dataset.idhall)
}*/