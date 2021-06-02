<?php
// Initialize shopping cart class
require_once 'Cart_function.php';
$cart = new CartFunction;
$user_id = $_SESSION['user_id'];
$conn = mysqli_connect('localhost','root','','cps3500_final');
// Include the database config file
require_once 'conn.php';

// Default redirect page
$redirectLoc = 'index.php';
$new_balance = 0;
// Process request based on the specified action
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];

        // Get product details
        $query = $db->query("SELECT * FROM products WHERE product_id = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['product_id'],
            'name' => $row['product_name'],
            'price' => $row['price'],
            'qty' => 1
        );

        // Insert item to cart
        $insertItem = $cart->insert($itemData);



        // Redirect to cart page
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        // Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);

        // Return status
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        // Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['id']);

        // Redirect to cart page
        $redirectLoc = 'viewCart.php';
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0){
        $redirectLoc = 'checkout.php';

        // Store post data
        $_SESSION['postData'] = $_POST;

        $first_name = strip_tags($_POST['first_name']);
        $last_name = strip_tags($_POST['last_name']);
        $email = strip_tags($_POST['email']);
        $phone = strip_tags($_POST['phone']);
        $address = strip_tags($_POST['address']);

        $FROM = "order_information@ez.com";
        $headers = "From $FROM";
        $message = "Hello! This is the email from EZ SHOP. Please keep your order information!";

        $errorMsg = '';
        if(empty($first_name)){
            $errorMsg .= 'Please enter your first name.<br/>';
        }
        if(empty($last_name)){
            $errorMsg .= 'Please enter your last name.<br/>';
        }
        if(empty($email)){
            $errorMsg .= 'Please enter your email address.<br/>';
        }
        if(empty($phone)){
            $errorMsg .= 'Please enter your phone number.<br/>';
        }
        if(empty($address)){
            $errorMsg .= 'Please enter your address.<br/>';
        }

        if(empty($errorMsg)){
            if(empty($errorMsg)){
                $custID = $db->insert_id;

                // Insert order info in the database
                $insertOrder = $db->query("INSERT INTO orders (user_id, grand_total, created, status, first_name, last_name, email, phone, address) VALUES ($user_id, '".$cart->total()."', NOW(), 'Pending', '".$first_name."', '".$last_name."', '".$email."', '".$phone."', '".$address."')");
                $sql_balance = "SELECT balance FROM users where id=$user_id";
                $result_ba=mysqli_query($conn,$sql_balance);
                $bb=mysqli_fetch_array($result_ba);
                $balance = $bb[0];

                $total = $cart->total();
                $new_balance = $balance-$total;
                if($new_balance>0){
                    if($insertOrder){
                        $orderID = $db->insert_id;

                        // Retrieve cart items
                        $cartItems = $cart->contents();

                        // Prepare SQL to insert order items
                        $sql = '';
                        $sql2 = '';
                        $sql1 ='';
                        foreach($cartItems as $item){
                            $sql .= "INSERT INTO product_orders (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');";
                            $sql1 .= "UPDATE users set balance=$new_balance where id=$user_id;";
                            $sql2 .= "UPDATE products set inventory=inventory-'".$item['qty']."' where product_id='".$item['id']."' ;";
                        }

                        // Insert order items in the database
                        // update inventory in the database
                        // update balance
                        $insertOrderItems = $db->multi_query($sql);
                        $updateInventory = $db->multi_query($sql2);
                        $updateBalance = $db->multi_query($sql1);

                        if($insertOrderItems && $updateInventory && $updateBalance){
                            // Remove all items from cart
                            $cart->destroy();

                            // Redirect to the status page
                            $redirectLoc = 'orderSuccess.php?id='.$orderID;
                            //send email
                            mail($email, "Thanks for your shopping on EZ SHOP.", $message, $headers);

                        }else{
                            $sessData['status']['type'] = 'error';
                            $sessData['status']['msg'] = 'Some problem occurred, please try again.1';
                        }
                    }else{
                        $sessData['status']['type'] = 'error';
                        $sessData['status']['msg'] = 'Some problem occurred, please try again.2';
                    }
                }else{
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'You do not have enough money.';
                }

            }else{
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Some problem occurred, please try again.3';
            }
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Please fill all the mandatory fields.<br>'.$errorMsg;
        }
        $_SESSION['sessData'] = $sessData;
    }
}

// Redirect to the specific page
header("Location: $redirectLoc");
exit();