<?php
/**
 * Created by PhpStorm.
 * User: imran
 * Date: 11/9/18
 * Time: 5:32 PM
 */

namespace Codilar\Seller\Model\Config\Source;


class LandingPageLayout
{
    public function toOptionArray()
    {
        $data = [
            ['value' => '1', 'label' => __('Layout 1')],
            ['value' => '2', 'label' => __('Layout 2')],
            ['value' => '3', 'label' => __('Layout 3')]
        ];
        return $data;
    }
}