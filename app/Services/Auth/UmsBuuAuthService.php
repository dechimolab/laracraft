<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Log;

class UmsBuuAuthService
{
    protected string $systemId;
    protected string $serviceKey;
    protected string $serviceUrl;

    public function __construct(?string $systemId = null, ?string $serviceKey = null, ?string $serviceUrl = null)
    {
        $this->systemId = (string) ($systemId ?? config('constants.configUms.SystemID') ?? config('ums.system_id', env('UMS_SYSTEM_ID', '')));
        $this->serviceKey = (string) ($serviceKey ?? config('constants.configUms.ServiceKey') ?? config('ums.service_key', env('UMS_SERVICE_KEY', '')));
        $this->serviceUrl = rtrim((string) ($serviceUrl ?? config('constants.configUms.ServiceUrl') ?? config('ums.service_url', env('UMS_SERVICE_URL', 'https://ums.buu.ac.th/index.php'))), '/');
    }

    /**
     * URL encrypt based on ServiceUms
     */
    public function my_encrypt(string $string): string
    {
        if (str_starts_with($string, '/')) {
            $string = substr($string, 1);
        }
        $skey = date('d');
        $string = $skey . '||' . $string;
        $data = base64_encode($string);
        $data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
        return '/' . $data;
    }

    /**
     * Reversible cipher encode function matching UMS Service standard
     */
    public function encode(string $string, string $secret = 'E20jTw8Iy'): string
    {
        $secret = md5(serialize($secret));
        $strLen = strlen($string);
        $secretLen = strlen($secret) - 1;
        $j = 0;
        $hash = '';
        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($string, $i, 1));
            if ($j > $secretLen) {
                $j -= $secretLen;
            }
            $ordSecret = ord(substr($secret, $j, 1));
            $j += 9;
            $hash .= strrev(base_convert(dechex($ordStr + $ordSecret), 16, 36));
        }
        return $hash;
    }

    /**
     * Reversible cipher decode function matching UMS Service standard
     */
    public function decode(string $string, string $secret = 'E20jTw8Iy'): string
    {
        $secret = md5(serialize($secret));
        $strLen = strlen($string);
        $secretLen = strlen($secret) - 1;
        $j = 0;
        $hash = '';
        for ($i = 0; $i < $strLen; $i += 2) {
            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
            if ($j > $secretLen) {
                $j -= $secretLen;
            }
            $ordSecret = ord(substr($secret, $j, 1));
            $j += 9;
            $hash .= chr($ordStr - $ordSecret);
        }
        return $hash;
    }

    /**
     * Send HTTP POST to UMS Gateway via cURL or stream context
     */
    public function url_get_contents(string $url, $context, array $postdata): string|false
    {
        if (function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-HTTP-Method-Override: PUT']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            $url_get_contents_data = curl_exec($ch);
            curl_close($ch);
            return $url_get_contents_data;
        }

        if (function_exists('file_get_contents')) {
            return @file_get_contents($url, false, $context);
        }

        return false;
    }

    /**
     * Dispatch payload to UMS Service endpoint
     */
    public function call_service(array $aData): object
    {
        if (empty($this->systemId) || empty($this->serviceKey)) {
            return (object) [
                'Error' => false,
                'Message' => 'ไม่ได้กำหนด SystemID หรือ ServiceKey ในการเชื่อมต่อ UMS',
                'aData' => null,
            ];
        }

        $service_url = $this->serviceUrl . $this->my_encrypt('syscontrol/umserviceforlaravel/service_check_parameter');
        $jsonData = json_encode($aData, JSON_UNESCAPED_UNICODE);
        $encrypted = base64_encode($this->encode($jsonData, $this->serviceKey));
        $postdata = [
            'SystemID' => $this->systemId,
            'Data' => $encrypted,
        ];

        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($postdata),
                'timeout' => 15,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        $context = stream_context_create($opts);

        try {
            $result = $this->url_get_contents($service_url, $context, $postdata);
            if ($result === false || $result === '') {
                return (object) [
                    'Error' => false,
                    'Message' => 'ไม่สามารถเชื่อมต่อ UMS Service Gateway ได้',
                    'aData' => null,
                ];
            }

            $rawDecrypted = $this->decode(base64_decode((string) $result), $this->serviceKey);
            $aReceiveData = json_decode($rawDecrypted);

            if (empty($aReceiveData)) {
                return (object) [
                    'Error' => false,
                    'Message' => 'ไม่สามารถถอดรหัสข้อมูลได้เนื่องจาก Service Key หรือการตอบกลับไม่ถูกต้อง',
                    'aData' => null,
                ];
            }

            return (object) $aReceiveData;
        } catch (\Throwable $e) {
            Log::error('UMS call_service exception: ' . $e->getMessage());
            return (object) [
                'Error' => false,
                'Message' => 'เกิดข้อผิดพลาดในการเชื่อมต่อ UMS: ' . $e->getMessage(),
                'aData' => null,
            ];
        }
    }

    /**
     * FunctionID 17: Get all registered roles/groups for configured SystemID
     */
    public function get_group_in_system(): object
    {
        return $this->call_service([
            'FunctionID' => 17,
        ]);
    }
}
