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
    public function rules(): array
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 128],
            [['create_time', 'update_time'], 'integer'],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
        ];
    }
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time = time();
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
    public function getUrl(): string
    {
        return Url::to(['article/view', 'id' => $this->id]);
    }
}