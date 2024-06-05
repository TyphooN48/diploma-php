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