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
            "/公会 创建 [公会名称] " => "创建一个公会",
            "/公会 解散 " => "公会会长解散自己的公会",
            "/公会 改名 [公会名称] " => "更改公会名称",
            "/公会 升级 [人数] " => "升级公会人数上限",
            "/公会 转让 [玩家] " => "公会会长转让公会",
            "/公会 信息 <名称|编号> " => "查看公会信息",
            "/公会 描述 [描述] " => "更改公会描述信息",
            "/公会 踢人 [玩家] " => "会长或副会长踢人",
            "/公会 邀请 [玩家] " => "邀请玩家进入公会",
            "/公会 加入 [名称|编号] " => "申请加入公会",
            "/公会 退出  " => "强转退出自己所在的公会",
            "/公会 同意 [玩家] " => "公会管理同意申请",
            "/公会 拒绝 [玩家] " => "公会管理拒绝申请",
            "/公会 设置副会长 [玩家] " => "设置副会长",
            "/公会 删除副会长 [玩家] " => "删除副会长",
            "/公会 列表 <页码> " => "显示全部公会列表",
            "/公会 帮助 <页码> " => "显示全部公会帮助",
            "/公会 排行 " => "设置公会浮空字排行榜)"
        );
    }
}
