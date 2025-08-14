<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
// require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/src/' . str_replace(['MiniStore\\', '\\'], ['', '/'], $class) . '.php';
    if (file_exists($path)) require $path;
});

use MiniStore\Modules\Products\Product;
use MiniStore\Modules\Users\Customer;
use MiniStore\Modules\Orders\Order;
use MiniStore\Modules\Payments\PayPal;

// logs
$logs = [];

// add logs
function addLog(string $message, string $type = "INFO") {
    global $logs;
    $logs[] = [
        'time' => date('Y-m-d H:i:s'),
        'type' => $type,
        'message' => $message
    ];
}

// create product
$product1 = new Product("Laptop", 1200.005, 9);
$product2 = new Product("Mouse", 25.005, 48);
$product3 = new Product("Keyboard", 75.005, 30);
addLog("Products created: Laptop, Mouse, Keyboard");

// create customer
$customer = new Customer("john.doe");
addLog("Customer created: {$customer->getUsername()}");

// create order
$order = new Order($customer);
try {
    $order->addProduct($product1, 1);
    $order->addProduct($product2, 2);
    addLog("Order placed for {$customer->getUsername()} with total before tax: {$order->getTotal()}");

    // add discount and Tax
    $totalAfterTax = $order->applyTax($order->getTotal());
    addLog("Tax added: " . (TAX_RATE * 100) . "%");

    $totalAfterDiscount = $order->applyDiscount($totalAfterTax);
    addLog("Discount applied: " . (DISCOUNT_PERCENT * 100) . "%");

    addLog("Final order amount after tax & discount: $totalAfterDiscount");

  // payment
$payment = new PayPal();
if ($payment->processPayment($totalAfterDiscount)) {
    addLog("Payment successful via PayPal for amount: $totalAfterDiscount", "SUCCESS");
}
$paymentMessage = $payment->getMessage();



} catch (Exception $e) {
    addLog("Error: " . $e->getMessage(), "ERROR");
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>MiniStore</title>
    <style>
        body { font-family: Arial, sans-serif; background: #ece1ecff; margin: 0; padding: 0; }
        header { background: linear-gradient(to right, #64206dff, #400568ff); color: white; text-align: center; padding: 15px; font-size: 20px; font-weight: bold; }
        .container { padding: 20px; max-width: 900px; margin: auto; }
        .products, .order, .logs { background: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .product-box { display: inline-block; width: 30%; border: 1px solid #ddd; margin: 5px; padding: 10px; border-radius: 5px; text-align: center; }
        .log-success { color: green; }
        .log-error { color: red; }
        .log-info { color: gray; }
    </style>
</head>
<body>

<header>
    مرحباً بك في متجر MiniStore
</header>

<div class="container">

    <!-- products -->
    <div class="products">
        <h3>المنتجات المتوفرة</h3>
        <div class="product-box">
            <strong><?php echo $product3->getName(); ?></strong><br>
            السعر: <?php echo $product3->getPrice(); ?><br>
            الكمية: <?php echo $product3->getStock(); ?>
        </div>
        <div class="product-box">
            <strong><?php echo $product2->getName(); ?></strong><br>
            السعر: <?php echo $product2->getPrice(); ?><br>
            الكمية: <?php echo $product2->getStock(); ?>
        </div>
        <div class="product-box">
            <strong><?php echo $product1->getName(); ?></strong><br>
            السعر: <?php echo $product1->getPrice(); ?><br>
            الكمية: <?php echo $product1->getStock(); ?>
        </div>
    </div>

    <!-- order-->
    <div class="order">
        <h3>تفاصيل الطلب</h3>
        <p>العميل: <?php echo $customer->getUsername(); ?></p>
        <p>المبلغ الأصلي: <?php echo $order->getTotal(); ?></p>
        <p>الضريبة: <?php echo number_format($totalAfterTax - $order->getTotal(), 3); ?></p>
        <p>بعد الضريبة: <?php echo number_format($totalAfterTax, 3); ?></p>
        
        <p>المبلغ النهائي: <strong><?php echo number_format($totalAfterDiscount, 3); ?></strong></p>
        <p>حالة الطلب: <span style="color:green;">completed</span></p>
    </div>

    <!-- logs-->
    <div class="logs">
        <h3>سجل الأحداث (Logs)</h3>
        <?php foreach ($logs as $log): ?>
            <p class="log-<?php echo strtolower($log['type']); ?>">
                <?php echo $log['time']; ?> - <?php echo $log['message']; ?>
            </p>
        <?php endforeach; ?>
    </div>

<!-- payment-message-->
<div class="payment-message" style="margin-top: 10px; font-weight: bold; color: blue;">
    <?php echo $paymentMessage; ?>
</div>


</div>

</body>
</html>
