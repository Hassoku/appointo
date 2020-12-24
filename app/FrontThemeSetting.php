<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontThemeSetting extends Model
{
    public function getLogoUrlAttribute(){
        if(is_null($this->logo)){
            return asset('assets/img/logo.png');
        }
        return asset_url('front-logo/'.$this->logo);
    }
}
