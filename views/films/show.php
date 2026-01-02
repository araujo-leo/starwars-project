<?php include __DIR__ . '/../partials/header.php'; ?>

    <style>
        body { background-color: #121212 !important; color: #e0e0e0 !important; }

        /* Typography & Colors */
        .text-starwars { color: #FFE81F; text-shadow: 0 0 10px rgba(255, 232, 31, 0.3); }
        .text-accent { color: #4db8ff; }

        /* Components */
        .crawl-container {
            background-color: #000;
            border: 2px solid #FFE81F;
            border-radius: 8px;
            padding: 2rem;
            font-family: 'Courier New', Courier, monospace;
            color: #FFE81F;
            line-height: 1.8;
            font-size: 1.1rem;
            text-align: justify;
            box-shadow: 0 0 15px rgba(255, 232, 31, 0.2);
        }

        .stat-box {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            transition: transform 0.2s;
        }
        .stat-box:hover { transform: translateY(-3px); border-color: #FFE81F; }
        .info-label { color: #888; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .info-value { color: #fff; font-size: 1rem; font-weight: 500; }

        /* TABS Styling */
        .nav-tabs { border-bottom: 1px solid #333; margin-bottom: 20px; }
        .nav-link { color: #888; border: none; font-weight: bold; transition: 0.3s; padding: 10px 20px; }
        .nav-link:hover { color: #e0e0e0; background-color: rgba(255, 255, 255, 0.05); border-radius: 5px; }
        .nav-link.active {
            background-color: transparent !important;
            color: #FFE81F !important;
            border-bottom: 3px solid #FFE81F;
        }

        /* DATA CHIPS (Cards compactos para lista) */
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
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .data-chip:hover {
            background-color: #252525;
            border-color: #FFE81F;
            transform: translateY(-2px);
            color: #FFE81F;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .chip-avatar {
            width: 45px; height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #444;
            flex-shrink: 0;
            background-color: #000;
        }
        .chip-content {
            flex-grow: 1;
            min-width: 0; /* Garante que o text-truncate funcione */
        }
        .chip-name {
            font-weight: bold;
            font-size: 0.95rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .chip-meta {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #777;
        }

        /* Animação de Loading no Texto */
        .loading-text {
            display: inline-block;
            width: 80px;
            height: 12px;
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
                <li class="breadcrumb-item"><a href="/">Films</a></li>
                <li class="breadcrumb-item active" aria-current="page" id="breadcrumb-title">Loading...</li>
            </ol>
        </nav>

        <div id="film-content" style="display: none;">

            <div class="row mb-5 align-items-center">
                <div class="col-md-4 text-center">
                    <img id="film-img" src="" class="img-fluid rounded shadow-lg border border-secondary" style="max-height: 450px;">
                </div>
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold text-white mb-0" id="film-title"></h1>
                    <h4 class="text-starwars mb-4" id="film-episode"></h4>

                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="info-label">Director</div>
                                <div class="info-value" id="film-director"></div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="stat-box">
                                <div class="info-label">Producer</div>
                                <div class="info-value" id="film-producer"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-box">
                                <div class="info-label">Release Date</div>
                                <div class="info-value" id="film-date"></div>
                            </div>
                        </div>
                    </div>

                    <div class="crawl-container" style="max-height: 200px; overflow-y: auto;">
                        <p id="film-crawl" class="mb-0 small"></p>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-5">

            <h4 class="mb-4 text-white border-start border-4 border-warning ps-3">Related</h4>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="chars-tab" data-bs-toggle="tab" data-bs-target="#chars-pane" type="button">Characters</button></li>
                <li class="nav-item"><button class="nav-link" id="planets-tab" data-bs-toggle="tab" data-bs-target="#planets-pane" type="button">Planets</button></li>
                <li class="nav-item"><button class="nav-link" id="ships-tab" data-bs-toggle="tab" data-bs-target="#ships-pane" type="button">Starships</button></li>
                <li class="nav-item"><button class="nav-link" id="vehicles-tab" data-bs-toggle="tab" data-bs-target="#vehicles-pane" type="button">Vehicles</button></li>
                <li class="nav-item"><button class="nav-link" id="species-tab" data-bs-toggle="tab" data-bs-target="#species-pane" type="button">Species</button></li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="chars-pane"><div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="list-characters"></div></div>
                <div class="tab-pane fade" id="planets-pane"><div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="list-planets"></div></div>
                <div class="tab-pane fade" id="ships-pane"><div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="list-starships"></div></div>
                <div class="tab-pane fade" id="vehicles-pane"><div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="list-vehicles"></div></div>
                <div class="tab-pane fade" id="species-pane"><div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3" id="list-species"></div></div>
            </div>

        </div>

        <div id="loader" class="text-center py-5">
            <div class="spinner-border text-starwars" style="width: 3rem; height: 3rem;" role="status"></div>
            <p class="mt-2 text-muted">Retrieving data from the archives...</p>
        </div>
    </div>

    <script>
        const filmId = <?= json_encode($data['id'] ?? null); ?>;

        const resourceMap = {
            'characters': 'people',
            'people': 'people',
            'planets': 'planets',
            'starships': 'starships',
            'vehicles': 'vehicles',
            'species': 'species'
        };

        // Helpers
        function episodeNumberToRoman(num) {
            const roman = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1};
            let str = '';
            for (let i of Object.keys(roman)) {
                let q = Math.floor(num / roman[i]);
                num -= q * roman[i];
                str += i.repeat(q);
            }
            return str;
        }

        function formatDate(dateString) {
            if(!dateString) return 'Unknown';
            return new Date(dateString).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        function extractIdFromUrl(url) {
            if (!url || typeof url !== 'string') return null;
            const matches = url.match(/\/(\d+)\/?$/);
            return matches ? matches[1] : null;
        }

        function fetchItemName(type, id, elementId) {
            const endpointName = resourceMap[type] || type;

            const url = `/api/${endpointName}/${id}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const data = response.data || response;
                $(`#${elementId}`).text(data.name).removeClass('loading-text');

                $(`#link-${elementId}`).attr('href', `/${endpointName}/${id}`).removeClass('disabled');
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
                let id = null;
                let itemUrl = '';

                if (typeof item === 'object' && item !== null) {
                    if (item.id) {
                        id = item.id;
                    }
                    else if (item.url) {
                        id = extractIdFromUrl(item.url);
                        itemUrl = item.url;
                    }
                } else if (typeof item === 'string') {
                    id = extractIdFromUrl(item);
                }

                if (!id) return;

                const uniqueElementId = `name-${type}-${id}`;
                const uniqueLinkId = `link-${uniqueElementId}`;
                const avatar = `https://placehold.co/100x100/333/FFE81F/?text=${icon}&font=roboto`;

                const html = `
                    <div class="col">
                        <a href="#" id="${uniqueLinkId}" class="data-chip disabled">
                            <img src="${avatar}" class="chip-avatar" alt="icon">
                            <div class="chip-content">
                                <div class="chip-name">
                                    <span id="${uniqueElementId}" class="loading-text"></span>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                container.append(html);

                fetchItemName(type, id, uniqueElementId);
            });
        }

        $(document).ready(function() {
            if (!filmId) return;

            $.ajax({
                url: `/api/films/${filmId}`,
                method: 'GET',
                dataType: 'json'
            }).done(function(response) {
                const film = response.data || response;

                $('#loader').hide();
                $('#film-content').fadeIn();

                $('#film-title').text(film.title);
                $('#breadcrumb-title').text(film.title);
                $('#film-episode').text('Episode ' + episodeNumberToRoman(film.episode_id));
                $('#film-director').text(film.director);
                $('#film-producer').text(film.producer);
                $('#film-date').text(formatDate(film.release_date));

                const formattedCrawl = film.opening_crawl ? film.opening_crawl.replace(/\r\n/g, '<br>').replace(/\n/g, '<br>') : '';
                $('#film-crawl').html(formattedCrawl);

                const romanEp = episodeNumberToRoman(film.episode_id);
                $('#film-img').attr('src', `https://placehold.co/400x550/000000/FFE81F/?text=EPISODE+${romanEp}&font=montserrat`);

                // Chamadas para as listas
                renderRelatedList('#list-characters', film.characters, 'characters', 'Char');
                renderRelatedList('#list-planets', film.planets, 'planets', 'Plan');
                renderRelatedList('#list-starships', film.starships, 'starships', 'Ship');
                renderRelatedList('#list-vehicles', film.vehicles, 'vehicles', 'Vehi');
                renderRelatedList('#list-species', film.species, 'species', 'Spec');
            });
        });
    </script>

<?php include __DIR__ . '/../partials/footer.php'; ?>