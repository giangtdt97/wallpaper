<?php
namespace App\Actions;

use App\Models\Wallpaper;
use TCG\Voyager\Actions\AbstractAction;

class FeaturedAction extends AbstractAction
{
     public function getTitle()
     {
         return $this->data->{'feature'}=='ACCEPT'?'BLOCK':'ACCEPT';
     }

     public function getIcon()
     {
         return $this->data->{'feature'}=='ACCEPT'?'voyager-lock':'voyager-list-add';
     }
    public function getAttributes()
    {
        // Action button class
        return [
            'class' => 'btn btn-sm btn-danger pull-right edit',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'wallpapers';
    }

     public function getDefaultRoute()
     {
         return route('wallpapers.publish', array("id"=>$this->data->{$this->data->getKeyName()}));
     }
 }
