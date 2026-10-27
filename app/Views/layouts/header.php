<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? e($pageTitle) . ' | ' : '' ?><?= e(APP_NAME) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-full flex flex-col font-sans antialiased bg-slate-50 text-slate-800">

    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="flex items-center space-x-3 text-slate-900 hover:text-brand-600 transition">
                        <div class="w-9 h-9 rounded-lg bg-brand-600 text-white flex items-center justify-center font-bold shadow-sm">
                            AF
                        </div>
                        <div>
                            <span class="text-lg font-bold tracking-tight text-slate-900">Asset<span class="text-brand-600">Flow</span></span>
                            <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-xs font-semibold bg-slate-100 text-slate-600 rounded-full border border-slate-200">
                                BTS SIO SLAM
                            </span>
                        </div>
                    </a>

                    <nav class="hidden md:flex space-x-1 pl-6">
                        <a href="index.php?route=home" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50 transition">
                            Tableau de bord
                        </a>
                        <a href="index.php?route=assets" class="px-3 py-2 rounded-md text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-slate-50 transition">
                            Parc Matériel
                        </a>
                    </nav>
                </div>

                <div class="flex items-center space-x-3 text-xs">
                    <?php if (\App\Config\Database::isConnected()): ?>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-2 h-2 mr-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            BDD connectée
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-800 border border-amber-200">
                            <span class="w-2 h-2 mr-1.5 bg-amber-500 rounded-full"></span>
                            BDD non configurée
                        </span>
                    <?php endif; ?>

                    <span class="hidden lg:inline-block px-2.5 py-1 rounded-md text-xs font-mono bg-slate-100 text-slate-600 border border-slate-200">
                        PHP <?= e(PHP_VERSION) ?>
                    </span>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-grow">
