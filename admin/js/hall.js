const buttonsDelHall = Array.from(document.querySelectorAll('.delete_hall'))
const text = '<p class="conf-step__paragraph">Всё готово, теперь можно:</p>'
const statusDiv = document.getElementById('hallStatusDiv')
const errSH = document.getElementById('errStatusHall')
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

async function getHallStatus(e) {
    const hallID = e.target.value
    if (hallID != null) {
        statusDiv.innerText = ''
        let formData = new FormData();
        formData.append('hallID', hallID);
        formData.append('type', 'get');

        let response = await fetch('/api/status_hall.php', {
            method: 'POST',
            body: formData
        })
        let result = await response.json()

        if (result.status) {
            errSH.innerText = ''
            errSH.style.display = 'none'
            let btn = ''
            if(result.data == true)
                btn = '<button class="conf-step__button conf-step__button-accent" onclick="setHallStatus(' + hallID + ', 0)">Приостановить продажу билетов</button>'
            else
                btn = '<button class="conf-step__button conf-step__button-accent" onclick="setHallStatus(' + hallID + ', 1)">Открыть продажу билетов</button>'
            statusDiv.innerHTML = text + btn
        } else {
            errSH.innerText = result.mess
            errPSC.style.display = 'block'
        }
    }
}

async function setHallStatus(hallID, status){
    let formData = new FormData();
    formData.append('hallID', hallID);
    formData.append('status', status);
    formData.append('type', 'set');

    let response = await fetch('/api/status_hall.php', {
        method: 'POST',
        body: formData
    })
    let result = await response.json()

    if (result.status) {
        errSH.innerText = ''
        errSH.style.display = 'none'
        let btn = ''
        if(status == 1)
            btn = '<button class="conf-step__button conf-step__button-accent" onclick="setHallStatus(' + hallID + ', 0)">Приостановить продажу билетов</button>'
        else
            btn = '<button class="conf-step__button conf-step__button-accent" onclick="setHallStatus(' + hallID + ', 1)">Открыть продажу билетов</button>'
        statusDiv.innerHTML = text + btn
    } else {
        errSH.innerText = result.mess
        errPSC.style.display = 'block'
    }
}

document.querySelectorAll("input[name='start-hall']")
    .forEach(inp => inp.addEventListener('change', (e) => {
        getHallStatus(e)
    }))