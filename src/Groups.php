<?php
namespace Websoftwares\Wk2014;
use Psr\Log\LoggerInterface;
/**
* Groups class
*
* @package Websoftwares
* @subpackage Wk2014
* @license http://opensource.org/licenses/MIT
* @author Boris <boris@websoftwar.es>
*/
class Groups extends Base
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
     * getGroup retrieve group teams from database
     * @param int $id
     * @return array
     */
    public function getGroup($id = null)
    {
        $group = [];

        if (! $id || ! is_int($id)) {
            throw new \InvalidArgumentException("The id must have a valid integer value");
        }

        try {
            $sth = Db::getInstance()->prepare("
            SELECT t.code, t.title FROM events e
                JOIN events_teams et ON et.event_id = e.id
                JOIN teams t ON t.id = et.team_id
                JOIN groups_teams gt ON gt.team_id = et.team_id
                JOIN groups g ON g.id = gt.group_id
            WHERE e.key = :event
                AND g.pos = :group
                AND g.event_id = e.id
                GROUP BY t.title");

            $sth->execute([':event' => "world.2014", ":group" => $id]);
            $teams = $sth->fetchAll(\PDO::FETCH_KEY_PAIR);

            if ($countries = $this->getTranslation($this->language, 'countries')) {

                foreach ($countries as $code => $country) {
                    if (array_key_exists($code,$teams)) {
                       $teams[$code] = $country;
                    }
                }
            }

        } catch (PDOException $e) {
            $this->logger->log('warning', $e->getMessage());
        }
        $group['event'] = "world.2014";
        $group['group'] = $id;
        $group['teams'] = $teams;

        return $group;
    }
}
