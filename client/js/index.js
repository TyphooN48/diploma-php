const dayLinks = Array.from(document.getElementsByClassName("page-nav__day"))
const today = new Date()
let selectedDate = today.getFullYear() + '-' + today.getMonth() + '-' + today.getDate()
function setSeances(e) {
    document.getElementsByClassName("page-nav__day_chosen")[0].classList.remove('page-nav__day_chosen')

    let date
    if (e.target.dataset.day) {
        date = e.target.dataset.day
        e.target.classList.add('page-nav__day_chosen')
        selectedDate = e.target.dataset.fulldate
    } else {
        date = e.target.parentElement.dataset.day
        e.target.parentElement.classList.add('page-nav__day_chosen')
        selectedDate = e.target.parentElement.dataset.fulldate
    }
    const timeBtn = Array.from(document.querySelectorAll('.movie-seances__time,.movie-seances__time-disabled'))
    if(date == today.getDate()) {
        timeBtn.forEach(btn => {
            if(btn.dataset.seancetime < today.getHours() + ":" + today.getMinutes()) {
                btn.classList.remove('movie-seances__time', 'movie-seances__time-disabled')
                btn.classList.add('movie-seances__time-disabled')
            } else {
                btn.classList.remove('movie-seances__time', 'movie-seances__time-disabled')
                btn.classList.add('movie-seances__time')
            }
        })
    } else {
        timeBtn.forEach(btn => {
            btn.classList.remove('movie-seances__time', 'movie-seances__time-disabled')
            btn.classList.add('movie-seances__time')
        })
    }
    const movieSeances = Array.from(document.getElementsByClassName("movie-seances__time"))
    movieSeances.forEach(time => time.addEventListener('click', (e) => {
        const selectSeance = e.target.dataset.seanceid
        const selectFilm = e.target.dataset.filmid
        selectSeancePost({ film_id: selectFilm, seance_id: selectSeance, date: selectedDate})
    }))
}

function selectSeancePost(params) {
    const path = '/client/hall.php'
    const form = document.createElement("form");
    form.method = 'post';
    form.action = path;

    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement("input");
            hiddenField.type = "hidden";
            hiddenField.name = key;
            hiddenField.value = params[key];
            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

dayLinks.forEach(day => day.addEventListener('click', setSeances))