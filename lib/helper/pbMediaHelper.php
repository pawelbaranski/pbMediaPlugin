<?php

function pb_image($image, $options = array())
{
  $image_view = new pbImageView($image, $options);
  return $image_view;
}

?>
