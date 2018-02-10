<?php

namespace NoDrop;

use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\event\inventory\InventoryPickupArrowEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;

class NoDrop extends PluginBase implements Listener{
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    /**
     * @param PlayerDeathEvent $event
     *
     * Blocks items from dropping if they player dies
     */
    public function onPlayerDeath(PlayerDeathEvent $event){
        if($event->getEntity() instanceof Player){
            $event->setDrops([]);
        }
    }

    /**
     * @param PlayerDropItemEvent $dropItemEvent
     *
     * Block players from dropping items
     */
    public function onDrop(PlayerDropItemEvent $dropItemEvent) {
            $dropItemEvent->setCancelled();
    }

    /**
     * @param InventoryPickupItemEvent $inventoryPickupItemEvent
     *
     * Block players from picking up items
     */
    public function onPickupItem(InventoryPickupItemEvent $inventoryPickupItemEvent) {
        $inventoryPickupItemEvent->setCancelled();
    }

    /**
     * @param InventoryPickupArrowEvent $inventoryPickupArrowEvent
     *
     * Block players from picking up items
     */
    public function onPickupArrow(InventoryPickupArrowEvent $inventoryPickupArrowEvent) {
        $inventoryPickupArrowEvent->setCancelled();
    }

    /**
     * @param PlayerJoinEvent $joinEvent
     *
     * Clear the player inventory if they join
     */
    public function onJoin(PlayerJoinEvent $joinEvent) {
        $joinEvent->getPlayer()->getInventory()->clearAll();
        $joinEvent->getPlayer()->getArmorInventory()->clearAll();
    }

    /**
     * @param EntityLevelChangeEvent $entityLevelChangeEvent
     *
     * Clear the player inventory if they change worlds
     */
    public function onWorldChange(EntityLevelChangeEvent $entityLevelChangeEvent) {
        $entity = $entityLevelChangeEvent->getEntity();
        if($entity instanceof Player) {
            $entity->getInventory()->clearAll();
            $entity->getArmorInventory()->clearAll();
        }
    }
}