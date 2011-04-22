<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once dirname(__FILE__).'/../vendor/WideImage/WideImage.php';
//include "WideImage/WideImage.php";

/**
 * pbImageView
 *
 * @property Image $image
 * @property string $link
 *
 */
class pbImageView
{
    protected
    $image,
    $attributes,
    $link,
    $thumbnail;

  public function __construct(pbImage $image, $options = array())
  {
    $this->image = $image;
    
    $this->attributes             = array_key_exists('attributes', $options) ? $options['attributes'] : array();
    
    $this->link['as_link']        = array_key_exists('as_link', $options) ? $options['as_link'] : false;
    $this->link['href']           = array_key_exists('link_href', $options) ? $options['link_href'] : false;
    $this->link['attributes']     = array_key_exists('link_attributes', $options) ? $options['link_attributes'] : array();
    $this->link['blank']          = array_key_exists('blank', $options) ? $options['blank'] : false;

    $this->thumbnail['width']     = array_key_exists('width', $options) ? $options['width'] : null;
    $this->thumbnail['height']    = array_key_exists('height', $options) ? $options['height'] : null;
    $this->thumbnail['method']    = array_key_exists('method', $options) ? $options['method'] : 'inside';
    $this->thumbnail['web_path']  = false;
  }

  /**
   * Sets dimensions for the thumbnail
   * @param integer $width
   * @param integer $height
   * @return ImageView
   */
  public function size($width, $height)
  {
    $this->thumbnail['width']   = $width;
    $this->thumbnail['height']  = $height;

    return $this;
  }

  /**
   * Sets the scale method for the thumbnail
   * @param string $method
   * @return ImageView
   */
  public function method($method)
  {
    $this->thumbnail['method']  = $method;

    return $this;
  }

  public function setAttribute($name, $value)
  {
    $this->attributes[$name] = $value;

    return $this;
  }

  public function setLinkAttribute($name, $value)
  {
    $this->link['attributes'][$name] = $value;

    return $this;
  }

  /**
   * Is called the image will be in <a> tag, with html attributes passed as parameters
   * @param array $attributes html attributes
   * @return ImageView
   */
  public function asLink($attributes = array(), $link_href = false)
  {
    $this->link['as_link'] = true;
    $this->link['href'] = $link_href;
    $this->link['attributes'] = $attributes;
    
    return $this;
  }

  public function blank($value = true)
  {
    $this->link['blank'] = $value;

    return $this;
  }

  protected function getTitle()
  {
    return $this->image->getTitle();
  }

  /**
   *
   * @return string
   */
  public function getWebPath()
  {    
    if(!$this->thumbnail['web_path'])
    {        
        //if web_path was not set yet and either width or height is specified
        if(!is_null($this->thumbnail['width']) || !is_null($this->thumbnail['height']))
        {            
            //create thumbnail
            $this->thumbnail['web_path'] = pbMedia::toWebPath($this->image->getThumbnailsDir().'/'.$this->createThumbnail());
        }
        else
        {
            //get source image as is
            $this->thumbnail['web_path'] = $this->image->getWebPath();
        }
    }
    
    return $this->thumbnail['web_path'];
  }

  /**
   * Adds width, height and method values to filename to make it unique for the main Image object
   * @return string
   */
  protected function generateFilename()
  {
    $width  = 'w'.$this->thumbnail['width'];
    $height = 'h'.$this->thumbnail['height'];
    $method = 'm'.$this->thumbnail['method'];
    
    return $width.$height.$method.'f'.$this->image->getFileName();
  }

  public function __toString()
  {      
      return $this->render();
  }

  public function render()
  {
    $html = 'Brak zdjęcia';
    
    if($this->image->getId() && file_exists($this->image->getPath()))
    {        
        $attributes = $this->attributes;
        $id    = array_key_exists('id', $attributes) ? ' id="'.$attributes['id'].'" ' : '';
        $class = array_key_exists('class', $attributes) ? ' class="'.implode(' ',$attributes['class']).'" ' : '';
        $style = array_key_exists('style', $attributes) ? ' style="'.implode(';',$attributes['style']).'" ' : '';        
        $html = '<img '.$id.$class.$style.' title="'.$this->getTitle().'" src="'.$this->getWebPath().'" >';

        if($this->link['as_link'])
        {
            $html = $this->getImageLink($html);
        }
    }

    

    return $html;
  }

  /**
   * First it checks if thumbnail is in cache, if not it creates new thumbnail
   * @return boolean true if thumbnail was created
   */
  protected function createThumbnail()
  {
      
    $filename = $this->generateFilename();

    if(!$this->isInThumbnailsDir($filename))
    {        
      $image = WideImage::load($this->image->getPath());

      $image = $image->resize($this->thumbnail['width'], $this->thumbnail['height'], $this->thumbnail['method']);

      $image->saveToFile($this->image->getThumbnailsDir().'/'.$filename);
    }

    return $filename;
  }

  protected function isInThumbnailsDir($filename)
  {
      return file_exists($this->image->getThumbnailsDir().'/'.$filename);
  }

  /**
   * Creates image link with href to the original file
   * @param string $html
   * @return string
   */
  protected function getImageLink($html)
  {
    $attributes = $this->link['attributes'];
    
    $id    = array_key_exists('id', $attributes) ? ' id="'.$attributes['id'].'" ' : '';
    $class = array_key_exists('class', $attributes) ? ' class="'.implode(' ',$attributes['class']).'" ' : '';
    $target = $this->link['blank'] ? ' target="_blank" ' : '' ;

    $href = $this->link['href'] === false ? $this->image->getWebPath() : $this->link['href'];

    $html = '<a href="'.$href.'"'.$id.$class.$target.'>'.$html.'</a>';
    
    return $html;
  }

}

?>
