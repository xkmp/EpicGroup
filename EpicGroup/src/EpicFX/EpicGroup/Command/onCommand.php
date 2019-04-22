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
}