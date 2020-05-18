<?php
namespace api;

require '../index.php';

//ini_set('display_errors', 1);
//echo '<pre>';
//error_reporting(E_ALL);

class apiBusiness
{
    const BASE_URL = 'https://check.business.ru/open-api/v1/';

    const HEADER = [
        'getTokenURL' => 'Token',
        'commandURL' => 'Command',
        'getSystemStatus' => 'StateSystem',
        'getUser' => 'User',
        'getGoods' => 'Goods'
    ];

    //private $appID = false;
    //private $secret = false;

    public $token = true;
    public $nonce = true;

    public function __construct()
    {
        $this->getAppID();
        $this->getSecret();
        $this->getNonce();
        $this->getToken();
    }

    public function getAppID()
    {
        //$appID = $_POST['appID'];
        if (!isset($_SESSION['appID']))
        {
            $_SESSION['appID'] = $_POST['appID'];
        }

        return $_SESSION['appID'];
    }

    public function getSecret()
    {
        if(!isset($_SESSION['secret']))
        {
            $_SESSION['secret'] = $_POST['secret'];
        }

        return $_SESSION['secret'];
    }

        /* Создание хэша */
    private function getNonce($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $this->nonce = $randomString;
    }
        /* Получение токена */
    public function getToken()
    {
        $token = json_decode(
            $this->sendRequest(self::HEADER['getTokenURL'], ["nonce" => $this->nonce, "app_id" => $this->getAppID()]),
            true)['token'];

        $this->token = $token;

    }
        /* Формирование подписи */
    private function getSign(array $params)
    {
        return md5(json_encode($params,JSON_UNESCAPED_UNICODE) . $this->getSecret());
    }

        /* Получение данных о пользователе */
    public function getUserById()
    {
        return json_decode($this->sendRequest(
            self::HEADER['getUser'],
            [
                "token" => $this->token,
                "app_id" => $this->getAppID(),
                "nonce" => $this->nonce,
            ]
        ), true)['login'];

    }
        /* Отправка и получение запросов от self::BASE_URL(Онлайн-чеки) */
    private function sendRequest($url, $params)
    {
        ksort($params);
        $ch = curl_init();

        if($url == self::HEADER['commandURL']) //POST запрос - true, GET - false,
        {
            curl_setopt($ch, CURLOPT_URL, self::BASE_URL. $url);
            $postFields = json_encode($params, JSON_UNESCAPED_UNICODE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            $postHeader = [
                'Content-Type: application/json; charset=utf-8',
                'sign: ' . $this->getSign($params),
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);

        } else {

            curl_setopt($ch, CURLOPT_URL, self::BASE_URL. $url . '?' . http_build_query($params));
            $getHeader = ['sign: ' . $this->getSign($params)];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $getHeader);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($ch);
    }

        /* Открытие смены */
    public function openShift()
    {
        return $this->sendRequest(
            self::HEADER['commandURL'],
            [
                'nonce' => $this->nonce,
                'app_id' => $this->getAppID(),
                'token' => $this->token,
                'type' => 'openShift',
                'command' => [
                    'report_type' => false,
                    'author' => 'Almaz'
                ]
            ]
        );
    }
        /* Закрытие смены */
    public function closeShift()
    {
        return $this->sendRequest(
            self::HEADER['commandURL'],
            [
                'nonce' => $this->nonce,
                'app_id' => $this->getAppID(),
                'token' => $this->token,
                'type' => 'closeShift',
                'command' => [
                    'report_type' => false,
                    'author' => 'Almaz'
                ]
            ]
        );
    }
        /* Чек прихода */
    public function printCheck($data)
    {
        $data["app_id"] = $this->getAppID();
        $data["nonce"] = $this->nonce;
        $data["token"] = $this->token;
        $data["type"] = "printCheck";

        return $this->sendRequest(
            self::HEADER['commandURL'],
                $data
        );
    }

    public function testPrintCheck($data)
    {
        return $this->sendRequest(
            self::HEADER['commandURL'],
            [
                "nonce" => $this->nonce,
                "app_id" => $this->getAppID(),
                "token" => $this->token,
                "type" => "printCheck",
                "command" => $data
            ]
        );
    }
        /* Чек возврата */
    public function returnCheck()
    {
        $data["app_id"] = $this->getAppID();
        $data["nonce"] = $this->nonce;
        $data["token"] = $this->token;
        $data["type"] = "printPurchaseReturn";

        return $this->sendRequest(
            self::HEADER['commandURL'],
            $data
        );
    }

    public function getSystemStatus()
    {
        return $this->sendRequest(
            self::HEADER['getSystemStatus'],
            [
                "app_id" => $this->getAppID(),
                "nonce" => $this->nonce,
                "token" => $this->token
            ]
        );
    }

    /**
     * @return mixed
     */
    public function productList()
    {
        $data = $_POST;

        for($i = 0; $i < 50; $i++)
        {
            $firstItem = 'item'. $i . '_field_1';
            if (isset($data[$firstItem]))
            {
                $productName = 'item' . $i;

                for ($j = 1; $j< 8; $j++)
                {
                    $productList = $productName . '_field_' . $j;

                    if (isset($data[$productList]))
                    {
                        $product[$j] = $data[$productList];
                    }
                }
                $productAll[] = $product;
            }
        }

        foreach ($productAll as $key => $value)
        {
            if ($value[5] >= 1)
            {
                $ndsNotApply = false;

            } else $ndsNotApply = true;

           $nds = $value[5] == 1 ? '0' : $value[5];

            $items = [
                "count" => (int) $value[3],
                "price" => (int) $value[2],
                "sum" => (int) $value[4],
                "name" => trim($value[1]),
                "payment_mode" => (int) $value[7],
                "item_type" => (int) $value[6],
                "nds_value" => (int) $nds,
                "nds_not_apply" => $ndsNotApply
            ];

            $getForProducts[] = $items;
        }

        return $getForProducts;

        //return var_dump($getForProducts);
    }

    public function requestCheck()
    {
        $data = $_POST;

        $email = $data['email'];
        $taxSystem = $data['taxSystem'];
        $payedCashless = $data['payedCashless']; //безналичные
        $payedCash = $data['payedCash']; //наличные

        $random = random_int(1, 100000);

        $printCheck = [
            "command" => [
                "author" => 'Almaz Akhmetov', //goto
                "smsEmail54FZ" => $email,
                "c_num" => $random,
                "payed_cash" => $payedCash,
                "payed_cashless" => $payedCashless,
                "goods" => $this->productList(),

                'tag1055' => $taxSystem,
            ]
        ];

        //return var_dump($printCheck);

        return $this->printCheck($printCheck);
    }
}
$apiBusiness = new apiBusiness;


/*switch (empty($_POST))
{
    case $_POST['jsonCheck']:
        $pd = json_decode($_POST['jsonCheck'], true);
        print_r($apiBusiness->testPrintCheck($pd));
        break;
    default:
        echo 'Hello, world';
        break;
}*/

//var_dump($apiBusiness->productList());
echo '<pre>';
var_dump($apiBusiness->requestCheck());
//var_dump($_SESSION['appID']);

