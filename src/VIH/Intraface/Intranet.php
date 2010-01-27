<?php
class VIH_Intraface_Intranet
{
    public $values;

    public function __construct()
    {
        $this->values = array(
            'id' => 0,
            'public_key' => 'file');
    }

    public function get($key)
    {
        return $this->values[$key];
    }
}
