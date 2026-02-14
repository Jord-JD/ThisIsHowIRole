<? 
namespace JordJD\ThisIsHowIRole;

use JordJD\ThisIsHowIRole\DatabaseDrivers\PDODatabaseDriver;
use JordJD\ThisIsHowIRole\DatabaseDrivers\EloquentDatabaseDriver;

abstract class DatabaseHelper
{
public static function getDatabaseDriver()
{
    if (class_exists('Illuminate\Database\Eloquent\Model')) {
        return new EloquentDatabaseDriver();
      } else {
        return  new PDODatabaseDriver();
      }
}
}