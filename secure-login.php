<?php
// تمرين تسجيل الدخول 

// 1. الخطر الأكبر: SQL Injection إذا لم نستخدم Prepared Statements

// 2. استخدام query() بدل prepare() يسبب ثغرة SQL Injection

// 3. لمنع معرفة سبب الفشل: نعرض نفس الرسالة دائماً

// 4. Prepared Statements ليست كافية، نحتاج أيضاً:
//    - تجزئة كلمات المرور
//    - التحقق من صحة الإدخال

// الكود العملي:
session_start();
$db = new PDO('mysql:host=localhost;dbname=university', 'root', '');

function login($email, $password) {
    global $db;
    
    // استخدام Prepared Statement لمنع SQL Injection
    $stmt = $db->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user) {
        // التحقق من كلمة المرور بعد التجزئة
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
    }
    
    // نفس الرسالة دائماً سواء خطأ في البريد أو كلمة المرور
    echo "البريد الإلكتروني أو كلمة المرور غير صحيح";
    return false;
}

// مثال الاستخدام
// login('student@university.edu', 'mypassword123');
?>
