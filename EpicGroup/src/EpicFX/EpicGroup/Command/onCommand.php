<?php
declare(strict_types = 1);
namespace EpicFX\EpicGroup\Command;

use EpicFX\EpicGroup\EpicGroup;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

// 2019年4月22日 下午2:17:06
class onCommand
{

    private $plugin;

    public function __construct(EpicGroup $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * 命令处理时间
     *
     * @param CommandSender $player
     * @param Command $command
     * @param string $label
     * @param array $k
     * @return bool
     */
    public function onCmd($player, $command, $label, $k): bool
    {
        switch (strtolower($command->getName())) {
            case "公会":
                if (! isset($k[0]))
                    return FALSE;
                switch (strtolower($k[0])) {
                    case value:
                        break;

                    default:
                        break;
                }
                break;
            default:
                return FALSE;
        }
    }
    public function getHelp(): array
    {
        return array(
            "/红包 <红包金额> <红包Key> <红包个数> <Luck|Mean|Ladder> " => " 快捷发布一个红包，可直接省略后部内容，仅输入“/红包”可快捷发送",
            "/pf add [item] [物品ID] [物品数量] [红包数量] <红包Key> <红包领取类型<Luck|Mean|Ladder>>" => "发布一个物品红包",
            "/pf add [money] [红包金额] [红包数量] <红包Key> <红包领取类型<Luck|Mean|Ladder>>" => "发布一个金币红包",
            "/pf show " => "显示红包功能主界面(游戏内有效)",
            "/pf set" => "显示红包功能设置页面(游戏内且管理员有效)",
            "/pf help" => "获取帮助界面",
            "/pf my <ui>" => "查看个人信息(当第二个参数为ui时，将以UI的形式展示您的信息！)"
        );
    }
}