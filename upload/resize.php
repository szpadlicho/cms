<?php
include('ImageCreateFromBmp.php');
Class ImageResize{
    private $src_img;
    private $dst_img;
    private $max_width;
    private $max_height;
    public function resizeImage($file, $m_width, $m_height, $save)
    {
        $this->src_img      = $file;
        $this->max_width    = $m_width;
        $this->max_height   = $m_height;
        $this->dst_img      = $save;
        $filename = $this->src_img;
        // Content type
        //header('Content-Type: image/jpeg');
        // Get size and type
        $arr_img = list($width, $height, $type) = getimagesize($filename);
        // Get new sizes
        $max_width = $this->max_width;
        $max_height = $this->max_height;
        if($width > $max_width){//dopasowywuje jeśli zaszerokie
            $proc = ($max_width / $width) * 100;
            $new_width = $max_width;
            $new_height = ($proc / 100) * $height;
            if($new_height > $max_height){
                $proc = ($max_height / $new_height) * 100;
                $new_height = $max_height;
                $new_width = ($proc / 100) * $new_width;        
            }
        } else {
            $new_width = $width;
        }        
        if($height > $max_height){//dopasowywuje jesli zawysokie
            $proc = ($max_height / $height) * 100;
            $new_height = $max_height;
            $new_width = ($proc / 100) * $width;
            if($new_width > $max_width){
                $proc = ($max_width / $new_width) * 100;
                $new_width = $max_width;
                $new_height = ($proc / 100) * $new_height;        
            }
        } else {
            $new_height = $height;
        }
        //*
        $new_w = $new_width;
        $new_h = $new_height;
        // Create empty form
        $thumb = imagecreatetruecolor($this->max_width, $this->max_height);
        //**przeźroczystość
        imagesavealpha($thumb, true);
        //imagealphablending($thumb, false);
        $white = imagecolorallocatealpha($thumb, 255, 255, 255, 127);//127 to przeźroczystość
        imagefill($thumb, 0, 0, $white);
        //**
        // Get surroces image
        //$source = imagecreatefromjpeg($filename);
        switch ($type) {
            case 1://gif
                $source = imagecreatefromgif($filename);
                break;
            case 2://jpeg
                $source = imagecreatefromjpeg($filename);
                break;
            case 3://png
                $source = imagecreatefrompng($filename);
                break;
            case 6://bmp
                $source = ImageCreateFromBmp($filename);
                break;    
        }
        //** Positon center
        $center_w = ($this->max_width - $new_w) / 2;
        $center_h = ($this->max_height - $new_h) / 2;
        //**
        // Resize
        imagecopyresized($thumb, $source, $center_w, $center_h, 0, 0, $new_w, $new_h, $width, $height);
        // Save destyny image
        imagepng($thumb, $this->dst_img, 9);
        // Destroy handle
        imagedestroy($thumb);      
    }
}
?>