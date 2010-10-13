<?php
/**
 * Filehandler til at uploade og vise billeder (samt redigere)
 *
 * Det er vel lidt fjollet, at den hedder en filehandler, hvis den er til billeder?
 * S� b�r den hedde ImageHandler? Men det kunne jo v�re kvikt om FileHandler ogs� kunne
 * klare upload af fx pdf'er?
 *
 * @todo - klassen skal lige dokumenteres.
 * @todo - m�ske skal gif ikke v�re underst�ttet - der er vist nogle problemer med rettigheder.
 *         Jeg tror vi skal sl� den underst�ttelse fra, for der er en del af de der
 *         php-hall�jsaer, der ikke helt kan h�ndtere dem?
 *
 * @author Sune Jensen <sj@sunet.dk>
 **/
class VIH_FileHandler
{
    public $id;
    public $error = array();
    public $value;
    public $instance_type = array();
    public $allowed_transform_image = array('jpg', 'jpeg', 'gif', 'png');
    public $file_types;
    public $upload_path;
    public $tempdir_path;
    public $file_viewer;
    public $www_path;
    public $instance_path;
    public $kernel;

    /**
     * void init.
     *
     * @param id id p� fil.
     */
    function __construct($id = 0)
    {
        $this->loadMimeTypes();

        $this->kernel = new VIH_Intraface_Kernel;
        $this->kernel->intranet = new VIH_Intraface_Intranet;
        $this->kernel->user = new VIH_Intraface_User;
        $im = new Ilib_Filehandler_InstanceManager($this->kernel);
        $this->instance_type = $im->getList();

        $this->upload_path = PATH_UPLOAD . $this->kernel->intranet->get('id') . '/';
        $this->tempdir_path = $this->upload_path.PATH_UPLOAD_TEMPORARY;
        $this->file_viewer = FILE_VIEWER;
        $this->www_path = PATH_WWW;
        $this->instance_path = $this->upload_path.'instance/';

        settype($id, 'integer');
        $this->id = (int)$id;
        if ($this->id > 0) {
            $this->load();
        }

    }

    /**
     *
     */
    function load()
    {
        $db = new DB_Sql;
        $db->query("SELECT * FROM file_handler WHERE active = 1 AND id = ".$this->id);
        if (!$db->nextRecord()) {
            return false;
        }

        $this->value['id'] = $db->f('id');
        $this->value['date_created'] = $db->f('date_created');
        $this->value['date_updated'] = $db->f('date_changed');
        $this->value['file_name'] = $db->f('file_name');
        $this->value['server_file_name'] = $db->f('server_file_name');
        $this->value['original_server_file_name'] = $this->value['server_file_name'];
        $this->value['file_size'] = $db->f('file_size');
        $this->value['file_type'] = $this->file_types[$db->f('file_type_key')];
        $this->value['access_key'] = $db->f('access_key');

        $this->value['file_path'] = $this->upload_path . $db->f('server_file_name');
        if (!file_exists($this->value['file_path'])) {
            return;
        }
        $this->value['original_file_path'] = $this->value['file_path'];

        $this->value['last_modified'] = filemtime($this->get('file_path'));

        $this->value['file_uri'] = $this->file_viewer.'?/'.$this->kernel->intranet->get('public_key').'/'.$this->get('access_key').'/'.urlencode($this->get('file_name'));

        return true;
    }

    private function getInstanceType($type)
    {
        for ($i = 0, $max = count($this->instance_type); $i < $max; $i++) {
            if (isset($this->instance_type[$i]['name']) && $this->instance_type[$i]['name'] == $type) {
                return $this->instance_type[$i];
                exit;
            }
        }

        return false;
    }

    function loadInstance($type, $param = array())
    {
        if ($this->id == 0) {
            return 0;
        }

        $type_prop = $this->getInstanceType($type);
        if ($type_prop === false) {
            return 0;
            throw new Exception("Ugyldig type i FileHandler->loadInstance");
        }

        $db = new DB_Sql;
        $db->query("SELECT * FROM file_handler_instance WHERE active = 1 AND file_handler_id = ".$this->id." AND type_key = ".$type_prop['type_key']);
        if (!$db->nextRecord()) {
            $id = $this->createInstance($type, $param);

            $db->query("SELECT * FROM file_handler_instance WHERE active = 1 AND id = ".$id);
            if (!$db->nextRecord()) {
                return 0; //throw new Exception("Kunne ikke hente instance i FileHandler->loadInstance");
            }
        }

        $this->value['instance_id'] = $db->f('id');
        $this->value['date_created'] = $db->f('date_created');
        $this->value['date_updated'] = $db->f('date_changed');
        $this->value['server_file_name'] = $db->f('server_file_name');
        $this->value['file_size'] = $db->f('file_size');
        $this->value['type'] = $type;
        $this->value['file_path'] = PATH_UPLOAD_INSTANCE . $db->f('server_file_name');
        $this->value['file_path'] = $this->instance_path . $db->f('server_file_name');
        if (!file_exists($this->get('file_path'))) {
            return;
        }
        $this->value['last_modified'] = filemtime($this->get('file_path'));

        $this->value['file_uri'] = FILE_VIEWER.'?/'.$this->kernel->intranet->get('public_key').'/'.$this->get('access_key').'/'.$this->get('type').'/'.urlencode($this->get('file_name'));

        return true;
    }

    function createInstance($type, $param = array())
    {
        $type_prop = $this->getInstanceType($type);
        if ($type_prop === false) {
            return 0;
            throw new Exception("Ugyldig type i FileHandler->createInstance");
        }

        $mime_type = $this->get('file_type');
        $extension = $mime_type['extension'];

        if (!in_array($extension, $this->allowed_transform_image)) {
            return 0;
            throw new Exception("Den type fil kan ikke manipuleres i FileHandler->createInstance");
        }
        $original_file_path = $this->get('original_file_path');
        if (!file_exists($original_file_path)) {
            return 0;
        }

        // imagelibrary b�r s�ttes udefra p� en eller anden m�de
        $image = Image_Transform::factory(IMAGE_LIBRARY);
        $error = $image->load($this->get('original_file_path'));

        if ($error !== true) {
            return 0;
            throw new Exception("Kunne ikke åbne fil i FileHandler->createInstance. ".$error->getMessage());
        }

        // print('filehandler type_key'.$type.$type_prop['type_key']);

        if (!empty($type_prop['fixed'])) { // square

            // skal lige resizes f�rst!
            if ($image->img_x > $image->img_y) {
                $image->scaleByY($type_prop['max_height']);
            } else {
                $image->scaleByX($type_prop['max_width']);
            }
            if ($image->crop($type_prop['max_width'], $type_prop['max_height']) !== true){
                throw new Exception("Der opstod en fejl under formatering (crop) af billedet i FileHandler->createInstance");
            }
        } else {

            if ($image->fit($type_prop['max_width'], $type_prop['max_height']) !== true) {
                throw new Exception("Der opstod en fejl under formatering (fit) af billedet i FileHandler->createInstance");
            }

            // skal tage h�jde for b�de h�jde og bredde max
            // Nu tager den istedet n�rmere h�jde for at det ikke er strict
            /*
            if ($image->img_x < $image->img_y) {
                $image->scaleByY($type_prop['max_height']);
            }
            else {
                $image->scaleByX($type_prop['max_width']);
            }

            if ($image->crop($type_prop['max_width'], $type_prop['max_height']) !== true){
                throw new Exception("Der opstod en fejl under formatering (crop) af billedet i FileHandler->createInstance");
            }
            */

        }

        $instance_id = $this->updateInstance(array('type' => $type));
        $server_file_name = $instance_id.'.'.$extension;

        if ($image->save($this->instance_path.$server_file_name) !== true) {
            throw new Exception("Kunne ikke gemme billedet i FileHandler->createInstance");
        }

        $size = filesize($this->instance_path.$server_file_name);

        $imagesize = getimagesize($this->instance_path.$server_file_name);
        $width = $imagesize[0]; // imagesx($file);
        $height = $imagesize[1]; // imagesy($file);

        return $this->updateInstance(array('server_file_name' => $server_file_name, 'file_size' => $size, 'width' => $width, 'height' => $height), $instance_id);
    }

    /**
     * @todo - B�r denne metode hedde saveInstance()
     */
    function updateInstance($input, $id = 0)
    {
        if (!is_array($input)) {
            throw new Exception("Input skal være et array i FileHandler->updateInstance");
        }

        $input = array_map("mysql_escape_string", $input);
        $input = array_map("strip_tags", $input);
        $input = array_map("trim", $input);

        settype($id, 'integer');

        $sql = array();
        $sql[] = "date_changed = NOW()";
        $sql[] = "file_handler_id = ".$this->id;

        if (isset($input['type'])) {
            $type_prop = $this->getInstanceType($input['type']);
            if ($type_prop === false) {
                throw new Exception("Ugyldig type i FileHandler->updateInstance");
            }
            $sql[] = 'type_key = '.$type_prop['type_key'];
        }

        if (isset($input['file_size'])) {
            $sql[] = 'file_size = '.(int)$input['file_size'];
        }
        if (isset($input['server_file_name'])) {
            $sql[] = 'server_file_name = "'.$input['server_file_name'].'"';
        }

        if (isset($input['width'])) {
            $sql[] = 'width = "'.$input['width'].'"';
        }

        if (isset($input['height'])) {
            $sql[] = 'height = "'.$input['height'].'"';
        }

        $db = new DB_Sql;

        if ($id > 0) {
            $db->query('UPDATE file_handler_instance SET '.implode(", ", $sql).' WHERE id = '.$id);
        } else {
            $db->query('INSERT INTO file_handler_instance SET '.implode(", ", $sql).', date_created = NOW(), active = 1');
            $id = $db->insertedId();
        }

        return $id;
    }

    function upload($field_name)
    {

        $upload = new HTTP_Upload('en');

        $file = $upload->getFiles($field_name);

        if ($file->isError()) {
            $this->error[] = $file->getMessage();
            return false;
        }

        $prop = $file->getProp(); // returnere et array med oplysninger om filen.

        if (!$file->isValid()) {
            $this->error[] = "Filen er ikke en gyldig upload fil";
            return false;
        }
        if (!isset($prop['ext']) || $prop['ext'] == "") {
            // Ved ikke om denne skal v�re der. Mener at mac-computere tit undlader at bruge extensions. /Sune 2/3 2006
            // den skal v�re der, synes jeg for jeg har ofte oplevet at mac snyder / lo
            $this->error[] = 'Filen mangler en filtype, f.eks. .pdf';
            return false;
        }

        // $instance_id = $this->updateInstance(array('type' => 'original', ));

        $id = $this->update(array('file_name' => $prop['real'], 'file_size' => $prop['size'], 'file_type' => $prop['type']));


        $server_file_name = $id.".".strtolower($prop['ext']);
        $file->setName($server_file_name);

        $moved = $file->moveTo($this->upload_path);

        if (PEAR::isError($moved)) {
            $this->error[] = 'Der opstod en fejl under flytningen af filen';
            return false;
        }

        $mime_type = $this->_getMimeType($prop['type'], 'mime_type');
        if ($mime_type['image']) {
            $imagesize = getimagesize($this->upload_path.$server_file_name);
            $width = $imagesize[0]; // imagesx($file);
            $height = $imagesize[1]; // imagesy($file);
        } else {
            $width = 0;
            $height = 0;
        }

        $this->update(array('server_file_name' => $server_file_name, 'width' => $width, 'height' => $height));

        $this->load();

        return $id;
    }

    /**
     * @todo - denne metode b�r hedde save() fordi den ikke updater, men gemmer
     */
    function update($input)
    {
        $db = new DB_Sql;

        if (!is_array($input)) {
            throw new Exception("Input skal være et array i FileHandler->updateInstance");
        }

        $input = array_map("mysql_escape_string", $input);
        $input = array_map("strip_tags", $input);
        $input = array_map("trim", $input);

        $sql = array();

        $sql[] = 'date_changed = NOW()';

        if (isset($input['file_name'])) {
            $sql[] = 'file_name = "'.$input['file_name'].'"';
        }

        if (isset($input['server_file_name'])) {
            $sql[] = 'server_file_name = "'.$input['server_file_name'].'"';
        }

        if (isset($input['file_size'])) {
            $sql[] = 'file_size = '.(int)$input['file_size'];
        }

        if (isset($input['file_type_key'])) {
            $mime_type = $this->_getMimeType($input['file_type_key'], 'key');
            $sql[] = 'file_type_key = "'.$input['file_type_key'].'"';
        } elseif (isset($input['file_type'])) {
            $mime_type = $this->_getMimeType($input['file_type'], 'mime_type');
            $sql[] = 'file_type_key = "'.$mime_type['key'].'"';
        } elseif ($this->id == 0) {
            throw new Exception('you need to provide a file type the first time you save an image');
            exit;
        }

        $sql[] = 'accessibility_key = 3';

        if ($this->id != 0) {
            $db->query("UPDATE file_handler SET ".implode(', ', $sql)." WHERE id = ".$this->id);
        } else {
            $sql[] = 'access_key = "'.$this->kernel->randomKey(50).'"';
            $sql[] = 'active = 1';

            $db->query("INSERT INTO file_handler SET ".implode(', ', $sql).", date_created = NOW()");
            $this->id = $db->insertedId();
        }

        return $this->id;
    }

    function get($key = '')
    {
        if (!empty($key)) {
            if (!empty($this->value[$key])) {
                return $this->value[$key];
            }
            return '';
        }
        return $this->value;
    }

    function getError($format = "")
    {

        if ($format == 'html') {
            return implode('<br />', $this->error);
        } else {
            return $this->error;
        }
    }

    /**
     * Metoden spytter et image-tag ud og det er xhtml.
     *
     * @author Lars Olesen <lars@legestue.net>
     *
     * @param $alt Alternativ tekst, hvis billedet ikke vises
     * @return img-tag eller en tom streng, hvis der ikke er noget billede at vise
     **/
    function getImageHtml($alt = '', $attr = '')
    {
        if ($this->id == 0) {
            return '';
        }
        return '<img src="'.$this->get('file_uri').'" alt="'.$alt.'" '.$attr.' />';
    }

    private function loadMimeTypes()
    {
        $filetype = new Ilib_Filehandler_FileType();
        $this->file_types = $filetype->getList();
    }

    private function _getMimeType($key, $from = 'key')
    {
        if (empty($this->file_types)) {
            $this->loadMimeTypes();
        }

        if ($from == 'key') {
            if (!is_integer($key)) {
                throw new Exception("Når der skal findes mimetype fra key (default), skal første parameter til FileHandler->_getMimeType være en integer");
            }
            return $this->file_types[$key];
        }

        if (in_array($from, array('mime_type', 'extension'))) {
            foreach ($this->file_types AS $file_key => $file_type) {
                if ($file_type[$from] == $key) {
                    // Vi putter lige key med i arrayet
                    $file_type['key'] = $file_key;
                    return $file_type;
                }
            }
        }

        return false;
    }
}