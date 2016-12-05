<?php

/*
 * @file
 *
 * Blade Loader
 */

namespace Hunter\Engine\Blade;

class Loader {

    const MAIN_NAMESPACE = '__main__';

    protected $paths = array();

    protected $cache_path;

    public function __construct($paths = array(), $cache_path) {
        if ($paths) {
            $this->setPaths($paths);
        }

        if($cache_path){
          $this->cache_path = $cache_path;
        }
    }

    public function setPaths($paths, $namespace = self::MAIN_NAMESPACE) {
        if (!is_array($paths)) {
            $paths = array($paths);
        }
        $this->paths[$namespace] = array();
        foreach ($paths as $path) {
            $this->addPath($path, $namespace);
        }
    }

    public function addPath($path, $namespace = self::MAIN_NAMESPACE) {
        if (!is_dir($path)) {
            throw new \Exception(sprintf('The "%s" directory does not exist.', $path));
        }
        $this->paths[$namespace][] = rtrim($path, '/\\');
    }

    public function getSource($name) {
        return file_get_contents($this->findTemplate($name));
    }

    public function setSource($name, $contents, $lock = false) {
        return file_put_contents($name, $contents, $lock ? LOCK_EX : 0);
    }

    public function exists($name, $cache) {
        return $this->findTemplate($name, $cache);
    }

    protected function findTemplate($name, $cache = FALSE, $namespace = self::MAIN_NAMESPACE) {
        if($cache && is_file($name)){
          return $name;
        }

        foreach ($this->paths[$namespace] as $dir) {
            $file = $dir . '/' . $name;
            if (is_file($file)) {
                return $file;
            }
        }

        return false;
    }

    public function getCachePath() {
        return $this->cache_path;
    }

    /**
     * Removes all files in this bin.
     */
    public function deleteAll() {
      return $this->unlink($this->cache_path);
    }

    /**
     * Deletes files and/or directories in the specified path.
     *
     * If the specified path is a directory the method will
     * call itself recursively to process the contents. Once the contents have
     * been removed the directory will also be removed.
     *
     * @param string $path
     *   A string containing either a file or directory path.
     *
     * @return bool
     *   TRUE for success or if path does not exist, FALSE in the event of an
     *   error.
     */
    protected function unlink($path) {
      if (file_exists($path)) {
        if (is_dir($path)) {
          // Ensure the folder is writable.
          @chmod($path, 0777);
          foreach (new \DirectoryIterator($path) as $fileinfo) {
            if (!$fileinfo->isDot()) {
              $this->unlink($fileinfo->getPathName());
            }
          }
          return @rmdir($path);
        }
        // Windows needs the file to be writable.
        @chmod($path, 0700);
        return @unlink($path);
      }
      // If there's nothing to delete return TRUE anyway.
      return TRUE;
    }

}
