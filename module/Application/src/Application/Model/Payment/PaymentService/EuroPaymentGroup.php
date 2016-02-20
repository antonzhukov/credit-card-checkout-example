<?php
/**
 * @author zhukov
 */

namespace Application\Model\Payment\PaymentService;

use Application\ValueObject\CreditCardPayment;
use Application\Model\Payment\PaymentService;
use Application\ValueObject\PaymentServiceResponse;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;
use Application\Exception\BadResponseException;

class EuroPaymentGroup implements PaymentService
{
    protected $url;
    protected $appName;
    protected $secretKey;

    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->appName = $config['app_name'];
        $this->secretKey = $config['secret_key'];
    }

    /**
     * @param CreditCardPayment $payment
     * @return PaymentServiceResponse
     */
    public function processCreditCardPayment(CreditCardPayment $payment)
    {
        $result = false;
        $message = '';

        $params = [
            'FirstName' => $payment->firstName,
            'LastName' => $payment->lastName,
            'Amount' => $payment->amount,
            'Currency' => $payment->currency,
            'CreditCardNumber' => $payment->cardNumber,
            'Cvv' => $payment->cvv,
            'ExpMonth' => $payment->expireMonth,
            'ExpYear' => $payment->expireYear,
        ];

        $rawResponse = $this->sendRequest($params);

        if (is_array($rawResponse) && isset($rawResponse['result'], $rawResponse['resultCode'])) {
            if ($rawResponse['result'] === 'OK') {
                $result = true;
            }
            if (isset($rawResponse['message'])) {
                $message = $rawResponse['message'];
            }
        }

        return new PaymentServiceResponse($result, $message);
    }

    /**
     * @param $params
     * @return array
     * @throws BadResponseException
     */
    protected function sendRequest($params)
    {
        $timestamp = time();
        error_reporting(E_ALL);
        $data = $this->encryptData(json_encode($params));

        $client = new Client();
        $client->setAdapter(new Curl())
            ->setRawBody(json_encode($data)) /** TODO: add mcrypt for me */
            ->setUri($this->url)
            ->setHeaders([
                'Payment-App-Name' => $this->appName,
                'Payment-Token' => $this->generateToken($data, $timestamp),
                'Payment-Timestamp' => $timestamp,
                'Content-Type' => 'application/json',
            ])
            ->setMethod('POST');

        try {
            $response = $client->send();
        } catch (Client\Adapter\Exception\RuntimeException $e) {
            throw new BadResponseException();
        }

        if (!$response->isSuccess()) {
            throw new BadResponseException();
        }

        $result = $response->getBody();

        $json = json_decode(trim($result), true);

        return $json;
    }

    /**
     * Token generation algorithm same on service and client
     * Used to validate client
     * @param $data
     * @return string
     */
    protected function generateToken($data, $timestamp)
    {
        return sha1($data . $timestamp . $this->appName . $this->secretKey);
    }

    protected function encryptData($plaintext)
    {
        $ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC); //Gets the size of the IV belonging to a specific cipher/mode combination.
        $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_RANDOM); //Creates an initialization vector (IV) from a random source.
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->secretKey, $plaintext, MCRYPT_MODE_CBC, $iv); //Encrypts the data and returns it.
        return base64_encode($iv.$ciphertext); //Encode Base 64
    }
}
