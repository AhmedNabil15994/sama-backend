<?php

namespace Modules\Order\Traits;

use Modules\Cart\Traits\CartTrait;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;

trait OrderCalculationTrait
{
    use CartTrait;

    public function calculateTheOrder($request)
    {
        $cart = $this->getCartContent();

        $subtotal = 0.000;
        $total = 0.000;

        $courses = [];
        $notes = [];
        $packages = [];

        foreach ($cart as $key => $item) {
            switch($item['attributes']['type']){
                case 'course':
                    $orderCourses['course'] = Course::find($item['attributes']['item_id']);
                    $orderCourses['price'] = $orderCourses['course']['price'];
                    $orderCourses['total'] = $item['price'];

                    $subtotal += $orderCourses['total'];
                    $total += $orderCourses['total'];
                    $courses[] = $orderCourses;
                    break;
                case 'note':
                    $orderNotes['note'] = Note::find($item['attributes']['item_id']);
                    $orderNotes['price'] = $orderNotes['note']['price'];
                    $orderNotes['total'] = $item['price'];

                    $subtotal += $orderNotes['total'];
                    $total += $orderNotes['total'];
                    $notes[] = $orderNotes;
                    break;
                case 'package':
                    $orderPackages['package'] = PackagePrice::find($item['attributes']['item_id']);
                    
                    $orderPackages['price'] = $orderPackages['package']->has_offer_know ? 
                        calculateOfferAmountByPercentage($orderPackages['package']->price,$orderPackages['package']->offer_percentage) : 
                        $orderPackages['package']->price;
                        
                    $orderPackages['off'] = 
                        $orderPackages['package']->has_offer_know ? 
                        $orderPackages['package']->price - calculateOfferAmountByPercentage($orderPackages['package']->price, $orderPackages['package']->offer_percentage)
                         : null;

                    $orderPackages['total'] = $orderPackages['price'];

                    $subtotal += $orderPackages['total'];
                    $total += $orderPackages['total'];
                    $packages[] = $orderPackages;
                    break;

            }
        }

        return [
            'subtotal' => $subtotal,
            'total' => $total,
            'order_courses' => $courses,
            'order_notes' => $notes,
            'order_packages' => $packages,
        ];
    }
}
