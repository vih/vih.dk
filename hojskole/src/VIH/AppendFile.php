<?php
class VIH_AppendFile extends Ilib_Filehandler_AppendFile
{
    public function __construct($kernel, $belong_to, $belong_to_id)
    {
        $this->registerBelongTo(0, '_invalid_');
        $this->registerBelongTo(1, 'ansat');
        $this->registerBelongTo(2, 'facilitet');
        $this->registerBelongTo(3, 'dokumenter');
        $this->registerBelongTo(4, 'korkursus');
        $this->registerBelongTo(5, 'langtkursus_fag');
        $this->registerBelongTo(6, 'fotogalleri');

        if(!in_array($belong_to, $this->belong_to_types)) {
            throw new Exception("AppendFile->__construct unknown type");
        }

        $this->belong_to_key = $this->getBelongToKey($belong_to);
        $this->belong_to_id = (int)$belong_to_id;

        parent::__construct($kernel, $belong_to, $belong_to_id);
    }
}