<?php

namespace InstagramScraper\Model;

class CacheItem
{
    protected $val = '';
    protected $key = '';

    public function __construct($path, $key)
    {
        $this->key = $key;
        $this->filename = $path . DIRECTORY_SEPARATOR . md5($this->key);
        if (is_file($this->filename)) {
            if (time() - filemtime($this->filename) < 60*15){
                $this->val = @file_get_contents($this->filename);
                $json = json_decode($this->val, true);
                if ($json) {
                    $this->val = $json;
                }
            }else{
                unlink($this->filename);
            }
        }
    }

    public function get()
    {
        return $this->val;
    }

    public function set($val)
    {
        $this->val = $val;
    }

    public function save()
    {
        file_put_contents($this->filename, json_encode($this->val));
    }
}