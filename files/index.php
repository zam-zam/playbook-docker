<?php
header("Content-Type: text/plain");

$cpuCoresCount = getCpuCoresCount();
$totalMemory = getTotalMemory();
$freeMemory = getFreeMemory();
$totalDiskSpace = getTotalDiskSpace();
$freeDiskSpace = getFreeDiskSpace();

printf("Cpu Cores: %s \n", $cpuCoresCount);
printf("Free Memory/Total Memory (kB): %s/%s \n", $freeMemory, $totalMemory);
printf("Free Disk Space/Total Disk Space (kB): %s/%s \n", $freeDiskSpace, $totalDiskSpace);

function getCpuCoresCount()
{
    /*
    ** Beware! I know regexps!
    */
    $cpuInfo = file_get_contents('/proc/cpuinfo');
    preg_match_all('/^processor/', $cpuInfo, $matches);
    return count($matches[0]);
}

function getTotalMemory()
{
    return trim(shell_exec("cat /proc/meminfo | grep MemTotal | awk '{print $2}'"));
}

function getFreeMemory()
{
    return trim(shell_exec("cat /proc/meminfo | grep MemFree | awk '{print $2}'"));
}

function getTotalDiskSpace()
{
    return trim(shell_exec("df / | sed -e 1d | awk '{print $2}'"));
}

function getFreeDiskSpace()
{
    return trim(shell_exec("df / | sed -e 1d | awk '{print $4}'"));
}