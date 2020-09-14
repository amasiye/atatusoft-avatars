<?php

class Home extends Controller
{
  public function index($width = '', $height = '')
  {
    if (!isset($width) || empty($width)) {
      $width = 1024;
    }

    if (!isset($height) || empty($height)) {
      if (!empty($width)) {
        $height = $width;
      }
    }

    $path = dirname(__DIR__, 1) . '/assets/images/avatars/png/';
    $images = scandir($path);

    # Remove the first two entries (i.e . and ..)
    array_shift($images);
    array_shift($images);
    
    $filename = $path . $images[rand(0, count($images) - 1)];
    $filename = str_replace('/', DIRECTORY_SEPARATOR, $filename);
    
    $image = $this->load_png($filename, $width, $height);
    // var_export($image); exit;

    $this->view('home/index', ['image' => $image]);
  }

  private function load_png($img_name, $width = 1024, $height = 1024)
  {
    $width = (int)$width;
    $height = (int)$height;

    list($src_width, $src_height) = getimagesize($img_name);

    /* Attempt to open */
    $im_p = @imagecreatetruecolor($width, $height);
    $im = @imagecreatefrompng($img_name);

    /* See if it failed */
    if (!$im) {
      /* Create a blank image */
      $im  = imagecreatetruecolor($width, $height);
      $bgc = imagecolorallocate($im, 255, 255, 255);
      $tc  = imagecolorallocate($im, 0, 0, 0);

      imagefilledrectangle($im, 0, 0, $width, $height, $bgc);

      /* Output an error message */
      imagestring($im, 1, 5, 5, 'Error loading ' . $img_name, $tc);
      return $im;
    } else {
      @imagecopyresampled($im_p, $im, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
    }

    return $im_p;
  }
}

?>