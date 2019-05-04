<?php
namespace EpicFX\EpicGroup\Configs;

use pocketmine\utils\Config;
use EpicFX\EpicGroup\EpicGroup;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;

class Configs
{

    private $plugin;

    public static function getDPlayer(): array
    {
        return array(
            "初次进入" => TRUE,
            "姓名" => NULL,
            "公会" => NULL,
            "加入游戏时间" => date("Y-m-d H:is"),
            "加公会日期" => NULL,
            "职务" => NULL,
            "未提交金币" => 0,
            "公会币" => EpicGroup::$getInstance->Config->get("默认公会币"),
            "贡献" => NULL
        );
    }

    public static function GroupEntrepotDC(): array
    {
        return array(
            "Name" => NULL,
            "Time" => date("Y-m-d H:is"),
            "Count" => 0,
            "ID" => NULL,
            "ItemName" => NULL
        );
    }

    public static function getGroupDC(): array
    {
        return array(
            "ID" => NULL,
            "Name" => NULL,
            "昵称" => NULL,
            "资金" => 0,
            "贡献" => 0,
            "等级" => 0,
            "描述" => NULL,
            "创建日期" => date("Y-m-d H:is"),
            "会长" => NULL,
            "库存" => EpicGroup::$getInstance->Config->get("默认最大库存"),
            "最大人数" => EpicGroup::$getInstance->Config->get("默认最大人数"),
            "公会伤害" => FALSE,
            "是否发送禁止PVP公告" => TRUE,
            "禁止PVP公告" => EpicGroup::$getInstance->Config->get("禁止PVP默认公告"),
            "入会缴费" => FALSE,
            "入会费用" => 1000,
            "接受申请" => TRUE,
            "贡献兑换倍率" => 100000,
            "场地" => array(
                "x1" => NULL,
                "y1" => NULL,
                "x2" => NULL,
                "y2" => NULL
            ),
            "申请" => array(),
            "未读消息" => array(),
            "出售商城" => EpicGroup::$getInstance->DefaultRecycleMall,
            "回收商城" => EpicGroup::$getInstance->DefaultRecycleMall,
            "仓库" => array(),
            "副会长" => array(),
            "精英" => array(),
            "正式成员" => array(),
            "实习成员" => array(),
            "所有成员" => array()
        );
    }

    public static function getDC(): array
    {
        return array(
            "更新检查" => true,
            "初次进入提示" => true,
            "默认公会币" => 10,
            "创建费用" => 50000,
            "过户费用" => 10000,
            "公会世界" => "Group",
            "公会彩色字付费" => FALSE,
            "默认最大人数" => 10,
            "默认最大库存" => 10,
            "禁止PVP默认公告" => "同工会误伤解除~",
            "公会彩色字付费币种" => "TGC",
            // The guild currency 公会币
            "公会彩色字付费方式" => 0,
            // 0一次性，1 单个符号付费
            "公会彩色字价格" => 1,
            "点击打开GUI" => array(
                "点击打开GUI" => true,
                "手持物品ID" => "280:0",
                "撤回事件检测" => true,
                "被点击物品ID" => "41:0"
            )
        );
    }

    /**
     * 默认回收商场配置
     *
     * @return array
     */
    public static function getRecycleMallDC(): array
    {
        return array(
            TextFormat::GREEN . "铁块" => array(
                "Money" => 5,
                "Count" => 15,
                "Grade" => TRUE,
                "ID" => "42:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "绿宝石块" => array(
                "Money" => 5,
                "Count" => 3,
                "Type" => "Sell",
                "Grade" => TRUE,
                "ID" => "133:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "金块" => array(
                "Money" => 5,
                "Count" => 10,
                "Grade" => TRUE,
                "ID" => "41:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "钻石块" => array(
                "Money" => 5,
                "Count" => 7,
                "Grade" => TRUE,
                "ID" => "57:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "草方块" => array(
                "Money" => 1,
                "Count" => 122,
                "ID" => "2:0",
                "Grade" => TRUE,
                "Items" => - 1
            ),
            TextFormat::GREEN . "泥土" => array(
                "Money" => 1,
                "Count" => 800,
                "ID" => "3:0",
                "Grade" => TRUE,
                "Items" => - 1
            ),
            TextFormat::GREEN . "石头" => array(
                "Money" => 1,
                "Count" => 250,
                "ID" => "1:0",
                "Grade" => TRUE,
                "Items" => - 1
            )
        );
    }

    /**
     * 默认公会出售商城配置
     *
     * @return array
     */
    public static function getSellMallDC(): array
    {
        return array(
            TextFormat::GREEN . "钻石剑" => array(
                "Money" => 5,
                "Count" => 12,
                "Grade" => TRUE,
                "ID" => "276:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "铁块" => array(
                "Money" => 5,
                "Count" => 12,
                "Grade" => TRUE,
                "ID" => "42:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "绿宝石块" => array(
                "Money" => 5,
                "Count" => 2,
                "Type" => "Sell",
                "Grade" => TRUE,
                "ID" => "133:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "金块" => array(
                "Money" => 5,
                "Count" => 8,
                "Grade" => TRUE,
                "ID" => "41:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "钻石块" => array(
                "Money" => 5,
                "Count" => 5,
                "Grade" => TRUE,
                "ID" => "57:0",
                "Items" => - 1
            ),
            TextFormat::GREEN . "草方块" => array(
                "Money" => 1,
                "Count" => 89,
                "ID" => "2:0",
                "Grade" => TRUE,
                "Items" => - 1
            ),
            TextFormat::GREEN . "泥土" => array(
                "Money" => 1,
                "Count" => 500,
                "ID" => "3:0",
                "Grade" => TRUE,
                "Items" => - 1
            ),
            TextFormat::GREEN . "石头" => array(
                "Money" => 1,
                "Count" => 200,
                "ID" => "1:0",
                "Grade" => TRUE,
                "Items" => - 1
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
        @mkdir($plugin->getDataFolder() . EpicGroup::$GroupPath);
        @mkdir($plugin->getDataFolder() . EpicGroup::$PlayerPath);
        $plugin->Config = new Config($plugin->getDataFolder() . "Config.yml", Config::YAML, Configs::getDC());
        $plugin->GroupIDListConfig = new Config($plugin->getDataFolder() . "GroupIDList.yml", Config::YAML, array());
        $plugin->GroupNameListConfig = new Config($plugin->getDataFolder() . "GroupNameList.yml", Config::YAML, array());
        $plugin->DefaultSellMall = new Config($plugin->getDataFolder() . "DefaultSellMall.yml", Config::YAML, Configs::getSellMallDC());
        $plugin->DefaultRecycleMall = new Config($plugin->getDataFolder() . "DefaultRecycleMall.yml", Config::YAML, Configs::getRecycleMallDC());
    }
}