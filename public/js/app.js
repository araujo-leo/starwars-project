$(document).ready(function() {
    if ($('#films-container').length) {
        loadFilms();
    }
});

function loadFilms() {
    $.ajax({
        url: '/api/films',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#loading').hide();
            let films = response.results || response.data.results;

            films.forEach(function(film) {
                let html = `
                    <div class="col-md-4">
                        <div class="card card-film h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">${film.title}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Episódio ${film.episode_id}</h6>
                                <p class="card-text text-truncate">${film.opening_crawl}</p>
                                <ul class="list-unstyled small text-muted">
                                    <li>📅 ${film.release_date}</li>
                                    <li>🎬 ${film.director}</li>
                                    <li>🖋️ ${film.interval.years} anos, ${film.interval.months} meses, ${film.interval.days} dias</li>
                                </ul>
                                <a href="/filme/${film.id}" class="btn btn-outline-primary w-100 mt-2">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                `;
                $('#films-container').append(html);
            });
        },
        error: function(xhr, status, error) {
            $('#loading').html('<div class="alert alert-danger">Erro ao carregar filmes.</div>');
            console.error("Erro:", error);
        }
    });
}