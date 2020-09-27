<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use SimpleXMLElement;

class CentralBankCurrency extends DataTransferObject
{
    public string $numCode;

    public string $code;

    public int $nominal;

    public string $name;

    public float $value;

    public static function createFromXml(SimpleXMLElement $node): self
    {
        $strValue = (string)$node->Value;
        $strValue = str_replace(',', '.', $strValue);
        $value = (float)$strValue;

        return new self([
            'numCode' => (string)$node->NumCode,
            'code' => (string)$node->CharCode,
            'nominal' => (int)$node->Nominal,
            'name' => (string)$node->Name,
            'value' => $value,
        ]);
    }
}
