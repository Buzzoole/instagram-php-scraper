<?php

namespace InstagramScraper;

use InstagramScraper\Model\CacheItem;

class CacheManager
{
    private $vars = [];
    protected static $path = '';
    protected static $instance = '';
    const TYPE_FILES = 'files';

    public static function setDefaultConfig($options)
    {
        if (isset($options['path'])){
            self::$path = $options['path'];
        }
    }

    /**
     * @param $type
     * @return CacheManager
     */
    public static function getInstance($type)
    {
        if(self::$instance == null)
        {
            $c = __CLASS__;
            self::$instance = new $c($type);
        }

        return self::$instance;
    }

    public function __construct($type)
    {
        if ($type===self::TYPE_FILES){
            if (!is_dir(self::$path)) {
                mkdir(self::$path);
            }
        }
    }

    /**
     * @param $key
     * @return CacheItem
     */
    public function getItem($key)
    {
        if (!in_array($key, $this->vars)) {
            $this->vars[$key] = new CacheItem(self::$path, $key);
        }
        return $this->vars[$key];
    }

    public function save(CacheItem $cacheItem)
    {
        return $cacheItem->save();
    }
}