const buttonsDelFilm = Array.from(document.querySelectorAll('.delete-film'))
const buttonsDelSeance = Array.from(document.querySelectorAll('.delete-seance'))
const filmsGridElement = Array.from(document.querySelectorAll('.conf-step__seances-movie'))

async function deleteFilm(e) {
    e.preventDefault()
    const formFilm = document.getElementById('daleteFilm')
    const errP = document.getElementById('errTextDelFilm')

    let response = await fetch('/api/delete_film.php', {
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

async function deleteSeance(e) {
    e.preventDefault()
    const formSeance = document.getElementById('deleteSeance')
    const errP = document.getElementById('errTextDelSeance')

    let response = await fetch('/api/delete_seance.php', {
        method: 'POST',
        body: new FormData(formSeance)
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
        if(!e.target.classList.contains('delete-film'))
            filmID = e.target.parentElement.dataset.filmid
        else
            return;
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

function setColour(gridFilm) {
    const filmList = Array.from(document.querySelectorAll('.conf-step__movie'))
    const gridFilmID = gridFilm.dataset.filmid
    const colour = window.getComputedStyle(filmList.find(film => film.dataset.filmid == gridFilmID)).backgroundColor
    gridFilm.style.backgroundColor = colour
}

buttonsDelFilm.forEach(buttonDel =>
    buttonDel.addEventListener('click',
        (e) => showPopup('deleteFilm', e.target.dataset.idfilm)))
buttonsDelSeance.forEach(buttonDel =>
    buttonDel.addEventListener('click',
        (e) => showPopup('deleteSeance', e.target.dataset.idseance)))

filmsGridElement.forEach(gridFilm => setColour(gridFilm))