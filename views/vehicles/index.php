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

        .vehicle-card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.2s, border-color 0.2s;
            height: 100%;
            text-decoration: none;
            display: block;
        }
        .vehicle-card:hover {
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

        .vehicle-name {
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .vehicle-model {
            color: #888;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

    </style>

    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-starwars mb-0">Vehicles</h2>
        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" role="status"></div>
            <p class="mt-2 text-muted">Loading garage...</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="vehicles-list">
        </div>
    </div>

    <script>
        function extractIdFromUrl(url) {
            if (!url) return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        function getInitials(name) {
            return name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        $(document).ready(function() {
            $.ajax({
                url: '/api/vehicles',
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                $('#loader').hide();
                const results = response.data.results;

                const listContainer = $('#vehicles-list');

                results.forEach(vehicle => {
                    let id = vehicle.id;
                    if (!id && vehicle.url) id = extractIdFromUrl(vehicle.url);
                    if (!id) return;

                    const initials = getInitials(vehicle.name);
                    const imgUrl = `https://placehold.co/400x250/111/FFE81F/?text=${initials}&font=montserrat`;

                    const html = `
                    <div class="col">
                        <a href="/vehicles/${id}" class="vehicle-card rounded overflow-hidden">
                            <img src="${imgUrl}" class="card-img-top" alt="${vehicle.name}">
                            <div class="card-body">
                                <div class="vehicle-name text-truncate">${vehicle.name}</div>
                                <div class="vehicle-model text-truncate">${vehicle.model}</div>
                            </div>
                        </a>
                    </div>
                `;
                    listContainer.append(html);
                });

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to load vehicles.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>