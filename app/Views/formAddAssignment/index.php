<?php

/**
 * @var array<int, array<string, mixed>> $users
 * @var array<int, array<string, mixed>> $assets
 */
?>
<div class="flex items-center justify-center">
    <form action="" method="post" class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 sm:p-8 max-w-2xl space-y-6">

        <div class="space-y-1">
            <h2 class="text-lg font-bold tracking-tight text-slate-900">Nouvelle affectation</h2>
            <p class="text-sm text-slate-500">Choisissez le collaborateur, l'équipement et la date d'affectation.</p>
        </div>

        <div class="space-y-2">
            <label for="selectUser" class="block text-sm font-medium text-slate-700">Collaborateur</label>
            <select name="selectUser" id="selectUser" required
                class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                <option value="" disabled selected>Sélectionner un collaborateur</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= e($user['id']) ?>">
                        <?= e($user['prenom'] . ' ' . $user['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="space-y-2">
            <label for="selectAsset" class="block text-sm font-medium text-slate-700">Équipement</label>
            <select name="selectAsset" id="selectAsset" required
                class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
                <option value="" disabled selected>Sélectionner un équipement</option>
                <?php foreach ($assets as $asset): ?>
                    <?php if ($asset['statut'] !== 'disponible') continue; ?>
                    <option value="<?= e($asset['id']) ?>">
                        <?= e($asset['code_inventaire'] . ' — ' . $asset['designation']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="space-y-2">
            <label for="dateAjout" class="block text-sm font-medium text-slate-700">Date d'affectation</label>
            <input type="date" name="dateAjout" id="dateAjout" required
                class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30">
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="index.php?route=assets"
                class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 transition shadow-sm">
                Annuler
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500/50 transition shadow-sm">
                Assigner l'équipement
            </button>
        </div>

    </form>
</div>