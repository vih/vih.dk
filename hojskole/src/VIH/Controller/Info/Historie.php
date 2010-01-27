<?php
class VIH_Controller_Info_Historie extends k_Controller
{
    function GET()
    {
        $data = file_get_contents($this->url('/gfx/folder/historie.pdf'));

        $response = new k_http_Response(200, $data);
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