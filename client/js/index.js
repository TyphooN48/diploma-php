const dayLinks = Array.from(document.getElementsByClassName("page-nav__day"))
const movieSeances = Array.from(document.getElementsByClassName("movie-seances__time"))

function setSeances(e) {
    document.getElementsByClassName("page-nav__day_chosen")[0].classList.remove('page-nav__day_chosen')

    let date
    if (e.target.dataset.day) {
        date = e.target.dataset.day
        e.target.classList.add('page-nav__day_chosen')
    } else {
        date = e.target.parentElement.dataset.day
        e.target.parentElement.classList.add('page-nav__day_chosen')
    }
    const timeBtn = Array.from(document.querySelectorAll('.movie-seances__time,.movie-seances__time-disabled'))
    const today = new Date()
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

movieSeances.forEach(time => time.addEventListener('click', (e) => {
    const selectSeance = e.target.dataset.seanceid
    const selectFilm = e.target.dataset.filmid
    selectSeancePost({ film_id: selectFilm, seance_id: selectSeance })
}))