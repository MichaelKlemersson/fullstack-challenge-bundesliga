<?php

namespace App\Support\Traits;

use App\Support\SoapApiClient;
use App\Support\Api\Response\ParseSoapResponse;

/**
 * Trait BundesligaSoapApi
 */
trait BundesligaSoapApi
{
    /**
     * Endpoint to the soap requests
     *
     * @var string
     */
    protected $soapApiUri = 'https://www.OpenLigaDB.de/Webservices/Sportsdata.asmx';

    /**
     * Return the client to be used in requests
     *
     * @return SoapApiClient
     */
    protected function getSoapClient()
    {
        return new SoapApiClient();
    }

    /**
     * A helper function to parse soap response to array
     *
     * @param mixed $response
     * @return array
     */
    protected function parseSoapResponse($response)
    {
        $arrayResponse = (new ParseSoapResponse())->parse($response);

        return array_shift($arrayResponse);
    }

    /**
     * Return all availables sports
     *
     * @return array
     */
    public function getAvailabeSports()
    {
        return $this->parseSoapResponse(
            $this
                ->getSoapClient()
                ->fetch($this->soapApiUri, [
                    'action' => 'GetAvailSports'
                ])
        )['Sport'];
    }

    /**
     * Return all available leagues from a sport
     *
     * @param int $sportId
     * @param string $session
     * @return array
     */
    public function getLeaguesFromSport(int $sportId, string $session = '')
    {
        $result = $this->parseSoapResponse(
            $this
                ->getSoapClient()
                ->fetch($this->soapApiUri, [
                    'action' => 'GetAvailLeaguesBySports',
                    'params' => [[
                        'sportID' => $sportId
                    ]]
                ])
        );

        $result = array_shift($result);

        if ($session) {
            $result = array_filter($result, function ($league) use ($session) {
                return ($league['leagueSaison'] === $session);
            });
        }

        return array_values($result);
    }
    
    /**
     * Return the next match of a league
     *
     * @param string $league
     * @return array
     */
    public function getNextLeagueMatch(string $league)
    {
        return $this->parseSoapResponse(
            $this
                ->getSoapClient()
                ->fetch($this->soapApiUri, [
                    'action' => 'GetNextMatch',
                    'params' => [[
                        'leagueShortcut' => $league
                    ]]
                ])
        );
    }
}
