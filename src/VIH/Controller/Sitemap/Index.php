<?php
class VIH_Controller_Sitemap_Index
{
    function GET()
    {
        $title = 'Sitemap';
        $meta['description'] = '';
        $meta['keywords'] = 'sitemap';

        $this->document->title = $title;
        $this->document->meta = $meta;
        $this->document->body_class = 'nosidebar';
        return '
            <h1>Sitemap</h1>
            <dl class="sitemap">
                <dt><a href="' . url('/') . '">Forside</a></dt>
                <dd>
                    <dl>
                        <dt><a href="'.url('/hojskole/') .'">Idrætshøjskolen</a></dt>
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
}
