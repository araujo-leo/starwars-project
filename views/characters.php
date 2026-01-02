<?php include __DIR__ . '/partials/header.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Personagens</h2>

        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center" id="characters-list">

        <span class="loader mt-5 mx-auto text-center">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
        </span>

        </div>

        <template id="char-template">
            <div class="col">
                <div class="card h-100 shadow-sm border-0 bg-dark text-light char-card">
                    <div class="card-body text-center">
                        <img src="" class="rounded-circle mb-3 border border-2 border-success object-fit-cover" width="80" height="80" alt="avatar">
                        <h5 class="card-title fw-bold text-success name-display"></h5>
                        <ul class="list-unstyled small text-secondary mt-3">
                            <li>Gênero: <span class="gender-display text-light"></span></li>
                            <li>Nascimento: <span class="birth-display text-light"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </template>

        <div class="row my-5">
            <div class="col d-flex justify-content-between align-items-center">
                <button id="btn-prev" class="btn btn-outline-secondary px-4" disabled>&laquo; Anterior</button>
                <span class="text-muted small" id="page-indicator">Página 1</span>
                <button id="btn-next" class="btn btn-outline-success px-4" disabled>Próxima &raquo;</button>
            </div>
        </div>
    </div>

    <style>
        .char-card { transition: transform 0.2s, box-shadow 0.2s; }
        .char-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.5)!important;
        }
    </style>

    <script>
        function getInitials(name) {
            if (!name) return "?";
            return name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        let currentPage = 1;

        function loadCharacters(url) {
            $('.loader').show();
            $('#characters-list').empty();
            $('#btn-prev, #btn-next').prop('disabled', true);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                $('.loader').hide();

                let results = [];
                if (response.data && response.data.results) {
                    results = response.data.results;
                } else if (response.results) {
                    results = response.results;
                }

                const templateHTML = $('#char-template').html();

                if (!templateHTML) {
                    console.error("ERRO CRÍTICO: <template id='char-template'> não encontrado no HTML.");
                    return;
                }

                $.each(results, function(index, char) {
                    const card = $(templateHTML);

                    card.find('.name-display').text(char.name);
                    card.find('.gender-display').text(char.gender);
                    card.find('.birth-display').text(char.birth_year);

                    const initials = getInitials(char.name);
                    card.find('img').attr('src', `https://placehold.co/100x100/198754/FFFFFF/?text=${initials}&font=roboto`);

                    $('#characters-list').append(card);
                });

                const nextLink = response.next || (response.data && response.data.next);
                const prevLink = response.previous || (response.data && response.data.previous);

                handlePagination(nextLink, prevLink);

            }).fail(function() {
                $('.loader').hide();
                $('#characters-list').html('<div class="alert alert-danger w-100 text-center">Erro ao carregar.</div>');
            });
        }

        function handlePagination(nextUrl, prevUrl) {
            if (nextUrl) {
                $('#btn-next').data('url', nextUrl).prop('disabled', false);
            } else {
                $('#btn-next').prop('disabled', true);
            }

            if (prevUrl) {
                $('#btn-prev').data('url', prevUrl).prop('disabled', false);
            } else {
                $('#btn-prev').prop('disabled', true);
            }
        }

        $(document).ready(function() {
            loadCharacters('/api/people?page=1');

            $('#btn-next').click(function() {
                const url = $(this).data('url');
                if (url) {
                    currentPage++;
                    $('#page-indicator').text('Página ' + currentPage);
                    loadCharacters(url);
                }
            });

            $('#btn-prev').click(function() {
                const url = $(this).data('url');
                if (url) {
                    currentPage--;
                    $('#page-indicator').text('Página ' + currentPage);
                    loadCharacters(url);
                }
            });
        });
    </script>

<?php include __DIR__ . '/partials/footer.php'; ?>