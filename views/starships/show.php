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
                <li class="breadcrumb-item"><a href="/starships" class="text-decoration-none text-warning">Starships</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page" id="breadcrumb-name">Loading...</li>
            </ol>
        </nav>

        <div id="ship-content" style="display: none;">

            <div class="row mb-5">
                <div class="col-md-4 text-center d-flex flex-column align-items-center">
                    <img id="ship-img" src="" class="rounded border border-3 border-warning shadow-lg mb-3" style="width: 100%; max-width: 350px; height: 220px; object-fit: cover;">
                    <h1 class="display-6 fw-bold text-white mb-0" id="ship-name"></h1>
                    <p class="mt-1" id="ship-model"></p>
                    <span class="badge bg-dark border border-secondary text-warning mt-1 px-3 py-2" id="ship-class"></span>
                </div>

                <div class="col-md-8">
                    <h4 class="text-starwars mb-3 border-bottom border-secondary pb-2">Technical Specs</h4>
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Hyperdrive Rating</div>
                                <div class="text-value text-warning"><span id="ship-hyperdrive"></span></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">MGLT</div>
                                <div class="text-value"><span id="ship-mglt"></span></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Max Atm. Speed</div>
                                <div class="text-value"><span id="ship-speed"></span></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Cost</div>
                                <div class="text-value"><span id="ship-cost"></span></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Length</div>
                                <div class="text-value"><span id="ship-length"></span> m</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="text-label">Cargo Capacity</div>
                                <div class="text-value"><span id="ship-cargo"></span> kg</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="text-label">Crew</div>
                                <div class="text-value" id="ship-crew"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="text-label">Passengers</div>
                                <div class="text-value" id="ship-passengers"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="stat-box text-start px-4">
                                <div class="text-label">Manufacturer</div>
                                <div class="text-value" id="ship-manufacturer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 text-white border-start border-4 border-warning ps-3">Related</h4>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pilots-pane">Pilots</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#films-pane">Films</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="pilots-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-pilots"></div></div>
                <div class="tab-pane fade" id="films-pane"><div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3" id="list-films"></div></div>
            </div>
        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-2 text-muted">Calculating hyperspace coordinates...</p>
        </div>
    </div>

    <script>
        const shipId = <?= json_encode($data['id'] ?? null); ?>;

        function getInitials(name) {
            if (!name) return "S";
            const matches = name.match(/(\b\S)?/g);
            return matches ? matches.join("").match(/(^\S|\S$)?/g).join("").toUpperCase() : "S";
        }

        function extractIdFromUrl(url) {
            if (!url || typeof url !== 'string') return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        function formatNumber(num) {
            if (!num || isNaN(num)) return num;
            return parseInt(num).toLocaleString();
        }

        const resourceMap = {
            'films': 'films',
            'pilots': 'people'
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
                if(endpoint === 'people') frontendLink = 'character';
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
                if (type === 'films') avatar = `https://placehold.co/80x100/111/FFE81F/?text=FILM&font=montserrat`;

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
            if (!shipId) return;

            $.ajax({
                url: `/api/starships/${shipId}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const s = response.data || response;

                $('#loader').hide();
                $('#ship-content').fadeIn();

                $('#ship-name').text(s.name);
                $('#breadcrumb-name').text(s.name);
                $('#ship-model').text(s.model);
                $('#ship-class').text(s.starship_class);

                const initials = getInitials(s.name);
                $('#ship-img').attr('src', `https://placehold.co/400x250/000000/FFE81F/?text=${initials}&font=montserrat`);

                $('#ship-hyperdrive').text(s.hyperdrive_rating);
                $('#ship-mglt').text(s.MGLT);
                $('#ship-speed').text(s.max_atmosphering_speed);

                $('#ship-cost').text(s.cost_in_credits !== 'unknown' ? formatNumber(s.cost_in_credits) + ' credits' : 'Unknown');
                $('#ship-length').text(formatNumber(s.length));
                $('#ship-crew').text(formatNumber(s.crew));
                $('#ship-passengers').text(formatNumber(s.passengers));
                $('#ship-cargo').text(formatNumber(s.cargo_capacity));
                $('#ship-manufacturer').text(s.manufacturer);

                renderRelatedList('#list-pilots', s.pilots, 'pilots', 'Plt');
                renderRelatedList('#list-films', s.films, 'films', 'Mov');

            }).fail(function() {
                $('#loader').html('<div class="alert alert-danger">Failed to retrieve starship data.</div>');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>