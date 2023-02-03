<?php

/**
 * A minimal example.
 */

require_once('bootstrap.php');

use Coderjerk\ScoroPhp\ScoroPhp;

$scoro = new ScoroPhp(
    $_ENV['SCORO_COMPANY_ACCOUNT_ID'],
    $_ENV['SCORO_API_KEY'],
);

try {
    $contacts =
        $scoro->module('contacts')
        ->action('view')
        ->id(35)
        ->call();
    dd($contacts);


    foreach ($contacts->data as $contact) {
    }
} catch (\Throwable $th) {
    echo $th->getMessage();
}
