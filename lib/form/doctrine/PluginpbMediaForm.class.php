<?php

/**
 * PluginMedia form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginpbMediaForm extends BasepbMediaForm
{
//    protected
//    $record;

    public function configure()
    {        
        parent::configure();

        $this->setRecord($this->getOption('record', false));

//        $this->widgetSchema['upload']  = new sfWidgetFormInputFile(array());

        $this->widgetSchema['upload']  = new sfWidgetFormInputFileEditable(
                    array(
                        'file_src' => $this->isNew() ? '' : $this->getObject()->getWebPath(),
                        'edit_mode' => !$this->isNew(),
                    )
                );

        /** validators **/

        $this->validatorSchema['upload_delete'] = new sfValidatorPass();

        $this->validatorSchema['upload'] = new sfValidatorFile(array(
                'path' => pbMedia::mediaDir(),
                'required' => $this->isNew(),
                ));

        unset($this['created_at'], $this['updated_at'], $this['type'], $this['file_name'], $this['file_dir'], $this['file_type']);
    }

    public function processValues($values)
    {
//        $values = parent::processValues($values);
        $upload = $values['upload'];

        //if delete flag was set - delete file/s
        if($values['upload_delete'])
        {
            $this->processDelete();
        }
        //if flag was not set and user set a file to upload
        else if($upload)
        {
            //if object exist - delete file/s
            if(!$this->isNew())
            {
                $this->processDelete();
            }
            //set values of new file
            $values['name'] = (!empty($values['name']) ? $values['name'] : $upload->getOriginalName());
            $values['file_name'] = $upload->generateFilename();
            $values['file_dir']  = $upload->getPath();
            $values['file_type']  = $upload->getType();
            $upload->save($values['file_name']);
        }

        return $values;
    }

    protected function processDelete()
    {
        $this->getObject()->deleteFile();
    }

    public function setRecord($record)
    {
        $this->record = $record;
    }

    /**
     *
     * @return sfDoctrineRecord
     */
    public function getRecord()
    {
        return $this->record;
    }

    protected function doSave($con = null)
    {
        parent::doSave($con);

        if($this->getRecord())
        {
            $this->saveAssignment($this->getRecord());
        }
    }

    protected function saveAssignment($record)
    {
        $assigned_media = new pbAssignedMedia();
        $assigned_media->setMediaId($this->getObject()->getId());
        $assigned_media->setRecordModel(get_class($record));
        $assigned_media->setRecordId($record->getId());

        $assigned_media->save();
    }
    
}
