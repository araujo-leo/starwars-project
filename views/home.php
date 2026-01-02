<?php include __DIR__ . '/partials/header.php'; ?>

    <div class="row mb-3">
        <div class="col">
            <h1>Catálogo de Filmes</h1>
            <p class="lead">A saga completa consumida via API.</p>
        </div>
    </div>

    <div id="loading" class="text-center py-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
    </div>

    <div id="films-container" class="row g-4">

    </div>

<?php include __DIR__ . '/partials/footer.php'; ?>