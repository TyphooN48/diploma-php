const saveCostBtn = document.getElementById('saveCost')
const canselCostBtn = document.getElementById('canselCost')
const divSave = document.getElementById('hallSave')
const errP = document.getElementById('hallError')
const inpCostSt = document.getElementById('costStandart')
const inpCostVp = document.getElementById('costVip')

async function getCost(e) {
    const hallID = e.target.value

    if (hallID != null) {
        divSave.innerText = ''
        errP.style.display = 'none'
        let formData = new FormData();
        formData.append('hallID', hallID);
        formData.append('type', 'get');

        let response = await fetch('/api/cost_hall.php', {
            method: 'POST',
            body: formData
        })
        let result = await response.json()

        if (result.status) {
            errP.style.display = 'none'
            errP.innerText = ''
            inpCostSt.value = result.data['standart']
            inpCostVp.value = result.data['vip']
            saveCostBtn.removeAttribute("disabled")
        } else {
            divSave.innerText = ''
            errP.innerText = result.mess
            errP.style.display = 'block'
        }
    }
}

async function saveCost() {
    const hallInp = document.querySelector("input[name='prices-hall']:checked")

    if (hallInp != null) {
        let hallID = hallInp.value

        let formData = new FormData();
        formData.append('hallID', hallID);
        formData.append('type', 'set');
        formData.append('standart', inpCostSt.value);
        formData.append('vip', inpCostVp.value);

        let response = await fetch('/api/cost_hall.php', {
            method: 'POST',
            body: formData
        })
        let result = await response.json()

        if (result.status) {
            errP.style.display = 'none'
            divSave.innerText = 'Данные успешно обновлены'
        } else {
            errP.style.display = 'block'
            divSave.innerText = ''
            errP.innerText = result.mess
        }
    }
}

function cancel() {
    inpCostSt.value = ''
    inpCostVp.value = ''
    saveCostBtn.setAttribute("disabled", true)
    if(document.querySelector("input[name='prices-hall']:checked"))
        document.querySelector("input[name='prices-hall']:checked").checked = false;
}

document.querySelectorAll("input[name='prices-hall']")
    .forEach(inp => inp.addEventListener('change', (e) => {
    getCost(e)
}))

saveCostBtn.addEventListener('click', saveCost)
canselCostBtn.addEventListener('click', cancel)