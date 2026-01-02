<?php include __DIR__ . '/partials/header.php'; ?>

    <div class="d-flex text-center flex-column justify-content-center mt-4">
        <h2 class="w-100 mb-4">Catálogo de Filmes</h2>

        <div class="row row-cols-1 row-cols-md-3 row-gap-4 my-4 justify-content-center" id="films-list">

        <span class="loader mt-5 mx-auto">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </span>

            <template id="card-template">
                <div class="col">
                    <div class="card h-100 shadow-sm card-film">
                        <img src="" alt="film-img" class="card-img-top object-fit-cover" style="height: 200px;" referrerpolicy="no-referrer">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"></h5>
                            <h6 class="card-subtitle mb-2 text-muted episode-display"></h6>

                            <div class="card-text flex-grow-1 mb-3"></div>

                            <div class="d-flex justify-content-center align-items-end mt-auto">
                                <a href="" class="btn btn-outline-primary w-100">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <style>
        .card-text {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 5;
            overflow: hidden;
            text-align: justify;
            font-size: 0.9rem;
        }
        .card-film {
            transition: transform 0.2s;
        }
        .card-film:hover {
            transform: translateY(-5px);
        }
    </style>

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
                    filmCard.find('.episode-display').text('Episódio ' + film.episode_id);
                    filmCard.find('.card-text').text(film.opening_crawl);

                    const romanEp = episodeNumberToRoman(film.episode_id);
                    filmCard.find('img').attr('src', `https://placehold.co/500x200/1a1a1a/FFE81F/?text=${romanEp}&font=montserrat`);

                    filmCard.find('a').attr('href', '/filme/' + film.id);

                    filmsList.append(filmCard);
                });
            }).fail(function() {
                $('.loader').html('<div class="alert alert-danger">Erro ao carregar filmes.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/partials/footer.php'; ?>