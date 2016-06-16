<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class UnitTester extends \Codeception\Actor
{
    use _generated\UnitTesterActions;
   /**
    * Define custom actions here
    */

    public function getEntityManager()
    {

///////////////// entity manager === can be injected /////////////////

// the connection configuration
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => 'root',
            'dbname'   => 'Chinook',
        ];

        $config = Setup::createAnnotationMetadataConfiguration(['/'], true, null, null, false);
        $config->setNamingStrategy(new UnderscoreNamingStrategy());
        $entityManager = EntityManager::create($dbParams, $config);
////////////////////////////////////////////////////////////////////

        return $entityManager;
    }
}
