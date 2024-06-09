<?php
namespace Interfaces;
use MainCli;
interface Command
{
    public function __construct(MainCli $cli, array $args = []);
    public function run();
}