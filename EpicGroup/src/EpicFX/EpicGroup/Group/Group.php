<?php
declare(strict_types = 1);
namespace EpicFX\EpicGroup\Group;

use EpicFX\EpicGroup\EpicGroup;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\Config;
use EpicFX\EpicGroup\Configs\Configs;
use EpicFX\EpicGroup\Instrument\SmallTools;

// 2019年4月21日 下午10:16:44
class Group
{

    private $plugin;

    /**
     * 公会名称
     *
     * @var string
     */
    private $GroupName;

    /**
     * 公会配置文件
     *
     * @var Config
     */
    private $GroupConfig;

    public function __construct(EpicGroup $plugin, string $GroupName = NULL)
    {
        $this->plugin = $plugin;
        $this->GroupName = $GroupName;
        if ($GroupName !== NULL)
            $this->GroupConfig = Group::getGroupConfig($GroupName);
    }

    /**
     * 获取公会等级
     *
     * @return int
     */
    public function getExpLevel(): int
    {
        $times = SmallTools::ComputationTimeToArray(date("Y-m-d H:is") - strtotime($this->GroupConfig->get("创建日期")));
        $players = count($this->GroupConfig->get("所有成员"));
        $money = $this->GroupConfig->get("资金") / 1000;
        $sell = count($this->GroupConfig->get("出售商城")) / 2;
        $shop = count($this->GroupConfig->get("回收商城")) / 2;
        $sb = $this->GroupConfig->get("贡献") / 5;
        $maxPlayer = $this->GroupConfig->get("最大人数") / 10;
        $in = 0;
        if ($maxPlayer > 0 and $players > 0)
            $in = ($sb / $maxPlayer - $sb / $players);
        $kcupup = $this->GroupConfig->get("库存");
        $items = 0;
        if (count($kcupup) > 0 and $maxPlayer > 0 and $players > 0) {
            foreach ($kcupup as $item) {
                $items += $item["Count"];
            }
            $items = $items / count($kcupup) / ($maxPlayer - $players);
        }
        return (int) ($players * 1.5 + $times["天"] + $times["年"] * 10 + $money + $sell + $shop + $sb + $maxPlayer - $in + $items);
    }

    /**
     * 判断玩家是否在该公会
     *
     * @param \pocketmine\Player|CommandSender|ConsoleCommandSender $player
     * @return bool
     */
    public function isPlayer($player): bool
    {
        $player = \EpicFX\EpicGroup\Player\Player::getAllPlayer($player);
        if ($player === NULL)
            return FALSE;
        return in_array($player->getName(), $this->GroupConfig->get("所有成员"));
    }

    /**
     * 获取所有成员列表
     *
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->GroupConfig->get("所有成员");
    }

    /**
     * 获取当前公会配置文件
     *
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->GroupConfig;
    }

    /**
     * 检查玩家是否在一个公会内部
     *
     * @param Player|CommandSender|ConsoleCommandSender $player
     * @return bool
     */
    public static function isPlayerInGroup($player): bool
    {
        $name = null;
        if ($player instanceof ConsoleCommandSender)
            return NULL;
        if ($player instanceof CommandSender and $player instanceof Player)
            $name = $player->getName();
        if (is_string($player))
            $name = $player;
        if (! $player instanceof Player and ! is_string($player) and ! $player instanceof CommandSender and ! is_string($name) and $name !== NULL)
            return null;
        if (\EpicFX\EpicGroup\Player\Player::isExistConfig($name)) {
            $config = \EpicFX\EpicGroup\Player\Player::getPlayerConfig($name);
            return ($config->get("公会", NULL) !== NULL);
        } else {
            return FALSE;
        }
    }

    /**
     * 获取公会配置文件
     *
     * @param string $GroupName
     * @return config
     */
    public static function getGroupConfig(string $GroupName): config
    {
        $GroupID = Group::UnknownToID($GroupName);
        if ($GroupID === NULL)
            return NULL;
        return new Config(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$GroupPath . EpicGroup::$getInstance->GroupIDListConfig->get($GroupName), Config::YAML, Configs::getGroupDC());
    }

    /**
     * 判断两个玩家是否在一个公会内部
     *
     * @param Player|CommandSender|ConsoleCommandSender $player1
     * @param Player|CommandSender|ConsoleCommandSender $player2
     * @return bool
     */
    public static function isPlayerAsPlayerToGroup($player1, $player2): bool
    {
        $player1 = \EpicFX\EpicGroup\Player\Player::getAllPlayer($player1);
        $player2 = \EpicFX\EpicGroup\Player\Player::getAllPlayer($player2);
        if ($player2 === NULL or $player1 === NULL)
            return FALSE;
        if (! \EpicFX\EpicGroup\Player\Player::isExistConfig($player2) or ! \EpicFX\EpicGroup\Player\Player::isExistConfig($player1))
            return FALSE;
        if (! Group::isPlayerInGroup($player1) or ! Group::isPlayerInGroup($player2))
            return FALSE;
        return (\EpicFX\EpicGroup\Player\Player::getPlayerConfig($player1)->get("公会") === \EpicFX\EpicGroup\Player\Player::getPlayerConfig($player2)->get("公会"));
    }

    /**
     * 根据公会名称获取公会ID
     *
     * @param string $GroupName
     * @return string
     */
    public static function UnknownToID(string $GroupName): string
    {
        if ($EpicGroup = EpicGroup::$getInstance->GroupNameListConfig->get($GroupName, NULL) !== NULL)
            return $EpicGroup;
        $GroupName = newGroup::BarcaToName($GroupName);
        if ($EpicGroup = EpicGroup::$getInstance->GroupIDListConfig->get($GroupName, NULL) !== NULL)
            return $GroupName;
        return EpicGroup::$getInstance->GroupNameListConfig->get($GroupName, NULL);
    }

    public function isBanPVPMsg(): bool
    {
        return $this->getConfig()->get("是否发送禁止PVP公告", FALSE);
    }

    public function getBanPVPMsg(): string
    {
        return $this->getConfig()->get("禁止PVP公告", Configs::getGroupDC()["禁止PVP公告"]);
    }
}