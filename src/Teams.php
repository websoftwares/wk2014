<?php
namespace Websoftwares\Wk2014;
use Psr\Log\LoggerInterface;
/**
* Teams class
*
* @package Websoftwares
* @subpackage Wk2014
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class Teams extends Base
{
    /**
     * __construct description
     * @param LoggerInterface $logger   some object that is an instance of
     * @param string          $language NL|...
     */
    public function __construct(LoggerInterface $logger, $language = null)
    {
        parent::__construct($logger);

        if ($language) {
            $this->language = $language;
        }
    }

    /**
     * getTeamMatches retrieve matches for team by fifa country code
     * @see http://en.wikipedia.org/wiki/List_of_FIFA_country_codes
     * @param  string $id i.e "NED", "GER"
     * @return array
     */
    public function getTeamMatches($code = null)
    {
        $teamMatches = [];

        if (! $code) {
            throw new \InvalidArgumentException("The FIFA country code must be set.");
        }

        try {
            $sth = Db::getInstance()->prepare("SELECT
                r.pos,
                ga.play_at,
                t1.code t1_code,
                t1.title t1_title,
                t2.code t2_code,
                t2.title t2_title
                FROM events e
                    JOIN rounds r ON r.event_id = e.id
                    JOIN games ga ON ga.round_id = r.id
                    JOIN teams t1 ON t1.id = ga.team1_id
                    JOIN teams t2 ON t2.id = ga.team2_id
                WHERE e.key = :event
                AND t1_code = :code OR t2_code = :code
                AND strftime('%Y-%m-%d',ga.play_at) BETWEEN '2014-06-12' AND '2014-07-14'");
            $sth->execute([':event' => "world.2014", ":code" => $code]);

            while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $teamMatches[$row['pos']] = [
                    'play_at' => $row['play_at'],
                    $row['t1_code'] => $row['t1_title'],
                    $row['t2_code'] => $row['t2_title']
                    ];
            }

            if ($countries = $this->getTranslation($this->language, 'countries')) {
                foreach ($teamMatches as $round => $teamMatch) {
                    foreach ($countries as $code => $country) {
                        if (array_key_exists($code,$teamMatch)) {
                            $teamMatches[$round][$code] = $country;
                        }
                    }
                }
            }

        } catch (PDOException $e) {
            $this->logger->log('warning', $e->getMessage());
        }

       return $teamMatches;
    }
}
