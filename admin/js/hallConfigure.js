const inpRows = document.getElementById('hallRows')
const inpRowPlaces = document.getElementById('hallRowPlaces')
const gridDiv = document.getElementById('hallGrid')
const saveGridBtn = document.getElementById('saveGrid')
const errPHC = document.getElementById('gridError')
const canselGridBtn = document.getElementById('canselGrid')
const divSaveHC = document.getElementById('gridSave')

const typePlace = new Map([
    [0, 'disabled'],
    [1, 'standart'],
    [2, 'vip']
])

function changeChairType(e) {
    let chairClassList = e.target.classList
    if(chairClassList.contains('conf-step__chair_disabled'))
        chairClassList.replace('conf-step__chair_disabled', 'conf-step__chair_standart')
    else if(chairClassList.contains('conf-step__chair_standart'))
        chairClassList.replace('conf-step__chair_standart', 'conf-step__chair_vip')
    else if(chairClassList.contains('conf-step__chair_vip'))
        chairClassList.replace('conf-step__chair_vip', 'conf-step__chair_disabled')
}

async function drawGrid(e) {
    const hallID = e.target.value

    if (hallID != null) {
        divSaveHC.innerText = ''

        let formData = new FormData();
        formData.append('hallID', hallID);
        formData.append('type', 'get');

        let response = await fetch('/api/grid_hall.php', {
            method: 'POST',
            body: formData
        })
        let result = await response.json()

        if (result.status) {
            gridDiv.innerHTML = ''
            let insertGrid = ''
            for (let i = 1; i <= result.data['rows']; i++) {
                insertGrid += '<div class="conf-step__row">'
                for (let j = 1; j <= result.data['places']; j++) {
                    let chairID = result.data['places'] * (i - 1) + j - 1
                    insertGrid += '<span class="conf-step__chair conf-step__chair_' + typePlace.get(result.data['grid'][chairID]) + '"></span>'
                }
                insertGrid += '</div>'
            }
            inpRows.value = result.data['rows']
            inpRowPlaces.value = result.data['places']
            gridDiv.innerHTML = insertGrid

            gridDiv.querySelectorAll('span')
                .forEach(chair =>
                    chair.addEventListener('click', (e) => changeChairType(e))
                )
            saveGridBtn.removeAttribute("disabled")
            inpRows.removeAttribute("disabled")
            inpRowPlaces.removeAttribute("disabled")
        } else {
            saveGridBtn.setAttribute("disabled", true)
            inpRowPlaces.setAttribute("disabled", true)
            inpRows.setAttribute("disabled", true)
            errPHC.innerText = result.mess
        }
    }
}

function changeGrid() {
    gridDiv.innerHTML = ''
    divSaveHC.innerText = ''
    let insertGrid = ''
    for (let i = 1; i <= inpRows.value; i++) {
        insertGrid += '<div class="conf-step__row">'
        for (let j = 1; j <= inpRowPlaces.value; j++) {
            let chairID = inpRowPlaces.value * (i - 1) + j - 1
            insertGrid += '<span class="conf-step__chair conf-step__chair_standart"></span>'
        }
        insertGrid += '</div>'
    }
    gridDiv.innerHTML = insertGrid
    gridDiv.querySelectorAll('span')
        .forEach(chair =>
            chair.addEventListener('click', (e) => changeChairType(e))
        )
    saveGridBtn.removeAttribute("disabled")
    inpRows.removeAttribute("disabled")
    inpRowPlaces.removeAttribute("disabled")
}

async function saveGrid() {
    if (!confirm("Все билеты проданные в этот зал будут аннулированы!")) {
        return
    }
    const hallInp = document.querySelector("input[name='chairs-hall']:checked")
    let hallGrid = []
    Array.from(gridDiv.querySelectorAll('span')).forEach(chair => {
        let charClass = chair.classList[1]
        switch (charClass) {
            case 'conf-step__chair_disabled':
                hallGrid.push(0)
                break
            case 'conf-step__chair_standart':
                hallGrid.push(1)
                break
            case 'conf-step__chair_vip':
                hallGrid.push(2)
                break
        }
    })

    if (hallInp != null) {
        let hallID = hallInp.value

        let formData = new FormData();
        formData.append('hallID', hallID);
        formData.append('type', 'set');
        formData.append('rows', inpRows.value);
        formData.append('rowPlaces', inpRowPlaces.value);
        formData.append('grid', hallGrid);

        let response = await fetch('/api/grid_hall.php', {
            method: 'POST',
            body: formData
        })
        let result = await response.json()

        if (result.status) {
            errPHC.style.display = 'none'
            divSaveHC.innerText = 'Данные успешно обновлены'
        } else {
            errPHC.style.display = 'block'
            divSaveHC.innerText = ''
            errPHC.innerText = result.mess
        }
    }
}

function cancel() {
    inpRows.value = ''
    inpRowPlaces.value = ''
    gridDiv.innerHTML = ''
    inpRowPlaces.setAttribute("disabled", true)
    inpRows.setAttribute("disabled", true)
    saveGridBtn.setAttribute("disabled", true)
    if (document.querySelector("input[name='chairs-hall']:checked"))
        document.querySelector("input[name='chairs-hall']:checked").checked = false;
}

document.querySelectorAll("input[name='chairs-hall']")
    .forEach(inp => inp.addEventListener('change', (e) => {
        drawGrid(e)
    }))

inpRows.addEventListener('input', changeGrid)
inpRowPlaces.addEventListener('input', changeGrid)
saveGridBtn.addEventListener('click', saveGrid)
canselGridBtn.addEventListener('click', cancel)