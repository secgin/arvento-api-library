<?php

namespace YG\Arvento;

class Arvento implements ArventoInterface
{
    private string
        $host,
        $username,
        $pin1,
        $pin2;

    private string $lastError = '';

    public function __construct(string $host, string $username, string $pin1, string $pin2)
    {
        $this->host = $host;
        $this->username = $username;
        $this->pin1 = $pin1;
        $this->pin2 = $pin2;
    }

    public function getNodeFromLicensePlate(string $licensePlate): ?string
    {
        $result = $this->request('GetNodeFromLicensePlate', ['LicensePlate' => $licensePlate]);

        return $result
            ? $result->GetNodeFromLicensePlateResult
            : null;
    }

    public function getVehicleStatusByNodeV3(string $node): ?object
    {
        $result = $this->request('GetVehicleStatusByNodeV3', [
            'Node' => $node,
            'Language' => '0'
        ]);

        return $result
            ? $result->GetVehicleStatusByNodeV3Result->LastPacket
            : null;
    }

    private function request(string $method, array $params)
    {
        $this->lastError = '';
        $params = $this->prepareMethodParams($params);
        try
        {
            $soap = new \SoapClient($this->host, $this->getSoapParams());
            return $soap->$method($params);
        }
        catch (\Exception $e)
        {
            $this->lastError = $e->getMessage();
        }
        return null;
    }

    private function getSoapParams(): array
    {
        return [
            'soap_version' => SOAP_1_2,
            'exceptions' => true,
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE,
        ];
    }

    private function prepareMethodParams(array $params): array
    {
        return array_merge(
            [
                'Username' => $this->username,
                'PIN1' => $this->pin1,
                'PIN2' => $this->pin2
            ],
            $params);
    }
}