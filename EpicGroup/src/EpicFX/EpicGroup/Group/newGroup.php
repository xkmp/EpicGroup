<?php
namespace EpicFX\EpicGroup\Group;

use EpicFX\EpicGroup\EpicGroup;
use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use EpicFX\EpicGroup\Instrument\SmallTools;
use onebone\economyapi\EconomyAPI;
use pocketmine\utils\Config;
use EpicFX\EpicGroup\Configs\Configs;

// 2019年4月18日 下午6:30:07
class newGroup
{

    public static $ColorFontKey = "0123456789abcdefghijklmnopqrstuvwxyz";

    private $plugin;

    public function __construct(EpicGroup $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     *
     * @param Player|CommandSender|ConsoleCommandSender $player
     * @param string $GroupName
     * @return array
     */
    public function ToNewGroup($player, String $GroupName): bool
    {
        $plugin = $this->plugin;
        if ($player instanceof ConsoleCommandSender) {
            $player->sendMessage(TextFormat::RED . "很抱歉！作为控制台您无法创建一个公会！");
            return FALSE;
        }
        if ($player instanceof CommandSender) {
            $player = $plugin->getServer()->getPlayer($player->getName());
            if ($player === null or ! $player->isOnline()) {
                $plugin->getServer()
                    ->getLogger()
                    ->info(TextFormat::WHITE . $player->getName() . TextFormat::RED . "正在创建一个公会，但是他并不在服务器，请检查");
                return FALSE;
            }
        }
        if (is_string($player)) {
            $player = $plugin->getServer()->getPlayer($player);
            if ($player === null or ! $player->isOnline()) {
                $plugin->getServer()
                    ->getLogger()
                    ->info(TextFormat::WHITE . $player . TextFormat::RED . "正在创建一个公会，但是他并不在服务器，请检查");
                return FALSE;
            }
        }
        if (! $player instanceof Player and ! is_string($player)) {
            $plugin->getServer()
                ->getLogger()
                ->info(TextFormat::RED . "正有进程尝试创建一个公会，但是参数错误！请检查。");
            return FALSE;
        }
        if (! newGroup::isGroupNameExist($GroupName)) {
            $player->sendMessage(TextFormat::RED . "该公会名称不可用！请更换名称后重试！推荐使用：" . TextFormat::WHITE . newGroup::getRandGroupName($GroupName));
            return FALSE;
        }
        if (EconomyAPI::getInstance()->myMoney($player) < $plugin->Config->get("创建费用")) {
            $player->sendMessage(TextFormat::RED . "您的余额不足以支付创建公会所需要的费用！");
            return FALSE;
        }
        if (Group::isPlayerInGroup($player)) {
            $player->sendMessage(TextFormat::RED . "利当前已经在一个公会内部！");
            return FALSE;
        }
        if ($plugin->GroupIDListConfig->get(GroupNameListConfig, NULL) !== NULL or $plugin->GroupNameListConfig->get(newGroup::BarcaToName($GroupName), NULL) !== NULL and $plugin->GroupIDListConfig->get($GroupName, NULL) !== NULL or $plugin->GroupIDListConfig->get(newGroup::BarcaToName($GroupName), NULL) !== NULL) {
            $player->sendMessage(TextFormat::RED . "公会名不合法！请更换公会名！（已存在与公会名相同的公会ID）");
            return FALSE;
        }
        $config = EpicGroup::$getInstance->Config;
        $money = 0;
        if ($config->get("公会彩色字付费")) {
            if ($config->get("公会彩色字付费方式") === 0) {
                if (newGroup::getColorFontCount($GroupName) > 0) {
                    $money = $config->get("公会彩色字价格");
                }
            } else {
                $money = $config->get("公会彩色字价格") * newGroup::getColorFontCount($GroupName);
            }
            switch (strtolower($config->get("公会彩色字付费币种"))) {
                case "gtc":
                case "公会币":
                    if (\EpicFX\EpicGroup\Player\Player::getPlayerGTC($player) < $money) {
                        $player->sendMessage(TextFormat::RED . "你无法支付彩色公会名所需的费用！(公会币不足)");
                        return FALSE;
                    } else {
                        \EpicFX\EpicGroup\Player\Player::reducePlayerGTC($player, $money);
                    }
                    break;
                case "money":
                case "金币":
                case "Economy":
                    if (EconomyAPI::getInstance()->myMoney($player) < ($plugin->Config->get("创建费用") + $money)) {
                        $player->sendMessage(TextFormat::RED . "你无法支付彩色公会名所需的费用！");
                        return FALSE;
                    } else {
                        EconomyAPI::getInstance()->reduceMoney($money);
                    }
                    break;
            }
        }
        $GroupConfigFileName = newGroup::getNewGroupConfigFileName();
        EconomyAPI::getInstance()->reduceMoney($player, $plugin->Config->get("创建费用"));
        $GroupID = newGroup::getNewGroupID();
        $plugin->GroupIDListConfig->set($GroupID, $GroupConfigFileName);
        $plugin->GroupNameListConfig->set(newGroup::BarcaToName($GroupName), $GroupID);
        $data = Configs::getGroupDC();
        $data["会长"] = $player->getName();
        $data["ID"] = $GroupID;
        $data["Name"] = $GroupName;
        $data["昵称"] = newGroup::BarcaToName($GroupName);
        $data["创建日期"] = date("Y-m-d H:is");
        new Config(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$GroupPath . $GroupConfigFileName, Config::YAML, $data);
        $player->sendMessage(TextFormat::DARK_GREEN . "您的公会：" . TextFormat::GOLD . $GroupName . TextFormat::DARK_GREEN . "创建成功！快去邀请玩家加入吧~");
        $plugin->getServer()->broadcastMessage(TextFormat::WHITE . $player->getName() . TextFormat::GOLD . "创建了一个公会！快去加入吧！" . TextFormat::AQUA . "ID: " . TextFormat::YELLOW . $GroupID);
        return ($plugin->GroupNameListConfig->save() and $plugin->GroupIDListConfig->save());
    }

    /**
     * 判断公会名是否可用
     *
     * @param String $GroupName
     * @return bool
     */
    public static function isGroupNameExist(String $GroupName): bool
    {
        $config = EpicGroup::$getInstance->GroupListConfig;
        if (! isset($config->get("Name", array())[$GroupName]))
            return FALSE;
        if ($config->get("Name", array())[$GroupName] !== NULL)
            return FALSE;
        if (! isset($config->get("Name", array())[newGroup::BarcaToName($GroupName)]))
            return FALSE;
        if ($config->get("Name", array())[newGroup::BarcaToName($GroupName)] !== NULL)
            return FALSE;
        return TRUE;
    }

    /**
     * 获取一个新的公会ID
     *
     * @param string $text
     * @return string
     */
    private function getNewGroupID(string $text = "0123456789abcdefghijklmnopqrstuvwxyz")
    {
        $ID = date("ymd") . "-" . $text{mt_rand(0, strlen($text))};
        if (EpicGroup::$getInstance->GroupListConfig->get($ID, NULL) !== NULL) {
            return $this->getNewGroupID($text);
        }
        return $ID;
    }

    /**
     * 获取一个新的或者添加一段随机代码后的公会名称
     *
     * @param String $GroupName
     * @param int $length
     * @param string $text
     * @return string
     */
    public static function getRandGroupName(String $GroupName = "", int $length = 10, string $text = "0123456789abcdefghijklmnopqrstuvwxyz"): string
    {
        $GroupNameStandby = $GroupName;
        $length = $length - mb_strlen($GroupName);
        if ($length <= 1) {
            $GroupName .= $text{mt_rand(0, mb_strlen($text))};
        } else {
            for ($i = 0; $i < $length; $i ++) {
                $GroupName .= $text{mt_rand(0, mb_strlen($text))};
            }
        }
        if (newGroup::isGroupNameExist($GroupName)) {
            return newGroup::getRandGroupName($GroupNameStandby);
        }
        return $GroupName;
    }

    public static function getNewGroupConfigFileName(int $length = NULL, string $text = "0123456789.-abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ+_")
    {
        if ($length === NULL or $length < 5)
            $length = mt_rand(5, 20);
        $FileName = "";
        while (mb_strlen($FileName) < $length) {
            $FileName .= $text{mt_rand(0, mb_strlen($text))};
        }
        $FileName = $FileName . ".yml";
        if (is_file(EpicGroup::$getInstance->getDataFolder() . EpicGroup::$GroupPath . $FileName))
            return newGroup::getNewGroupConfigFileName($length, $text);
        return $FileName;
    }

    /**
     * 将颜色字符过滤
     *
     * @param string $name
     * @return string
     */
    public static function BarcaToName(string $name): string
    {
        if (SmallTools::isText($name, "§")) {
            $length = mb_strlen(newGroup::$ColorFontKey);
            for ($i = 0; $i < $length; $i ++) {
                $ColorFontKey = "§" . mb_substr(newGroup::$ColorFontKey, $i, 1);
                $name = str_replace($ColorFontKey, "", $name);
            }
        }
        return $name;
    }

    public static function getColorFontCount(String $text): int
    {
        return count(explode("§", $text)) - 1;
    }
}