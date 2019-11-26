<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Attribute
 *
 * @property-read \App\Models\AttributeType $attributeType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Attribute query()
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AttributeType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attribute[] $attributes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AttributeType query()
 */
	class AttributeType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Brand search($term)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeType[] $attributeType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $children
 * @property-read \App\Models\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category search($term)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\District query()
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FavoriteBrand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteBrand query()
 */
	class FavoriteBrand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FavoriteCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteCategory query()
 */
	class FavoriteCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FavoriteProduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FavoriteProduct query()
 */
	class FavoriteProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Follow
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Follow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Follow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Follow query()
 */
	class Follow extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IdentifyPhoto
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IdentifyPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IdentifyPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\IdentifyPhoto query()
 */
	class IdentifyPhoto extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterAssessmentType
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MasterDetailAssessmentType[] $detailAssessmentTypes
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterAssessmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterAssessmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterAssessmentType query()
 */
	class MasterAssessmentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterCollection
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterCollection query()
 */
	class MasterCollection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterDetailAssessmentType
 *
 * @property-read \App\Models\MasterAssessmentType $assessmentType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderAssessment[] $orderAssessment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterDetailAssessmentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterDetailAssessmentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterDetailAssessmentType query()
 */
	class MasterDetailAssessmentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterPaymentMethod
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterPaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterPaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterPaymentMethod query()
 */
	class MasterPaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterProductStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterProductStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterProductStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterProductStatus query()
 */
	class MasterProductStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterShipProvider
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ShipProviderService[] $shipProviderService
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterShipProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterShipProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterShipProvider query()
 */
	class MasterShipProvider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MasterTargetGender
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterTargetGender newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterTargetGender newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MasterTargetGender query()
 */
	class MasterTargetGender extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MoneyAccount
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $user
 * @property-read \App\Models\WithdrawRequest $withdrawRequest
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MoneyAccount query()
 */
	class MoneyAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property-read \App\Models\User $buyer
 * @property-read \App\Models\OrderAssessment $orderAssessment
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payment
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\OrderStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderAssessment
 *
 * @property-read \App\Models\MasterDetailAssessmentType $detailAssessmentType
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderAssessment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderAssessment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderAssessment query()
 */
	class OrderAssessment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderPayment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderPayment query()
 */
	class OrderPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatus
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderStatus query()
 */
	class OrderStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Attribute[] $attribute
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\ShippingAddress $shippingFrom
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product search($term)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductComment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductComment query()
 */
	class ProductComment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Province
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Province query()
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SearchHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SearchHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SearchHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SearchHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SearchHistory search($term)
 */
	class SearchHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShippingAddress
 *
 * @property-read \App\Models\District $district
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Province $province
 * @property-read \App\Models\Street $street
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Ward $ward
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShippingAddress query()
 */
	class ShippingAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ShipProviderService
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShipProviderService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShipProviderService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShipProviderService query()
 */
	class ShipProviderService extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Street
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street query()
 */
	class Street extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Unit
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit query()
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \App\Models\IdentifyPhoto $identifyPhoto
 * @property-read \App\Models\MoneyAccount $moneyAccount
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $sellingProducts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ward
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ward newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ward newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ward query()
 */
	class Ward extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WatchedProduct
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WatchedProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WatchedProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WatchedProduct query()
 */
	class WatchedProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Webhook
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Webhook newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Webhook newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Webhook query()
 */
	class Webhook extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\WithdrawRequest
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MoneyAccount[] $moneyAccount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WithdrawRequest query()
 */
	class WithdrawRequest extends \Eloquent {}
}

namespace App{
/**
 * App\PasswordReset
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PasswordReset query()
 */
	class PasswordReset extends \Eloquent {}
}

