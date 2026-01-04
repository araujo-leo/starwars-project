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

        a.card-char {
            display: block;
            text-decoration: none;
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            cursor: pointer;
        }
        a.card-char:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
            border-color: #FFE81F;
        }

        .btn-outline-warning {
            color: #FFE81F;
            border-color: #FFE81F;
        }

        .btn-outline-warning:hover {
            background-color: #FFE81F;
            color: #000;
        }
        .btn-outline-warning:disabled {
            border-color: #444;
            color: #666;
        }

        .page-indicator {
            font-family: monospace;
            color: #888;
            font-size: 1.1rem;
        }
    </style>

    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center mb-5">
            <h2 class="display-5 fw-bold text-starwars mb-2">Galactic Figures</h2>
            <p class="text-white">Database of known habitants</p>
        </div>

        <div id="main-loader" class="text-center py-5" style="display: none;">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center" id="characters-list">
        </div>

        <template id="char-template">
            <div class="col">
                <a href="#" class="card h-100 card-char text-light">
                    <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                        <img src="" class="rounded-circle mb-3 border border-2 border-warning object-fit-cover shadow" width="100" height="100" alt="avatar">

                        <h5 class="card-title fw-bold text-starwars name-display mb-3"></h5>

                        <ul class="list-unstyled small text-muted w-100">
                            <li class="mb-1 border-bottom border-secondary pb-1 mx-3 text-starwars">
                                Gender: <span class="gender-display text-white fw-bold"></span>
                            </li>
                            <li class="mx-3 pt-1 text-starwars">
                                Birth Year: <span class="birth-display text-white fw-bold"></span>
                            </li>
                        </ul>

                        <small class="mt-3 text-warning opacity-50">Click to view details</small>
                    </div>
                </a>
            </div>
        </template>

        <div class="row my-5">
            <div class="col d-flex justify-content-between align-items-center">
                <button id="btn-prev" class="btn btn-outline-warning px-4 fw-bold" disabled>
                    &laquo; Previous
                </button>

                <span class="page-indicator" id="page-indicator">Page 1</span>

                <button id="btn-next" class="btn btn-outline-warning px-4 fw-bold" disabled>
                    Next &raquo;
                </button>
            </div>
        </div>
    </div>

    <script>
        function getInitials(name) {
            if (!name) return "?";
            return name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        function extractIdFromUrl(url) {
            if (!url) return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        let currentPage = 1;

        function loadCharacters(url) {
            $('#characters-list').empty();
            $('#main-loader').show();
            $('#btn-prev, #btn-next').prop('disabled', true);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                $('#main-loader').hide();

                let results = [];
                if (response.data && response.data.results) {
                    results = response.data.results;
                } else if (response.results) {
                    results = response.results;
                }

                const templateHTML = $('#char-template').html();

                $.each(results, function(index, char) {
                    const card = $(templateHTML);

                    card.find('.name-display').text(char.name);
                    const gender = (char.gender === 'n/a') ? 'Droid/None' : char.gender;
                    const birth = (char.birth_year === 'unknown') ? 'Unknown' : char.birth_year;
                    card.find('.gender-display').text(gender);
                    card.find('.birth-display').text(birth);
                    const initials = getInitials(char.name);
                    card.find('img').attr('src', `https://placehold.co/100x100/000000/FFE81F/?text=${initials}&font=montserrat`);

                    let id = char.id;
                    if (!id && char.url) {
                        id = extractIdFromUrl(char.url);
                    }

                    if (id) {
                        card.find('a').attr('href', `/characters/${id}`);
                    }

                    $('#characters-list').append(card);
                });

                const nextLink = response.next || (response.data && response.data.next);
                const prevLink = response.previous || (response.data && response.data.previous);

                handlePagination(nextLink, prevLink);

            }).fail(function() {
                $('#main-loader').hide();
                $('#characters-list').html('<div class="alert alert-danger bg-dark text-danger border-danger w-100 text-center">Failed to retrieve data from archives.</div>');
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
                    $('#page-indicator').text('Page ' + currentPage);
                    loadCharacters(url);
                }
            });

            $('#btn-prev').click(function() {
                const url = $(this).data('url');
                if (url) {
                    currentPage--;
                    $('#page-indicator').text('Page ' + currentPage);
                    loadCharacters(url);
                }
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>