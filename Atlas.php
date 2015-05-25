<?php
namespace boundstate\atlas;

/* @var \Yii::$app->atlas Atlas */

/**
 * Atlas component.
 */
class Atlas extends \yii\base\Component
{
    public $baseUrl = 'https://atlas.boundstatesoftware.com';
    public $appId;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->appId === null) {
            throw new \yii\base\InvalidConfigException('The "appId" property must be set.');
        }
    }

    /**
     * Logs an exception.
     * @param \Exception $exception
     */
    public function logException($exception)
    {
        $this->execute('POST', '/exceptions', [
            'app_id' => $this->appId,
            'language' => 'php',
            'url' => \Yii::$app->request->absoluteUrl,
            'name' => get_class($exception),
            'message' => $exception->getMessage(),
            'stack_trace' => $exception->getTrace(),
        ]);
    }

    /**
     * Executes an API call.
     * @param string $method
     * @param string $url
     * @param array|boolean $data
     * @return mixed
     */
    private function execute($method, $url, $data = false)
    {
        $ch = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                if ($data) {
                    $bodyData = json_encode($data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($bodyData)
                    ]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyData);
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            default:
                if ($data) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}