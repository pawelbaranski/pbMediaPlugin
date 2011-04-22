<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FileTypeMapper
{
    static public function getMapping($key)
    {
        $mappings = sfConfig::get('app_pb_media_file_type_mapping');
        $mapping = $key;
        //check if the is a mapping for the exact file type
        if(array_key_exists($key, $mappings))
        {
            $mapping = $mappings[$key];
        }
        //check if there is a general mapping rule
        else
        {
            $key = strstr($key, '/', true);
            if($key !== false && array_key_exists($key, $mappings))
            {
                $mapping = $mappings[$key];
            }
        }

        return $mapping;
    }
}
?>
