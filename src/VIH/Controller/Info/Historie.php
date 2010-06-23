<?php
class VIH_Controller_Info_Historie extends k_Component
{
    protected $template;

    function __construct(k_TemplateFactory $template)
    {
        $this->template = $template;
    }

    function renderPdf()
    {
        $data = file_get_contents($this->url('/gfx/folder/historie.pdf'));

        $response = new k_HttpResponse(200, $data);
        $response->setEncoding(NULL);
        $response->setContentType("application/pdf");

        $response->setHeader("Content-Length", strlen($data));
        $response->setHeader("Content-Disposition", "attachment; filename=\"foobar.pdf\"");
        $response->setHeader("Content-Transfer-Encoding", "binary");
        $response->setHeader("Cache-Control", "Public");
        $response->setHeader("Pragma", "public");
        throw $response;
    }

}