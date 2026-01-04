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

        .species-card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.2s, border-color 0.2s;
            height: 100%;
            text-decoration: none;
            display: block;
        }

        .species-card:hover {
            transform: translateY(-5px);
            border-color: #FFE81F;
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-bottom: 1px solid #333;
            background-color: #000;
        }

        .card-body {
            padding: 15px;
        }

        .species-name {
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .species-meta {
            color: #888;
            font-size: 0.85rem;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
        }
    </style>

    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-starwars mb-0">Species</h2>
        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" role="status"></div>
            <p class="mt-2 text-muted">Scanning biology database...</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="species-list">
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
            if (!matches) return "?";
            return matches.join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        $(document).ready(function() {
            $.ajax({
                url: '/api/species',
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                $('#loader').hide();
                console.log("Resposta da API:", response);

                let results = [];

                if (Array.isArray(response)) {
                    results = response;
                }
                else if (response.results && Array.isArray(response.results)) {
                    results = response.results;
                }
                else if (response.data && Array.isArray(response.data)) {
                    results = response.data;
                }
                else if (response.data && response.data.results && Array.isArray(response.data.results)) {
                    results = response.data.results;
                }
                else {
                    console.error("Estrutura do JSON desconhecida:", response);
                    $('#species-list').html('<div class="col-12 text-center text-danger">Erro de formato JSON.</div>');
                    return;
                }

                if (results.length === 0) {
                    $('#species-list').html('<div class="col-12 text-center text-muted">Nenhuma espécie encontrada.</div>');
                    return;
                }

                const listContainer = $('#species-list');
                listContainer.empty();

                results.forEach(specie => {
                    let id = specie.id;
                    if (!id && specie.url) id = extractIdFromUrl(specie.url);

                    if (!id) return;

                    const initials = getInitials(specie.name);
                    const imgUrl = `https://placehold.co/300x300/1a1a1a/FFE81F/?text=${initials}&font=montserrat`;

                    const language = specie.language && specie.language !== 'n/a' ? specie.language : 'Unknown';
                    const classification = specie.classification || 'Unknown';

                    const html = `
                    <div class="col">
                        <a href="/species/${id}" class="species-card rounded overflow-hidden">
                            <img src="${imgUrl}" class="card-img-top" alt="${specie.name}">
                            <div class="card-body">
                                <div class="species-name text-truncate">${specie.name}</div>
                                <div class="species-meta">
                                    <span>${classification}</span>
                                    <span class="text-warning">${language}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                    listContainer.append(html);
                });

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Falha ao carregar espécies.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>