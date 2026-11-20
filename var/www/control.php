<?php

header("Cache-Control: no-store");

if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') {
    exit('Forbidden.');
}

function println($line) {
    printf("%s\n", $line);
}

function perc($x, $y) {
    return sprintf('%d%%', $x * 100 / $y);
}

function mbytes($bytes) {
    return sprintf('%.2F', $bytes / 1024 / 1024);
}

function cmd_opcache_stats() {
    $details = opcache_get_status(false);

    $stats = $details['opcache_statistics'];
    $oomRestarts = $stats['oom_restarts'];
    $hashRestarts = $stats['hash_restarts'];
    $autoRestarts = $oomRestarts + $hashRestarts;
    $keysUsed = $stats['num_cached_keys'];
    $keysTotal = $stats['max_cached_keys'];

    $mem = $details['memory_usage'];
    $memUsed = $mem['used_memory'];
    $memFree = $mem['free_memory'];
    $memTotal = $memUsed + $memFree;

    $str = $details['interned_strings_usage'];
    $strUsed = $str['used_memory'];
    $strTotal = $str['buffer_size'];

    $summary = [
        'auto_restarts' => $autoRestarts,
        'keys' => [
            'full' => perc($keysUsed, $keysTotal),
            'used' => $keysUsed,
            'total' => $keysTotal,
        ],
        'mem' => [
            'full' => perc($memUsed, $memTotal),
            'used_mbytes' => mbytes($memUsed),
            'total_mbytes' => mbytes($memTotal),
        ],
        'strings' => [
            'full' => perc($strUsed, $strTotal),
            'used_mbytes' => mbytes($strUsed),
            'total_mbytes' => mbytes($strTotal),
        ],
    ];

    print_r([
        'details' => $details,
        'summary' => $summary,
    ]);
}

function cmd_opcache_reset() {
    opcache_reset();
    println('Opcache reset done.');
}

function cmd_apcu_clear() {
    apcu_clear_cache();
    println('APCu cache cleared.');
}

function cmd_apcu_stats() {
    $cache = apcu_cache_info(true);
    $sma = apcu_sma_info(true);

    $used = $cache['mem_size'];
    $total = $sma['seg_size'];
    $summary = [
        'entries' => $cache['num_entries'],
        'mem_full' => perc($used, $total),
        'mem_used_mbytes' => mbytes($used),
        'mem_total_mbytes' => mbytes($total),
    ];

    print_r([
        'cache' => $cache,
        'sma' => $sma,
        'summary' => $summary,
    ]);
}

#function cmd_eval() {
#    $code = file_get_contents('php://input');
#    println(eval($code));
#}

function cmd_reload() {
    opcache_invalidate(__FILE__, true);
    println('Done.');
}

function cmd_ping() {
    println('Pong.');
}

$func = 'cmd_' . $_SERVER['QUERY_STRING'];
$retval = call_user_func($func);
if ($retval === false) {
    println('Unrecognized command.');
}
