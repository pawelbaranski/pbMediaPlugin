<?php

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @property record sfDoctrineRecord
 */
class PluginpbModelMediaForm extends pbMediaForm
{
//    protected
//    $record;
//
//    public function configure()
//    {
//        parent::configure();
//
//        if( !($record = $this->getOption('record', false)) )
//        {
//            throw new Exception('Record is not set');
//        }
//
//        $this->setRecord($record);
//
////        $this->embedRelation('pbAssignedMedia');
////        $this->embedRelation('pbAssignedMedia', 'pbAssignedMediaEmbeddedForm', array('record' => $record));
////        $this->embedForm('pb_assigned_media', new pbAssignedMediaEmbeddedForm(null, array('record' => $record)));
//    }
//
//    public function setRecord($record)
//    {
//        $this->record = $record;
//    }
//
//    /**
//     *
//     * @return sfDoctrineRecord
//     */
//    public function getRecord()
//    {
//        return $this->record;
//    }
//
//    protected function doSave($con = null)
//    {
//        parent::doSave($con);
//
//        $assigned_media = new pbAssignedMedia();
//        $assigned_media->setMediaId($this->getObject()->getId());
//        $assigned_media->setRecordModel(get_class($this->getRecord()));
//        $assigned_media->setRecordId($this->getRecord()->getId());
//
//        $assigned_media->save();
//    }

}

?>
