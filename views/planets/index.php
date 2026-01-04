<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        body { background-color: #121212 !important; color: #e0e0e0 !important; }
        .text-starwars { color: #FFE81F; text-shadow: 0 0 10px rgba(255, 232, 31, 0.3); }
        a.card-item {
            display: block; text-decoration: none; background-color: #1e1e1e; border: 1px solid #333;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s; cursor: pointer;
        }
        a.card-item:hover { transform: translateY(-8px); box-shadow: 0 10px 20px rgba(0,0,0,0.5); border-color: #FFE81F; }
        .btn-outline-warning { color: #FFE81F; border-color: #FFE81F; }
        .btn-outline-warning:hover { background-color: #FFE81F; color: #000; }
        .btn-outline-warning:disabled { border-color: #444; color: #666; }
    </style>

    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-5">
            <h2 class="display-5 fw-bold text-starwars mb-2">Planetary Systems</h2>
            <p class="text-white">Explore the galaxy</p>
        </div>

        <div id="main-loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status"></div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center" id="list-container"></div>

        <template id="item-template">
            <div class="col">
                <a href="#" class="card h-100 card-item text-light">
                    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                        <img src="" class="rounded-circle mb-3 border border-2 border-warning object-fit-cover shadow" width="100" height="100">
                        <h5 class="card-title fw-bold text-starwars name-display mb-3"></h5>
                        <ul class="list-unstyled small text-muted w-100">
                            <li class="mb-1 border-bottom border-secondary pb-1 mx-3 text-starwars">
                                Climate: <span class="field-1 text-white fw-bold"></span>
                            </li>
                            <li class="mx-3 pt-1 text-starwars">
                                Terrain: <span class="field-2 text-white fw-bold"></span>
                            </li>
                        </ul>
                        <small class="mt-3 text-warning opacity-50">View Planet</small>
                    </div>
                </a>
            </div>
        </template>

        <div class="row my-5">
            <div class="col d-flex justify-content-between align-items-center">
                <button id="btn-prev" class="btn btn-outline-warning px-4 fw-bold" disabled>&laquo; Previous</button>
                <span class="page-indicator text-muted" id="page-indicator">Page 1</span>
                <button id="btn-next" class="btn btn-outline-warning px-4 fw-bold" disabled>Next &raquo;</button>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;

        function extractIdFromUrl(url) {
            if (!url) return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        function loadData(url) {
            $('#list-container').empty();
            $('#main-loader').show();
            $('#btn-prev, #btn-next').prop('disabled', true);

            $.ajax({ url: url, method: 'GET', dataType: 'json' }).done(function(response) {
                $('#main-loader').hide();
                const results = response.data.results || response.results;
                const templateHTML = $('#item-template').html();

                $.each(results, function(index, item) {
                    const card = $(templateHTML);
                    card.find('.name-display').text(item.name);

                    // Campos Específicos de Planeta
                    card.find('.field-1').text(item.climate);
                    card.find('.field-2').text(item.terrain);

                    // Imagem e Link
                    let id = item.id || extractIdFromUrl(item.url);
                    card.find('img').attr('src', `https://placehold.co/100x100/101010/FFE81F/?text=PL&font=montserrat`);
                    if (id) card.find('a').attr('href', `/planets/${id}`);

                    $('#list-container').append(card);
                });

                // Paginação
                const nextLink = response.next || (response.data && response.data.next);
                const prevLink = response.previous || (response.data && response.data.previous);

                if (nextLink) $('#btn-next').data('url', nextLink).prop('disabled', false);
                if (prevLink) $('#btn-prev').data('url', prevLink).prop('disabled', false);

            }).fail(() => {
                $('#main-loader').hide();
                $('#list-container').html('<div class="alert alert-danger w-100 text-center">Failed to load data.</div>');
            });
        }

        $(document).ready(function() {
            loadData('/api/planets?page=1');

            $('#btn-next').click(function() {
                const url = $(this).data('url');
                if(url) { currentPage++; $('#page-indicator').text('Page ' + currentPage); loadData(url); }
            });
            $('#btn-prev').click(function() {
                const url = $(this).data('url');
                if(url) { currentPage--; $('#page-indicator').text('Page ' + currentPage); loadData(url); }
            });
        });
    </script>
<?php include __DIR__ . '/../partials/footer.php'; ?>