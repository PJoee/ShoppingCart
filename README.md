# ShoppingCart
ShoppingCart

EXAMPLE
$cart = new ShoppingCart();
// this both sets and updates the current item, first integer is the itemId second is the quantity
$add            = $cart->setItem(123,1);

// this adds and attribute example desc or info, first integer is the itemId
$addAtt         = $cart->setAttribute(2,"desc","kage");
$addAtt         = $cart->setAttribute(2,"info","mere kage");

// removes 1 of the items in the cart
$remove         = $cart->remove(3);

// clears the cart
$cart->clear();

// destroy the entire session
$cart->destroy();

// gets all the items in the cart
$getItems       = $cart->getItems();

// example of how to use it
foreach ($getItems as $key => $value) {
  echo 'id# ' . $key . ' quantity ' . $value . ' ';
  echo $getAtt = $cart->getAttribute($key,'desc');
  echo $getAtt = $cart->getAttribute($key,'info');
  echo '<br>';
}

still needs error reporting if item is not set and if not integer etc.
and much more
