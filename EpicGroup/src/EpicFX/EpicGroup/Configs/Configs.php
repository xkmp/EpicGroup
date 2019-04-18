<?php
namespace EpicFX\EpicGroup\Configs;

use pocketmine\utils\Config;
use EpicFX\EpicGroup\EpicGroup;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;

class Configs
{

    private $plugin;

    public static function getDPlayer(): array
    {
        return array(
            "初次进入"=>TRUE,
            "姓名" => NULL,
            "公会" => NULL,
            "加入游戏时间" => date("Y-m-d H:is"),
            "加公会日期" => NULL,
            "职务" => NULL,
            "公会币" => EpicGroup::$getInstance->Config->get("默认公会币"),
            "贡献" => NULL
        );
    }

    public static function getDC(): array
    {
        return array(
            "更新检查" => true,
            "初次进入提示" => true,
            "默认公会币" => 10,
            "点击打开GUI" => array(
                "点击打开GUI" => true,
                "手持物品ID" => "280:0",
                "撤回事件检测" => true,
                "被点击物品ID" => "41:0"
            )
        );
    }

    /**
     * 获取玩家配置文件对象
     *
     * @param Player|string|CommandSender|ConsoleCommandSender $player
     * @return Config
     */
    public static function getPlayerConfig($player): Config
    {
        if ($player instanceof ConsoleCommandSender)
            return NULL;
        if ($player instanceof CommandSender or $player instanceof Player)
            $player = $player->getName();
        return new Config(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$PlayerPath . $player . "." . EpicGroup::$getInstance->getName(), Config::YAML, Configs::getDPlayer());
    }

    public function __construct(EpicGroup $plugin)
    {
        $this->plugin = $plugin;
        @mkdir($plugin->getDataFolder());
        @mkdir($plugin->getDataFolder() . EpicGroup::$ProfitPath);
        @mkdir($plugin->getDataFolder() . EpicGroup::$PlayerPath);
        $plugin->Config = new Config($plugin->getDataFolder() . "Config.yml", Config::YAML, Configs::getDC());
        $plugin->ListConfig = new Config($plugin->getDataFolder() . "GroupList.yml", Config::YAML, array());
    }
}