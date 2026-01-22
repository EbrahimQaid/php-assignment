<?php
// تمرين تحويل الأموال 

// 1. الخطر الأكبر: فقدان التناسق بين العمليات
// 2. إذا نجحت العمليتان وفشل التسجيل: البيانات غير متناسقة
// 3. أستخدم Transactions
// 4. rollback يرجع كل التغييرات إذا فشلت عملية
// 5. لا أعرض رسالة الخطأ الحقيقية لأمن النظام
// 6. أسجل في logs: وقت الخطأ، نوع العملية، المعرّفات

// الكود العملي:
function transferMoney($fromAccount, $toAccount, $amount) {
    $db = new PDO('mysql:host=localhost;dbname=bank', 'root', '');
    
    try {
        // بدء المعاملة
        $db->beginTransaction();
        
        // 1. خصم من الحساب الأول
        $stmt1 = $db->prepare(
            "UPDATE accounts SET balance = balance - ? WHERE id = ? AND balance >= ?"
        );
        $stmt1->execute([$amount, $fromAccount, $amount]);
        
        if ($stmt1->rowCount() == 0) {
            throw new Exception("رصيد غير كافي");
        }
        
        // 2. إضافة للحساب الثاني
        $stmt2 = $db->prepare(
            "UPDATE accounts SET balance = balance + ? WHERE id = ?"
        );
        $stmt2->execute([$amount, $toAccount]);
        
        // 3. تسجيل العملية
        $stmt3 = $db->prepare(
            "INSERT INTO transactions (from_account, to_account, amount) VALUES (?, ?, ?)"
        );
        $stmt3->execute([$fromAccount, $toAccount, $amount]);
        
        // تأكيد المعاملة إذا نجحت كل العمليات
        $db->commit();
        
        echo "تم التحويل بنجاح";
        return true;
        
    } catch (Exception $e) {
        // التراجع عن كل التغييرات
        $db->rollBack();
        
        // تسجيل الخطأ في السجلات
        error_log("فشل تحويل الأموال: " . $e->getMessage());
        
        // عرض رسالة عامة للمستخدم
        echo "حدث خطأ في التحويل. الرجاء المحاولة لاحقاً";
        return false;
    }
}

// مثال الاستخدام
// transferMoney(1, 2, 500);
?>
