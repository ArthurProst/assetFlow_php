<?php
declare(strict_types=1);

namespace App\Controllers;

use RuntimeException;

abstract class BaseController
{
    /**
     * Rend une vue encapsulée dans le layout standard (header/footer).
     *
     * @param string $view Chemin relatif de la vue depuis app/Views/ (ex: 'home/index')
     * @param array<string, mixed> $data Variables injectées dans la vue
     */
    protected function render(string $view, array $data = []): void
    {
        if (!isset($data['pageTitle']) && defined('APP_NAME')) {
            $data['pageTitle'] = APP_NAME;
        }
        extract($data, EXTR_SKIP);

        $cleanView = str_replace(['../', '..\\'], '', $view);
        $viewsPath = dirname(__DIR__) . '/Views/';
        $viewFile = $viewsPath . $cleanView . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException("La vue demandée '{$cleanView}' est introuvable (chemin testé : {$viewFile}).");
        }

        $headerFile = $viewsPath . 'layouts/header.php';
        $footerFile = $viewsPath . 'layouts/footer.php';

        if (file_exists($headerFile)) {
            require $headerFile;
        }

        require $viewFile;

        if (file_exists($footerFile)) {
            require $footerFile;
        }
    }

    /**
     * Effectue une redirection HTTP immédiate et interrompt le script.
     */
    protected function redirect(string $url, int $statusCode = 302): never
    {
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
}