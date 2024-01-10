<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\StripeClient;

if (!function_exists('stripe')) {
    function stripe(): StripeClient
    {
        return new StripeClient(config('stripe.secret'));
    }
}

//if (!function_exists('randomModel')) {
//    /**
//     * @param $model
//     * @param int $count
//     * @param bool $useFactory
//     * @return Model|null|Collection
//     */
//    function randomModel(
//        $model,
//        int    $count = 1,
//        bool   $useFactory = false,
//    ): Model|Collection|null
//    {
////        $event = App\Models\Event::class;
//
//        dump(is_subclass_of(Event::class, Model::class));
//        dump($model instanceof Model);
//        dd(is_a($model, Model::class));
//
//        dd($model);
//
//        if ($useFactory && in_array(HasFactory::class, class_uses_recursive($model), true)) {
//            /** @var HasFactory $model */
//            return $model::factory($count)->create();
//        }
//
//        if (!is_a($model, Model::class, true)) {
//            return null;
//        }
//
//        /** @var Model $model */
//        return $model::inRandomOrder()->take($count);
//    }
//}
