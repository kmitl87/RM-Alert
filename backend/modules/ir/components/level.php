<?php
namespace backend\modules\ir\components;
use yii\base\Component;

class Level extends Component
{
    public function getLavel($levelID = null)
    {
        if($levelID == 1)
        {
            $text = '<span class="label label-default"> A </span>';
        }
        else if($levelID == 2)
        {
            $text = '<span class="label label-info"> B </span>';
        }
        else if($levelID == 3)
        {
            $text = '<span class="label label-primary"> C </span>';
        }
        else if($levelID == 4)
        {
            $text = '<span class="label label-warning"> D </span>';
        }
        else if($levelID == 5)
        {
            $text = '<span class="label label-warning"> E </span>';
        }
        else if($levelID == 6)
        {
            $text = '<span class="label label-warning"> F </span>';
        }
        else if($levelID == 7)
        {
            $text = '<span class="label label-danger"> G </span>';
        }
        else if($levelID == 8)
        {
            $text = '<span class="label label-danger"> H </span>';
        }
        else if($levelID == 9)
        {
            $text = '<span class="label label-danger"> I </span>';
        }
        return $text;
    }

}