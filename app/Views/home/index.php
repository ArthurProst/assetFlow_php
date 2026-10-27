<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-brand-900 rounded-2xl p-8 sm:p-10 text-white shadow-lg">
        <div class="max-w-3xl space-y-3">
            <div class="inline-flex items-center space-x-2 bg-brand-500/20 text-brand-300 px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider border border-brand-500/30">
                <span>Atelier Professionnel</span>
                <span>•</span>
                <span>BTS SIO SLAM</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                AssetFlow — Portail DSI
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                Plateforme centrale de gestion et de traçabilité du parc matériel informatique. Retrouvez ci-dessous les 8 modules fonctionnels du cahier des charges à implémenter.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-900">
                    Modules Fonctionnels du Cahier des Charges
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Sélectionnez un module pour accéder à son interface de travail.
                </p>
            </div>
            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                8 modules
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($modules as $module): ?>
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-brand-600 text-white font-extrabold text-xs shadow-sm">
                                <?= e($module['code']) ?>
                            </span>
                            <span class="text-[11px] font-mono text-slate-400">
                                Module <?= e(substr($module['code'], 1)) ?>
                            </span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">
                            <?= e($module['titre']) ?>
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            <?= e($module['description']) ?>
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <a href="index.php?route=<?= e($module['route']) ?>" 
                           class="inline-flex items-center justify-center w-full px-3 py-2 rounded-lg text-xs font-semibold text-brand-700 bg-brand-50 hover:bg-brand-100 border border-brand-200 transition">
                            Consulter &rarr;
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
