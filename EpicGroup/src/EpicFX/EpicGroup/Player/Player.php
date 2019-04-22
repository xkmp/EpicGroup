<?php
declare(strict_types = 1);
namespace EpicFX\EpicGroup\Player;

use EpicFX\EpicGroup\EpicGroup;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\Config;
use EpicFX\EpicGroup\Configs\Configs;

// 2019年4月21日 下午10:19:13
class Player
{

    private $plugin;

    /**
     * 玩家的各种操作（公会币等)
     *
     * @param EpicGroup $plugin
     */
    public function __construct(EpicGroup $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * 减少一个玩家的公会币
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return bool
     */
    public static function reducePlayerGTC($player, int $money): int
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return FALSE;
        if ($player instanceof CommandSender and $player instanceof \pocketmine\Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof \pocketmine\Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return FALSE;
        $config = Player::getPlayerConfig($player);
        $config->set("公会币", $config->get("公会币") - $money);
        return $config->save();
    }

    /**
     * 判断一个玩家是否存在配置文件
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return int 忘记公会币
     */
    public static function getPlayerGTC($player): int
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return 0;
        if ($player instanceof CommandSender and $player instanceof \pocketmine\Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof \pocketmine\Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return 0;
        return Player::getPlayerConfig($player)->get("公会币");
    }

    /**
     * 判断一个玩家是否存在配置文件
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return bool
     */
    public static function isExistConfig($player): bool
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return NULL;
        if ($player instanceof CommandSender and $player instanceof \pocketmine\Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof \pocketmine\Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return null;
        return is_file(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$PlayerPath . $name . ".yml");
    }

    /**
     * 获取一个玩家的配置文件
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return bool
     */
    public static function getPlayerConfig($player): Config
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return NULL;
        if ($player instanceof CommandSender and $player instanceof \pocketmine\Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof \pocketmine\Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return null;
        return new Config(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$PlayerPath . $name . ".yml", Config::YAML, Configs::getDPlayer());
    }

    /**
     * 过滤各种玩意获取玩家对象
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return \pocketmine\Player
     */
    public static function getAllPlayer($player): Player
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return NULL;
        if ($player instanceof CommandSender and $player instanceof \pocketmine\Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof \pocketmine\Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return null;
        return EpicGroup::$getInstance->getServer()->getPlayer($name);
    }
}