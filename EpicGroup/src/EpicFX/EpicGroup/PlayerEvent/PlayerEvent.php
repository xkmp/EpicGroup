<?php
namespace EpicFX\EpicGroup\PlayerEvent;

use EpicFX\EpicGroup\EpicGroup;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use EpicFX\EpicGroup\Configs\Configs;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use EpicFX\EpicGroup\Group\Group;
use pocketmine\Player;

// 2019年4月18日 下午12:57:25
class PlayerEvent implements Listener
{

    private $plugin;

    public function __construct(EpicGroup $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * 被人干了
     *
     * @param EntityDamageEvent $e
     */
    public function onEntityDamage(EntityDamageEvent $e)
    {
        $player = $e->getEntity();
        if ($e instanceof EntityDamageByEntityEvent) {
            $Bkill = $e->getDamager();
            if ($Bkill === NULL or ! $Bkill instanceof Player)
                return;
        }
        if (! \EpicFX\EpicGroup\Player\Player::isExistConfig($Bkill) || ! \EpicFX\EpicGroup\Player\Player::isExistConfig($player))
            return;
        if (Group::isPlayerAsPlayerToGroup($player, $Bkill) and ! $this->plugin->Config->get("公会伤害")) {
            $e->setCancelled();
            $group = \EpicFX\EpicGroup\Player\Player::getGroup($player);
            if ($group->isBanPVPMsg())
                $Bkill->sendMessage($group->getBanPVPMsg());
        }
    }

    /**
     * 吗哈皮滚蛋了
     *
     * @param PlayerQuitEvent $e
     */
    public function onPlayerQuit(PlayerQuitEvent $e)
    {}

    public function onPlayerJoin(PlayerJoinEvent $e)
    {
        $plugin = $this->plugin;
        $player = $e->getPlayer();
        $PlayerConfig = Configs::getPlayerConfig($player);
        if ($PlayerConfig->get("初次进入")) {
            $array = Configs::getDPlayer();
            $array["初次进入"] = FALSE;
            $array["姓名"] = $player->getName();
            $PlayerConfig->setAll($array);
            $PlayerConfig->save();
            if ($plugin->Config->get("初次进入提示")) {
                $player->sendMessage(TextFormat::WHITE . "[" . TextFormat::RED . $plugin->getName() . TextFormat::WHITE . "] " . TextFormat::GREEN . "欢迎您来到" . TextFormat::GOLD . $plugin->getServer()
                    ->getMotd() . TextFormat::GREEN . "，本服务器支持公会玩法！详情输入" . TextFormat::WHITE . "/公会 帮助 " . TextFormat::GREEN . "查看相关玩法哦");
            }
        }
    }
}