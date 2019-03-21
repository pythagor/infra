<?php

use Infra\Sdk\Utils;
use DnsX\Model\DnsRecord;

function generateRecords()
{
    // Create the GraphQL query
    $query = <<<GRAPHQL
query {
    allHosts {
        name
        publicIp
        privateIp
    }
}
GRAPHQL;

    $data = Utils::query($query);

    $records = [];

    foreach ($data['data']['allHosts'] as $host) {
        $fullName = $host['name'] . '.host';
        $record = new DnsRecord();
        $record->setName($fullName);
        $record->setType('A');
        $record->setTtl(60);
        $record->setValue($host['publicIp']);
        $records[] = $record;
    }
    
    foreach ($data['data']['allHosts'] as $host) {
        if ($host['privateIp']) {
            $fullName = 'private-ip.' . $host['name'] . '.host';
            $record = new DnsRecord();
            $record->setName($fullName);
            $record->setType('A');
            $record->setTtl(60);
            $record->setValue($host['privateIp']);
            $records[] = $record;
        }
    }
    return $records;
}