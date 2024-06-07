const acceptSeat = Array.from(document.getElementsByClassName('acceptin-button'))[0]
const allSeats = Array.from(document.querySelectorAll('.buying-scheme__row .buying-scheme__chair'))

let selectedSeats = []
function checkSeat() {
    const path = '/client/payment.php'
    const form = document.createElement("form")
    form.method = 'post'
    form.action = path
    const hiddenField1 = document.createElement("input")
    hiddenField1.type = "hidden"
    hiddenField1.name = 'seats'
    hiddenField1.value = selectedSeats.join()
    form.appendChild(hiddenField1)
    const hiddenField2 = document.createElement("input")
    hiddenField2.type = "hidden"
    hiddenField2.name = 'film_id'
    hiddenField2.value = document.querySelector('input[name="film_id"]').value
    form.appendChild(hiddenField2)
    const hiddenField3 = document.createElement("input")
    hiddenField3.type = "hidden"
    hiddenField3.name = 'seance_id'
    hiddenField3.value = document.querySelector('input[name="seance_id"]').value
    form.appendChild(hiddenField3)
    const hiddenField4 = document.createElement("input")
    hiddenField4.type = "hidden"
    hiddenField4.name = 'date'
    hiddenField4.value = document.querySelector('input[name="date"]').value
    form.appendChild(hiddenField4)
    document.body.appendChild(form)
    form.submit()
}

function selectPlace(e) {
    const chair = e.target
    if(chair.classList.contains('buying-scheme__chair_taken') || chair.classList.contains('buying-scheme__chair_disabled'))
        return
    else {
        if(chair.classList.contains('buying-scheme__chair_selected')) {
            let index = selectedSeats.indexOf(chair.dataset.seatid)
            if (index !== -1)
                selectedSeats.splice(index, 1)
            chair.classList.remove('buying-scheme__chair_selected')
        }
        else {
            selectedSeats.push(chair.dataset.seatid)
            chair.classList.add('buying-scheme__chair_selected')
        }
    }
    if(selectedSeats.length > 0)
        acceptSeat.removeAttribute("disabled")
    else
        acceptSeat.setAttribute("disabled", true)
}

allSeats.forEach(seat => seat.addEventListener('click', (e) => selectPlace(e)))

acceptSeat.addEventListener('click', checkSeat)