<?php
namespace EpicFX\EpicGroup;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use EpicFX\EpicGroup\Instrument\SmallTools;
use EpicFX\EpicGroup\PlayerEvent\PlayerEvent;
use EpicFX\EpicGroup\Instrument\CheckForUpdates;
use EpicFX\EpicGroup\Configs\BlockList;
use EpicFX\EpicGroup\Configs\Configs;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use EpicFX\EpicGroup\Command\onCommand;

// 2019年4月17日 下午4:06:35
class EpicGroup extends PluginBase implements Listener
{

    /**
     *
     * @var EpicGroup
     */
    public static $getInstance;

    /**
     * 玩家配置文件路径
     *
     * @var string
     */
    public static $PlayerPath = "Players/";

    /**
     * 公会配置文件夹存储路径
     *
     * @var string
     */
    public static $GroupPath = "Groups/";

    /**
     * 主配置文件
     *
     * @var Config
     */
    public $Config;

    /**
     * 方块名称ID对照表
     *
     * @var Config
     */
    public $BlickList;

    /**
     * 公会ID配置文件对照表
     *
     * @var Config
     */
    public $GroupIDListConfig;

    /**
     * 公会名称对照表
     *
     * @var Config
     */
    public $GroupNameListConfig;

    /**
     * 默认商城配置
     *
     * @var Config
     */
    public $DefaultSellMall, $DefaultRecycleMall;

    /**
     * 玩家命令处理类
     *
     * @var onCommand
     */
    public $onCommand;

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        return (bool) $this->onCommand->onCmd($sender, $command, $label, $args);
    }

    public function onEnable()
    { // error_reporting(0);
        @date_default_timezone_set('Etc/GMT-8');
        $start = $this->getServer()->getPluginManager();
        $start->registerEvents(new PlayerEvent($this), $this);
        $start->registerEvents($this, $this);
        new Configs($this);
        BlockList::makeConfig($this);
        if ($this->Config->get("更新检查")) {
            new CheckForUpdates($this);
        }
        $this->onCommand = new onCommand($this);
        $this->getLogger()->info(SmallTools::getFontColor($this->getName() . "插件启动！作者：小凯     QQ：2508543202  感谢使用！"));
    }

    public function onLoad()
    {
        self::$getInstance = $this;
        $this->getLogger()->info(SmallTools::getFontColor($this->getName() . "插件加载中....."));
    }

    public function onDisable()
    {
        $this->getLogger()->info(SmallTools::getFontColor($this->getName() . "插件关闭！QAQ你居然把我关闭了，是不是不爱我了."));
    }
}
?>