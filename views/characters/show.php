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
            0% {
                opacity: 0.5;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.5;
            }
        }
    </style>

    <div class="container mt-4 mb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/characters" class="text-decoration-none text-warning">Characters</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page" id="breadcrumb-name">Loading...</li>
            </ol>
        </nav>

        <div id="char-content" style="display: none;">

            <div class="row mb-5">
                <div class="col-md-4 text-center d-flex flex-column align-items-center">
                    <img id="char-img" src="" class="rounded-circle border border-3 border-warning shadow-lg mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    <h1 class="display-5 fw-bold text-white mb-0" id="char-name"></h1>
                    <span class="badge bg-dark border border-secondary text-warning mt-2 px-3 py-2" id="char-gender"></span>
                </div>

                <div class="col-md-8">
                    <h4 class="text-starwars mb-3 border-bottom border-secondary pb-2">Physical Traits</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Height</div>
                                <div class="text-value"><span id="char-height"></span> cm</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Mass</div>
                                <div class="text-value"><span id="char-mass"></span> kg</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Born</div>
                                <div class="text-value" id="char-birth"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Hair Color</div>
                                <div class="text-value text-capitalize" id="char-hair"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Eye Color</div>
                                <div class="text-value text-capitalize" id="char-eye"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Skin Color</div>
                                <div class="text-value text-capitalize" id="char-skin"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-box d-flex align-items-center justify-content-between px-4">
                                <div class="text-start">
                                    <div class="text-label">Homeworld</div>
                                    <div class="text-value">
                                        <span id="homeworld-name" class="loading-text">Fetching...</span>
                                    </div>
                                </div>
                                <a href="#" id="homeworld-link" class="btn btn-sm btn-outline-warning disabled">View Planet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 text-white border-start border-4 border-warning ps-3">Related</h4>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#films-pane">Films</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#vehicles-pane">Vehicles</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#ships-pane">Starships</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#species-pane">Species</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="films-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-films"></div></div>
                <div class="tab-pane fade" id="vehicles-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-vehicles"></div></div>
                <div class="tab-pane fade" id="ships-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-starships"></div></div>
                <div class="tab-pane fade" id="species-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-species"></div></div>
            </div>

        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-2 text-muted">Identify subject...</p>
        </div>
    </div>

    <script>
        const charId = <?= json_encode($data['id'] ?? null); ?>;

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
            'vehicles': 'vehicles',
            'starships': 'starships',
            'species': 'species',
            'planets': 'planets'
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

                $(`#${elementId}`).text(displayText).removeClass('loading-text');
                $(`#link-${elementId}`).attr('href', `/${endpoint === 'films' ? 'filme' : endpoint}/${id}`).removeClass('disabled');
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
                if (!id && item.url) id = extractIdFromUrl(item.url); // Fallback

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
            if (!charId) return;

            $.ajax({
                url: `/api/people/${charId}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const char = response.data || response;

                $('#loader').hide();
                $('#char-content').fadeIn();

                $('#char-name').text(char.name);
                $('#breadcrumb-name').text(char.name);
                $('#char-gender').text(char.gender);
                $('#char-height').text(char.height);
                $('#char-mass').text(char.mass);
                $('#char-birth').text(char.birth_year);
                $('#char-hair').text(char.hair_color);
                $('#char-eye').text(char.eye_color);
                $('#char-skin').text(char.skin_color);

                const initials = getInitials(char.name);
                $('#char-img').attr('src', `https://placehold.co/200x200/000000/FFE81F/?text=${initials}&font=montserrat`);

                if (char.homeworld) {
                    const planetId = extractIdFromUrl(char.homeworld);
                    if (planetId) {
                        $.ajax({
                            url: `/api/planets/${planetId}`,
                            method: 'GET'
                        }).done(function(res) {
                            const planet = res.data || res;
                            $('#homeworld-name').text(planet.name).removeClass('loading-text');
                            $('#homeworld-link').attr('href', `/planet/${planetId}`).removeClass('disabled');
                        });
                    }
                }

                renderRelatedList('#list-films', char.films, 'films', 'Mov');
                renderRelatedList('#list-vehicles', char.vehicles, 'vehicles', 'Veh');
                renderRelatedList('#list-starships', char.starships, 'starships', 'Ship');
                renderRelatedList('#list-species', char.species, 'species', 'Spe');

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to retrieve character data.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>