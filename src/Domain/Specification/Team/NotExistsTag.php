<?php
/**
 * Namespace for all Specifications of Team.
 * @since 0.0.1-dev
 */
namespace Clanify\Domain\Specification\Team;

use Clanify\Core\Database;
use Clanify\Domain\Entity\IEntity;
use Clanify\Domain\Entity\Team;
use Clanify\Domain\Repository\TeamRepository;
use Clanify\Domain\Specification\Specification;

/**
 * Class NotExistsTag
 *
 * @author Sebastian Brosch <contact@sebastianbrosch.de>
 * @copyright 2015 Clanify
 * @license GNU General Public License, version 3
 * @package Clanify\Domain\Specification\Team
 * @version 0.0.1-dev
 */
class NotExistsTag extends Specification
{
    /**
     * Method to check if the Team satisfies the Specification.
     * @param IEntity $team The Team which will be checked.
     * @return bool The state if the Team satisfies the Specification.
     * @since 0.0.1-dev
     */
    public function isSatisfiedBy(IEntity $team)
    {
        //check if the Entity is a Team.
        if ($team instanceof Team) {
            $database = Database::getInstance();
            $teamRepository = new TeamRepository($database->getConnection());

            //find the Teams by tag.
            $teams = $teamRepository->findByTag($team->tag);

            //check if the id should be excluded.
            if ($this->excludeID) {
                return $this->excludeCurrentID($teams, $team);
            } else {
                return (count($teams) > 0) ? false : true;
            }
        } else {
            return false;
        }
    }
}
