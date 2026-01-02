<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        body {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }
        .text-starwars {
            color: #FFE81F;
            text-shadow: 0 0 10px rgba(255, 232, 31, 0.3);
        }
        .card-film {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
        }
        .card-film:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            border-color: #FFE81F;
        }
        .card-text {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 4;
            overflow: hidden;
            text-align: justify;
            font-size: 0.85rem;
            color: #b0b0b0;
        }
        .meta-data {
            font-size: 0.8rem;
            color: #888;
        }
        .interval-badge {
            font-size: 0.75rem;
            background-color: #2c2c2c;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 4px 8px;
            margin-top: 8px;
            display: inline-block;
            color: #FFE81F;
        }
    </style>

    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-5">
            <h2 class="display-5 fw-bold text-starwars mb-2">Films</h2>
            <p class="text-white">Explore the timeline</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center" id="films-list">

        <span class="loader mt-5 mx-auto">
            <div class="spinner-border text-starwars" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </span>

        </div>

        <template id="card-template">
            <div class="col">
                <div class="card h-100 card-film text-light">
                    <img src="" alt="film-img" class="card-img-top object-fit-cover opacity-75" style="height: 220px;" referrerpolicy="no-referrer">

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold text-white mb-0"></h5>
                            <span class="badge bg-warning text-dark episode-badge"></span>
                        </div>

                        <div class="meta-data mb-3">
                            <small>🎬 <span class="director-display"></span></small><br>
                            <small>📅 <span class="date-display"></span></small>
                        </div>

                        <div class="card-text flex-grow-1 mb-3"></div>

                        <div class="text-center mb-3">
                            <div class="interval-badge shadow-sm">
                                ⏳ Released <span class="interval-display fw-bold"></span> ago
                            </div>
                        </div>

                        <div class="mt-auto">
                            <a href="" class="btn btn-outline-warning w-100 fw-bold">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function episodeNumberToRoman(num) {
            const roman = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1};
            let str = '';
            for (let i of Object.keys(roman)) {
                let q = Math.floor(num / roman[i]);
                num -= q * roman[i];
                str += i.repeat(q);
            }
            return str;
        }

        function formatDate(dateString) {
            if(!dateString) return 'Unknown';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        $(document).ready(function() {
            $.ajax({
                url: '/api/films',
                method: 'GET',
                dataType: 'json',
                async: true
            }).done(function (response) {

                const films = response.results || response.data.results || response;

                const templateHTML = $('#card-template').html();
                const filmsList = $('#films-list');

                $('.loader').remove();

                films.forEach(function (film) {
                    const filmCard = $(templateHTML);

                    filmCard.find('.card-title').text(film.title);
                    filmCard.find('.episode-badge').text('EP ' + film.episode_id);
                    filmCard.find('.card-text').text(film.opening_crawl);
                    filmCard.find('.director-display').text(film.director);
                    filmCard.find('.date-display').text(formatDate(film.release_date));

                    const romanEp = episodeNumberToRoman(film.episode_id);
                    filmCard.find('img').attr('src', `https://placehold.co/500x220/000000/FFE81F/?text=STAR+WARS+${romanEp}&font=montserrat`);

                    if (film.interval) {
                        let timeParts = [];
                        if (film.interval.years > 0) timeParts.push(`${film.interval.years}y`);
                        if (film.interval.months > 0) timeParts.push(`${film.interval.months}m`);
                        if (film.interval.days > 0)  timeParts.push(`${film.interval.days}d`);

                        const timeString = timeParts.join(' ');
                        filmCard.find('.interval-display').text(timeString);
                    } else {
                        filmCard.find('.interval-badge').hide();
                    }

                    filmCard.find('a').attr('href', '/filme/' + film.id);

                    filmsList.append(filmCard);
                });
            }).fail(function() {
                $('.loader').html('<div class="alert alert-danger bg-dark text-danger border-danger">Failed to load the Force.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>