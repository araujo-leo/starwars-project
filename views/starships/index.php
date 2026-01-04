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

        .ship-card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.2s, border-color 0.2s;
            height: 100%;
            text-decoration: none;
            display: block;
        }
        .ship-card:hover {
            transform: translateY(-5px);
            border-color: #FFE81F;
        }
        .card-img-top {
            height: 160px;
            object-fit: cover;
            border-bottom: 1px solid #333;
            background-color: #000;
        }
        .card-body {
            padding: 15px;
        }

        .ship-name {
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .ship-model {
            color: #888;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
    </style>

    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-starwars mb-0">Starships</h2>
        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" role="status"></div>
            <p class="mt-2 text-muted">Loading fleet...</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="ships-list">
        </div>
    </div>

    <script>
        function extractIdFromUrl(url) {
            if (!url || typeof url !== 'string') return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        function getInitials(name) {
            if (!name || typeof name !== 'string') return "??";
            const matches = name.match(/(\b\S)?/g);
            if (!matches) return "S";
            return matches.join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        $(document).ready(function() {
            $.ajax({
                url: '/api/starships',
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                $('#loader').hide();

                let results = [];
                if (Array.isArray(response)) results = response;
                else if (response.results && Array.isArray(response.results)) results = response.results;
                else if (response.data && Array.isArray(response.data)) results = response.data;
                else if (response.data && response.data.results) results = response.data.results;

                const listContainer = $('#ships-list');

                results.forEach(ship => {
                    let id = ship.id;
                    if (!id && ship.url) id = extractIdFromUrl(ship.url);
                    if (!id) return;

                    const initials = getInitials(ship.name);
                    const imgUrl = `https://placehold.co/400x250/111/FFE81F/?text=${initials}&font=montserrat`;

                    const html = `
                    <div class="col">
                        <a href="/starships/${id}" class="ship-card rounded overflow-hidden">
                            <img src="${imgUrl}" class="card-img-top" alt="${ship.name}">
                            <div class="card-body">
                                <div class="ship-name text-truncate">${ship.name}</div>
                                <div class="ship-model text-truncate">${ship.manufacturer}</div>
                                <div class="mt-2 badge bg-dark border border-secondary ">${ship.starship_class}</div>
                            </div>
                        </a>
                    </div>
                `;
                    listContainer.append(html);
                });

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to load starships.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>