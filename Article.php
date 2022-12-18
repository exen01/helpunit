namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $create_time
 * @property int $update_time
 */
class Article extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'article';
    }
}