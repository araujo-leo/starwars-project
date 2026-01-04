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
            color: #888;
            font-size: 0.8rem;
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
            height: 100%;
            transition: transform 0.2s;
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
            background-color: #1e1e1e; border: 1px solid #333; border-radius: 8px;
            padding: 10px; display: flex; align-items: center; gap: 12px;
            transition: all 0.3s ease; text-decoration: none; color: #fff;
        }

        .data-chip:hover {
            background-color: #252525;
            border-color: #FFE81F;
            transform: translateY(-2px);
            color: #FFE81F;
        }

        .chip-avatar {
            width: 45px;
            height: 45px;
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
            width: 80px;
            height: 12px;
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
                <li class="breadcrumb-item"><a href="/species" class="text-decoration-none text-warning">Species</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page" id="breadcrumb-name">Loading...</li>
            </ol>
        </nav>

        <div id="species-content" style="display: none;">

            <div class="row mb-5">
                <div class="col-md-4 text-center d-flex flex-column align-items-center">
                    <img id="species-img" src="" class="rounded-circle border border-3 border-warning shadow-lg mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                    <h1 class="display-5 fw-bold text-white mb-0" id="species-name"></h1>
                    <div class="mt-2">
                        <span class="badge bg-dark border border-secondary text-warning px-3 py-2" id="species-classification"></span>
                        <span class="badge bg-secondary text-light px-3 py-2" id="species-designation"></span>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4 class="text-starwars mb-3 border-bottom border-secondary pb-2">Biological Traits</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Avg Height</div>
                                <div class="text-value"><span id="species-height"></span> cm</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Avg Lifespan</div>
                                <div class="text-value"><span id="species-lifespan"></span> yrs</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Language</div>
                                <div class="text-value text-capitalize" id="species-language"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Eye Colors</div>
                                <div class="text-value text-capitalize" style="font-size: 0.9rem;" id="species-eyes"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Hair Colors</div>
                                <div class="text-value text-capitalize" style="font-size: 0.9rem;" id="species-hair"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Skin Colors</div>
                                <div class="text-value text-capitalize" style="font-size: 0.9rem;" id="species-skin"></div>
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
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#people-pane">Characters</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#films-pane">Films</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="people-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-people"></div></div>
                <div class="tab-pane fade" id="films-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-films"></div></div>
            </div>

        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-2 text-muted">Analyzing DNA...</p>
        </div>
    </div>

    <script>
        const speciesId = <?= json_encode($data['id'] ?? null); ?>;

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
                                <div class="chip-name"><span id="${elementId}" class="loading-text"></span></div>
                            </div>
                        </a>
                    </div>
                `;
                container.append(html);
                fetchItemName(type, id, elementId);
            });
        }

        $(document).ready(function() {
            if (!speciesId) return;

            $.ajax({
                url: `/api/species/${speciesId}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const s = response.data || response;

                $('#loader').hide();
                $('#species-content').fadeIn();

                $('#species-name').text(s.name);
                $('#breadcrumb-name').text(s.name);
                $('#species-classification').text(s.classification);
                $('#species-designation').text(s.designation);

                $('#species-height').text(s.average_height);
                $('#species-lifespan').text(s.average_lifespan);
                $('#species-language').text(s.language);
                $('#species-eyes').text(s.eye_colors);
                $('#species-hair').text(s.hair_colors);
                $('#species-skin').text(s.skin_colors);

                const initials = getInitials(s.name);
                $('#species-img').attr('src', `https://placehold.co/200x200/000000/FFE81F/?text=${initials}&font=montserrat`);

                if (s.homeworld) {
                    const planetId = extractIdFromUrl(s.homeworld);
                    if (planetId) {
                        $.ajax({
                            url: `/api/planets/${planetId}`,
                            method: 'GET'
                        }).done(function(res) {
                            const planet = res.data || res;
                            $('#homeworld-name').text(planet.name).removeClass('loading-text');
                            $('#homeworld-link').attr('href', `/planets/${planetId}`).removeClass('disabled');
                        }).fail(function() {
                            $('#homeworld-name').text("Unknown Location").removeClass('loading-text');
                        });
                    }
                } else {
                    $('#homeworld-name').text("n/a").removeClass('loading-text');
                }

                renderRelatedList('#list-people', s.people, 'people', 'Char');
                renderRelatedList('#list-films', s.films, 'films', 'Mov');

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to retrieve species data.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>