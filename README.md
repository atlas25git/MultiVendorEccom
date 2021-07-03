# How to use
```php
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact', 'HomeController@contact')->name('contact');

```

## Route::get('/home', 'HomeController@index')->name('home');

1. Redirects to HomeController.php
2. Index fn invoked.
3. Fetches Products from eloquent model named product.
4. Fetches Categories 
5. Redirecting the fetched data to home view.

Route::get('/contact', 'HomeController@contact')->name('contact');

1. Adds contact data to the main front end template.

```php
Route::get('/products/search', 'ProductController@search')->name('products.search');
Route::resource('products', 'ProductController');

```

### Route::get('/products/search', 'ProductController@search')->name('products.search');

1. Redirects to productsController,  invokes the search function.

### Route::resource('products', 'ProductController');

1. Route model binding.

```php

Route::get('/add-to-cart/{product}', 'CartController@add')->name('cart.add')->middleware('auth');
Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');
Route::get('/cart/destroy/{itemId}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');
Route::get('/cart/update/{itemId}', 'CartController@update')->name('cart.update')->middleware('auth');
Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::get('/cart/apply-coupon', 'CartController@applyCoupon')->name('cart.coupon')->middleware('auth');

```

### Route::get('/add-to-cart/{product}', 'CartController@add')->name('cart.add')->middleware('auth');

1) Invokes add method in carts controller.

2) Creates session and uses auth()→id() as input.

3) Populates the array using the parameters of the product request made to it.

### Route::get('/cart', 'CartController@index')->name('cart.index')->middleware('auth');

1. Invokes index method.
2. Fetches cart data, using sessions and auth id as it's input.
3. Returns the fetched data to cart's view.

### Route::get('/cart/destroy/{itemId}', 'CartController@destroy')->name('cart.destroy')->middleware('auth');

1) Takes item id as input and invokes remove method.

### Route::get('/cart/update/{itemId}', 'CartController@update')->name('cart.update')->middleware('auth');

1) Used to update item quantity, and makes changes in the quantity, value.

### Route::get('/cart/checkout', 'CartController@checkout')->name('cart.checkout')->middleware('auth');

1) Redirects to cart.checkout view.

### Route::get('/cart/apply-coupon', 'CartController@applyCoupon')->name('cart.coupon')->middleware('auth');

1) Takes coupon code from the made request.

2) Checks for it in the coupon model.

3) Else makes necessary changes.

```php
Route::resource('orders', 'OrderController')->middleware('auth');
```

### Route::resource('orders', 'OrderController')->middleware('auth');

1. RESTful route creates methods for all the crud options easily.
2. Here the main functionality is to store the orders on request passed by cart.

```php
Route::resource('shops','ShopController')->middleware('auth');
```

### Route::resource('shops','ShopController')->middleware('auth');

1. RESTful controller for the data storage of registered shop.
2. Utilized functionality : store.

```php
Route::get('paypal/checkout/{order}', 'PayPalController@getExpressCheckout')->name('paypal.checkout');
Route::get('paypal/checkout-success/{order}', 'PayPalController@getExpressCheckoutSuccess')->name('paypal.success');
Route::get('paypal/checkout-cancel', 'PayPalController@cancelPage')->name('paypal.cancel');
```

### Route::get('paypal/checkout/{order}', 'PayPalController@getExpressCheckout')->name('paypal.checkout');

1. Invokes ExpressCheckout method, where we use paypalService to createOrder, based on order id that is passed.
2. PaypalService's createOrder method looks up for the passed orderID and then creates checkout data. This is stored in our express checkout method.
3. We check for the status code of response received.
4. Once the response states that execution is successful we look up the order model with orderId, and in its paypalId we store the id contained in the response.

5, After all this is verified user is redirected to the approved link.

6. Once the payment is done based on its status success/cancel particular functions are hit.

### Route::get('paypal/checkout-success/{order}', 'PayPalController@getExpressCheckoutSuccess')->name('paypal.success');

1. We check if the order is completed.
2. Now we turn the is_paid value of order to 1.
3. We clear the cart.
4. Mail is send to user's email fetched from order→user→email.
5. User is redirected to home, with success message.

### Route::get('paypal/checkout-cancel', 'PayPalController@cancelPage')->name('paypal.cancel');

1. Handles the contingency of failed order status, at present dumps the data.

```php
Route::group(['prefix' => 'admin'], function () {

    Voyager::routes();

    Route::get('/order/pay/{suborder}', 'SubOrderController@pay')->name('order.pay');

});
```

1) Here a transaction is created for the subOrder.

2) Paid amount is stated, and on the basis of this commission is calculated.

3) On invoking this link admin is redirected to Paypal, where a commission is to be transferred. 

```php
Route::group(['prefix' => 'seller', 'middleware' => 'auth', 'as' => 'seller.', 'namespace' => 'Seller'], function () {

    Route::redirect('/','seller/orders');

    Route::resource('/orders',  'OrderController');

    Route::get('/orders/delivered/{suborder}',  'OrderController@markDelivered')->name('order.delivered');
});
```

1) Route contains crud functionality for orders both in admin and user mode.

2) Marks the orders which have been delivered by the seller.



Clone repo

`git clone https://github.com/webdevmatics/webmall.git`

`Save .env.example as .env and put your database credentials`


Install the composer dependencies

`composer install`


Set application key

`php artisan key:generate`   

And Migrate with

`php artisan migrate --seed` or `php artisan migrate:fresh --seed`

 `php artisan storage:link`


Login Credentials for admin panel

 admin@webmall.com  password : password
 seller1@webmall.com  password : password
 seller2@webmall.com  password : password
