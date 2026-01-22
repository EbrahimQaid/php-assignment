<?php
require_once 'Product.php';
require_once 'Customer.php';
require_once 'Order.php';

// بيانات تجريبية
$customer = new Customer("أحمد محمد", "ahmed@example.com", "2023-01-15");

$laptop = new Product("لابتوب HP Victus", 3500, 12);
$laptop->setDiscount(15);

$mouse = new Product("ماوس قيمنق RGB", 120, 45);

$keyboard = new Product("كيبورد ميكانيكي", 250, 20);
$keyboard->setDiscount(10);

$headset = new Product("سماعة محيطية 7.1", 180, 0); // Out of stock
$headset->setDiscount(5);

$order = new Order("ORD-7742", date('Y-m-d'), "قيد التوصيل");
$order->addProduct($laptop);
$order->addProduct($mouse);
$order->addProduct($keyboard);
$order->addProduct($headset);

$orderDetails = $order->getOrderDetails();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة المتجر | OOP PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>نظام إدارة المتجر الذكي</h1>
            <p>مثال تطبيقي للبرمجة كائنية التوجه (OOP) بلغة PHP</p>
        </header>

        <div class="grid">
            <!-- كرت العميل -->
            <div class="card">
                <h3>👤 معلومات العميل</h3>
                <div class="card-item">
                    <span class="label">الاسم الكامل</span>
                    <span class="value"><?php echo $customer->getName(); ?></span>
                </div>
                <div class="card-item">
                    <span class="label">عمر العضوية</span>
                    <span class="value"><?php echo $customer->getMembershipAge(); ?></span>
                </div>
                <div class="card-item">
                    <span class="label">الحالة</span>
                    <span class="badge badge-success">عضو نشط</span>
                </div>
            </div>

            <!-- كرت المنتجات -->
            <div class="card">
                <h3>📦 تفاصيل المنتجات</h3>
                <?php foreach ($orderDetails['products'] as $p): ?>
                <div class="card-item">
                    <div>
                        <span class="label"><?php echo $p->getName(); ?></span>
                        <?php if (!$p->isInStock()): ?>
                            <span class="badge badge-danger" style="font-size: 0.7rem; margin-right: 5px;">غير متوفر</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <?php if ($p->getOriginalPrice() > $p->getPriceAfterDiscount()): ?>
                            <span class="price-original"><?php echo $p->getOriginalPrice(); ?></span>
                        <?php endif; ?>
                        <span class="value"><?php echo $p->getPriceAfterDiscount(); ?> ريال</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- كرت الطلب -->
            <div class="card">
                <h3>🛒 ملخص الطلب</h3>
                <div class="card-item">
                    <span class="label">رقم الطلب</span>
                    <span class="value">#<?php echo $orderDetails['number']; ?></span>
                </div>
                <div class="card-item">
                    <span class="label">تاريخ الطلب</span>
                    <span class="value"><?php echo $orderDetails['date']; ?></span>
                </div>
                <div class="card-item">
                    <span class="label">الحالة</span>
                    <span class="badge badge-warning"><?php echo $orderDetails['status']; ?></span>
                </div>
                <div class="card-item" style="margin-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem;">
                    <span class="label">الإجمالي النهائي</span>
                    <span class="price-tag"><?php echo $order->calculateTotal(); ?> ريال</span>
                </div>
            </div>
        </div>

        <footer>
            جميع الحقوق محفوظة &copy; <?php echo date('Y'); ?> | تم التطوير بواسطة Antigravity
        </footer>
    </div>
</body>
</html>
