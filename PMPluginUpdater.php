<?php
namespace Author\Plugin;

use pocketmine\utils\Utils;
use pocketmine\utils\MainLogger;
/*
This updater class has been made by the (r) MC-PE.GA All rights reserved.
This updater has the purpose to update a plugin new version very easily
Put this into your folder, call it with new Updater($this); and the see the magic !
*/

class Updater {
  
  const PREFIX = "§l§o§a[§r§b§6Updater§o§a]§f§r ";
  
  public function __connstruct(\pocketmine\plugin\Plugin $main) {
    $this->main = $main;
    $version = $main->getDescription()->getVersion();
    $name = $main->getDescription()->getName();
    $author = $main->getDescription()->getAuthors()[0];
    MainLogger::getLogger()->info(self::PREFIX . "Searching for updates for $name ... This can take some minutes...");
    $utd = json_decode(Utils::getURL("http://updater.mc-pe.ga/" . $author . "/" . $name . "/main.json", 40));
    list($umajor, $uminor, $upatch) = explode(".", $utd->version);
    list($major, $minor, $patch) = explode(".", $version);
    if($umajor > $major) {
      MainLogger::getLogger()->info(self::PREFIX . "New update found for $name ! Version " . $utd->version . ". Downloading new version...");
      $this->update($name, $utd->ltd);
    } elseif($uminor > $miner) {
      MainLogger::getLogger()->info(self::PREFIX . "New update found for $name ! Version " . $utd->version . ". Downloading new version...");
      $this->update($name, $utd->ltd);
    } elseif($upatch > $patch) {
      MainLogger::getLogger()->info(self::PREFIX . "New update found for $name ! Version " . $utd->version . ". Downloading new version...");
      $this->update($autor, $name, $utd->ltd);
    } else {
      MainLogger::getLogger()->info(self::PREFIX . "$name is up to date !";
    }
  }
  
  
  public function update(string $author, string $name, string $dl) {
    $r = new ReflectionMethod(get_class($this->main), 'isPhar');
    $r->setAccessible(true);
    $isPhar = $r->invoke($this->main); //Don't worry :) It's a small hack to accessif it's a phar or not.
    if($isPhar) {
      $path = Phar::running(false);
      $this->main->setEnable(false);
      unlink($path);
      file_put_contents($this->main->getServer()->getPluginPath() . $dl, Utils::getURL("http://updater.mc-pe.ga/" . $author . "/" . $name . "/" . $dl, 40));
      $plugin = $this->getServer()->getPluginManager()->loadPlugin($this->main->getServer()->getPluginPath() . $dl);
      $this->getServer()->getPluginManager()->enablePlugin($plugin);
    } else {
      if (PHP_OS == 'WINNT') {
        echo "Your development of $name version is no longer up to date ! Are you sure you want to update or you want to keep your modified version? ";
        $cmd = stream_get_line(STDIN, 1024, PHP_EOL);
      } else {
        $cmd = readline(self::PREFIX . "Your development version of $name is no longer up to date ! Are you sure you want to update or you want to keep your modified version? ");
      }
      if($cmd == "true") {
        $this->main->setEnable(false);
        file_put_contents($this->main->getServer()->getPluginPath() . $dl, Utils::getURL("http://updater.mc-pe.ga/" . $author . "/" . $name . "/" . $dl, 40));
        $plugin = $this->getServer()->getPluginManager()->loadPlugin($this->main->getServer()->getPluginPath() . $dl);
        $this->getServer()->getPluginManager()->enablePlugin($plugin);
      }
    }
  }
  
  
}
