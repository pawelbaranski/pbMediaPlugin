<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class pbFile
{
  /**
   * Deletes file which filename matches given patern
   * @param array $directory - directories from which files will be deleted
   * @param string $pattern - common file pattern rules
   * @param boolean $recursive - if subdirectories should by also included, default = false
   * @return array of deleted filenames
   */
  static public function deleteLike(array $directories, $pattern, $recursive = false)
  {
    $filenames = array();

    foreach($directories as $directory)
    {
      $filenames = array_merge($filenames, self::deleteLikeFromDir($directory, $pattern));
    }

    return $filenames;
  }

  static public function deleteLikeFromDir($directory, $pattern, $recursive = false)
  {
    $filenames = array();
    $files = glob($directory.'/'.$pattern);
    
    foreach($files as $file)
    {
      @unlink($file);
      $filenames[] = $file;
    }

    return $filenames;
  }

  static public function deleteMultipleLikeFromDir($directory, array $patterns, $recursive = false)
  {
    $filenames = array();

    foreach($patterns as $pattern)
    {
      $filenames = array_merge($filenames, self::deleteLikeFromDir($directory, $pattern));
    }

    return $filenames;
  }

  static public function deleteFiles($directory, array $filenames)
  {
    $deleted = array();

    foreach($filenames as $file)
    {
      @unlink($directory.'/'.$file);
      $deleted[] = $file;
    }

    return $deleted;
  }
}

?>
