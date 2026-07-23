<?php

use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBField;


class Helper extends Extension
{
    public function URLEncode()
    {
        return urlencode($this->owner->value);
    }

    public function Pluralise()
    {
        return ($this->owner->value != 1 ? 's' : '');
    }


    public function PipeBr()
    {
        return DBField::create_field('HTMLFragment', str_replace(['|'], ['<br />'], $this->owner->value));
    }

    public function ValidLink()
    {
        $link = $this->owner->value;
        $valid=(preg_match("/http(s)?:\/\//", $link) ? true : false);
        $link=($valid ? $link : ('https://'.$link));

        return $link;
    }


    public function TelFormat()
    {
        $telFormat = $this->owner->value;

        // Only allow numbers or + symbol
        $telFormat = preg_replace('/[^0-9+]/', '', $telFormat);

        return $telFormat;
    }


    public function ConvertStrToDate()
    {
        return strtotime($this->owner->value);
    }

    public function DateConvert($format)
    {
        if($this->owner->value) {
            $date = strtotime($this->owner->value);
            return date($format, $date);
        }
    }

    public function ShortDate()
    {
        if($this->owner->value){
            return date('d/m/Y',strtotime($this->owner->value));
        }
    }
    public function ShortTime()
    {
        if($this->owner->value){
            return date('H:i',strtotime($this->owner->value));
        }
    }
}
