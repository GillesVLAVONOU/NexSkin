<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;

class SitemapController extends Controller
{
    public function index(): void
    {
        $projectModel = new Project();
        $projects = $projectModel->getPublished();

        header('Content-Type: application/xml; charset=UTF-8');

        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/realisations'), 'priority' => '0.9'],
            ['loc' => url('/services'), 'priority' => '0.8'],
            ['loc' => url('/a-propos'), 'priority' => '0.7'],
            ['loc' => url('/contact'), 'priority' => '0.8'],
            ['loc' => url('/mentions-legales'), 'priority' => '0.3'],
            ['loc' => url('/politique-confidentialite'), 'priority' => '0.3'],
        ];

        foreach ($projects as $project) {
            $urls[] = [
                'loc' => url('/realisations/' . $project['slug']),
                'priority' => '0.8',
                'lastmod' => date('Y-m-d', strtotime($project['updated_at'] ?? $project['created_at'] ?? 'now')),
            ];
        }

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

        foreach ($urls as $item) {
            echo "  <url>\n";
            echo '    <loc>' . escapeHtml($item['loc']) . "</loc>\n";
            if (!empty($item['lastmod'])) {
                echo '    <lastmod>' . escapeHtml($item['lastmod']) . "</lastmod>\n";
            }
            echo '    <priority>' . escapeHtml($item['priority']) . "</priority>\n";
            echo "  </url>\n";
        }

        echo "</urlset>\n";
    }
}
