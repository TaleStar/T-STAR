<?php

namespace pocketmine\auth;

use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\Utils;
use pocketmine\utils\TextFormat;

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;



class Auth implements Listener{
	
	}
	public function onEnable(){
		 @mkdir($this->getDataFolder());   
   $this->pass=  new Config($this->getDataFolder()."PassWord.yml", Config::YAML, array());
   $this->login=  new Config($this->getDataFolder()."Login.yml", Config::YAML, array());
		$this->getLogger()->info("login test");
	}
	public function onJoin(PlayerJoinEvent $e){
		
		$p = $e->getPlayer();
		$n = $p->getName();
		
		$this->login->set($n,"no");
		$this->login->save();
		if($this->pass->get($n) == null){
			$p->sendmessage("please type password");
		}else{
			
			$p->sendmessage("please login first");
			
		}
			
	}
	
	public function onChat(PlayerChatEvent $e){
		$log = $this->login;
		$n = $e->getPlayer()->getName();
		$pass = $this->pass;
			
		if($log->get($n) == "no"){
				$msg = $e->getMessage();
				if($this->pass->get($n) == null){
					
					$pass->set($n,$msg);
					$pass->save();
					$e->getPlayer()->sendmessage("accessful register , your password is ".$msg);
					$log->set($n,"yes");
					$log->save();
				
					$e->setCancelled();
				}else{
					
					if($pass->get($n) == $msg){
						$e->getPlayer()->sendmessage("accessful login");
						$log->set($n,"yes");
						$log->save();
						$e->setCancelled();
					}else{
						$e->getPlayer()->sendmessage("password is no true");
						
					}
				
				}
		}
	
		
		
	}
	public function onDI(PlayerDropItemEvent $e){
	    $p = $e->getPlayer();
		if($this->if($p) == "nl"){
			$e->setCancelled();
		}
	}
	public function onTouch(PlayerInteractEvent $e){
		$p = $e->getPlayer();
		if($this->if($p) == "nl"){
			$e->setCancelled();
		}
	}
	public function onCmdChat(PlayerCommandPreprocessEvent $e){
		$p = $e->getPlayer();
		$pass = $this->pass;
		$msg = $e->getMessage();
		if($pass->get($p->getName()) == $msg || $pass->get($p->getName()) == null){
			
			
		}else{
		if($this->if($p) == "nl"){
			$e->setCancelled();
		}
	  }
	}
	public function onMove(PlayerMoveEvent $e){
		$p = $e->getPlayer();
		if($this->if($p) == "nl"){
			//$e->setCancelled();
		}
	}
	public function if($p){
		$log = $this->login;
		$n = $p->getName();
		if($log->get($n) == "no"){
			$p->sendmessage("please login first");
			return "nl";
			
		}else{
			return "yl";
		}
	}
	
}
