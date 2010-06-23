<?php
/**
 * Controller for the intranet
 */
class VIH_Controller_Fotogalleri_Show extends k_Component
{
    public $map = array();
    protected $template;
    protected $mdb2;
    protected $kernel;

    function __construct(k_TemplateFactory $template, MDB2_Driver_Common $mdb2, VIH_Intraface_Kernel $kernel)
    {
        $this->template = $template;
        $this->mdb2 = $mdb2;
        $this->kernel = $kernel;
    }

    function renderHtml()
    {
        $result = $this->db->query('SELECT id FROM fotogalleri WHERE active = 1 ORDER BY date_created DESC LIMIT 1');
        if (PEAR::isError($result)) {
            throw new Exception($result->getUserInfo());
        }

        if ($row = $result->fetchRow()) {
            $this->kernel->session_id = $this->session()->sessionId();

            $appender = new VIH_AppendFile($this->kernel, 'fotogalleri', $row['id']);
            $appender->getDBQuery()->setFilter('order_by', 'name');

            $photos = $appender->getList();
            $photo = array();

            for ($i = 0, $max = count($photos); $i < $max; $i++) {
                if ($this->name == $photos[$i]['id']) {
                    $photo = $photos[$i];
                    $index = $i;
                    $filehandler = new Ilib_Filehandler($kernel, $photos[$i]['file_handler_id']);
                    $filehandler->createInstance('medium');
                    $photo['instance'] = $filehandler->instance->get();
                    if ($filehandler->get('description') != $filehandler->get('file_name')) {
                        $photo['description'] = $filehandler->get('description');
                    }
                    break;
                }
            }

            if (empty($photo)) {
                return 'Ugyldigt billede';
            }

            $previous = 0;
            if (isset($photos[$index - 1])) {
                $previous = $this->context->url($photos[$index - 1]['id']);
            }

            $next = 0;
            if (isset($photos[$index + 1])) {
                $next = $this->context->url($photos[$index + 1]['id']);
            }


            $list = array('photo' => $photo, 'previous' => $previous, 'next' => $next, 'list' => $this->context->url(NULL));

            $this->document->setTitle('Årets højdepunkter');
            $this->document->theme = 'photogallery';

            $tpl = $this->template->create('sidebar-wrapper');
            $tpl_foto = $this->template->create('Fotogalleri/foto');
            return $tpl->render($this, array('content' => $tpl_foto->render($this, $list), 'content_sub' => ''));
        }
    }
}