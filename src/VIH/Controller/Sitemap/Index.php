<?php
class VIH_Controller_Sitemap_Index
{
    function renderHtml()
    {
        $title = 'Sitemap';
        $meta['description'] = '';
        $meta['keywords'] = 'sitemap';

        $this->document->setTitle($title);
        $this->document->meta = $meta;
        $this->document->body_class = 'nosidebar';
        return '
            <h1>Sitemap</h1>
            <dl class="sitemap">
                <dt><a href="' . $this->url('/') . '">Forside</a></dt>
                <dd>
                    <dl>
                        <dt><a href="'.url('/hojskole/') .'">Idr�tsh�jskolen</a></dt>
                        <dd><a href="'.url('/langekurser/') .'">Lange kurser</a></dd>
                        <dd><a href="'.url('/kortekurser/') .'">Korte kurser</a></dd>
                    </dl>
                <dd>
                    <dl>
                    </dl>
                </dd>
                <dd>
                    <dl>
                        <dt><a href="'.url('/faciliteter/') .'">Faciliteter</a></dt>
                    </dl>
                </dd>
            </dl>
        ';
    }

    function renderXml()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
    <urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
        <url>
            <loc>http://www.vih.dk/nyheder/</loc>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/kortekurser/</loc>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/langekurser/</loc>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/nyheder/</loc>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/underviser/</loc>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/faciliteter/</loc>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>

        <url>
            <loc>http://www.vih.dk/info/</loc>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>

    </urlset>';
    }
}
