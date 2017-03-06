<?php

  /**
   * EXAMPLE
   * $cart = new ShoppingCart();
   * $add            = $cart->setItem(123,1);
   * $addAtt         = $cart->setAttribute(2,"desc","kage");
   * $addAtt         = $cart->setAttribute(2,"info","mere kage");
   * $remove         = $cart->remove(3);
   * $getItems       = $cart->getItems();
   * $cart->clear();
   * $cart->destroy();
   * foreach ($getItems as $key => $value) {
   *  echo 'id# ' . $key . ' quantity ' . $value . ' ';
   *  echo $getAtt = $cart->getAttribute($key,'desc');
   *  echo $getAtt = $cart->getAttribute($key,'info');
   *  echo '<br>';
   * }
   *
   *  still needs error reporting if item is not set and if not integer etc.
   *  and much more
   */
  class ShoppingCart
  {
    private $sessionId         = 'shoppingCart';
    private $sessionAttributes = '_attributes';
    private $items             = array();
    private $attributes        = array();

    public function __construct() {
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      $this->read();
  	}

    /* GETTING */
    public function getItems()
    {
      return $this->items;
    }
    public function getAttribute($id, $key)
    {
      return $this->attributes[$id][$key];
    }

    /*
	   * Sets item or update item with quantity
	  */
    public function setItem($id,$qty = 1)
    {
      if($qty <= 0){
        return $this->remove($id);
      }
      $this->items[$id] = $qty;
      $this->write();
      return TRUE;
    }
    /*
	   * Sets or update 1 or more attributes for an item
	  */
    public function setAttribute($id, $key = '', $value = '')
    {
      if(isset($this->items[$id])) {
        $this->attributes[$id][$key] = $value;
        $this->write();
        return TRUE;
      }
    }

    /*
	   * Remove Specific item
	  */
    public function remove($id)
    {
      if(isset($this->items[$id])) {
        unset($this->items[$id]);
  		  unset($this->attributes[$id]);
  		  $this->write();
        return TRUE;
      }
    }
    /*
    * Clear the cart
    */
    public function clear()
    {
      unset($this->items);
      unset($this->attributes);
    }

    /*
	   * Wipe out session
	  */
    public function destroy() {
  		unset($_SESSION[$this->sessionId]);
      unset($_SESSION[$this->sessionId . $this->sessionAttributes]);
  		$this->items = array();
  		$this->attributes = array();
  	}

    /* WHAT GETS THE JOB DONE */
    private function read()
    {
      $listItem       = $_SESSION[$this->sessionId];
      $listAttributes = $_SESSION[$this->sessionId . $this->sessionAttributes];

  		$items = explode(';', $listItem);
  		foreach($items as $item) {
        if (strpos($item, ',') !== FALSE) {
          list($id, $qty) = explode(',', $item);
          $this->items[$id] = $qty;
        }
  		}

      $attributes = explode(';', $listAttributes);
      foreach($attributes as $attribute) {
        if (strpos($attribute, ',') !== FALSE) {
          list($id, $key, $value) = explode(',', $attribute);
          $this->attributes[$id][$key] = $value;
        }
      }

    }
    private function write()
    {
      $_SESSION[$this->sessionId] = '';
  		foreach($this->items as $id => $qty) {
        $_SESSION[$this->sessionId] .= $id . ',' . $qty . ';';
  		}

      $_SESSION[$this->sessionId . $this->sessionAttributes] = '';
      foreach($this->attributes as $id => $attributes) {
        foreach ($attributes as $key => $value) {
          $_SESSION[$this->sessionId . $this->sessionAttributes] .= $id . ',' . $key . ',' . $value . ';';
        }
      }

      $_SESSION[$this->sessionId] = rtrim($_SESSION[$this->sessionId], ';');
      $_SESSION[$this->sessionId . $this->sessionAttributes] = rtrim($_SESSION[$this->sessionId . $this->sessionAttributes], ';');

    }


  }// class end


 ?>
