<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wider text-brand-600">Référentiel Matériel
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Parc Informatique — Assigner un outil à un collaborateur
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Inventaire complet des actifs informatiques et état d'affectation en temps réel.
            </p>
        </div>

        <a href="index.php?route=home"
            class="inline-flex items-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
            &larr; Retour au portail
        </a>
    </div>


    <?php if (!$dbConnected): ?>
        <div class="bg-amber-50 border border-amber-200 p-6 rounded-xl text-center space-y-2">
            <h3 class="text-sm font-bold text-amber-900">Base de données non accessible</h3>
            <p class="text-xs text-amber-700">
                Veuillez importer le script <code class="font-bold">sql/00_init_schema.sql</code> pour afficher la liste des
                équipements.
            </p>
        </div>
    <?php else: ?>
        <div>
            <form action="">
                <select name="selectUser" id="selectUser">
                    <?php foreach ($variable as $key => $value): ?>
                        # code...
                    <?php endforeach ?>
                </select>

                <select name="selectTool" id="selectTool">
                    <?php foreach ($variable as $key => $value) {
                        # code...
                    } ?>
                </select>
                <input type="date" name="dateAjout" id="dateAjout">
            </form>
        </div>
    <?php endif ?>

</div>