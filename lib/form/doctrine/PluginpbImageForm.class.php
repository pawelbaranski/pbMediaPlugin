<?php

/**
 * PluginImage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginpbImageForm extends BasepbImageForm
{
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['upload']->setOption('is_image', true)
                                     ->setOption('with_delete', true);

        $this->validatorSchema['upload']->setOption('mime_types', 'web_images');
    }

    protected function processDelete()
    {
        //deletes main file
        parent::processDelete();
        //deletes thumbnails
        $this->getObject()->deleteThumbnails();
    }

}
