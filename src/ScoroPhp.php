<?php

namespace Coderjerk\ScoroPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Minimal class to call the Scoro Rest API.
 */
class ScoroPhp
{
    /**
     * Available in your Scoro dashboard
     *
     * @var string
     */
    public $company_account_id;

    /**
     * Available in your Scoro dashboard
     *
     * @var string
     */
    public $api_key;

    /**
     * Default language
     *
     * @var string
     */
    public $lang = 'eng';

    /**
     * the id of the object you want to target,
     * if available, based on the module and action
     *
     * @var string
     */
    public $id;

    /**
     * the module to access
     *
     * @var string
     */
    public $module;

    /**
     * What to do with the selected module object
     *
     * @var string
     */
    public $action;

    /**
     * Filters for the request
     *
     * @var array
     */
    public $filters;

    /**
     * Module specific request modifiers
     *
     * @var array
     */
    public $request;

    /**
     * The page to return
     *
     * @var string
     */
    public $page;

    /**
     * Results per page - capped at 100 for list methods
     *
     * @var string
     */
    public $per_page;

    /**
     * Various bookmark related options
     *
     * @var array
     */
    public $bookmarks;


    public function __construct(
        $company_account_id,
        $api_key,
    ) {
        $this->company_account_id = $company_account_id;
        $this->api_key = $api_key;
    }


    /**
     * Set the module to request
     *
     * @param string $module
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function module($module): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->module = $module;

        return $this;
    }


    /**
     * Set the module action.
     *
     * @param string $action
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function action($action): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Set filter options
     *
     * @param array $filters
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function filter($filters): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * Set default language
     *
     * @param string $lang
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function lang($lang): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Set pagination options
     *
     * @param integer $per_page
     * @param integer $page
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function paginate($per_page, $page): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->per_page = $per_page;

        $this->page = $page;

        return $this;
    }

    /**
     * Set id when targetting individual resource
     *
     * @param string $id
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function id($id): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set Requests
     *
     * @param array $requests
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function request($request): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Set Bookmarks
     *
     * @param array $bookmarks
     * @return \Coderjerk\ScoroPhp\ScoroPhp
     */
    public function bookmarks($bookmarks): \Coderjerk\ScoroPhp\ScoroPhp
    {
        $this->bookmarks = $bookmarks;

        return $this;
    }


    /**
     * Perform the request
     *
     * @return object | exception
     */
    public function call()
    {

        $base_uri = "https://{$this->company_account_id}.scoro.com/api/v2/";

        $endpoint = implode("/", array_filter(
            [$this->module, $this->action, $this->id]
        ));

        $client = new Client([
            'base_uri' => $base_uri,
        ]);

        try {
            $response = $client->request('POST', $endpoint, [
                'json' => [
                    'apiKey'             => $this->api_key,
                    'company_account_id' => $this->company_account_id,
                    'per_page'           => $this->per_page,
                    'page'               => $this->page,
                    'request'            => $this->request,
                    'filter'             => $this->filters,
                    'bookmarks'          => $this->bookmarks
                ]
            ]);

            return json_decode($response->getBody());
        } catch (ClientException $e) {
            throw $e;
        }
    }
}
