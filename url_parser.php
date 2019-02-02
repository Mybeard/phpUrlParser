<?php
$shortopts  = "u:";
$longopts  = ["url:"];

if (getopt($shortopts, $longopts)) {
    $data = (getopt($shortopts, $longopts));
} elseif (!getopt($shortopts, $longopts) && $argc == 2) {
    $data = ($argv[1]);
} else {
    echo "no URL provided", PHP_EOL;
}

$url = getUrl($data);
$parsed_url = parse_url($url);
printResult(getResult($parsed_url));


function getUrl($data)
{
    if (is_array($data)) {
		foreach ($data as $value) {
            $url = $value;
        }
	}
	else {
        $url = $data;
    }

    return $url;

}


function getParsedQuery($query)
{
    parse_str($query, $output);
    $parsedQuery = $output;
    return $parsedQuery;

}

function getExtension($path)
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    return $extension;
}

function getDomain($host)
{
    preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/", $host, $domain);
    $domain = $domain[0];
    return $domain;

}

function getTld($host)
{
    $domain = getDomain($host);
    $tld = substr($domain, strpos($domain, '.'));
    return $tld;
}


function getResult($parsed_url)
{
    extract($parsed_url);

    $extension = getExtension($path);
    $domain = getDomain($host);
    $tld = getTld($host);
    $parsed_url['extension'] = $extension;
    $parsed_url['domain'] = $domain;
    $parsed_url['tld'] = $tld;
    if ($query){
        $parsedQuery = getParsedQuery($query);
        return $resultArr =[$parsed_url, 'pasedQuery' => $parsedQuery];

    }
    else {
        return $resultArr = $parsed_url;
    }

}

function printResult($result)
{
    echo json_encode($result, JSON_PRETTY_PRINT);
}