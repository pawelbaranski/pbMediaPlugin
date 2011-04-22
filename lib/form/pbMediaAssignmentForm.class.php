<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//temp - for now code is put into mediaForm

//class pbMediaAssignmentForm
//{
//    public function configure()
//    {
//        parent::configure();
//
//        $this->setRecord($this->getOption('record', false));
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
//        if($this->getRecord())
//        {
//            $this->saveAssignment($this->getRecord());
//        }
//    }
//
//    protected function saveAssignment($record)
//    {
//        $assigned_media = new pbAssignedMedia();
//        $assigned_media->setMediaId($this->getObject()->getId());
//        $assigned_media->setRecordModel(get_class($record));
//        $assigned_media->setRecordId($record->getId());
//
//        $assigned_media->save();
//    }
//}

?>
