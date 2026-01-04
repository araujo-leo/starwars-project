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

        .text-label {
            color: #888; font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .text-value {
            color: #fff;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .stat-box {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s;
            height: 100%;
        }
        .stat-box:hover {
            transform: translateY(-3px);
            border-color: #FFE81F;
        }

        .nav-tabs {
            border-bottom: 1px solid #333;
            margin-bottom: 20px;
        }

        .nav-link {
            color: #888;
            border: none;
            font-weight: bold;
            transition: 0.3s;
            padding: 10px 20px;
        }

        .nav-link:hover {
            color: #e0e0e0;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
        }

        .nav-link.active {
            background-color: transparent !important;
            color: #FFE81F !important;
            border-bottom: 3px solid #FFE81F;
        }

        .data-chip {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #fff;
            position: relative;
        }
        .data-chip:hover {
            background-color: #252525;
            border-color: #FFE81F;
            transform: translateY(-2px);
            color: #FFE81F;
        }
        .chip-avatar {
            width: 45px; height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #444;
            background-color: #000;
        }
        .chip-content {
            flex-grow: 1;
            min-width: 0;
        }

        .chip-name {
            font-weight: bold;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .loading-text {
            display: inline-block;
            width: 80px; height: 12px;
            background-color: #333;
            border-radius: 4px;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 0.5; }
            50% { opacity: 1; }
            100% { opacity: 0.5; }
        }
    </style>

    <div class="container mt-4 mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/planets" class="text-decoration-none text-warning">Planets</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page" id="breadcrumb-name">Loading...</li>
            </ol>
        </nav>

        <div id="planet-content" style="display: none;">

            <div class="row mb-5">
                <div class="col-md-4 text-center d-flex flex-column align-items-center">
                    <img id="planet-img" src="" class="rounded-circle border border-3 border-warning shadow-lg mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    <h1 class="display-5 fw-bold text-white mb-0" id="planet-name"></h1>
                    <span class="badge bg-dark border border-secondary text-warning mt-2 px-3 py-2" id="planet-population"></span>
                </div>

                <div class="col-md-8">
                    <h4 class="text-starwars mb-3 border-bottom border-secondary pb-2">Planetary Data</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Rotation Period</div>
                                <div class="text-value"><span id="planet-rotation"></span> h</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Orbital Period</div>
                                <div class="text-value"><span id="planet-orbit"></span> days</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Diameter</div>
                                <div class="text-value"><span id="planet-diameter"></span> km</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Climate</div>
                                <div class="text-value text-capitalize" id="planet-climate"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Gravity</div>
                                <div class="text-value text-capitalize" id="planet-gravity"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Surface Water</div>
                                <div class="text-value"><span id="planet-water"></span>%</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-box text-start px-4">
                                <div class="text-label">Terrain</div>
                                <div class="text-value text-capitalize" id="planet-terrain"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 text-white border-start border-4 border-warning ps-3">Related</h4>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#residents-pane">Residents</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#films-pane">Films</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="residents-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-residents"></div></div>
                <div class="tab-pane fade" id="films-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-films"></div></div>
            </div>

        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-2 text-muted">Scanning sector...</p>
        </div>
    </div>

    <script>
        const planetId = <?= json_encode($data['id'] ?? null); ?>;

        function getInitials(name) {
            if (!name) return "?";
            return name.match(/(\b\S)?/g).join("").match(/(^\S|\S$)?/g).join("").toUpperCase();
        }

        function extractIdFromUrl(url) {
            if (!url) return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        const resourceMap = {
            'films': 'films',
            'people': 'people',
            'residents': 'people'
        };

        function fetchItemName(type, id, elementId) {
            const endpoint = resourceMap[type] || type;

            $.ajax({
                url: `/api/${endpoint}/${id}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const data = response.data || response;
                const displayText = data.title || data.name;

                let frontendLink = endpoint;
                if(endpoint === 'people') frontendLink = 'characters';
                if(endpoint === 'films') frontendLink = 'films';

                $(`#${elementId}`).text(displayText).removeClass('loading-text');
                $(`#link-${elementId}`).attr('href', `/${frontendLink}/${id}`).removeClass('disabled');
            }).fail(function() {
                $(`#${elementId}`).text(`Unidentified #${id}`).removeClass('loading-text').addClass('text-muted');
            });
        }

        function renderRelatedList(containerId, items, type, icon) {
            const container = $(containerId);
            container.empty();

            if (!items || items.length === 0) {
                container.html('<div class="col-12 text-muted">No records found.</div>');
                return;
            }

            items.forEach(item => {
                let id = item.id;
                // Se vier como URL (comum na SWAPI), extrai o ID
                if (!id && (typeof item === 'string' || item.url)) {
                    id = extractIdFromUrl(item.url || item);
                }

                if (!id) return;

                const uniqueId = `${type}-${id}`;
                const elementId = `name-${uniqueId}`;
                const linkId = `link-${elementId}`;

                let avatar = `https://placehold.co/80x80/333/FFE81F/?text=${icon}&font=roboto`;
                if (type === 'films') {
                    avatar = `https://placehold.co/80x100/111/FFE81F/?text=FILM&font=montserrat`;
                }

                const html = `
                    <div class="col">
                        <a href="#" id="${linkId}" class="data-chip disabled">
                            <img src="${avatar}" class="chip-avatar" style="${type === 'films' ? 'border-radius: 4px; width: 40px; height: 50px;' : ''}" alt="icon">
                            <div class="chip-content">
                                <div class="chip-name">
                                    <span id="${elementId}" class="loading-text"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                container.append(html);

                fetchItemName(type, id, elementId);
            });
        }

        $(document).ready(function() {
            if (!planetId) return;

            $.ajax({
                url: `/api/planets/${planetId}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const planet = response.data || response;

                $('#loader').hide();
                $('#planet-content').fadeIn();

                // Preenche os dados principais
                $('#planet-name').text(planet.name);
                $('#breadcrumb-name').text(planet.name);
                $('#planet-rotation').text(planet.rotation_period);
                $('#planet-orbit').text(planet.orbital_period);
                $('#planet-diameter').text(planet.diameter);
                $('#planet-climate').text(planet.climate);
                $('#planet-gravity').text(planet.gravity);
                $('#planet-terrain').text(planet.terrain);
                $('#planet-water').text(planet.surface_water);

                // Formata população
                let pop = planet.population;
                if (pop !== 'unknown') {
                    pop = parseInt(pop).toLocaleString() + ' inhabitants';
                }
                $('#planet-population').text(pop);

                // Avatar do Planeta
                const initials = getInitials(planet.name);
                $('#planet-img').attr('src', `https://placehold.co/200x200/000000/FFE81F/?text=${initials}&font=montserrat`);

                // Listas Relacionadas (Residentes e Filmes)
                // Nota: A API geralmente retorna 'residents' (que são people)
                renderRelatedList('#list-residents', planet.residents, 'people', 'Res');
                renderRelatedList('#list-films', planet.films, 'films', 'Mov');

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to retrieve planet data.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>