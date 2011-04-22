<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMapper
{
    static public function getMapping($key)
    {
        $mappings = sfConfig::get('app_pb_media_model_name_mapping');
        return array_key_exists($key, $this->mappings) ? $this->mappings[$key] : $key;
    }
}

?>
